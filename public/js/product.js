document.addEventListener('DOMContentLoaded', function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }); 
    
    function fetchProduct(object = 'product'){
        $('.tbl-'+object).DataTable({
        
           processing: true,
           serverSide: true,
           ajax: '/path/to/script',
           scrollY: 470,
           scroller: {
               loadingIndicator: true
           },
            ajax:{
                url: "/read-product",
                type:"GET",
                data: {
                    object : object
                }
            },
          order: [[0, 'desc']],
               
           columns:[       
                {data: 'sku', name: 'sku',orderable: true},
                {data: 'name', name: 'name'},
                {data: 'category', name: 'category'},
                {data: 'subcategory', name: 'subcategory'},
                {data: 'qty', name: 'qty'},
                {data: 'variation', name: 'variation'},
                {data: 'size', name: 'size'},
                {data: 'price', name: 'price'},
                {data: 'volumes',name: 'volumes'},
                {data: 'packaging',name: 'packaging'}, 
                {data: 'closures',name: 'closures'},    
                {data: 'action', name: 'action',orderable: false},
           ]
          });
    }

    function readPricePerVolume(sku) {
        
        $.ajax({
            url: '/read-price-per-volume/'+sku,
            tpye: 'GET',
            success:function(data){  console.log(data)
                populatePriceDOM(data);
            }
          });
    }

    function removePricePerVolume(sku, volume) {
        
        $.ajax({
            url: '/remove-price-per-volume',
            type: 'POST',
            data: {
                sku: sku,
                volume: volume
            },
            success:function(data){  console.log(data)
                if (data.status == 'success'){
                    $.toast({
                        text: volume + ' volume was removed.',
                        showHideTransition: 'plain',
                        hideAfter: 4500, 
                    });
                }
            }
          });
    }
    function populatePriceDOM(data){
        $.each(data, function(i, v){  
            var price_html = "";
            price_html += '<div class="col-sm-12 col-md-3 col-lg-2 mt-sm-2 price-input-'+data[i].volume+'">';
            price_html += '<label class="col-form-label price-label-'+data.volume+'">Price for '+data[i].volume+' volume</label>';
            price_html += '<input class="form-control choices-text-remove-button" name="prices[]" type="number" step="any" value="'+data[i].price+'" required></div>' ; 
        $('.price-container').append(price_html);
        });
        $('.loader-container').remove();
    }
    function choices() {
        if ($('#choices-multiple-remove-button').length > 0) {
            var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
                removeItemButton: true,
              });
        }

        if ($('#choices-text-remove-button').length > 0) {
           
            const element = document.getElementById('choices-text-remove-button');
            const example = new Choices(element, {
                delimiter: ',',
                editItems: true,
                removeItemButton: true,
            });
            
            element.addEventListener(
                'addItem',
                function(event) {
                // do something creative here...
                console.log(event.detail.id);
                console.log(event.detail.value);
                console.log(event.detail.label);

                var price_html = '<div class="col-sm-12 col-md-3 mt-sm-2 price-input-'+event.detail.value+'">';
                    price_html += '<label class="col-form-label price-label-'+event.detail.value+'">Price for '+event.detail.value+' volume</label>';
                    price_html += '<input class="form-control choices-text-remove-button" name="prices[]" type="text" required></div>' ; 

                $('.price-container').append(price_html);

                },
                false,
            );

            element.addEventListener(
                'removeItem',
                function(event) {
                // do something creative here...
                console.log(event.detail.id);
                console.log(event.detail.value);
                console.log(event.detail.label);

                var sku = $('input[name=sku]').val();

                $('.price-input-'+event.detail.value).remove();
                removePricePerVolume(sku, event.detail.value);
                },
                false,
            );
        }
        if ($('.choices-multiple').length > 0) {
            var multipleCancelButton = new Choices('.choices-multiple', {
                removeItemButton: true,
              });
        }
        if ($('[data-trigger]').length > 0) {
          var genericExamples = new Choices('[data-trigger]', {
              placeholderValue: '0',
              searchPlaceholderValue: 'Search attribute...',
              removeItemButton: true,
            }); 
        }
    }

    $(document).on('change','[name="category_id"]', function(){ 
        if ($(this).find("option:selected").text() == 'Packaging') {
          $('.packaging').hide();
        }
        else {
          $('.packaging').show();
        }
    });

    
$(document).on('change', 'select[name=category_id]', function(){
    var category_id = $(this).val();
       
    getSubcategory(category_id);
    
});         
     

function getSubcategory(category_id) {

    $.ajax({
        url: '/read-subcategory/'+category_id,
        tpye: 'GET',
        success:function(data){ console.log(data)
            populateDropdown(data, 'sub_category');
        }
      });
}

function populateDropdown(data, object){ 
    var selected = ""; 
    var selected_id= $('select[name='+ object +'_id] :selected').val();
    if(!selected_id){
        selected_id= $('select[name='+ object +'_id] option:first').val();
    }
    if(data.length > 0) {
        $('select[name='+ object +'_id]').empty();
        for (var i = 0; i < data.length; i++) 
        {
            selected = data[i].id == selected_id ? "selected" : "";

            $('select[name='+ object +'_id]').append('<option '+selected+' value="' + data[i].id + '">' + data[i].name + '</option>');
     
        }
    }
    else {
        $('select[name='+ object +'_id]').empty()
    }
       
}

$(document).on('change', 'select[name=packaging_id]', function(){
    var packaging_id = $(this).val();
    getClosures(packaging_id);
    
}); 

var product_id;
$(document).on('click', '.btn-archive-product', function(){ 
    product_id = $(this).attr('data-id');
    var row = $(this).closest("tr");
    var name = row.find("td:eq(1)").text();console.log(name)
    $('.delete-success').hide();
    $('.delete-message').html('Are you sure do you want to archive <b>'+ name +'</b> ?');
  }); 
  
$(document).on('click', '.btn-confirm-archive', function(){
    $.ajax({
        url: '/product/archive/'+ product_id,
        type: 'POST',
      
        beforeSend:function(){
            $('.btn-confirm-archive').text('Please wait...');
        },
        
        success:function(){
            setTimeout(function(){
                $('.btn-confirm-archive').text('Yes');
                $('#confirmModal').modal('hide');
                $('.tbl-product').DataTable().ajax.reload();
                $.toast({
                    text: 'Product was successfully deleted.',
                    showHideTransition: 'plain',
                    hideAfter: 4500, 
                });
            }, 1000);
        }
    });
  
});
     
function getClosures(packaging_id) {

    $.ajax({
        url: '/read-closures/'+packaging_id,
        tpye: 'GET',
        success:function(data){ 
            populateDropdown(data, 'cap')
    
        }
      });
}


$(document).on('click', '.btn-delete-image', function(){ 
    var id = $(this).attr('data-id');
    var $this = $(this);
    $.ajax({
        url: '/delete-image/'+id,
        type: 'POST',
        beforeSend:function(){
            $this.html('<i class="fas fa-spinner fa-spin"></i>');
        },
        success:function(data){
            setTimeout(function() {
                $this.html('Delete photo');
                $this.closest('.image-container').remove(); 
                $.toast({
                    text: 'Image was deleted.',
                    showHideTransition: 'plain'
                });
            },300);
        }
    });
  }); 


$(document).on('click', '#btn-generate-varation-code', function(){ 
    $('[name=variation_code]').val(generateRandom());
}); 

$(document).on('click', '.btn-archive', function(){
    let id = $(this).attr('data-id');
    $('#btn-confirm').attr('data-id', id);
    $('.modal-title').text('Archive confirmation');
    $('#confirmation-modal p').text('Are you sure do you want to archive this data?');
});

$(document).on('click', '#btn-confirm', function(){
    let id = $(this).attr('data-id');
    let btn = $(this);
    btn.html('Please wait...')
    $.ajax({
        url: '/archive/do-archive/'+id,
        type: 'POST',
        success:function(){
            btn.html("Yes");
            $('#confirmation-modal').modal('hide');
            $('.tbl-product').DataTable().ajax.reload();
        }
    });
});


function generateRandom() {
    return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
        (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
      );
}

function initComponents()
{ 
    var category_id = $('select[name=category_id]').val();
    var sku = $('input[name=sku]').val();
    choices();
    if ($('select[name=category_id]').length > 0) {
        getSubcategory(category_id);
    }
    if ($('.tbl-product').length > 0) {
        fetchProduct(); 
    }
    else if ($('.tbl-packaging').length > 0) {console.log('pack')
        fetchProduct('packaging');  
    }

    readPricePerVolume(sku);
}

initComponents();

});

