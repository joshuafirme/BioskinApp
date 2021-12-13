function readDefaultAddress() {
    $.ajax({
        url: '/read-default-address/',
        type: 'GET',
        success:function(data){  
            $('#fullname').text(data.name);
            $('#phone_no').text(data.phone_no);
            $('#address').text(data.address);
        }
    });
}

function getItems (data,identifier) {
    var html = '<input type="radio" name="rdo-address" data-id="'+data.id+'" data-name="'+data.name+'" data-address="'+data.address+'" data-phone="'+data.phone_no+'">';
    html += '<div class="address-container">';
    html += '<div class="address-container">';
    html += '<div class="form-group row">';
    html +=     '<label for="input" class="col-sm-2 col-form-label">Fullname</label>';
    html +=      '<div class="col-sm-10">';
    html +=         '<div class="m-2">'+data.name+'</div>';
    html +=     '</div>';
    html +='</div>';
    html += '<div class="form-group row">';
    html +=     '<label for="input" class="col-sm-2 col-form-label">Address</label>';
    html +=     '<div class="col-sm-10"><div class="m-2">'+data.address+'</div></div>';
    html += '</div>';
    html +=  '<div class="form-group row">';
    html +=     '<label for="input" class="col-sm-2 col-form-label">Phone number</label>';
    html +=     '<div class="col-sm-10">';
    html +=          '<div class="m-2">'+data.phone_no+'</div>';
    html +=     '</div>';
    html +=  '</div>';
    html += '<hr></div>';

    return html;
}


function readAddresses() {
    var html = '';
    $.ajax({
        url: '/account/read-addresses',
        type: 'GET',
        success:async function(data){  
            console.log(data)
            if (data.length > 0) {
                for (var i = 0; i < data.length; i++) {   
                    if (typeof data[i] != 'undefined') { 
                        html += getItems(data[i], i);
                    } 
                }
                $('.addresses-main-container').html(html);
            }
            else {
                html += '<p class="text-center text-muted">No address.</p>';
                $('.addresses-main-container').html(html);
            }
        }
    });
}

$('#btn-change-address').on('click', function(){
    readAddresses();
});

$(document).on('change', '[name=rdo-address]', async function(){ 

    let name = $(this).attr('data-name');
    let address = $(this).attr('data-address');
    let phone = $(this).attr('data-phone');

    $('#fullname').text(name);
    $('#address').text(address);
    $('#phone_no').text(phone);
});

$(document).on('click', '#btn-set-default', function(){ 
    readDefaultAddress();
});


readDefaultAddress();