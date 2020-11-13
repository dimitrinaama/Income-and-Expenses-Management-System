<?php include('include/header.php'); ?>
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Manage Providers</h1>
      <div>
        <button type="button" id="add_provider"  class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus text-white-50"></i> Add New Provider</button>
        <a href="print_provider.php" target="_blank" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-print text-white-50"></i> Print</a>
      </div>
    </div>

    <!-- Providers DataTale -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Providers</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="providerTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th width="5%">ID</th>
                <th>Name</th>
                <th>Email</th>
                <th width="10%">Officer</th>
                <th width="10%">Telephone</th>
                <th width="10%">Status</th>
                <th width="10%">Action</th>
              </tr>
            </thead>
            <tfoot>
              <th width="5%">ID</th>
              <th>Name</th>
              <th>Email</th>
              <th width="10%">Officer</th>
              <th width="10%">Telephone</th>
              <th width="10%">Status</th>
              <th width="10%">Action</th>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- /.Providers DataTale -->

  <!-- MODALS -->
  <!-- Add Provider Modal -->
  <div class="modal fade" id="formModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_title"></h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="provider_form">
            <div class="form-group">
              <label>Name <i class="text-danger">*</i></label>
              <input type="text" id="full_name" name="full_name" class="form-control" maxlength="100" autocomplete="off" placeholder="Enter full name">
              <div id="full_name_error_message" class="text-danger"></div>
            </div>
            <div class="form-group">
              <label>Email </label>
              <input type="text" id="email" name="email" class="form-control" maxlength="100" autocomplete="off" placeholder="Enter E-mail">
              <div id="email_error_message" class="text-danger"></div>
            </div>
            <div class="form-group">
              <label>Officer Name </label>
              <input type="text" id="officer_name" name="officer_name" class="form-control" maxlength="100" autocomplete="off" placeholder="Enter officer name">
            </div>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label>Telephone </label>
                <input type="text" id="telephone" name="telephone" class="form-control" maxlength="100" autocomplete="off" placeholder="Enter telephone">
              </div>
              <div class="form-group col-md-4">
                <label>Cellphone </label>
                <input type="text" id="cellphone" name="cellphone" class="form-control" maxlength="100" autocomplete="off" placeholder="Enter cellphone">
              </div>
              <div class="form-group col-md-4">
                <label>Status <i class="text-danger">*</i></label>
                <select name="status" id="status" class="custom-select">
                  <option value="" hidden>Status</option>
                  <option>Active</option>
                  <option>Inactive</option>
                </select>
                <div id="status_error_message" class="text-danger"></div>
              </div>
            </div>
            <div class="form-group">
              <label>Address </i></label>
              <textarea id="address" name="address" class="form-control" rows="2" maxlength="500" autocomplete="off" placeholder="Enter address"></textarea>
            </div>
            <hr>
            <div class="form-group">
              <label>Bank Name </label>
              <input type="text" id="bank_name" name="bank_name" class="form-control" maxlength="100" autocomplete="off" placeholder="Enter bank name">
              <div id="website_error_message" class="text-danger"></div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Bank Account </label>
                <input type="text" id="bank_account" name="bank_account" class="form-control" maxlength="100" autocomplete="off" placeholder="Enter bank account">
              </div>
              <div class="form-group col-md-6">
                <label>Account Type </label>
                <select name="account_type" id="account_type" class="custom-select">
                  <option value="" hidden>Account Type</option>
                  <option>Saving Account</option>
                  <option>Current Account</option>
                </select>
              </div>
            </div>
            <hr>
            <div class="form-group">
              <label>Website </label>
              <input type="text" id="website" name="website" class="form-control" maxlength="100" autocomplete="off" placeholder="Enter full name">
              <div id="website_error_message" class="text-danger"></div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Username </label>
                <input type="text" id="username" name="username" class="form-control" maxlength="100" autocomplete="off" placeholder="Enter username">
              </div>
              <div class="form-group col-md-6">
                <label>Password </label>
                <input type="text" id="password" name="password" class="form-control" maxlength="100" autocomplete="off" placeholder="Enter password">
              </div>
            </div>
            <hr>
            <div class="form-group">
              <label>Notes </i></label>
              <textarea id="notes" name="notes" class="form-control" rows="5" maxlength="500" autocomplete="off" placeholder="Enter note"></textarea>
            </div>
            <br>
            <div class="modal-footer">
              <input type="hidden" name="provider_id" id="provider_id"/>
              <input type="hidden" name="action" id="action" value="add_provider"/>
              <button type="button" name="cancel_button" id="cancel_button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <input type="submit" name="save_button" id="save_button" class="btn btn-info" value="Save" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- /.Add Provider Modal -->

  <!-- View Provider Modal-->
  <div class="modal fade" id="readModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Provider Details</h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table table-borderless">
            <tr>
              <th>ID</th>
              <td>
                <div id="view_id"></div>
              </td>
            </tr>
            <tr>
              <th>Full Name</th>
              <td>
                <div id="view_full_name"></div>
              </td>
            </tr>
            <tr>
              <th>E-Mail</th>
              <td>
                <div id="view_email"></div>
              </td>
            </tr>
            <tr>
              <th>Officer Name</th>
              <td>
                <div id="view_officer_name"></div>
              </td>
            </tr>
            <tr>
              <th>Telephone</th>
              <td>
                <div id="view_telephone"></div>
              </td>
            </tr>
            <tr>
              <th>Cellphone</th>
              <td>
                <div id="view_cellphone"></div>
              </td>
            </tr>
            <tr>
              <th>Status</th>
              <td>
                <div id="view_status"></div>
              </td>
            </tr>
            <tr>
              <th>Address</th>
              <td>
                <div id="view_address"></div>
              </td>
            </tr>
            <tr>
              <th>Bank Name</th>
              <td>
                <div id="view_bank_name"></div>
              </td>
            </tr>
            <tr>
              <th>Bank Account Number</th>
              <td>
                <div id="view_bank_account_number"></div>
              </td>
            </tr>
            <tr>
              <th>Bank Account Type</th>
              <td>
                <div id="view_bank_account_type"></div>
              </td>
            </tr>
            <tr>
              <th>Website</th>
              <td>
                <div id="view_website"></div>
              </td>
            </tr>
            <tr>
              <th>Username</th>
              <td>
                <div id="view_username"></div>
              </td>
            </tr>
            <tr>
              <th>Password</th>
              <td>
                <div id="view_password"></div>
              </td>
            </tr>
            <tr>
              <th>Notes</th>
              <td>
                <div id="view_notes"></div>
              </td>
            </tr>
            <tr>
              <th>Created by</th>
              <td>
                <div id="view_created_by"></div>
              </td>
            </tr>            
            <tr>
              <th>Created</th>
              <td>
                <div id="view_created_at"></div>
              </td>
            </tr>
            <tr>
              <th>Last updated by</th>
              <td>
                <div id="view_last_update_by"></div>
              </td>
            </tr>
            <tr>
              <th>Last updated</th>
              <td>
                <div id="view_updated_at"></div>
              </td>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- /.View Provider Modal -->

<?php include('include/footer.php'); ?>

<script>

  $(document).ready(function(){
    var datatable = $('#providerTable').DataTable({
      'processing': true,
      'serverSide': true,
      'ajax': {
        url:'provider_action.php',
        type: 'POST',
        data: {action:'provider_fetch'}
      },
      'columns': [
        { data: 'provider_id' },
        { data: 'provider_full_name'},
        { data: 'provider_email'},
        { data: 'provider_officer_name'},
        { data: 'provider_telephone'},
        { data: 'provider_status'},
        { data: 'action',"orderable":false}
      ]
    });

    $('#add_provider').click(function(){
      $('#modal_title').text('Add Provider');
      $('#button_action').val('Save');
      $('#action').val('add_provider');
      $('#formModal').modal('show');
      clearField();
    });

    // Clear form.
    function clearField() {
      $('#provider_form')[0].reset();
      $("#full_name_error_message").hide();
      $("#full_name").removeClass("is-invalid");
      $("#email_error_message").hide();
      $("#email").removeClass("is-invalid");
      $("#status_error_message").hide();
      $("#status").removeClass("is-invalid");
    }

    var error_full_name = false;
    var error_email = false;
    var error_status = false;

    $("#full_name").focusout(function() {
      checkFullName();
    });

    $("#email").focusout(function() {
      checkEmail();
    });

    $("#status").focusout(function() {
      checkStatus();
    });

    // Validate fullname field.
    function checkFullName() {
      if ( $.trim( $('#full_name').val() ) == '' ){
        $("#full_name_error_message").html("Full name is a required field.");
        $("#full_name_error_message").show();
        $("#full_name").addClass("is-invalid");
        error_full_name = true;
      } else {
        $("#full_name_error_message").hide();
        $("#full_name").removeClass("is-invalid");
      }
    }

    // Validate email field.
    function checkEmail() {
      var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);

      if ($.trim($('#email').val()) == '') {
        $("#email_error_message").hide();
        $("#email").removeClass("is-invalid");
      } else if (!(pattern.test($("#email").val()))) {
        $("#email_error_message").html("Invalid email address");
        $("#email_error_message").show();
        error_email = true;
        $("#email").addClass("is-invalid");
      } else {
        $("#email_error_message").hide();
        $("#email").removeClass("is-invalid");
      }
    }

    // Validate status field.
    function checkStatus() {
      if ( $.trim( $('#status').val() ) == '' ){
        $("#status_error_message").html("Status is a required field.");
        $("#status_error_message").show();
        $("#status").addClass("is-invalid");
        error_status = true;
      } else {
        $("#status_error_message").hide();
        $("#status").removeClass("is-invalid");
      }
    }

    // Create new provider.
    $('#provider_form').on('submit', function(event){
      event.preventDefault();
      
      error_full_name = false;
      error_email = false;
      error_status = false;
  
      checkFullName();
      checkEmail();
      checkStatus();
  
      if (error_full_name == false && error_email == false && error_status == false) {
        $.ajax({
          type:"POST",
          data: $('#provider_form').serialize(),
          url:"provider_action.php",
          dataType:"json",
          beforeSend:function(){
            $('#save_button').val('Please wait...');
            $('#save_button').attr('disabled', 'disabled');
            $('#cancel_button').attr('disabled', 'disabled');
          },success:function(data){
            $('#formModal').modal('hide');
            clearField();
            datatable.ajax.reload();
            Notiflix.Notify.Success(data.message);
            $('#save_button').val('Save');
            $('#save_button').attr('disabled', false);
            $('#cancel_button').attr('disabled', false);
          },error:function(){
            Notiflix.Notify.Failure('Oops! Something went wrong.');
            $('#save_button').val('Save');
            $('#save_button').attr('disabled', false);
            $('#cancel_button').attr('disabled', false);
          }
        });
      } else {
        Notiflix.Notify.Failure('Please check in on some of the fields.');
      }
    });

    // Udpate provider information
    $(document).on('click', '.update_provider', function(){
      provider_id = $(this).attr('id');
      $('#modal_title').text('Update Provider');
      $('#action').val('update_provider');
      $('#formModal').modal('show');
      clearField();

      $.ajax({
        type:"POST",
        data: {action:'single_fetch', provider_id:provider_id},
        url:"provider_action.php",
        dataType:"json",
        success:function(data){
          $('#provider_id').val(data.provider_id);
          $('#full_name').val(data.provider_full_name);
          $('#email').val(data.provider_email);
          $('#officer_name').val(data.provider_officer_name);
          $('#telephone').val(data.provider_telephone);
          $('#cellphone').val(data.provider_cellphone);
          $('#status').val(data.provider_status);
          $('#address').val(data.provider_address);
          $('#bank_name').val(data.provider_bank_name);
          $('#bank_account').val(data.provider_bank_account_number);
          $('#account_type').val(data.provider_bank_account_type);
          $('#website').val(data.provider_website);
          $('#username').val(data.provider_username);
          $('#password').val(data.provider_password);
          $('#notes').val(data.provider_note);
        }
      });
    });

    // Display provider information
    $(document).on('click', '.view_provider', function(){
      provider_id = $(this).attr('id');
      $.ajax({
        type:"POST",
        data: {action:'single_fetch', provider_id:provider_id},
        url:"provider_action.php",
        dataType:"json",
        success:function(data){
          $('#view_id').text(data['provider_id']);
          $('#view_full_name').text(data['provider_full_name']);
          $('#view_email').text(data['provider_email']);
          $('#view_officer_name').text(data['provider_officer_name']);
          $('#view_telephone').text(data['provider_telephone']);
          $('#view_cellphone').text(data['provider_cellphone']);
          $('#view_address').text(data['provider_address']);
          $('#view_bank_name').text(data['provider_bank_name']);
          $('#view_bank_account_number').text(data['provider_bank_account_number']);
          $('#view_bank_account_type').text(data['provider_bank_account_type']);
          $('#view_website').text(data['provider_website']);
          $('#view_username').text(data['provider_username']);
          $('#view_password').text(data['provider_password']);
          $('#view_status').text(data['provider_status']);
          $('#view_notes').text(data['provider_note']);
          $('#view_created_by').text(data['provider_created_by']);
          $('#view_created_at').text(data['provider_created_at']);
          $('#view_last_update_by').text(data['provider_last_update_by']);
          $('#view_updated_at').text(data['provider_updated_at']);
        }
      });
    });
  });
</script>