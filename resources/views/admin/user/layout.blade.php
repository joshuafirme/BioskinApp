
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

@include('admin.scripts')
@include('admin.datatables-scripts')
@include('partials._modals')
@include('partials._global_scripts')
<script src="{{asset('js/users.js')}}"></script>

</body>
</html>