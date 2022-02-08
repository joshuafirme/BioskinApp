
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

<script>
 $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });    

  $(function () {
    $(document).on('click', '.enable_on_retail', function(){ 
      let id = $(this).attr('data-id');
        let enable_on_retail = 0; 
        if ($(this).prop('checked')) {
          enable_on_retail = 1;
        }
        
        $.ajax({
        url: '/payment-settings/update/'+id,
        type: 'POST',
        data: {
          enable_on_retail : enable_on_retail
        },
        success:function(){
            alert('Settings applied!')
        }
    });

    });

    $(document).on('click', '.enable_on_rebrand', function(){ 
        let id = $(this).attr('data-id');
        let enable_on_rebrand = 0; 
        if ($(this).prop('checked')) {
          enable_on_rebrand = 1;
        }
        $.ajax({
        url: '/payment-settings/update/'+id,
        type: 'POST',
        data: {
          enable_on_rebrand : enable_on_rebrand
        },
        success:function(){
            alert('Settings applied!')
        }
    });

    });
  });

</script>
</body>
</html>
