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
                {data: 'customer', name: 'customer'},
                {data: 'username', name: 'username'},
                {data: 'access_rights', name: 'access_rights'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action',orderable: false},
           ]
          });
    }


function on_click() {
    var user_id;
    $(document).on('click', '.btn-archive', function(){ 
        user_id = $(this).attr('data-id');
        $('.message').html('Are you sure do you want to delete this user?'); console.log(user_id)
    }); 
    
    $(document).on('click', '.btn-confirm-archive', function(){
        $.ajax({
            url: '/users/archive/'+ user_id,
            type: 'POST',
        
            beforeSend:function(){
                $('.btn-confirm-archive').text('Please wait...');
            },
            
            success:function(){
                setTimeout(function(){
                    location.reload();
                }, 1000);
            }
        });
  
    });

    $(document).on('change', '#access_rights', function(){
        let access_rights = $(this).val();
        initCourierContainer(access_rights)
        
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


function initCourierContainer(access_rights) {
    if (access_rights == 7) {
        $('.courier-container').removeClass('d-none');
    } else {
        $('.courier-container').addClass('d-none');
        $('#courier_id').val(0);
    }
}

if ($('#choices-multiple-remove-button').length > 0) {
    var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
        removeItemButton: true,
      });
}

function initComponents()
{ 
    initCourierContainer($('#access_rights').val());
    fetchUsers();
    on_click();
}

initComponents();

});

