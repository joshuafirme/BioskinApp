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
                {data: 'closure',name: 'closure'},    
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

