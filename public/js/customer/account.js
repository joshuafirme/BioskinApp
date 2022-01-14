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
    let address = "-";
    if (data.province && data.municipality) {
        address = data.province+', '+data.municipality+' '+data.brgy;
    }
    html +=     '<div class="col-sm-10"><div class="m-2">'+address+'</div></div>';
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
    html += '<button class="btn btn-secondary m-1 btn-update-address" data-id="'+data.id+'" data-toggle="modal" data-target="#address-modal" ';
    html += 'data-name="'+data.name+'" data-phone="'+data.phone_no+'" data-region="'+data.region+'" ';
    html += 'data-province="'+data.province+'" data-municipality="'+data.municipality+'" data-brgy="'+data.brgy+'" ';
    html += 'data-detailed-loc="'+data.detailed_loc+'" data-notes="'+data.notes+'">Change</button>';
    
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
                html += '<p class="text-center text-muted">No address.</p>';
                $('.addresses-main-container').html(html);
            }
        }
    });
}

$(document).on('click','#btn-save-address', function(e){
    e.preventDefault();
    var btn = $(this);

    var fullname = $('#fullname').val();
    var phone_no = $('#phone_no').val();
    var region = $('#region').val();
    var province = $('#province').val();
    var municipality = $('#municipality').val();
    var brgy = $('#brgy').val();
    var detailed_loc = $('#detailed_loc').val();
    var notes = $('#notes').val();

    var action = $('#address-modal').attr('data-action');
    var id = $('#address-modal').attr('data-id');
    console.log(id)
    var url = '/account/add-address';

    if (action == "update") {
        url = '/account/update-address/'+id;
    }

    if (fullname && phone_no && region && province && municipality && brgy && detailed_loc || notes) {
        btn.html('<i class="fas fa-spinner fa-pulse"></i>');
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                fullname     : fullname,
                phone_no     : phone_no,
                region       : region,
                province     : province,
                municipality : municipality,
                brgy         : brgy,
                detailed_loc : detailed_loc,
                notes        : notes
            },
            success: function(data){
                $('#address-modal').modal('hide');
                btn.html('Add');
                $.toast({
                    text: 'Address was successfully saved!',
                    showHideTransition: 'plain',
                    hideAfter: 3500, 
                });
                
                
                readAddresses();
            }
        });
    }
    else {
        $.toast({
            text: 'Please fill all the details.',
            showHideTransition: 'plain',
            hideAfter: 3500, 
        });
    }
    
});

$(document).on('click','#btn-delete-address', function(e){
    e.preventDefault();
    var id = $(this).attr('data-id');
    $('.modal-body').find('p').text("Are you sure you want to delete this address?");
    $('#delete-record-modal').modal('show');
    $('.btn-confirm-delete').attr('data-id', id);
});

$(document).on('click','.btn-confirm-delete', async function(){
    let id = $(this).attr('data-id');
    let btn = $(this);
    let address_item = $('[data-id="'+id+'"]');
    btn.html('<i class="fas fa-spinner fa-pulse"></i>');

    $.ajax({
        url: '/account/delete-address/'+id,
        type: 'POST',
        success: function(data){
            $('#delete-record-modal').modal('hide');
            address_item.parent().fadeOut();
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

$(document).on('click','.btn-update-address', function(e){
    e.preventDefault();
    let el = $(this);
    let modal = $('#address-modal');
    modal.attr("data-action", "update");
    modal.attr("data-id", el.attr('data-id'));
    modal.find('.modal-title').text("Update address");
    $('#btn-save-address').text("Update");

    $('#fullname').val(el.attr('data-name'));
    $('#phone_no').val(el.attr('data-phone'));
    $('#detailed_loc').val(el.attr('data-detailed-loc'));
    $('#notes').val(el.attr('data-notes'));

    let selected_region = el.attr('data-region');
    let selected_province = el.attr('data-province');
    let selected_municipality = el.attr('data-municipality');
    let selected_brgy = el.attr('data-brgy');
   
    populateRegions(selected_region, selected_province, selected_municipality, selected_brgy)
    
});



$(document).on('change','#region', function(e){
    e.preventDefault();
    var region = $(this).val();
    getProvinces(region);
    
});

$(document).on('change','#province', function(e){
    e.preventDefault();
    var province = $(this).val();
    getMunicipalities(province);
    
});

$(document).on('change','#municipality', function(e){
    e.preventDefault();
    var municipality = $(this).val();
    getBrgys(municipality);
    
});

$(document).on('click','#btn-add-new-address', function(e){

    let modal = $('#address-modal');

    modal.attr("data-action", "add");
    modal.find('.modal-title').text("Add new address");

    $('#btn-save-address').text("Add");
    populateRegions();
    
});

$('#confirm-password').on('blur', function() {
    var password = $('#password').val();
    var confirm_password = $(this).val();
    if (confirm_password.replace(/ /g, '').length >= 6) {
        if (password == confirm_password) {
            return true;
        } else {
            alert('Password do not match!');
        }
    } else {
        alert('Minimum of 6 characters!')
    }

});

$(document).on('click','#btn-update-password', function(e){
    let btn = $(this);
    let password = $('#password').val();
    let confirm_password = $('#confirm-password').val();
    
    if (password && confirm_password) {
        btn.html('<i class="fas fa-spinner fa-spin"></i>')
        $.ajax({
            url: '/account/change-password',
            type: 'POST',
            data: {
                password : password
            },
            success:function(data){
                btn.html("Save")
                $.toast({
                    text: 'Password was updated successfully.',
                    showHideTransition: 'plain',
                    hideAfter: 3500, 
                });
            }
          });
    }
    else {
        $.toast({
            text: 'Please input your new password.',
            showHideTransition: 'plain',
            hideAfter: 3800, 
        });
    }
});


function populateRegions(selected_region = "", selected_province = "", selected_municipality = "", selected_brgy = "") {
    fetch('https://raw.githubusercontent.com/flores-jacob/philippine-regions-provinces-cities-municipalities-barangays/master/philippine_provinces_cities_municipalities_and_barangays_2019v2.json')
          .then(function(response) {
            response.json().then(function(data) { 
              Object.keys(data).forEach(function(key) {
                let selected = selected_region == key ? "selected" : "";
                $('select[name=region]').append('<option '+selected+' value="' + key + '">' + data[key].region_name + '</option>');
              });

              getProvinces($('#region').val(), selected_province, selected_municipality, selected_brgy);
            });
          })
          .catch(function(error) {
            console.error(error);
          }); 
}

function getProvinces(region, selected_province = "", selected_municipality = "", selected_brgy = "") {
    $.ajax({
        url: '/get-provinces/'+region,
        type: 'GET',
        success:function(data){ 
            $('select[name=province]').empty();
            Object.keys(data).forEach(function(province) { 
                let selected = selected_province == province ? "selected" : "";
                $('select[name=province]').append('<option '+selected+' value="' + province + '">' + province + '</option>');
            });

            getMunicipalities($('select[name=province]').val(), selected_municipality, selected_brgy)
        }
      });
}

function getMunicipalities(province, selected_municipality = "", selected_brgy = "") {
    var region = $('#region').val();
    $.ajax({
        url: '/get-municipalities',
        type: 'GET',
        data: {
            province : province,
            region : region
        },
        success:function(data){ 
            
            $('select[name=municipality]').empty();
            Object.keys(data).forEach(function(municipality) {
                let selected = selected_municipality == municipality ? "selected" : "";
                $('select[name=municipality]').append('<option '+selected+' value="' + municipality + '">' + municipality + '</option>');
            });

            getBrgys($('select[name=municipality]').val(), selected_brgy);
        }
      });
}

function getBrgys(municipality, selected_brgy) {
    var region = $('#region').val(); console.log(selected_brgy+" selected brgy")
    var province = $('#province').val();
    $.ajax({
        url: '/get-brgys',
        type: 'GET',
        data: {
            municipality : municipality,
            region       : region,
            province     : province
        },
        success:function(data){ 
            
            $('select[name=brgy]').empty();
            data.forEach(function(brgy) {
                let selected = selected_brgy == brgy ? "selected" : "";
                $('select[name=brgy]').append('<option '+selected+' value="' + brgy + '">' + brgy + '</option>');
            });
        }
      });
}

readAddresses();