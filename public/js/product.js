document.addEventListener('DOMContentLoaded', function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }); 
    
    function fetchProduct(){
        $('#tbl-product').DataTable({
        
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
            },
          order: [[0, 'desc']],
               
           columns:[       
                {data: 'sku', name: 'sku',orderable: true},
                {data: 'name', name: 'name'},
                {data: 'category', name: 'category'},
                {data: 'subcategory', name: 'subcategory'},
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

    function choices() {
        var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
            removeItemButton: true,
          });
        var textRemove = new Choices(document.getElementById('choices-text-remove-button'), {
            delimiter: ',',
            editItems: true,
            removeItemButton: true,
          });
    
        var multipleCancelButton = new Choices('.choices-multiple', {
            removeItemButton: true,
          });
      
          var genericExamples = new Choices('[data-trigger]', {
              placeholderValue: '0',
              searchPlaceholderValue: 'Search attribute...',
              removeItemButton: true,
            });
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

function generateRandom() {
    return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
        (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
      );
}

function initComponents()
{ 
    var category_id = $('select[name=category_id]').val();
    var packaging_id = $('select[name=packaging_id]').val();
    choices();
    getSubcategory(category_id);
    getClosures(packaging_id);
    fetchProduct(); 
}

initComponents();

});

