
  document.addEventListener('DOMContentLoaded', function() {
    if ($('#read-one-slider').length > 0) {

        var splide = new Splide( '#read-one-slider', {
                  perPage    : 5,
                  cover      : true,
                  gap: 10,
                  height     : 600,
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
});