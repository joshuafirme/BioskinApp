async function getItems (data) {

    var html = '';
        html += '<div class="col-sm-12 col-md-6 col-lg-4">';
        html += '<div class="card shadow-none p-5">';
        html += '<a href="/shop/'+ data.sku +'"><div class="loading responsive-img product-image" id="data-image-'+data.sku+'"></div></a>';
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
        html +=        '<a class="btn btn-add-cart"><img src="https://img.icons8.com/external-kiranshastry-lineal-kiranshastry/34/000000/external-shopping-cart-ecommerce-kiranshastry-lineal-kiranshastry.png"/></a>';
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
var last_key = 0;        
async function readProducts(category_id, object = 'category') { 
    $.ajax({
        url: '/shop/read-all-product',
        type: 'GET',
        success:async function(data){
                data_storage = data;
                let data_count = 0;
                var html = "";  

                console.log(object)

                var enable_button = false;
                last_key = 3;
                for (var i = 0; i < last_key; i++) {
                    if (typeof data_storage[i] != 'undefined') {
                        let ids = object == 'category' ? data_storage[i].category_id : data_storage[i].sub_category_id;
                        ids = ids.split(", ");
                        if (ids.includes(category_id)) {
                            html += await getItems(data_storage[i]);
                            data_count++
                        }
                        readImage(data_storage[i].sku);
                    } 
                }
                if(data_count >= last_key){
                    enable_button = true;
                }

                if (enable_button) {
                    html += '<div class="col-12 load-more-container">';
                        html +='<button class="btn btn-sm btn-outline-success btn-load-more" data-type="all">Load more</button>';
                    html += '</div>';
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

async function readPackaging(subcategory_id, object = 'category') { 
    let url = object == 'category' ? "/shop/read-all-packaging/" : "/shop/read-packaging/"+subcategory_id;
    $.ajax({
        url: url,
        type: 'GET',
        success:async function(data){
                data_storage = data;
                let data_count = 0;
                var html = "";  
           
                for (var i = 0; i < data.length; i++) {
                    html += await getItems(data[i]);
                    data_count++
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
                html += '<li class=""><a style="cursor:pointer;" class="subcategory-name" data-category-id="'+data[i].cat_id+'" data-category="'+data[i].subcategory+'" data-name="'+data[i].name+'" data-id="'+data[i].id+'">'+data[i].name+'</a></li>';
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
        success:async function(data){ 
            $('.selected-category-name').text(data);
            $('[aria-current=page]').text(data);
            localStorage.setItem('selected-category', data);

            var category_name = localStorage.getItem('selected-category');
            if (!data || data == "") {
                await readSubcategory();
                category_name = data;
                console.log('getting category name...')
            }
            console.log(category_name+ " cat")
            setTimeout(async function(){
                if(category_name.toLowerCase().indexOf("pack") != -1) {
                    await readPackaging(category_id);
                }
                else {
                    await readProducts(category_id, 'category');
                }
            },800);
        }
    });
}

async function on_Click(category_id) {
    $(document).on('click', '.btn-load-more', async function(){
        $(this).html('<i class="fas fa-spinner fa-spin"></i>');
        setTimeout(async function() {
            $('.btn-load-more').hide();
            console.log(data_storage)
            var object = 'category';
            var html = "";
            var enable_button = false;
            var old_last_key = last_key;
            let data_count = 0;
            last_key = old_last_key + 3;
            for (var i = old_last_key; i < last_key; i++) {
                if (typeof data_storage[i] != 'undefined') {
                    let ids = object == 'category' ? data_storage[i].category_id : data_storage[i].sub_category_id;
                    ids = ids.split(", ");
                    if (ids.includes(category_id)) {
                        html += await getItems(data_storage[i]);
                    }
                    readImage(data_storage[i].sku);  console.log(data_storage[i])
                    data_count++;
                }
            }
            
            console.log(data_count+ " "+last_key)
            if (data_count >= last_key) {
                enable_button = true;
            }
            if (enable_button) {
                html += '<div class="col-12 load-more-container">';
                    html +='<button class="btn btn-sm btn-outline-success btn-load-more">Load more</button>';
                html += '</div>';
            }
            $('#product-container').append(html);
                
            $('.lds-ellipsis').css('display', 'none');
            
            
        },300)
        
    });
    
    $(document).on('click', '.subcategory-name', async function(){ 
        let object = 'sub_category';
        var subcategory_id = $(this).attr('data-id');
        var subcategory_name = $(this).attr('data-name');
        $('#product-container').html("");
        $('.lds-ellipsis').css('display', 'block');
    
        //$('.selected-category-name').text(subcategory_name);
    
        window.history.pushState(window.location.href, 'Title', '/shop/subcategory/'+subcategory_id);
    
        var category_name = localStorage.getItem('selected-category');
        if (!category_name || category_name == "") {
            category_name = $('[aria-current=page]').text(data);
        }
        console.log(category_name)
        if (category_name.toLowerCase().indexOf("pack") != -1) {
            await readPackaging(subcategory_id, object); 
            console.log('read pack')
            console.log(object)
        }
        else {
            await readProducts(subcategory_id, object); 
        }
    });
    
    $(document).on('click', '.category-name', async function(){ 
        var category_id = $(this).attr('data-id');
        var category_name = $(this).attr('data-name');
        $('#product-container').html("");
        $('.subcategory-container').html("");
        $('.lds-ellipsis').css('display', 'block');
        $('.selected-category-name').text(category_name);
        $('[aria-current=page]').text(category_name);
    
        window.history.pushState(window.location.href, 'Title', '/shop/category/'+category_id);
    
        if (category_name.toLowerCase().indexOf("pack") != -1) {
            await readPackaging(category_id);
        }
        else {
            await readProducts(category_id); 
        }
        await readSubcategory(category_id);
    });
}

async function renderConponents() {
    let url = window.location.href;
    let index = url.indexOf('category/');

    let category_id = url.substring(index+9);

    const read_subcategory = await readSubcategory(category_id);
    const read_category = await readCategoryName(category_id);
    const read_all_cat = await readAllCategory();
    const on_click = await on_Click(category_id);

   

}
                             
renderConponents();