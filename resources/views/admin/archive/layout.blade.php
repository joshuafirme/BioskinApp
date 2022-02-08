
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
@include('admin.partials._modals')


<script>
  $(function(){
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }); 
    $(document).on('click', '.btn-archive', function(){
        let id = $(this).attr('data-id');
        $('#btn-confirm').attr('data-id', id);
        $('.modal-title').text('Restore confirmation')
        $('#confirmation-modal p').text('Are you sure do you want to restore this data?');
    });

    $(document).on('click', '#btn-confirm', function(){
        let id = $(this).attr('data-id');
        let btn = $(this);
        btn.html('Please wait...')
        $.ajax({
            url: '/archive/restore/'+id,
            type: 'POST',
            success:function(){
              location.reload();
            }
        });
    });
  });
</script>


</body>
</html>
