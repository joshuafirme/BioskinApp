document.addEventListener('DOMContentLoaded', function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }); 
    
    function fetchUsers(){
        $('.tbl-user').DataTable({
        
           processing: true,
           serverSide: true,
           ajax: '/path/to/script',
           scrollY: 470,
           scroller: {
               loadingIndicator: true
           },
            ajax:{
                url: "/read-users",
                type:"GET",
            },
          order: [[0, 'desc']],
               
           columns:[       
                {data: 'lastname', name: 'lastname'},
                {data: 'firstname', name: 'firstname'},
                {data: 'middlename', name: 'middlename'},
                {data: 'email', name: 'email'},
                {data: 'username', name: 'username'},
                {data: 'access_rights', name: 'access_rights'},
                {data: 'action', name: 'action',orderable: false},
           ]
          });
    }


function on_click() {
    var product_id;
    $(document).on('click', '.btn-archive-product', function(){ 
        product_id = $(this).attr('data-id');
        var row = $(this).closest("tr");
        var name = row.find("td:eq(1)").text();console.log(name)
        $('.delete-success').hide();
        $('.delete-message').html('Are you sure do you want to archive <b>'+ name +'</b> ?');
    }); 
    
    $(document).on('click', '.btn-confirm-archive', function(){
        $.ajax({
            url: '/product/archive/'+ product_id,
            type: 'POST',
        
            beforeSend:function(){
                $('.btn-confirm-archive').text('Please wait...');
            },
            
            success:function(){
                setTimeout(function(){
                    $('.btn-confirm-archive').text('Yes');
                    $('#confirmModal').modal('hide');
                    $('.tbl-product').DataTable().ajax.reload();
                    $.toast({
                        text: 'Product was successfully adjusted.',
                        showHideTransition: 'plain',
                        hideAfter: 4500, 
                    });
                }, 1000);
            }
        });
  
    });
     
    $(document).on('click', '#btn-change-password', function(){
        $(this).hide();
        $('.new-password-container').removeClass('d-none');
        $('#password').prop('required',true);
    });
    
    $(document).on('click', '#cancel', function(){
        $('.new-password-container').addClass('d-none');
        $('#password').val(''); 
        $('#password').removeAttr("required"); 
        $('#btn-change-password').show();
    });
}


function initComponents()
{ 
    fetchUsers();
    on_click();
}

initComponents();

});

