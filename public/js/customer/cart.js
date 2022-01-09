$(document).ready(function () {
    function getItems (data,identifier) {
        var html = '';
        var packaging = data.packaging != null ? data.packaging : '-';
        var closure = data.closure != null ? data.closure : '-';
        var variation = data.variation != null ? data.variation : '-';
        var size = data.size != null ? data.size : '-';
        var stock = data.stock == 0 ? "<div class='text-danger'>Out of stock</div>" : 'Stock: '+data.stock+'';
        html += '<tr>';
        html +=    '<td><input type="checkbox" name="checkbox[]" value="'+ data.cart_id +'" data-amount="'+data.amount+'" data-stock="'+data.stock+'" data-check-val="'+data.is_checked+'"></input></td>';
        html +=    '<td>';
        html +=    '<a href="/shop/'+ data.sku +'/'+data.category+'"><div class="responsive-img" style="width:100px;"  id="data-image-'+identifier+'"></div></a>';
        html +=    '</td>';
        html +=    '<td id="data-name-'+identifier+'">'+data.name+' <br> '+stock+'</td>';
        html +=    '<td>'+size+'</td>';
        html +=    '<td>'+variation+'</td>';
        html +=    '<td>'+packaging+'</td>';
        html +=    '<td>'+closure+'</td>';
        html +=    '<td>';
        html +=        '<div class="row align-items-center">';
     //   html +=        '<div class="col"> <button class="btn">-</button><span>'+data.qty+'</span><button class="btn" href="#">+</button> </div>';
     html +=        '<div class="col"><span>'+data.qty+'</span> </div>';
        html +=    '</div>';
        html +=    '</td>';
        html +=    '<td>₱'+formatNumber(data.amount)+'</td>';
        html += '</tr>';
    
        return html;
    }
    
    async function readCart() {
        var html = '';
        $.ajax({
            url: '/read-cart',
            type: 'GET',
            success:async function(data){  
                $('.lds-ellipsis').hide();
                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {   
                        if (typeof data[i] != 'undefined') { 
                            html += getItems(data[i], i);
                        } 
                    }
                    $('#cart-item-container').html(html);
                    

                    $('#cart-item-container').find('input[type="checkbox"]').each(function(i){
                        if ($(this).attr('data-check-val') == 1) {
                            $(this).prop( "checked", true );
                        }
                    });
                    
                    let total = 0;
                    $('#cart-item-container').find(':checkbox:checked').each(function(i){
                        total = parseFloat(total) + parseFloat($(this).attr('data-amount'));
                        $('#total-amount').text(formatNumber(total.toFixed(2)));
                    });
                    
                }
                else {
                    let html_no_data = '<p class="text-center text-muted">Cart is empty.</p>';
                    $('.table-container').append(html_no_data);
                    $('#btn-checkout').hide();
                }
    
    
                for (var i = 0; i < data.length; i++) { 
                    readImage(data[i].sku, i);
                }

                await uncheckIfOutOfStock();
                
            }
        });
    }
    
    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }
    
    function makeResponvie() {
        let w = $('.responsive-img').width();
        $('.responsive-img').height(w); 
    }
    
    $(window).resize(function () {
        makeResponvie();
    });
    
    async function readImage(sku, i) {
        $.ajax({
            url: '/read-image/'+sku,
            type: 'GET',
            success:function(data){ 
                if (data) {
                    var src = '/images/'+data;
                    $('<img/>').attr('src', src).on('load', function() {
                        $(this).remove(); 
                        document.getElementById('data-image-'+i).style.backgroundImage='url('+src+')';
                    
                    });
                }
                else {
                    $('<img/>').attr('src', 'https://gmalcilk.sirv.com/243977931_6213185145420681_2932561991829971205_n.png').on('load', function() {
                        $(this).remove(); 
                        document.getElementById('data-image-'+i).style.backgroundImage='url("https://gmalcilk.sirv.com/243977931_6213185145420681_2932561991829971205_n.png")';
                    });
                }
    
                
                makeResponvie();
            }
        });
    }

    
    async function uncheckIfOutOfStock() {
        $('#cart-item-container').find('[type=checkbox]').each(async function(i){
            let check_value = 0;
            if (parseInt($(this).attr('data-stock')) <= 0) {
                check_value = 0; 
                $(this).prop( "checked", false );
                $(this).prop( "disabled", true );
                await updateCartCheck($(this).val(), check_value);
            }
        });
    }

    async function updateCartCheck(id, check_value) {
        
        $.ajax({
            url: '/cart/check-item/'+id,
            type: 'POST',
            data: {
                check_value : check_value
            },
            success:function(data){ console.log(check_value)
                
            }
        });
    }
    
        $('#select-all-product').on('click', function(){
            $('input[type="checkbox"]').prop('checked', this.checked);

             updateCart();

        });

        function updateCart() {
            var total = 0;
            var check_value = 0;
            $('#cart-item-container').find(':checkbox').each(async function(i){
                if (this.disabled) {
                    $(this).prop('checked', false);
                }
                if ($(this).is(':checked') == true) {
                    total = parseFloat(total) + parseFloat($(this).attr('data-amount'));
                    check_value = 1;
                    await updateCartCheck($(this).val(), check_value);
                } else { 
                    await updateCartCheck($(this).val(), check_value);
                } 
            });

            $('#total-amount').text(formatNumber(total.toFixed(2)));
        }
    
        $(document).on('click','#cart-item-container input[type="checkbox"]', async function(){
            let check_value = 0;
            let id = $(this).val();
            let total = 0;
            $('#cart-item-container').find(':checkbox:checked').each(function(i){
                total = parseFloat(total) + parseFloat($(this).attr('data-amount'));
                $('#total-amount').text(formatNumber(total.toFixed(2)));
            });
            if ($(this).is(':checked') == true) {
                check_value = 1;
            }
            await updateCartCheck(id, check_value);
        });
    
        $(document).on('click','#btn-delete-selected', function(){
    
            var $this = $(this);
            $this.html('<i class="fas fa-spinner fa-pulse"></i>');
    
            var ids = [];
    
            $('#cart-table tbody').find(':checkbox:checked').each(function(i){
                ids[i] = $(this).val();
            });
    
            if (ids.length > 0) {
                $.ajax({
                    url: '/cart/remove/'+ids,
                    type: 'POST',
                    success:function(data){ 
                    
                        $('#cart-table tbody').find(':checkbox:checked').each(function(i){
                            $(this).closest('tr').remove();
                        });
    
                        cartCount();
                        $.toast({
                            text: 'Item was removed from cart.',
                            showHideTransition: 'plain',
                            hideAfter: 4500, 
                        });
            
                        $this.html('Delete selected');
                        let total = 0;
                        $('#cart-table tbody').find('input[type=checkbox]').each(function(i){
                            total = parseFloat(total) + parseFloat($(this).attr('data-amount'));
                        });
                        $('#total-amount').text(formatNumber(total.toFixed(2)));
                    }
                });
            }
            else {
                $this.html('Delete selected');
                $.toast({
                    text: 'Please select an item.',
                    showHideTransition: 'plain',
                    hideAfter: 2500, 
                });
            }
            
            
        });
    
    async function render() {
        await readCart();
    }

    render();
});