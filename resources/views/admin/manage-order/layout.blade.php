
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
  
  $('.nav-tabs .nav-link:first').addClass('active');
  $('.tab-pane:first').addClass('show');
  $('.tab-pane:first').addClass('active');
</script>

<script src="{{asset('js/manage_orders.js')}}"></script>
</body>
</html>
