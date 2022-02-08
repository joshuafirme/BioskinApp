
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
    <strong>Copyright &copy; {{ date('Y') }} Bioskin Philippines.</strong>
    All rights reserved.
  </footer>

</div>
<!-- ./wrapper -->

@include('admin.scripts')
@include('partials._modals')
@include('partials._global_scripts')
</body>
</html>
