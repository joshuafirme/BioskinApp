async function getItems (data) {

    var html = '';
        html += '<div class="col-sm-12 col-md-6 col-lg-4">';
        html += '<div class="card shadow-none p-5">';
        html += '<div class="loading responsive-img product-image" id="data-image-'+data.sku+'"></div>';
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
        html +=         '<button class="btn btn-outline-secondary btn-block m-1">Rebrand now!</button>';
        html +=     '</div>';
        html +=  '</div>';
        html +=   '</div>';
        html +=   '</div>';
        html += '</div>';

    return html;
}
           
var data_storage;
async function readProducts(category_id, object = 'category') { 
    $.ajax({
        url: '/shop/read-all-product',
        type: 'GET',
        success:async function(data){
                data_storage = data;
                let data_count = 0;
                var html = "";  
                console.log(object)
                for (var i = 0; i < data.length; i++) {
                    let ids = object == 'category' ? data[i].category_id : data[i].sub_category_id;
                    ids = ids.split(", ");
                    if (ids.includes(category_id)) {
                        html += await getItems(data[i]);
                        data_count++
                    }

                    readImage(data[i].sku);
                }
                console.log(data_count)

                if (data_count == 0) {
                    html += '<div class="col-12 mt-5 d-flex justify-content-center">';
                    html +='<p class="text-muted">No products found.</p>';
                    html += '</div>';
                }
                $('#product-container').append(html);
                
                $('.lds-ellipsis').css('display', 'none');

                

        }
    });
   
}

async function readImage(sku) {
    $.ajax({
        url: '/read-image/'+sku,
        type: 'GET',
        success:function(data){ 
            if (data) {
                var src = '/images/'+data;
                $('<img/>').attr('src', src).on('load', function() {
                    $(this).remove(); 
                    $('#data-image-'+sku).removeClass('loading');
                    $('#data-image-'+sku).css('background-image', 'url("'+src+'")');
                
                });
            }
            else {
                $('<img/>').attr('src', 'https://via.placeholder.com/450x450.png?text=No%20image%20available').on('load', function() {
                    $(this).remove(); 
                    $('#data-image-'+sku).removeClass('loading');
                    $('#data-image-'+sku).css('background-image', 'url("https://via.placeholder.com/450x450.png?text=No%20image%20available")');
                });
            }
        }
    });
}

async function readAllCategory() {
    $.ajax({
        url: '/shop/read-all-category',
        type: 'GET',
        success:function(data){ 
            var html = '';   
            for (var i = 0; i < data.length; i++) {
                html += '<a class="col-xs-6 col-sm-4 col-md-1 text-center">';
                html += '<div class="text-bold text-muted category-name" data-name="'+data[i].name+'" data-id="'+data[i].id+'">'+data[i].name+'</div>';
                html += '</a>'
            }
            $('.category-container').append(html);
        }
    });
}

async function readSubcategory(category_id) {
    $.ajax({
        url: '/read-subcategory/'+category_id,
        type: 'GET',
        success:function(data){ 
            var html = '';   
            for (var i = 0; i < data.length; i++) {
                html += '<li class=""><a class="subcategory-name" href="#" data-category-id="'+data[i].cat_id+'" data-category="'+data[i].subcategory+'" data-name="'+data[i].name+'" data-id="'+data[i].id+'">'+data[i].name+'</a></li>';
                html += '</a>'
            }
            $('.subcategory-container').append(html);
        }
    });
}

async function readCategoryName(category_id) {
    $.ajax({
        url: '/category/read-one/'+category_id,
        type: 'GET',
        success:function(data){ 
            $('.selected-category-name').text(data);
            $('[aria-current=page]').text(data);
        }
    });
}

$(document).on('click', '.subcategory-name', async function(){ 
    let object = 'sub_category';
    var subcategory_id = $(this).attr('data-id');
    var subcategory_name = $(this).attr('data-name');
    var category_id = $(this).attr('data-category-id');
    var category_name = $(this).attr('data-category');
    $('#product-container').html("");
    $('.subcategory-container').html("");
    $('.lds-ellipsis').css('display', 'block');

    $('.selected-category-name').text(subcategory_name);

    window.history.pushState(window.location.href, 'Title', '/shop/subcategory/'+subcategory_id);
   
    await readSubcategory(category_id);
    await readProducts(subcategory_id, object); 
});

$(document).on('click', '.category-name', async function(){ 
    let object = 'category';
    var category_id = $(this).attr('data-id');
    var category_name = $(this).attr('data-name');
    $('#product-container').html("");
    $('.subcategory-container').html("");
    $('.lds-ellipsis').css('display', 'block');
    $('.selected-category-name').text(category_name);
    $('[aria-current=page]').text(category_name);
    window.history.pushState(window.location.href, 'Title', '/shop/category/'+category_id);

    await readProducts(category_id); 
    await readSubcategory(category_id);
});

async function renderConponents() {
    let url = window.location.href;
    let index = url.indexOf('category/');
    let category_id = url.substring(index+9);
    await readAllCategory();
    await readSubcategory(category_id);
    await readCategoryName(category_id);
    await readProducts(category_id, 'category');
}
                             
renderConponents();