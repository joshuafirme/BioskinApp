function getItems (data,identifier) {
    let address = "-";
    if (data.province && data.municipality) {
        address = data.province+', '+data.municipality+' '+data.brgy+' - '+data.detailed_loc;
    }
    var html = '<input type="radio" name="rdo-address" data-id="'+data.id+'" data-name="'+data.name+'" data-address="'+address+'" data-phone="'+data.phone_no+'">';
    html += '<div class="address-container">';
    html += '<div class="form-group row">';
    html +=     '<label for="input" class="col-sm-2 col-form-label">Fullname</label>';
    html +=      '<div class="col-sm-10">';
    html +=         '<div class="m-2">'+data.name+'</div>';
    html +=     '</div>';
    html +='</div>';
    html += '<div class="form-group row">';
    html +=     '<label for="input" class="col-sm-2 col-form-label">Address</label>';
    html +=     '<div class="col-sm-10"><div class="m-2">'+address+'</div></div>';
    html += '</div>';
    html +=  '<div class="form-group row">';
    html +=     '<label for="input" class="col-sm-2 col-form-label">Phone number</label>';
    html +=     '<div class="col-sm-10">';
    html +=          '<div class="m-2">'+data.phone_no+'</div>';
    html +=     '</div>';
    html +=  '</div>';
    html += '<hr>';

    return html;
}


function readAddresses() {
    var html = '';
    $.ajax({
        url: '/account/read-addresses',
        type: 'GET',
        success:async function(data){  
            if (data.length > 0) {
                for (var i = 0; i < data.length; i++) {   
                    if (typeof data[i] != 'undefined') { 
                        html += getItems(data[i], i);
                    } 
                }
                $('.addresses-main-container').html(html);
            }
            else {
                html += '<p class="text-center text-muted">No address was found. Please add your address <a target="_blank" href="/account">here</>.</p>';
                $('.addresses-main-container').html(html);
            }
        }
    });
}

function readDefaultAddress() {
    $.ajax({
        url: '/read-default-address/',
        type: 'GET',
        success:function(data){ 
            let address = "-";
            if (data.province && data.municipality) {
                address = data.province+', '+data.municipality+' '+data.brgy;
            }
            $('#address_id').val(data.id);
            $('#fullname').text(data.name);
            $('#phone_no').text(data.phone_no);
            $('#address').text(address);
        }
    });
}


function courierDOM(data) {
    let html = ``;
    html += `<div class="bg-white card">`;
    html += `<div class="form-check">`;
    html +=   `<label class="form-check-label" style="margin-top:12px;">`;
    html +=     `<input class="form-check-input radio-inline" type="radio" name="rdo-courier" data-id="`+data.id+`" data-name="`+data.name+`"  data-receive="`+data.receive_by+`"><span class="text-bold" `;
    html +=     `>`+data.name+`</span></label>`;
    html +=     `<div class="float-right"><b>Receive by</b><div>`+data.receive_by+`</div></div>`;
    html += `</div></div>`;
    return html;
}

function readCourier() {
    var html = '';
    $.ajax({
        url: '/checkout/read-courier',
        type: 'GET',
        success:function(data){
              
            console.log(data)
            if (data.length > 0) {
                for (var i = 0; i < data.length; i++) {   
                    if (typeof data[i] != 'undefined') { 
                        html += courierDOM(data[i]);
                    } 
                }
                $('#courier-modal .modal-body').html(html);
            }
            else {
                html += '<p class="text-center text-muted">No courier found.</p>';
                $('#courier-modal .modal-body').html(html);
            }
        }
    });
}

function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
}

$('#btn-change-address').on('click', function(){
    readAddresses();
});

$(document).on('change', '[name=rdo-address]', async function(){ 

    let address_id = $(this).attr('data-id');
    let name = $(this).attr('data-name');
    let address = $(this).attr('data-address');// 
    let phone = $(this).attr('data-phone');

    $('#address_id').val(address_id);
    $('#fullname').text(name);
    $('#address').text(address);
    $('#phone_no').text(phone);
});

$(document).on('blur', '#voucher', async function(){ 
    let voucher_code = $(this).val();
    if (voucher_code.length > 3) {
        $.ajax({
            url: '/validate-voucher',
            type: 'GET',
            data: {
                voucher_code : voucher_code
            },
            success:function(discount){
                let html = '<small class="text-danger" id="">Invalid voucher</small>';
                if (discount == 'invalid') {
                    $('#voucher-validation').html(html);
                    $('.voucher_discount_text').text('0.00');
                }
                else {
                    html = '<small class="text-success" id="">Voucher applied</small>';
                    $('#voucher-validation').html(html);
                    let merchant_total = $('#total_payment_text').text().replaceAll(',','');
                    let total = parseFloat(merchant_total) - parseFloat(discount);
                    $('.voucher_discount_text').text(discount);
                    $('#total_payment_text').text(formatNumber(total.toFixed(2)));
                }
            }
        });
    }

});

$(document).on('click', '#btn-place-order', async function(){ 
    var btn = $(this);
    let voucher_code = $('#voucher').val();
    let address_id = $('#address_id').val();
    let courier_id = $('#courier_id').val();
    let opt_payment_method = $("input[name='rad_pm']:checked").val();
    let mode_of_payment = $('.payment-method-container').find('.active').attr('data-value');

    var url = new URL(window.location);
    var buy_now = url.searchParams.get("buy_now");
    var sku = url.searchParams.get("sku");

    let opt_shipping_mop = $('input[name="opt_shipping_mop"]:checked').val();

    let notes = $('#notes').val();
    let html = '';
    if (mode_of_payment == 'online_payment' && !opt_payment_method) {
        html = '<small class="text-danger">Please select payment method.</small>';
        $('#input-validation').html(html);
        return;
    } 
    else if (mode_of_payment == 'COD'){
        opt_payment_method = 'COD';
    }
    if (courier_id.length == 0) {
        html = '<small class="text-danger">Please select courier.</small>';
        $('#input-validation').html(html);
        return;
    }
    if (address_id.length == 0) {
        html = '<small class="text-danger">Please select address.</small>';
        $('#input-validation').html(html);
        return;
    }
    else {
    }

    $('#input-validation').html('');

    btn.prop('disabled', true);
    btn.html('<i class="fas fa-spinner fa-pulse"></i>');

    $.ajax({
        url: '/place-order',
        type: 'POST',
        data: {
            voucher_code : voucher_code,
            address_id : address_id,
            courier_id : courier_id,
            opt_payment_method : opt_payment_method,
            opt_shipping_mop : opt_shipping_mop,
            notes : notes,
            buy_now : buy_now,
            sku : sku
        },
        success:function(data){
            btn.remove();
            if (data.status == "minimum_amount_exceeded") {
                html = '<small class="text-danger">Voucher minimum amount is invalid.</small>';
                $('#input-validation').html(html);
                return;
            }
            else if (data.status == "voucher_limit_exceeded") {
                html = '<small class="text-danger">Voucher used exceeded.</small>';
                $('#input-validation').html(html);
                return;
            }
           
            
            if (mode_of_payment == 'COD') {
                $('#order-placed-modal').modal({
                    backdrop: 'static',
                    keyboard: false 
                });
            }
            else {  
                paynamicsPayment(opt_payment_method, voucher_code, buy_now, sku);
            }
        }
    });
});

function paynamicsPayment(pmethod, voucher_code, buy_now, sku) {
    $.ajax({
        url: '/paynamics-payment',
        type: 'POST',
        data: {
            pmethod : pmethod,
            voucher_code : voucher_code,
            buy_now : buy_now,
            sku : sku
        },
        success:function(data){
            console.log(data)
            $('#paynamics-form-container').html(data);
        }
    });
}

$(document).on('click', '.payment-method-container button', function(){ 
    $('.payment-method-container button').removeClass('active');
    $(this).addClass('active');
    let btn_active = $('.payment-method-container').find('.active');
    let payment_method = btn_active.attr('data-value');
    $('.payment-method-container button i').remove();
    let _text = '';
    let fa_class = btn_active.hasClass("active") ? 'fas fa-check-circle' : 'far fa-circle';
    if (payment_method == 'online_payment') {
        $('.payment-methods-container').removeClass('d-none');
        $('.computation-container').addClass('col-lg-12');
        _text = 'Online Payment';
        $('.payment-method-container button').html('Cash on Delivery <i class="far fa-circle float-right"></i>');
    }
    else {
        $('.payment-methods-container').addClass('d-none');
        $('.computation-container').removeClass('col-lg-12');
        _text = 'Cash on Delivery';
        $('.payment-method-container button').html('Online Payment <i class="far fa-circle float-right"></i>');
    }
    $(this).html(_text+' <i class="'+fa_class+' float-right"></i>');
});

$(document).on('click', '#btn-set-default', function(){ 
    readDefaultAddress();
});

$(document).on('click', '#btn-change-courier', function(){ 
    readCourier();
});

$(document).on('change', '[name=rdo-courier]', async function(){ 

    let courier_id = $(this).attr('data-id');
    let name = $(this).attr('data-name');
    let receive_by = $(this).attr('data-receive');

    $('#courier_id').val(courier_id);
    $('#courier_text').text(name);
    $('#receive_by_text').text(receive_by);
});



//readDefaultAddress();

