document.addEventListener('DOMContentLoaded', function() {

    var multipleCancelButton = new Choices('.choices-multiple', {
      removeItemButton: true,
    });

    var genericExamples = new Choices('[data-trigger]', {
        placeholderValue: '0',
        searchPlaceholderValue: 'Search attribute...',
        removeItemButton: true,
      });

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
            if($('select[name=sub_category_id] option').length == 1) {
                for (var i = 0; i < data.length; i++) 
                {
                    $('select[name=sub_category_id]').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                }
            }
            else {
                $('select[name=sub_category_id]').empty();
                for (var i = 0; i < data.length; i++) 
                {
                    $('select[name=sub_category_id]').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                }
            }
            
           
    
        }
      });
}

$(document).on('change', 'select[name=packaging_id]', function(){
    var packaging_id = $(this).val();
    getClosures(packaging_id);
    
});         
     
function getClosures(packaging_id) {

    $.ajax({
        url: '/read-closures/'+packaging_id,
        tpye: 'GET',
        success:function(data){ console.log(data)
            if($('select[name=cap_id] option').length == 1) {
                for (var i = 0; i < data.length; i++) 
                {
                    $('select[name=cap_id]').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                }
            }
            else {
                $('select[name=cap_id]').empty();
                for (var i = 0; i < data.length; i++) 
                {
                    $('select[name=cap_id]').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                }
            }
            
           
    
        }
      });
}

function initComponents()
{ 
    var category_id = $('select[name=category_id]').val();
       
    getSubcategory(category_id);
}

initComponents();

});