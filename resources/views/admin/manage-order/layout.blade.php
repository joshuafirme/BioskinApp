
@include('admin.header')

@include('admin.nav')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        @yield('content')
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

  <footer class="main-footer">
    <strong>Copyright &copy; 2021 Bioskin.</strong>
    All rights reserved.
  </footer>

</div>
<!-- ./wrapper -->

@include('admin.scripts')
@include('admin.datatables-scripts')

<script>
  
  $(function() {
    $('.nav-tabs .nav-link:first').addClass('active');
    $('.tab-pane:first').addClass('show');
    $('.tab-pane:first').addClass('active');

 /*   var url = new URL(window.location.href);
    var status = url.searchParams.get("status");
    if (status) {
      $('.tab-pane:first').removeClass('active');
    }
    if (status == 1) {
      $('#processing-tab').addClass('show');
      $('#processing-tab').addClass('active');
    }
    if (status == 2) {
      $('#otw-tab').addClass('show');
      $('#otw-tab').addClass('active');
    }
    if (status == 3) {
      $('#to-receive-tab').addClass('show');
      $('#to-receive-tab').addClass('active');
    }
    if (status == 6) {
      $('#order-received-tab').addClass('show');
      $('#order-received-tab').addClass('active');
    }
    if (status == 4) {
      $('#completed-tab').addClass('show');
      $('#completed-tab').addClass('active');
    }
    if (status == 5) {
      $('#cancelled-tab').addClass('show');
      $('#cancelled-tab').addClass('active');
    }*/
  })
</script>

<script src="{{asset('js/manage_orders.js')}}"></script>
</body>
</html>
