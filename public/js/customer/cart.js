function getItems (data,i) {
    var html = '';
    var packaging = data.packaging != null ? data.packaging : '-';
    var closure = data.closure != null ? data.closure : '-';
    var variation = data.variation != null ? data.variation : '-';
    html += '<tr>';
    html +=    '<td><input type="checkbox" name="checkbox[]" value="'+ data.cart_id +'"></input></td>';
    html +=    '<td>';
    html +=    '<a href="/shop/'+ data.sku +'/'+data.category+'"><div class="responsive-img" style="width:150px;"  id="data-image-'+i+'"></div></a>';
    html +=    '</td>';
    html +=    '<td>'+data.name+'</td>';
    html +=    '<td>'+variation+'</td>';
    html +=    '<td>'+packaging+'</td>';
    html +=    '<td>'+closure+'</td>';
    html +=    '<td>';
    html +=        '<div class="row align-items-center">';
    html +=        '<div class="col"> <button class="btn">-</button><span>'+data.qty+'</span><button class="btn" href="#">+</button> </div>';
    html +=    '</div>';
    html +=    '</td>';
    html +=    '<td>'+data.amount+'</td>';
    html += '</tr>';

    return html;
}

function readCart() {
    var html = '';
    $.ajax({
        url: '/read-cart',
        type: 'GET',
        success:async function(data){  
            $('.lds-ellipsis').hide();
        
            for (var i = 0; i < data.length; i++) {   
                if (typeof data[i] != 'undefined') { 
                    html += getItems(data[i], i);
                } 
            }

            $('#cart-item-container').html(html);

            for (var i = 0; i < data.length; i++) {
                if (typeof data[i] != 'undefined') { console.log(data[i])
                    readImage(data[i].sku, i);
                } 
            }
            
        }
    });
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
                $('<img/>').attr('src', 'https://via.placeholder.com/450x450.png?text=No%20image%20available').on('load', function() {
                    $(this).remove(); 
                    document.getElementById('data-image-'+i).style.backgroundImage='url("https://via.placeholder.com/450x450.png?text=No%20image%20available")';
                });
            }

            
            makeResponvie();
        }
    });
}

    $('#select-all-product').on('click', function(){
        $('input[type="checkbox"]').prop('checked', this.checked);
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
                    readCart();
                    $.toast({
                        text: 'Item was removed from cart.',
                        showHideTransition: 'plain',
                        hideAfter: 4500, 
                    });
                }
            });
        }
        else {
            $.toast({
                text: 'Please selecte an item.',
                showHideTransition: 'plain',
                hideAfter: 2500, 
            });
        }
        
        $this.html('Delete selected');
        
    });


readCart();