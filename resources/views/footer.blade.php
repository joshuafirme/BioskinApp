

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <style>

  </style>
  <!-- Main Footer -->
  <footer class="main-footer">
    <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
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
        <a href="https://www.facebook.com/BioskinTechLabInc" class="m-4 text-reset" target="_blank">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="https://www.instagram.com/bioskinphilippines/" class="m-4 text-reset" target="_blank">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="https://www.tiktok.com/@bioskinphilippines" class="m-4 text-reset" target="_blank">
          <i class="fab fa-tiktok"></i>
        </a>
        <a href="https://shopee.ph/bioskinphilippines" class="m-4 text-reset" target="_blank">
          <i class="fas fa-store"></i>
        </a>
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
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">
            Products
          </h6>
          <p>
            <a href="#!" class="text-reset">Angular</a>
          </p>
          <p>
            <a href="#!" class="text-reset">React</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Vue</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Laravel</a>
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">
            Useful links
          </h6>
          <p>
            <a href="#!" class="text-reset">Pricing</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Settings</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Orders</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Help</a>
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">
            Contact
          </h6>
          <p><i class="fas fa-home me-3"></i> Ecoland Subdivision Basketball Court, Block 4 Phase 2 Lot 11 Maya St, Matina Pangi Rd, Davao City, 8000 Davao del Sur</p>
          <p>
            <i class="fas fa-envelope me-3"></i>
            bioskin1a@yahoo.com
          </p>
          <p><i class="fas fa-phone me-3"></i> + 01 234 567 88</p>
          <p><i class="fas fa-print me-3"></i> + 01 234 567 89</p>
        </div>
        <!-- Grid column -->
      </div>
      <!-- Grid row -->
    </div>
  </section>
  <!-- Section: Links  -->

  <!-- Copyright -->
  <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
    © {{ date('Y') }} Bioskin Philippines  | All Rights Reserved
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