$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

async function fetchOrder(object = 'processing'){
    $('#tbl-'+object+'-order').DataTable({
    
        processing: true,
        serverSide: true,
        ajax: '/path/to/script',
        scrollY: 470,
        scroller: {
            loadingIndicator: true
        },

        ajax:{
            url: "/manage-order/read-orders",
            type:"GET",
            data: {
                object : object
            },
        },
           
       columns:[       
            {data: 'order_id', name: 'order_id'},
            {data: 'fullname', name: 'fullname'},
            {data: 'email', name: 'email'},
            {data: 'phone_no', name: 'phone_no'},
            {data: 'date_order', name: 'date_order'},
            {data: 'action', name: 'action',orderable: false},
       ]
      });
 
     
}


async function readOneOrder(order_no) {

    $('#orders-container').html('');
   // getShippingFee(order_no);
    $.ajax({
        url: '/manage-order/read-one-order/'+order_no,
        type: 'GET',
        success:function(data){
            let total = 0;
            $.each(data,function(i,v){
                var html = "";
                setTimeout(function() {
                    total = parseFloat(total) + parseFloat(data[i].price);
                    html += getItems(data[i]);
                    if (data.length-1 == i) {
                        html += getComputation(total);
                    }
                    $('#orders-container').append(html);
                },(i)*100)
            });
        }
    });
}

function getItems (data) {
    var html = "";
    var packaging = data.packaging != null ? data.packaging : '-';
    var closure = data.closure != null ? data.closure : '-';
    var variation = data.variation != null ? data.variation : '-';
    var size = data.size != null ? data.size : '-';
    html += '<tr>';
        html += '<td>'+data.sku+'</td>';
        html += '<td>'+data.name+'</td>';
        html += '<td>'+variation+'</td>';
        html += '<td>'+size+'</td>';
        html += '<td>'+packaging+'</td>';
        html += '<td>'+closure+'</td>';
        html += '<td>'+data.price+'</td>';
        html += '<td>'+data.qty+'</td>';
        html += '<td>'+data.amount+'</td>';
    html += '</tr>';
    
    return html;
}

function getComputation(total) {
    let fee = $('#shipping-fee-value').attr('content');
    let total_amount = total; //+ parseFloat(fee);
    var html = "";
    html += '<tr>';
        html += '<td></td><td></td><td></td><td></td><td></td><td></td><td></td>';
        html += '<td>Subtotal:</td>';
        html += '<td>₱'+formatNumber(total.toFixed(2))+'</td>';
    html += '</tr>';      
    html += '<tr>';
        html += '<td></td><td></td><td></td><td></td><td></td><td></td><td></td>';
        html += '<td>Total:</td>';
    html += '<td>₱'+formatNumber(total_amount.toFixed(2))+'</td>';
html += '</tr>';    
    return html;                     
}

async function getShippingFee(order_no) {
    $.ajax({
        url: '/get-shipping-fee/'+order_no,
        type: 'GET',
        success:function(data){
            $('#shipping-fee-value').attr('content', data);
        }
    });
}

async function readShippingAddress(order_id) { 
    $.ajax({
        url: '/read-shipping-address/'+order_id,
        type: 'GET',
        success:function(data){ console.log(data)
            let html = '';
            html += '<label>Shipping Address</label>';
            html += '<div>'+data.province+', '+data.municipality+' '+data.brgy+' '+data.detailed_loc+'</div>';
            html += '<div>Nearest landmark: '+data.notes+'</div>';
            $('#shipping-info-container').html(html);
        }
    });
}

function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}

async function on_Click() {
    
    $(document).on('click','.btn-show-order', async function(){
        let active_tab= $('.nav-tabs .active').attr('aria-controls');
        let btn_text = 'Accept'
        let status = 1; console.log(active_tab)
        if (active_tab== 'processing') {
            status = 2;
        }
        if (active_tab== 'otw') {
            status = 3;
        }
        else if (active_tab== 'shipped') {
            btn_text = 'Completed';
            status = 4;
        }

        let order_no = $(this).attr('data-order-no');
        let customer_name = $(this).attr('data-name');
        let phone = $(this).attr('data-phone');
        let email = $(this).attr('data-email');
        let payment_method = $(this).attr('data-payment');
        let user_id = $(this).attr('data-user-id');
        let delivery_date = $(this).attr('data-delivery-date');
        let btn = '';
        if (active_tab!= 'completed' && active_tab!= 'cancelled') {
            btn += '<button class="btn btn-sm btn-danger" id="btn-deny" data-active-tab="'+active_tab+'"  type="button">Deny</button>';
            btn += '<button class="btn btn-sm btn-success" id="btn-change-status" data-active-tab="'+active_tab+'" data-status="'+status+'"  type="button">'+btn_text+'</button>';
        }

                  
        let html = '<div class="col-sm-12 col-md-6">';
            html += '<div>Customer name: <b>'+customer_name+'</b></div>';
            html += '<div>Contact #: <b>'+phone+'</b></div>';
            html += '<div>Email: <b>'+email+'</b></div>';
            html += '</div>';
            html += '<div class="col-sm-12 col-md-6">';
            html += '<div class="float-right">Order #: <b>'+order_no+'</b><div>Payment method: '+payment_method+'</div></div>';
          //  if (active_tab == 'pending') {
          //      html += '<div class="float-right" style="margin-right:55px;"><b>Estimated Delivery Date:</b> <input id="delivery_date" type="date" class="form-control"></div>';
          //  }
          //  else {
          //      html += '<div class="float-right" style="margin-right:65px;"><b>Estimated Delivery Date:</b><br> '+delivery_date+'</div>';
          //  }
            html += '</div>';
        $('#show-orders-modal').modal('show');
        $('#show-orders-modal').find('#user-info').html(html);
        $('#show-orders-modal').find('.modal-footer').html(btn);

        await readOneOrder(order_no);
        await readShippingAddress(order_no);
        
        
        
        $('#btn-change-status').attr('data-order-no', order_no);
        
    });

    $(document).on('click','#btn-change-status', function(){
        let order_no = $(this).attr('data-order-no');
        let data_status = $(this).attr('data-status');
        let active_tab= $(this).attr('data-active-tab');
        let delivery_date = "";
        if($('#delivery_date').length > 0) {
            if ($('#delivery_date').val().length > 0) {
                delivery_date  = $('#delivery_date').val();
            }
            else {
                alert('Please input the estimated delivery date.');
                return;
            }
        } console.log(order_no)
        let btn = $(this);
        $.ajax({
            url: '/manage-order/change-status/'+order_no,
            type: 'POST',
            data: {
                status : data_status
            },
            beforeSend:function(){
                btn.text('Please wait...');
            },
            success:function(){
                $('#tbl-'+active_tab+'-order').DataTable().ajax.reload();
                $('#show-orders-modal').modal('hide');
                $.toast({
                    text: 'Order was successfully changed status.',
                    showHideTransition: 'plain',
                    hideAfter: 4500, 
                })
            }
        });
      });

      $(document).on('click','#btn-print', function(){
       // printElement(document.getElementById("printable-order-info"));
      });

      $(document).on('click','#to-pay-tab', function(){
        $('#tbl-to-pay-order').DataTable().destroy();
        fetchOrder('to-pay');  
      });

      $(document).on('click','#processing-tab', function(){
        $('#tbl-processing-order').DataTable().destroy();
        fetchOrder('processing');  
      });

      $(document).on('click','#otw-tab', function(){
        $('#tbl-otw-order').DataTable().destroy();
        fetchOrder('otw');  
      });

      $(document).on('click','#shipped-tab', function(){
        $('#tbl-shipped-order').DataTable().destroy();
        fetchOrder('shipped');  
      });

      $(document).on('click','#completed-tab', function(){
        $('#tbl-completed-order').DataTable().destroy();
        fetchOrder('completed');  
      });

      $(document).on('click','#cancelled-tab', function(){
        $('#tbl-cancelled-order').DataTable().destroy();
        fetchOrder('cancelled');  
      });
  
  
}


    
function printElement(elem) {
    var domClone = elem.cloneNode(true);
    
    var $printSection = document.getElementById("printSection");
    
    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }
    
    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
}

  async function render() {
    await fetchOrder();  
    await on_Click();
  }

  render();