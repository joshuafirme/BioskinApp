function getItems (data) {

    var html = '';
        html += '<div class="col-sm-12 col-md-6 col-lg-4">';
        html += '<div class="card shadow-none category-container p-5" style="width: 100%;">';
    
        html += '<div class="responsive-img" id="data-image-'+data.sku+'"></div>';
        html += '<div class="product-details">';

        html += '<div class="m-2">';
        html +=  '<div class="text-dark text-bold mt-1">'+data.name+'</div>';
        html +=   '<div class="text-muted mt-1">'+data.size+'</div>';
        html +=   '<div class="text-muted mt-1">'+data.price+'</div>';
        html +=   '</div>';

        html += '<div class="row product-buttons mt-2">';
        html +=   '<div class="col-10">';
        html +=      '<button class="btn btn-success btn-block m-1">Buy now</button>';
        html +=   '</div>';
        html +=    '<div class="col-2">';
        html +=        '<img src="https://img.icons8.com/external-kiranshastry-lineal-kiranshastry/34/000000/external-shopping-cart-ecommerce-kiranshastry-lineal-kiranshastry.png"/>';
        html +=     '</div>';
        html +=     '<div class="col-12">';
        html +=         '<button class="btn btn-secondary btn-block m-1">Rebrand now!</button>';
        html +=     '</div>';
        html +=  '</div>';
        html +=   '</div>';
        html +=   '</div>';
        html += '</div>';

    return html;
}
           
var data_storage;
function readProductsByCategory(category_id) { 
    $.ajax({
        url: '/shop/read-all-product',
        type: 'GET',
        success:function(data){
          
                data_storage = data;
                for (var i = 0; i < data.length; i++) {
                    var html = "";   
                    if (data[i].category_id.indexOf(category_id) != -1) {
                        html += getItems(data[i]);
                    }
                    $('#product-container').append(html);

                    readImage(data[i].sku);
                }
                console.log(data_storage)
                $('.lds-ellipsis').css('display', 'none');
                

        }
    });
   
}
function readImage(sku) {
    $.ajax({
        url: '/read-image/'+sku,
        type: 'GET',
        success:function(data){  
            $('#data-image-'+sku).css('background-image', 'url("/images/'+data+'")')
        }
    });
}

function readCategory() {
    $.ajax({
        url: '/shop/read-all-category',
        type: 'GET',
        success:function(data){ 
            var html = '';   
            for (var i = 0; i < data.length; i++) {
                html += '<a class="col-xs-6 col-sm-4 col-md-1 text-center">';
                html += '<div class="text-bold text-muted category-name"  data-id="'+data[i].id+'">'+data[i].name+'</div>';
                html += '</a>'
            }
            $('.category-container').append(html);
        }
    });
}




$(document).on('click', '.category-name', async function(){ 
    var category_id = $(this).attr('data-id');
    $('#product-container').html("");
    $('.lds-ellipsis').css('display', 'block');
    readProductsByCategory(category_id); 
});

function renderConponents() {
    let url = window.location.href;
    let index = url.indexOf('category/');
    let category_id = url.substring(index+9);
    readCategory();
    readProductsByCategory(category_id); 
}
                             
renderConponents();