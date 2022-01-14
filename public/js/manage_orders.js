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

async function readPackagingName(id, identifier, object) {
    $.ajax({
        url: '/read-packaging-name/'+id,
        type: 'GET',
        success:function(data){  console.log(data)
            data = data ? data : "-";
            $('.'+object+'-name-'+identifier).text(data)
        }
    });
}

async function readOneOrder(order_no) {

    $('#orders-container').html('');
   // getShippingFee(order_no);
    $.ajax({
        url: '/manage-order/read-one-order/'+order_no,
        type: 'GET',
        success:async function(data){
            let total = 0;
            $.each(data,function(i,v){
                var html = "";
                    total = parseFloat(total) + parseFloat(data[i].amount);
                    html += getItems(data[i], i);
                    if (data.length-1 == i) {
                        html += getComputation(total);
                    }
                    $('#orders-container').append(html);
            });

            for (var i = 0; i < data.length; i++) { 
                await readPackagingName(data[i].packaging_sku, i, 'packaging');
                await readPackagingName(data[i].cap_sku, i, 'cap');
            }
        }
    });
}

function getItems (data, identifier) {
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
        html += '<td class="packaging-name-'+identifier+'">-</td>';
        html += '<td class="cap-name-'+identifier+'">-</td>';
        html += '<td>₱'+formatNumber(data.price)+'</td>';
        html += '<td>'+data.qty+'</td>';
        html += '<td>₱'+formatNumber(data.amount)+'</td>';
    html += '</tr>';
    
    return html;
}

function getComputation(subtotal) {
    let fee = $('#shipping-fee-value').attr('content');
    let total_amount = 0; //+ parseFloat(fee);
    let discount = parseFloat(localStorage.getItem('discount'));
    total_amount = subtotal - discount;
    var html = "";

    let active_tab = $('.nav-tabs .active').attr('aria-controls');

    html += '<tr>';
        html += '<td></td><td></td><td></td><td></td><td></td><td></td><td></td>';
        html += '<td>Subtotal:</td>';
        html += '<td>₱'+formatNumber(subtotal.toFixed(2))+'</td>';
    html += '</tr>';

    html += '<tr>';
        html += '<td></td><td></td><td></td><td></td><td></td><td></td><td></td>';
        html += '<td>Discount:</td>';
        html += '<td>₱'+formatNumber(discount)+'</td>';
    html += '</tr>';

    if (active_tab == 'to-receive') {
        html += '<tr>';
            html += '<td></td><td></td><td></td><td></td><td></td><td></td><td></td>';
            html += '<td>Shipping fee:</td>';
            html += '<td><input id="shipping-fee-value" class="form-control"></td>';
        html += '</tr>'; 
    }     
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

async function readOrderDetails(order_id) { 
    $.ajax({
        url: '/read-order-details/'+order_id,
        type: 'GET',
        success:function(data){ console.log(data)
            let discount = data.discount != null ? data.discount : 0;
            localStorage.setItem('discount', discount);

            let html = '';
            html += '<label>Shipping Address</label>';
            html += '<div>'+data.province+', '+data.municipality+' '+data.brgy+' '+data.detailed_loc+'</div>';
            html += '<div>Nearest landmark: '+data.notes+'</div>';
            html += '<div>Courier: <span class="badge badge-light">'+data.courier+'</span></div>';
            $('#shipping-info-container').html(html);
        }
    });
}

function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}

async function on_Click() {
    
    $(document).on('click','.btn-show-order', async function(){
        let order_no = $(this).attr('data-order-no');
        let customer_name = $(this).attr('data-name');
        let phone = $(this).attr('data-phone');
        let email = $(this).attr('data-email');
        let payment_method = $(this).attr('data-payment');

        let active_tab= $('.nav-tabs .active').attr('aria-controls');
        let btn_text = 'Accept'
        let status = 1; 

        if (active_tab == 'processing') {
            status = 2;
        }
        if (active_tab== 'otw') {
            status = 3;
        }
        else if (active_tab== 'to-receive') {
            status = 4;
        }
        let btn = '';
 
        if ((active_tab!= 'completed' && active_tab!= 'cancelled') && (payment_method == 'cc' || payment_method == 'gc'
        || payment_method == 'bpionline' || payment_method == 'br_bdo_ph')) {
            btn += '<button class="btn btn-sm btn-danger" id="btn-deny" data-active-tab="'+active_tab+'"  type="button">Deny</button>';
            btn += '<button class="btn btn-sm btn-success" id="btn-change-status" data-active-tab="'+active_tab+'" data-status="'+status+'"  type="button">'+btn_text+'</button>';
        }
           
        let html = '<div class="col-sm-12 col-md-4">';
            html += '<div>Customer name: <b>'+customer_name+'</b></div>';
            html += '<div>Contact #: <b>'+phone+'</b></div>';
            html += '<div>Email: <b>'+email+'</b></div>';
            html += '</div>';
            
            html += '<div id="shipping-info-container" class="col-sm-12 col-md-4"></div>';

            html += '<div class="col-sm-12 col-md-4">';
            switch (payment_method) {
                case 'cc':
                    payment_method = "Credit/Debit Card";
                    break;
                case 'gc':
                    payment_method = "GCash";
                    break;
                case 'bpionline':
                    payment_method = "BPI Online";
                    break;
                case 'br_bdo_ph':
                    payment_method = "BDO Online";
                    break;
            }
            html += '<div>Order #: <b>'+order_no+'</b><div>Payment method: <span class="badge badge-light">'+payment_method+'</span></div></div>';
            html += '</div>';
        $('#show-orders-modal').modal('show');
        $('#show-orders-modal').find('#user-info').html(html);
        $('#show-orders-modal').find('.modal-footer').html(btn);

        await readOrderDetails(order_no);
        await readOneOrder(order_no);
        
        
        
        $('#btn-change-status').attr('data-order-no', order_no);
        
    });

    $(document).on('click','#btn-change-status', function(){
        let order_no = $(this).attr('data-order-no');
        let data_status = $(this).attr('data-status');
        let active_tab= $(this).attr('data-active-tab');
        let shipping_fee_value = $('#shipping-fee-value').val();
        let btn = $(this);

        if (active_tab == 'to-receive') {
            if (shipping_fee_value == "") {
                alert('Please input shipping fee.');
                return;
            }
        }
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

      $(document).on('click','#to-receive-tab', function(){ 
        $('#tbl-to-receive-order').DataTable().destroy();
        fetchOrder('to-receive');  
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
    let active_tab = $('.nav-tabs .active').attr('aria-controls');
    await fetchOrder(active_tab);  
    await on_Click();
  }

  render();