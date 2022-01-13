<script>
    function addToCart(sku, retail_price, btn, order_type) {
      
        let volume = $('#volumes-container').find('.active').attr('data-volume');
        let packaging_sku = $('.packaging-container').find('.active').attr('data-sku');
        let closure_sku = $('.closure-container').find('.active').attr('data-sku');
       
        let total_amount = $('#overall-total-price').attr('content');
        let price_by_volume = $('#price_by_volume_hidden').val()

        btn.html('<i class="fas fa-spinner fa-pulse"></i>');
            $.ajax({
            url: '/add-to-cart',
            type: 'POST',
            data: {
                sku   : sku,
                retail_price : retail_price,
                order_type : order_type,
                volume : volume,
                packaging_sku : packaging_sku,
                closure_sku : closure_sku,
                total_amount : total_amount,
                price_by_volume : price_by_volume
            },
            success:async function(data){ 
                if (data.message == 'unauthorized') {
                    $('#loginModal').modal('toggle');
                }
                else if (data.data == "not enough stock") {
                    $.toast({
                        text: 'Not enough stock!',
                        showHideTransition: 'plain',
                        hideAfter: 4500, 
                    });
                }
                else {
                    $.toast({
                        text: 'Product was successfully added to cart!',
                        showHideTransition: 'plain',
                        hideAfter: 4500, 
                    });
                    cartCount();
                }

                btn.html('<img src="https://img.icons8.com/external-kiranshastry-lineal-kiranshastry/34/000000/external-shopping-cart-ecommerce-kiranshastry-lineal-kiranshastry.png">')
            
            }
        });
        
        
}



function validateAttr() {
        if (!$('.btn-size').hasClass('active')) {
            $('.attr-validation').text('Please select product size.');
            return 'invalid';
        }
        if (!$('.btn-volume').hasClass('active')) {
            $('.attr-validation').text('Please select product volume.');
            return 'invalid';
        }   
        if (!$('.btn-packaging').hasClass('active') && $('.packaging-container').text().indexOf("No available") == -1) {
            $('.attr-validation').text('Please select product packaging.');
            return 'invalid';
        }   
        if (!$('.btn-closure').hasClass('active') && $('.closure-container').text().indexOf("No available") == -1) {
            $('.attr-validation').text('Please select product cap.');
            return 'invalid';
        }   

        $('.attr-validation').text('');
    }

$(document).on('click', '.btn-add-cart', async function(){
    let sku = $(this).attr('data-sku');
    let price = $(this).attr('data-price');
    let btn = $(this);
    let order_type = $(this).attr('data-order-type');

    let input_attr = 'valid';
    if (order_type == 1) {
        input_attr = validateAttr();
    }
    if (input_attr != 'invalid') {
      addToCart(sku, price, btn, order_type);
    }

});
</script>