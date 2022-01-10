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

    if (fullname && phone_no && region && province && municipality && brgy && detailed_loc || notes) {
        btn.html('<i class="fas fa-spinner fa-pulse"></i>');
        $.ajax({
            url: '/account/add-address',
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

    populateRegions();
    
});

function populateRegions() {
    fetch('https://raw.githubusercontent.com/flores-jacob/philippine-regions-provinces-cities-municipalities-barangays/master/philippine_provinces_cities_municipalities_and_barangays_2019v2.json')
          .then(function(response) {
            response.json().then(function(data) { 
              Object.keys(data).forEach(function(key) {
                $('select[name=region]').append('<option value="' + key + '">' + data[key].region_name + '</option>');
              });

              getProvinces($('#region').val());
            });
          })
          .catch(function(error) {
            console.error(error);
          }); 
}

function getProvinces(region) {
    $.ajax({
        url: '/get-provinces/'+region,
        tpye: 'GET',
        success:function(data){ 
            $('select[name=province]').empty();
            Object.keys(data).forEach(function(province) { console.log(province)
                $('select[name=province]').append('<option value="' + province + '">' + province + '</option>');
            });

            getMunicipalities($('select[name=province]').val())
        }
      });
}

function getMunicipalities(province) {
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
                $('select[name=municipality]').append('<option value="' + municipality + '">' + municipality + '</option>');
            });

            getBrgys($('select[name=municipality]').val());
        }
      });
}

function getBrgys(municipality) {
    var region = $('#region').val();
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
                $('select[name=brgy]').append('<option value="' + brgy + '">' + brgy + '</option>');
            });
        }
      });
}

readAddresses();