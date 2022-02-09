
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
    <strong>Copyright &copy; {{ date('Y') }} Bioskin.</strong>
    All rights reserved.
  </footer>

</div>
<!-- ./wrapper -->

@include('admin.scripts')
<!-- include summernote  -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
  $(document).ready(function() {
      $('#summernote').summernote({
  height: 500,                 // set editor height
  minHeight: null,             // set minimum height of editor
  maxHeight: null,             // set maximum height of editor
  focus: true                  // set focus to editable area after initializing summernote
});
  });
</script>
</body>
</html>
