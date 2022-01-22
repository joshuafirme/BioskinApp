<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).on('click', '.delete-record', function(){
        var id = $(this).attr('record-id');
        var object = $(this).attr('object');
        $('#delete-record-modal').modal('show');
        $("#delete-record-modal").attr("record-id", id);
        $("#delete-record-modal").attr("object", object);
    });
 
    $(document).on('click', '.delete-record-btn', function(){   
        var id = $('#delete-record-modal').attr('record-id');
        var object = $('#delete-record-modal').attr('object');
        var btn = $(this);
        $.ajax({
            url: `/`+object+`/`+id,
            data: {
                "_token": "{{ csrf_token() }}"
            },
            type: 'DELETE',
            beforeSend:function(){
                btn.text('Please wait...');
            },
            success: function(result) {
                if(result.status == "success"){
                    $("#record-id-"+id).fadeOut(100);
                    $.toast({
                        text: object+' was successfully deleted.',
                        showHideTransition: 'plain',
                        hideAfter: 5000, 
                    });
                }else{
                    alert("Deletion failed.");
                }
                btn.text('Yes');
                $('#delete-record-modal').modal('hide');
            }
        });
    });
</script>


