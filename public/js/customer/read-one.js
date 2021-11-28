
  document.addEventListener('DOMContentLoaded', function() {
    async function initSplide() {
        let height = 750;
        if ($(document).width() < 580 ) {
                height = 590;
        }
        if ($('#read-one-slider').length > 0) {

            var splide = new Splide( '#read-one-slider', {
                      perPage    : 4,
                      cover      : true,
                      gap: 10,
                      height     : height,
                      cover: true,
                      arrows: false,
                      direction   : 'ttb',
            });
            splide.mount();
        }
    }

    async function readProductInfo(sku, category_name) {
        $.ajax({
            url: '/shop/read-one/'+sku+'/'+category_name,
            type: 'GET',
            success:async function(data){

                if (data) {
                    await readImages(sku);
                    $('#description-text').text(data.description);
                    $('#direction-text').text(data.directions);
                    $('#precaution-text').text(data.precaution);
                    $('#ingredient-text').text(data.ingredient);
                }
                else {
                    alert('error loading product info');
                }
            }
        });
    }

    async function readImages(sku) {
        $.ajax({
            url: '/shop/read-images/'+sku,
            type: 'GET',
            success:async function(data){ 
              
                $('#read-one-slider .splide__list').html();

                if (data) {

                    let html = "";
                    document.getElementById('main-image').style.backgroundImage='url("/images/'+data[0].image+'")';

                    for (var i = 0; i < data.length; i++) {
                        html += '<div class="splide__slide row min-ht splide-other-img" data-id="'+data[i].id+'" data-src="images/'+data[i].image+'">';
                            html += '<img class="img-fluid" src="/images/'+data[i].image+'">';
                        html += '</div>';
                    }
                    
                    $('#read-one-slider .splide__list').html(html);

                    await initSplide();

                }
                else {
                    $('<img/>').attr('src', 'https://via.placeholder.com/450x450.png?text=No%20image%20available').on('load', function() {
                        $(this).remove(); 
                        document.getElementById('data-image-'+sku).style.backgroundImage='url("https://via.placeholder.com/450x450.png?text=No%20image%20available")';
                    });
                }
            }
        });
    }

      
    async function on_Click(){
        $(document).on('click', '.btn-show-hide', async function(){ 
            var object = $(this).attr('object');
            var dots = document.getElementById("dots-btn-"+object);
            var moreText = document.getElementById(object+"-text");
            var btnText = $(this);
            $('#detail-hide-'+object).css('height', 'auto');
            if (dots.style.display === "none") {
                dots.style.display = "inline";
                btnText.text("+"); 
                moreText.style.display = "none";
                $('#detail-hide-'+object).css('height', '50px');
            } 
            else {
                dots.style.display = "none";
                btnText.text("-"); 
                moreText.style.display = "inline";
            }
        });
    
        $(document).on('click', '.splide-other-img', async function(){ 
            let src = $(this).attr('data-src');
            let data_id = $(this).attr('data-id');
    
            $('.splide-other-img').css('opacity', '0.6');
            $('[data-id='+data_id+']').css('opacity', '1.0');

            document.getElementById('main-image').style.backgroundImage='url(/'+src+')';
        });
    
        $(document).on('click', '.btn-volume', async function(){ 
            let $this = $(this);
            let price = $this.attr('data-price');
            $('#volume-price').text(price);
            setActive('btn-volume', $this);
        });
        $(document).on('click', '.btn-size', async function(){ 
            let $this = $(this);
            setActive('btn-size', $this);
        });
        $(document).on('click', '.btn-packaging', async function(){ 
            let $this = $(this);
            let price = $this.attr('data-price');
            $('#packaging-price').text(price);
            setActive('btn-packaging', $this);
        });
        $(document).on('click', '.btn-closure', async function(){ 
            let $this = $(this);
            let price = $this.attr('data-price');
            $('#closure-price').text(price);
            setActive('btn-closure', $this);
        });

        $(document).on('click', '.btn-variation', async function(){ 
            let $this = $(this);
            let category_name = $('#category-value').val();
            let category_id = $('#category-id-value').val();
            let sku = $this.attr('data-sku');
            
            await readProductInfo(sku, category_name);

            window.history.pushState(window.location.href, 'Title', '/shop/'+sku+"/"+category_name);
            
            $('.btn-variation').removeClass('active');
            $this.addClass('active');
        });
    }

    function setActive(object, $this) {
        $('.'+object).removeClass('active');
        $this.addClass('active');
    }
    
    function makeResponvie() {
        let w = $('.responsive-img').width();
        $('.responsive-img').height(w);  console.log(w)
    }

    $(window).resize(function () {
        makeResponvie();
    });

    async function render() {
        await initSplide();
        await on_Click();
        makeResponvie();
    }

    render();
});