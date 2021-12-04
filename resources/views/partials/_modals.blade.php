

<!--Confirm Modal-->
<div class="modal fade" id="delete-record-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete?</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-sm btn-outline-dark delete-record-btn" type="button">Yes</button>
        <button class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!--Login Modal-->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Please login to continue.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container pl-3 pr-3">
          <div class="row">
            <div class="col-12 mt-2" id="login-validation">
            </div>
            <div class="input-group col-12 mt-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white px-4 border-md border-right-0">
                        <i class="fa fa-user text-muted"></i>
                    </span>
                </div>
                <input type="text" name="email" placeholder="Email" class="form-control bg-white border-left-0 border-md" required>
            </div>
            <div class="input-group col-12 mt-4">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white px-4 border-md border-right-0">
                        <i class="fa fa-lock text-muted"></i>
                    </span>
                </div>
                <input type="password" name="password" placeholder="Password" class="form-control bg-white border-left-0 border-md" required>
            </div>
            <div class="col-12 mt-4 mb-4">
              <button class="btn btn-success btn-block" id="btn-login">Login</button>
              <small>New member? <a href="{{ url('/signup') }}">Register here.</a></small>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(function () {
$('input, select').on('focus', function () {
    $(this).parent().find('.input-group-text').css('border-color', '#80bdff');
});
$('input, select').on('blur', function () {
    $(this).parent().find('.input-group-text').css('border-color', '#ced4da');
});
});
</script>