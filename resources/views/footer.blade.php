

@php
    $contact_data = json_decode(Cache::get('cache_contact_us'),true);
    $footer_data = json_decode(Cache::get('cache_footer'),true);
@endphp
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <style>

  </style>
  <!-- Main Footer -->
  <footer class="main-footer">
    <section class="d-flex justify-content-center justify-content-lg-between p-4">
    <!-- Left -->
    <div class="container">
      <div class="row">
        <div class="col-sm-12 col-md-6">

          <div class="me-5 d-none d-lg-block">
            <span>Get connected with us on social networks:</span>
          </div>
        </div>
        <div class="col-sm-12 col-md-6">

      <!-- Right -->
      <div class="float-right">
        @if (isset($footer_data['facebook']) && $footer_data['facebook'])
          <a href="{{$footer_data['facebook']}}" class="m-4 text-reset" target="_blank">
            <i class="fab fa-facebook-f"></i>
          </a>
        @endif
        @if (isset($footer_data['instagram']) && $footer_data['instagram'])
          <a href="{{$footer_data['instagram']}}" class="m-4 text-reset" target="_blank">
            <i class="fab fa-instagram"></i>
          </a>
        @endif
        @if (isset($footer_data['tiktok']) && $footer_data['tiktok'])
          <a href="{{$footer_data['tiktok']}}" class="m-4 text-reset" target="_blank">
            <i class="fab fa-tiktok"></i>
          </a>
        @endif
        @if (isset($footer_data['store']) && $footer_data['store'])
          <a href="{{$footer_data['store']}}" class="m-4 text-reset" target="_blank">
            <i class="fas fa-store"></i>
          </a>
        @endif
      </div>
        </div>
      </div>
    </div>
    <!-- Right -->
  </section>
  <!-- Section: Social media -->

  <!-- Section: Links  -->
  <section class="">
    <div class="container text-center text-md-start mt-5">
      <!-- Grid row -->
      <div class="row mt-3">
         <!--<div class="col-sm-12 text-left">
          <div class="mb-4">
            <div class="mb-1">Payment Methods</div>
            <img class="mr-2" width="32px"
            src="{{asset('images/gcash-logo.png')}}"
            alt="Gcash" style="border-radius: 3px;">
            <img class="mr-2" width="45px"
                src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/visa.svg"
                alt="Visa">
            <img class="mr-2" width="45px"
                src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/mastercard.svg"
                alt="Mastercard">
            <img class="mr-2" width="45px"
                src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/jcb.svg"
                alt="Mastercard">
          </div>
         </div> -->
        <!-- Grid column -->
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
          <!-- Content -->
          <h6 class="text-uppercase fw-bold mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="AdminLTE Logo" style="object-fit: cover;" width="100px" height="auto">
          </h6>
          <p>
            We can help you turn your vision into a reality! Start your SKINCARE and COSMETICS business with us
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-2 col-lg-4 mx-auto mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4 text-center">
            Products
          </h6>
          <div class="row">
            @php
              $cache_categories = Utils::readCategories();
            @endphp
            @foreach ($cache_categories as $item)
              <div class="col-6">
                <a href="{{ url('/shop/category/'.$item->id) }}" class="text-reset">{{$item->name}}</a>
              </div>
            @endforeach
          </div>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">
            Contact
          </h6>
          <p><i class="fas fa-home me-3"></i> {{isset($contact_data['location']) ? $contact_data['location'] : ""}}</p>
          <p>
            <i class="fas fa-envelope me-3"></i>
            {{isset($contact_data['email']) ? $contact_data['email'] : ""}}
          </p>
          <div class="mb-3"><i class="fas fa-phone me-3 mr-2"></i> 
             {{isset($contact_data['phone_number']) ? $contact_data['phone_number'] : ""}}</div>
        </div>
        <!-- Grid column -->
      </div>
      <!-- Grid row -->
    </div>
  </section>
  <!-- Section: Links  -->

  <!-- Copyright -->
  <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
    {{isset($footer_data['copyright']) ? $footer_data['copyright'] : ""}}
  </div>

  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>


<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }); 

    if ($('#secondary-slider').length > 0) {
      var column_count = 4;
      var height = 380;
      if(jQuery(document).width() < 480){
          column_count = 1;
      }
      else if(jQuery(document).width() < 680){
          column_count = 1;
      }
      else if(jQuery(document).width() < 780){
          column_count = 1;
      }
      else if(jQuery(document).width() < 1280){
          column_count = 2;
      }
      else if(jQuery(document).width() < 1600){
          column_count = 3;
      }

      var splide = new Splide( '#secondary-slider', {
                autoplay:true,
                autoplaySpeed:1500,
                perPage    : column_count,
                cover      : true,
                gap: 20,
                rewind: true,
                cover: true,
                pagination: true,
      });
      splide.mount();
    }

  });
</script>

@if(strpos($page_title,"Login") != "")
  <script src="{{asset('js/login.js')}}"></script>
@endif

<button onclick="topFunction()" id="btn-scroll-up" title="Go to top"><i class="fa fa-angle-up"></i></button>

<script>
    var mybutton = document.getElementById("btn-scroll-up");
  

  window.onscroll = function() {scrollFunction()};
  
  function scrollFunction() {
    if (document.body.scrollTop > 150 || document.documentElement.scrollTop > 150) {
      mybutton.style.display = "block";
    } else {
      mybutton.style.display = "none";
    }
  }
  
  // When the user clicks on the button, scroll to the top of the document
  function topFunction() {
    window.scrollTo({top: 0, behavior: 'smooth'});
  }


</script>

@include('scripts._global')
@include('partials._modals')
<script src="{{asset('js/customer/login.js')}}"></script>

</body>
</html>