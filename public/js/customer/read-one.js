
  document.addEventListener('DOMContentLoaded', function() {
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
        } else {
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
        $('#main-image').css('background-image', 'url("/'+src+'")');
    });

    
});