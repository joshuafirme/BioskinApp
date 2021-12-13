<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        ...
      </div>
    </div>
  </div>

  <div class="modal fade" id="add-address-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add new address</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">
                        <label class="col-form-label">Lastname</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="col-sm-4">
                        <label class="col-form-label">Firstname</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="col-sm-4">
                        <label class="col-form-label">Middlename</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="col-sm-12 mt-2">
                        <label class="col-form-label">Address</label>
                        <textarea rows="3" type="text" class="form-control" name="address" required></textarea>
                    </div>

                    <div class="col-sm-12 mt-2 mb-2">
                        <label class="col-form-label">Phone number</label>
                        <input type="text" class="form-control" name="phone_no" required>
                    </div>
        
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="btn-save-address">Save changes</button>
            </div>
          </div>
    </div>
  </div>
  