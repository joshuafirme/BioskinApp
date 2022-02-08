
@include('admin.header')

@include('admin.nav')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="error-page mt-5">

        <div class="error-content">
          <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops!</h3>

          <p>
            You are not authorize to access that page. 
          </p>

        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<footer class="main-footer">
  <strong>Copyright &copy; {{ date('Y') }} Bioskin Philippines</strong>
  All rights reserved.
</footer>

</div>
<!-- ./wrapper -->

@include('admin.scripts')
@include('partials._modals')
@include('partials._global_scripts')
</body>
</html>
