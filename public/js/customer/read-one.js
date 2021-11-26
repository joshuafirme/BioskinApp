
  document.addEventListener('DOMContentLoaded', function() {
    async function initSplide() {
        if ($('#read-one-slider').length > 0) {

            var splide = new Splide( '#read-one-slider', {
                      perPage    : 4,
                      cover      : true,
                      gap: 10,
                      height     : 750,
                      cover: true,
                      arrows: false,
                      direction   : 'ttb',
            });
            splide.mount();
        }
    }

    async function readProductInfo(sku) {
        $.ajax({
            url: '/shop/read-one/'+sku,
            type: 'GET',
            success:async function(data){
               
                    await readImages(sku);
            }
        });
    }

    async function readImages(sku) {
        $.ajax({
            url: '/shop/read-images/'+sku,
            type: 'GET',
            success:async function(data){ 
                console.log(data)
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
            var moreText = document.getElementById("more-"+object+"-text");
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
            console.log(src)
            $('.splide-other-img').css('opacity', '0.6');
            $('[data-id='+data_id+']').css('opacity', '1.0');
            document.getElementById('main-image').style.backgroundImage='url(/'+src+')';
        });
    
        $(document).on('click', '.btn-variation', async function(){ 
            let $this = $(this);
            let sku = $this.attr('data-sku');
            
            await readProductInfo(sku);

            $('.btn-variation').removeClass('active');
            $this.addClass('active');
        });
    }

    async function render() {
        await initSplide();
        await on_Click();
    }

    render();
});