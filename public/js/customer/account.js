function getItems (data,identifier) {
    var html = '';

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
    if (data.is_active == 1) {
        html += '<div class="text-success m-2">Default</div>';
    }
    else {
        html += '<button class="btn btn-secondary m-1" data-id="'+data.id+'" id="btn-set-as-default">Set as default</button>';
    }
    html += '<button class="btn btn-secondary m-1">Change</button>';
    html += '<button class="btn btn-secondary m-1" data-id="'+data.id+'" id="btn-delete-address">Delete</button>';
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
                html =+ '<p class="text-center text-muted">Cart is empty.</p>';
                $('.addresses-main-container').html(html);
            }
        }
    });
}

$(document).on('click','#btn-save-address', function(e){
    e.preventDefault();
    var btn = $(this);
    btn.html('<i class="fas fa-spinner fa-pulse"></i>');

    var fullname = $('#fullname').val();
    var address = $('#address').val();
    var phone_no = $('#phone_no').val();

    $.ajax({
        url: '/account/add-address',
        type: 'POST',
        data: {
            fullname : fullname,
            address  : address,
            phone_no : phone_no
        },
        success: function(data){
            $('#add-address-modal').modal('hide');
            btn.html('Add');
            $.toast({
                text: 'Address was successfully saved!',
                showHideTransition: 'plain',
                hideAfter: 3500, 
            });
            
            
            readAddresses();
        }
    });
    
});

$(document).on('click','#btn-delete-address', function(e){
    e.preventDefault();
    var btn = $(this);
    var id = $(this).attr('data-id');

    btn.html('<i class="fas fa-spinner fa-pulse"></i>');

    $.ajax({
        url: '/account/delete-address/'+id,
        type: 'POST',
        success: function(data){
            btn.parent().fadeOut();
            btn.html('Delete');
            $.toast({
                text: 'Address was successfully deleted!',
                showHideTransition: 'plain',
                hideAfter: 3500, 
            });
        
        }
    });
    
});

$(document).on('click','#btn-set-as-default', function(e){
    e.preventDefault();
    var btn = $(this);
    var id = $(this).attr('data-id');

    btn.html('<i class="fas fa-spinner fa-pulse"></i>');

    $.ajax({
        url: '/account/address-set-default/'+id,
        type: 'POST',
        success: function(data){
            readAddresses();
            $.toast({
                text: 'Default address was successfully changed.',
                showHideTransition: 'plain',
                hideAfter: 3500, 
            });
        
        }
    });
    
});




readAddresses();