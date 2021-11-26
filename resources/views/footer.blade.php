

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <main class="d-flex align-items-center py-3 py-md-0">
        <!-- Default to the left -->
        <strong>Copyright &copy; 2021 Bioskin</strong> <span class="ml-1">All rights reserved.</span>

    </main>
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

</body>
</html>