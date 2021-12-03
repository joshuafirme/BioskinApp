
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
                    $('#price-value').text(data.price);
                    $('#size-value').text(data.size);
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

    async function readPackaging(ids, object) {
        
        var html = ''; 
        if (ids) {
            $.ajax({
                url: '/read-packaging/'+ids,
                type: 'GET',
                success:function(data){ console.log(data)
                    if (data) {
                        for (var i = 0; i < data.length; i++) {
                            html += '<div class="col-sm-12 col-md-6">';
                                html += '<button class="btn btn-light btn-'+object+' btn-block m-1" data-sku="'+data[i].sku+'" data-name="'+data[i].name+'" data-price="'+data[i].price+'">'+data[i].name+ ' '+ data[i].size+'</button>';
                                
                            html += '<div class="m-1 rebrand-img" id="data-image-'+data[i].sku+'"></div>'; 
                            html += '</div>';
                        }
                    }
                    $('.'+object+'-container').html(html);
    
                    for (var i = 0; i < data.length; i++) {
                        readImage(data[i].sku);
                    }
                    
                }
            });
        } 
        else {
            html += '<p class="mx-auto text-muted">No available packaging</p>';
            $('.'+object+'-container').html(html);
        }
        
    }
    async function readImage(sku) {
        $.ajax({
            url: '/read-image/'+sku,
            type: 'GET',
            success:function(data){ 
                if (data) {
                    var src = '/images/'+data;
                    $('<img/>').attr('src', src).on('load', function() {
                        $(this).remove(); 
                        document.getElementById('data-image-'+sku).style.backgroundImage='url('+src+')';
                    
                    });
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

    async function readProductVolume(sku) {
        $.ajax({
            url: '/read-volumes/'+sku,
            type: 'GET',
            success:function(data){
                let html = ''; 
                if (data) {
                    for (var i = 0; i < data.length; i++) {
                        html += '<div class="col-sm-12 col-md-6">';
                            html += '<button class="btn btn-light btn-volume btn-block m-1" data-sku="'+data[i].sku+'" data-volume="'+data[i].volume+'" data-price="'+data[i].price+'">'+data[i].volume+'</button>';
                        html += '</div>';
                    }
                }

                $('#volumes-container').html(html);
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
            let volume = $this.attr('data-volume');
            $('#volume-price').text(price);

            setActive('btn-volume', $this);

            $('.custom-volume').text(volume);
            $('#custom-price').text(price);
            // compute total
            let total = parseFloat(price) * parseInt(volume);
            $('#volume-total-price').text(formatNumber(total));
        });
        $(document).on('click', '.btn-size', async function(){ 
            let $this = $(this);
            let category_name = $('#category-value').val();
            let sku = $this.attr('data-sku');
            let price = $this.attr('data-price');
            let size = $this.attr('data-size');
            let packaging_ids = $this.attr('data-packaging-ids');
            let closure_ids = $this.attr('data-closure-ids');
  
            clearSelectedAttrbutes();

            $('#size-price').text(price);

            $('#custom-size').text(size);
      
            await readProductInfo(sku, category_name);
            await readProductVolume(sku);
            
            await readPackaging(packaging_ids, 'packaging');
            await readPackaging(closure_ids, 'closure');
            

            window.history.pushState(window.location.href, 'Title', '/rebrand/'+sku+"/"+category_name);
            setActive('btn-size', $this);
        });
        $(document).on('click', '.btn-packaging', async function(){ 
            let $this = $(this);
            let price = $this.attr('data-price');
            let packaging_name = $this.attr('data-name');
            $('#custom-packaging').text(packaging_name);
            $('#packaging-price').text(price);
            $('#custom-packaging-price').text(price);
            setActive('btn-packaging', $this);

            let volume = $('.custom-volume:first').text();
            // compute total
            let total = parseFloat(price) * parseInt(volume);
            $('#packaging-total-price').text(formatNumber(total));
        });
        $(document).on('click', '.btn-closure', async function(){ 
            let $this = $(this);
            let price = $this.attr('data-price');
            let name = $this.attr('data-name');
            $('#custom-closure').text(name);
            $('#closure-price').text(price);
            $('#custom-closure-price').text(price);
            setActive('btn-closure', $this);
            let volume = $('.custom-volume:first').text();
            // compute total
            let total = parseFloat(price) * parseInt(volume);
            $('#closure-total-price').text(formatNumber(total));
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

        $(document).on('click', '.btn-add-cart', async function(){ 
            if (!$('.btn-size').hasClass('active')) {
                $('.attr-validation').text('Please select product size.');
                return;
            }
            if (!$('.btn-volume').hasClass('active')) {
                $('.attr-validation').text('Please select product volume.');
                return;
            }   
            if (!$('.btn-packaging').hasClass('active')) {
                $('.attr-validation').text('Please select product packaging.');
                return;
            }   
            if (!$('.btn-closure').hasClass('active')) {
                $('.attr-validation').text('Please select product cap.');
                return;
            }   

            $('.attr-validation').text('');
        });
     
    }

    function clearSelectedAttrbutes() {
        $('.custom-volume').text('-');
        $('#custom-price').text('-');
        $('#volume-total-price').text('-');

        $('#custom-packaging-price').text('-');
        $('#packaging-total-price').text('-');

        $('#custom-closure-price').text('-');
        $('#closure-total-price').text('-');
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

    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }

    function initSelectedAttr() {
        if ($('.btn-size').hasClass('active')) {
            let size = $('#pills-sizes').find('.active').attr('data-size');
            $('#custom-size').text(size);
        }
        if ($('.btn-volume').hasClass('active')) {
            let volume = $('#pills-volumes').find('.active').attr('data-volume');
            $('.custom-volume').text(volume);
        }   
    }

    async function render() {
        await initSplide();
        await on_Click();
        makeResponvie();

       initSelectedAttr();
    }

    render();
});