<script>
    function addToCart(sku, retail_price, btn) {
        btn.html('<i class="fas fa-spinner fa-pulse"></i>');
        $.ajax({
            url: '/add-to-cart',
            type: 'POST',
            data: {
                sku   : sku,
                retail_price : retail_price
            },
            success:async function(data){ 
                if (data.message == 'unauthorized') {
                    $('#loginModal').modal('toggle');
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


$(document).on('click', '.btn-add-cart', async function(){
    let sku = $(this).attr('data-sku');
    let price = $(this).attr('data-price');
    let btn = $(this);
    addToCart(sku, price, btn);
});
</script>