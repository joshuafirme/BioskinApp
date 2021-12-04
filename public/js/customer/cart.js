function getItems (data,i) {
    var html = '';
    var packaging = data.packaging != null ? data.packaging : '-';
    var closure = data.closure != null ? data.closure : '-';
    var variation = data.variation != null ? data.variation : '-';
    html += '<tr>';
    html +=    '<td>';
    html +=    '<a href="/shop/'+ data.sku +'/'+data.category+'"><div class="responsive-img" style="width:150px;"  id="data-image-'+i+'"></div></a>';
    html +=    '</td>';
    html +=    '<td>'+data.name+'</td>';
    html +=    '<td>'+variation+'</td>';
    html +=    '<td>'+packaging+'</td>';
    html +=    '<td>'+closure+'</td>';
    html +=    '<td>'+data.qty+'</td>';
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


readCart();