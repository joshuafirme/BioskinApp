async function getItems(data) {
    let category_name = $('#category-name-hidden').val();

    var html = '';
    html += '<div class="col-sm-12 col-md-6 col-lg-4">';
    html += '<div class="card shadow-none p-5">';
    html += '<a href="/shop/' + data.sku + '/' + category_name + '"><div class="loading responsive-img product-image" id="data-image-' + data.sku + '"></div></a>';
    html += '<div class="product-details">';

    html += '<div class="m-2">';
    html += '<div class="text-dark text-bold mt-1">' + data.name + '</div>';
    let qty_text = 'Qty: ' + data.qty;
    if (data.qty == 0) {
        qty_text = '<span class="text-danger">Out of stock</span>';
    }
    html += '<div class="text-muted mt-1 float-right">' + qty_text + '</div>';
    html += '<div class="text-muted mt-1">' + data.size + '</div>';
    html += '<div class="text-muted mt-1">₱' + data.price + '</div>';
    html += '</div>';
    if (data.qty > 0) {

        html += '<div class="row product-buttons mt-2">';
        html += '<div class="col-10">';
        html += '<button class="btn btn-success btn-block m-1">Buy now</button>';
        html += '</div>';
        html += '<div class="col-2">';
        html += '<a data-sku="' + data.sku + '" data-price="' + data.price + '" data-order-type="0" class="btn btn-add-cart"><img src="https://img.icons8.com/external-kiranshastry-lineal-kiranshastry/34/000000/external-shopping-cart-ecommerce-kiranshastry-lineal-kiranshastry.png"/></a>';
        html += '</div>';
        if (data.rebranding == 1) {
            html += '<div class="col-12">';
            html += '<a href="/rebrand/' + data.sku + '/' + category_name + '" class="btn btn-outline-secondary btn-block m-1">Rebrand now!</a>';
            html += '</div>';
        }
    }
    html += '</div>';
    html += '</div>';
    html += '</div>';
    html += '</div>';

    return html;
}

async function filterByCategory(data, object, category_id) {

    var seen = {};
    var out = [];
    var len = data.length;
    var j = 0;
    for (var i = 0; i < len; i++) {
        var item = data[i];
        let ids = object == 'category' ? data[i].category_id : data[i].sub_category_id;
        ids = ids.split(", ");
        if (ids.includes(category_id)) {
            seen[item.id] = 1;
            out[j++] = item;
        }
    }
    return out;
}

var data_storage;
var last_key = 0;
async function readProducts(category_id, object = 'category', type = 'product') {
    $.ajax({
        url: '/shop/read-all-' + type,
        type: 'GET',
        data: {
            object: type
        },
        success: async function(data) {

            data_storage = await filterByCategory(data, object, category_id);

            let data_count = 0;
            var html = "";

            console.log(object)

            var enable_button = false;
            last_key = 6;
            for (var i = 0; i < last_key; i++) {
                if (typeof data_storage[i] != 'undefined') {
                    html += await getItems(data_storage[i]);
                    data_count++
                }
            }
            if (data_storage.length > last_key) {
                enable_button = true;
            }

            if (enable_button) {
                html += '<div class="col-12 load-more-container">';
                html += '<button class="btn btn-sm btn-outline-success btn-load-more" data-type="all">Load more</button>';
                html += '</div>';
            }


            if (data_count == 0) {
                html += '<div class="col-12 mt-5 d-flex justify-content-center">';
                html += '<p class="text-muted">No products found.</p>';
                html += '</div>';
            }
            $('#product-container').append(html);
            for (var i = 0; i < last_key; i++) {
                if (typeof data_storage[i] != 'undefined') {
                    readImage(data_storage[i].sku);
                }
            }
            makeResponvie();
            $('.lds-ellipsis').css('display', 'none');



        }
    });

}

async function readPackaging(subcategory_id, object = 'category') {
    let url = object == 'category' ? "/shop/read-all-packaging/" : "/shop/read-packaging/" + subcategory_id;
    $.ajax({
        url: url,
        type: 'GET',
        success: async function(data) {
            data_storage = data;
            let data_count = 0;
            var html = "";

            for (var i = 0; i < data.length; i++) {
                html += await getItems(data[i]);
                data_count++
                readImage(data[i].sku);
            }


            if (data_count == 0) {
                html += '<div class="col-12 mt-5 d-flex justify-content-center">';
                html += '<p class="text-muted">No products found.</p>';
                html += '</div>';
            }
            $('#product-container').append(html);

            $('.lds-ellipsis').css('display', 'none');

            makeResponvie();

        }
    });

}

async function readImage(sku) {
    $.ajax({
        url: '/read-image/' + sku,
        type: 'GET',
        success: function(data) {
            if (data) {
                var src = '/images/' + data;
                $('<img/>').attr('src', src).on('load', function() {
                    $(this).remove();
                    $('#data-image-' + sku).removeClass('loading');
                    document.getElementById('data-image-' + sku).style.backgroundImage = 'url(' + src + ')';

                });
            } else {
                $('<img/>').attr('src', 'https://gmalcilk.sirv.com/243977931_6213185145420681_2932561991829971205_n.png').on('load', function() {
                    $(this).remove();
                    $('#data-image-' + sku).removeClass('loading');
                    document.getElementById('data-image-' + sku).style.backgroundImage = 'url("https://gmalcilk.sirv.com/243977931_6213185145420681_2932561991829971205_n.png")';
                });
            }
        }
    });
}

async function readAllCategory() {
    $.ajax({
        url: '/shop/read-all-category',
        type: 'GET',
        success: function(data) {
            var html = '';
            let col_count = 1;
            col_count = data.length > 9 ? '2' : '1';
            for (var i = 0; i < data.length; i++) {
                let wording = data[i].wording ? data[i].wording : "";
                html += '<a class="p-1 ml-3 mr-3 text-center">';
                html += '<div class="text-muted category-name" data-name="' + data[i].name + '" ';
                html += 'data-wording="' + wording + '" data-id="' + data[i].id + '">' + data[i].name + '</div>';
                html += '</a>'
            }
            $('.category-container').append(html);
        }
    });
}

async function readSubcategory(category_id) {
    $.ajax({
        url: '/read-subcategory/' + category_id,
        type: 'GET',
        success: function(data) {
            var html = '';
            for (var i = 0; i < data.length; i++) {
                html += '<li class=""><a style="cursor:pointer;" class="subcategory-name" data-category-id="' + data[i].cat_id + '" data-category="' + data[i].subcategory + '" data-name="' + data[i].name + '" data-id="' + data[i].id + '">' + data[i].name + '</a></li>';

            }
            $('.subcategory-container').append(html);
        }
    });
}

async function readCategoryName(category_id, object = 'category', subcategory_id) {
    $.ajax({
        url: '/category/read-one/' + category_id,
        type: 'GET',
        success: async function(data) {
            console.log('===============')
            console.log(data.name)
            $('.selected-category-name').text(data.name);
            if (data.wording != "" && data.wording != null) {
                $('.wording-container').html('<h5 class="text-center text-dark" id="wording-text">' + data.wording + '</h5>');
            } else {
                $('.wording-container').html('');
            }

            $('[aria-current=page]').text(data.name);
            localStorage.setItem('selected-category', data.name);

            var category_name = localStorage.getItem('selected-category');

            $('#category-name-hidden').val(category_name);
            if (!data.name || data.name == "") {
                await readSubcategory();
                category_name = data.name;
            }

            setTimeout(async function() {
                if (category_name.toLowerCase().indexOf("pack") != -1) {
                    await readProducts(category_id, object, 'packaging');
                } else {
                    if (object.indexOf('sub_category') != -1) {
                        category_id = subcategory_id;
                    }
                    await readProducts(category_id, object);
                }
            }, 800);
        }
    });
}
async function readCategoryID(subcategory_id) {
    $.ajax({
        url: '/read-category-id/' + subcategory_id,
        type: 'GET',
        success: async function(category_id) {
            let object = 'sub_category';
            const read_subcategory = await readSubcategory(category_id);
            const read_category = await readCategoryName(category_id, object, subcategory_id);

        }
    });
}



async function on_Click(category_id) {

    $(document).on('click', '.btn-load-more', async function() {
        $(this).html('<i class="fas fa-spinner fa-spin"></i>');
        setTimeout(async function() {
            $('.btn-load-more').hide();

            var object = 'category';
            var html = "";
            var enable_button = false;
            var old_last_key = last_key;
            last_key = old_last_key + 6;
            for (var i = old_last_key; i < last_key; i++) {
                if (typeof data_storage[i] != 'undefined') {
                    let ids = object == 'category' ? data_storage[i].category_id : data_storage[i].sub_category_id;
                    ids = ids.split(", ");
                    if (ids.includes(category_id)) {
                        html += await getItems(data_storage[i]);
                    }

                }
            }

            if (data_storage.length > last_key) {
                enable_button = true;
            }
            if (enable_button) {
                html += '<div class="col-12 load-more-container">';
                html += '<button class="btn btn-sm btn-outline-success btn-load-more">Load more</button>';
                html += '</div>';
            }
            $('#product-container').append(html);

            for (var i = old_last_key; i < last_key; i++) {
                if (typeof data_storage[i] != 'undefined') {
                    let ids = object == 'category' ? data_storage[i].category_id : data_storage[i].sub_category_id;
                    ids = ids.split(", ");
                    if (ids.includes(category_id)) {
                        await readImage(data_storage[i].sku);
                    }

                }
            }


            $('.lds-ellipsis').css('display', 'none');

            makeResponvie();

        }, 300)

    });

    $(document).on('click', '.subcategory-name', async function() {
        let object = 'sub_category';
        var subcategory_id = $(this).attr('data-id');
        var subcategory_name = $(this).attr('data-name');
        $('#product-container').html("");
        $('.lds-ellipsis').css('display', 'block');

        $('.selected-category-name').text(subcategory_name);

        window.history.pushState(window.location.href, 'Title', '/shop/subcategory/' + subcategory_id);

        var category_name = category_name = $('[aria-current=page]:first').text();

        $('#category-name-hidden').val(category_name);
        if (category_name.toLowerCase().indexOf("pack") != -1) {
            await readProducts(subcategory_id, object, 'packaging');
            console.log('read pack')
        } else {
            await readProducts(subcategory_id, object);
        }
    });

    $(document).on('click', '.category-name', async function() {
        var category_id = $(this).attr('data-id');
        var category_name = $(this).attr('data-name');
        var wording = $(this).attr('data-wording');
        $('#product-container').html("");
        $('.subcategory-container').html("");
        $('.lds-ellipsis').css('display', 'block');
        $('.selected-category-name').text(category_name);
        $('#category-name-hidden').val(category_name)
        $('[aria-current=page]').text(category_name);
        if (wording != "" && wording != null) {
            $('.wording-container').html('<h5 class="text-center text-dark" id="wording-text">' + wording + '</h5>');
        } else {
            $('.wording-container').html('');
        }

        window.history.pushState(window.location.href, 'Title', '/shop/category/' + category_id);

        if (category_name.toLowerCase().indexOf("pack") != -1) {
            await readProducts(category_id, 'category', 'packaging');
        } else {
            await readProducts(category_id);
        }
        await readSubcategory(category_id);
    });
}

function makeResponvie() {
    let w = $('.responsive-img').width();
    $('.responsive-img').height(w);
}

$(window).resize(function() {
    makeResponvie();
});

async function renderConponents() {
    let url = window.location.href;
    let index = url.indexOf('category/');

    let category_id = url.substring(index + 9);
    if (url.indexOf('subcategory/') != -1) {
        console.log(category_id + ' subcat id')
        await readCategoryID(category_id);
    } else {
        console.log(category_id + ' cat id')
        const read_subcategory = await readSubcategory(category_id);
        const read_category = await readCategoryName(category_id);
    }
    const read_all_cat = await readAllCategory();
    const on_click = await on_Click(category_id);



}

renderConponents();