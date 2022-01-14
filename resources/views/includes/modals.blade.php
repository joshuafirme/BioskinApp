<div class="modal fade" id="address-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                    <div class="col-sm-12 col-md-6 mt-2">
                        <label class="col-form-label">Full name</label>
                        <input type="text" class="form-control" id="fullname" required>
                    </div>

                    <div class="col-sm-12 col-md-6 mt-2 mb-2">
                        <label class="col-form-label">Phone number</label>
                        <input type="text" class="form-control" id="phone_no" required>
                    </div>

                    <div class="col-sm-12 col-md-6 mt-2">
                      <label class="col-form-label">Region</label>
                      <select class="form-control" name="region" id="region"></select>
                  </div>

                  <div class="col-sm-12 col-md-6 mt-2">
                    <label class="col-form-label">Province</label>
                    <select class="form-control" name="province" id="province"></select>
                  </div>

                  <div class="col-sm-12 col-md-6  mt-2">
                    <label class="col-form-label">Municipality</label>
                    <select class="form-control" name="municipality" id="municipality"></select>
                  </div>

                  <div class="col-sm-12 col-md-6 mt-2">
                    <label class="col-form-label">Barangay</label>
                    <select class="form-control" name="brgy" id="brgy"></select>
                  </div>

                    <div class="col-sm-12 col-md-6 mt-2">
                        <label class="col-form-label">House/Unit/Flr #, Bldg Name, Blk or Lot #</label>
                        <textarea rows="2" type="text" class="form-control" id="detailed_loc" required></textarea>
                    </div>

                    <div class="col-sm-12 col-md-6 mt-2">
                      <label class="col-form-label">Other Notes</label>
                      <textarea rows="2" type="text" class="form-control" id="notes" required></textarea>
                  </div>
        
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="btn-save-address">Add</button>
            </div>
          </div>
    </div>
  </div>

  <div class="modal fade" id="checkout-address-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Change address</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
              <div class="addresses-main-container">
              </div>
            </div>
          </div>
    </div>
  </div>

  <div class="modal fade" id="courier-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <img src="https://img.icons8.com/external-vitaliy-gorbachev-flat-vitaly-gorbachev/25/000000/external-courier-sales-vitaliy-gorbachev-flat-vitaly-gorbachev.png"/>
            <h5 class="modal-title ml-2 " id="exampleModalLabel">Change courier</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">

            </div>
          </div>
    </div>
  </div>


  <div class="modal fade" id="order-placed-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body text-center mt-3 mb-3">
                <div><img src="https://img.icons8.com/pastel-glyph/64/26e07f/nft-checked.png"/></div>
                <h2 class="mt-3">Order Placed</h2>
                <p>You can now check your purchases <a href="#">here</a></p>
                <a href="{{ url('/shop') }}">Continue shopping</a>
            </div>
          </div>
    </div>
  </div>

  <div class="modal fade" id="return-refund-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body text-center mt-3 mb-3">
                <div><img src="https://img.icons8.com/external-ddara-lineal-ddara/64/000000/external-refund-delivery-services-ddara-lineal-ddara.png"/></div>
                <h2 class="mt-3">Request Return/Refund</h2>
                <p>Please email us at </p>
                <div class="row">
                  <!--<div class="col-sm-12">
                      <label class="col-form-label float-left">Reason for Return/Refund</label>
                      <input type="text" class="form-control" name="name"  id="name" required>
                  </div>
                  <div class="col-sm-12">
                    <label class="col-form-label float-left">Message</label>
                    <textarea type="text" rows="3" class="form-control" name="message"  id="message" placeholder="Message (Optional)"></textarea>
                </div>-->
              </div>
            </div>
          </div>
    </div>
  </div>
  

  <!--Confirm Modal-->
<div class="modal fade" id="confirmation-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Please select reason or call 0939 194 8404 / (082)282-0679</p>
        <select class="form-control" name="cancellation_reason" id="cancellation_reason" style="height: 50px; fonr-size: 16px;">
          <option value="Change of mind">Change of mind</option>
          <option value="Want to change payment method">Want to change payment method</option>
          <option value="Change/combine order">Change/combine order</option>
          <option value="Duplicate order">Duplicate order</option>
          <option value="Payment issue">Payment issue</option>
          <option value="Other">Other</option>
        </select>
      </div>
      <div class="modal-footer">
        <button class="btn btn-sm btn-outline-dark delete-record-btn" id="btn-confirm" type="button">Confirm cancellation</button>
        <button class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


