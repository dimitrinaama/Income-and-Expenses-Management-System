<?php include('include/header.php'); ?>
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Profile</h1>
      <div>
        <button type="button" id="update_profile"  class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-user text-white-50"></i> Update Profile</button>
        <button type="button" id="update_password"  class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-key text-white-50"></i> Update Password</button>
      </div>
    </div>

    <!-- Content Row -->

    <div class="row">

      <!-- Profile Information -->
      <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Profile Information</h6>
          </div>
          <!-- Card Body -->
          <div class="card-body">
            <table class="table table-borderless">
              <tr>
                <th>Full Name</th>
                <td>
                  <div id="view_full_name"></div>
                </td>
              </tr>
              <tr>
                <th>E-mail</th>
                <td>
                  <div id="view_email"></div>
                </td>
              </tr>
              <tr>
                <th>Gender</th>
                <td>
                  <div id="view_gender"></div>
                </td>
              </tr>
              <tr>
                <th>Created</th>
                <td>
                  <div id="view_created_date"></div>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <!-- /.Profile Information -->
    </div>

  </div>
  <!-- /.container-fluid -->

  <!-- MODALS -->
  <!-- Update User Profile Modal -->
  <div class="modal fade" id="update_profile_form">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_title">Update Profile</h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="profile_form">
            <div class="form-group">
              <label>Full Name <i class="text-danger">*</i></label>
              <input type="text" id="full_name" name="full_name" class="form-control" maxlength="50" autocomplete="off" placeholder="Enter full name">
              <div id="full_name_error_message" class="text-danger"></div>
            </div>
            <div class="form-group">
              <label>E-mail </label>
              <input type="text" id="email" name="email" class="form-control" maxlength="100" autocomplete="off" placeholder="Enter email" readOnly>
              <div id="email_error_message" class="text-danger"></div>
            </div>
            <div class="form-group">
              <label>Gender <i class="text-danger">*</i></label>
              <select name="gender" id="gender" class="custom-select">
                <option value="" hidden>Gender</option>
                <option>Male</option>
                <option>Female</option>
              </select>
              <div id="gender_error_message" class="text-danger"></div>
            </div>
            <div class="modal-footer">
              <button type="button" name="cancel_profile_button" id="cancel_profile_button" class="btn btn-secondary" data-dismiss="modal">Close</button>     
              <input type="submit" name="update_profile_button" id="update_profile_button" class="btn btn-info" value="Update"/>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- End Update User Profile Modal -->

  <!-- User Modal -->
  <div class="modal fade" id="password_update_modal_form">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_title">Update Password</h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="update_password_form">
            <div class="mb-3">
                <label for="password">Current Password <i class="text-danger">*</i></label>
                <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter current Password">
                <div id="current_password_error_message" class="text-danger"></div>
            </div>
            <div class="mb-3">
                <label for="password">New password <i class="text-danger">*</i></label>
                <input type="password" class="form-control" id="new_password" name="new_password" maxlength="50"
                    placeholder="Enter password">
                <div id="new_password_error_message" class="text-danger"></div>
            </div>
            <div class="mb-3">
                <label for="confirm-password">Confirm Password <i class="text-danger">*</i></label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                    maxlength="50" placeholder="Enter confirm password">
                <div id="confirm_password_error_message" class="text-danger"></div>
            </div>
            <div class="modal-footer">
              <button type="button" name="cancel_password_button" id="cancel_password_button" class="btn btn-secondary" data-dismiss="modal">Close</button>     
              <input type="submit" name="update_password_button" id="update_password_button" class="btn btn-info" value="Update"/>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- End User Modal -->

<?php include('include/footer.php'); ?>

<script>

  $(document).ready(function () {
    getProfile();

    var error_full_name = false;
    var error_current_password = false;
    var error_new_password = false;
    var error_confirm_password = false;

    $("#full_name").focusout(function() {
      check_full_name();
    });

    $("#current_password").focusout(function() {
      check_current_password();
    });

    $("#new_password").focusout(function() {
      check_new_password();
    });

    $("#confirm_password").focusout(function() {
      check_confirm_password();
    });

    // Validate full name field.
    function check_full_name() {
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

    // Validate current password field.
    function check_current_password() {
      var current_password_length = $("#current_password").val().length;

      if ( $.trim( $('#current_password').val() ) == '' ){
        $("#current_password_error_message").html("Current password is a required field.");
        $("#current_password_error_message").show();
        $("#current_password").addClass("is-invalid");
        error_current_password = true;
      } else if (current_password_length < 8) {
        $("#current_password_error_message").html("At least 8 characters.");
        $("#current_password_error_message").show();
        $("#current_password").addClass("is-invalid");
        error_current_password = true;
      } else {
        $("#current_password_error_message").hide();
        $("#current_password").removeClass("is-invalid");
      }
    }

    // Validate new password field.
    function check_new_password() {
      var current_password = $("#current_password").val();
      var new_password = $("#new_password").val();
      var new_password_length = $("#new_password").val().length;

      if ( $.trim( $('#new_password').val() ) == '' ){
        $("#new_password_error_message").html("New password is a required field.");
        $("#new_password_error_message").show();
        $("#new_password").addClass("is-invalid");
        error_new_password = true;
      } else if (new_password_length < 8) {
        $("#new_password_error_message").html("At least 8 characters.");
        $("#new_password_error_message").show();
        $("#new_password").addClass("is-invalid");
        error_new_password = true;
      } else if (new_password == current_password) {
        $("#new_password_error_message").html("New password cannot be same as your current password.");
        $("#new_password_error_message").show();
        $("#new_password").addClass("is-invalid");
        error_confirm_password = true;
      } else {
        $("#new_password_error_message").hide();
        $("#new_password").removeClass("is-invalid");
      }
    }

    // Validate confirm password field.
    function check_confirm_password() {
      var new_password = $("#new_password").val();
      var confirm_password = $("#confirm_password").val();

      if ( $.trim( $('#confirm_password').val() ) == '' ){
        $("#confirm_password_error_message").html("Confirm password is a required field.");
        $("#confirm_password_error_message").show();
        $("#confirm_password").addClass("is-invalid");
        error_confirm_password = true;
      } else if (new_password !=  confirm_password) {
        $("#confirm_password_error_message").html("Passwords do not match.");
        $("#confirm_password_error_message").show();
        $("#confirm_password").addClass("is-invalid");
        error_confirm_password = true;
      } else {
        $("#confirm_password_error_message").hide();
        $("#confirm_password").removeClass("is-invalid");
      }
    }

    // Bring profile information.
    function getProfile() {
      $.ajax({
        type: "POST",
        data: {action: 'profile_fetch'},
        url: "profile_action.php",
        dataType: "json",
        success: function (data) {
          $('#view_full_name').text(data['user_full_name']);
          $('#view_email').text(data['user_email']);
          $('#view_gender').text(data['user_gender']);
          $('#view_status').text(data['user_status']);
          $('#view_created_date').text(data['user_created_at']);
        }
      });
    }

    // Fill update profile form.
    $('#update_profile').click(function(){
      $('#update_profile_form').modal('show');
      $.ajax({
        type: "POST",
        data: {action: 'profile_fetch'},
        url: "profile_action.php",
        dataType: "json",
        success: function (data) {
          $('#full_name').val(data.user_full_name);
          $('#email').val(data.user_email);
          $('#gender').val(data.user_gender);
          $("#full_name_error_message").hide();
          $("#full_name").removeClass("is-invalid");
          $("#alert_error_message").hide();
        }
      });
    });

    // Update profile information.
    $('#update_profile_form').on('submit', function (event) {
      event.preventDefault();
      error_full_name = false;

      check_full_name();

      if (error_full_name == false) {
        $.ajax({
          type: "POST",
          data: $('#profile_form').serialize()+'&action=update_profile',
          url: "profile_action.php",
          dataType: "json",
          beforeSend:function(){
            $('#update_profile_button').val('Please wait...');
            $('#update_profile_button').attr('disabled', 'disabled');
            $('#cancel_profile_button').attr('disabled', 'disabled');
          },success:function(data){
            getProfile();
            $('#update_profile_form').modal('hide');
            Notiflix.Notify.Success(data.message);
            $('#update_profile_button').val('Update');
            $('#update_profile_button').attr('disabled', false);
            $('#cancel_profile_button').attr('disabled', false);
          },error:function(){
            Notiflix.Notify.Failure('Oops! Something went wrong.');
            $('#update_profile_button').val('Update');
            $('#update_profile_button').attr('disabled', false);
            $('#cancel_profile_button').attr('disabled', false);
          }
        });
      } else {
        Notiflix.Notify.Failure('Please check in on some of the fields.');
      }
    });

    // Display password update modal form.
    $('#update_password').click(function(){
      $('#password_update_modal_form').modal('show');
      $('#update_password_form')[0].reset();
      $("#current_password_error_message").hide();
      $("#current_password").removeClass("is-invalid");
      $("#new_password_error_message").hide();
      $("#new_password").removeClass("is-invalid");
      $("#confirm_password_error_message").hide();
      $("#confirm_password").removeClass("is-invalid");
    });

    // Update profile password.
    $('#update_password_form').on('submit', function (event) {
      event.preventDefault();
      
      error_current_password = false;
      error_new_password = false;
      error_confirm_password = false;

      check_current_password();
      check_new_password();
      check_confirm_password();

      if (error_current_password == false && error_new_password == false && error_confirm_password == false) {
        $.ajax({
          type:"POST",
          data: $('#update_password_form').serialize()+'&action=update_password',
          url:"profile_action.php",
          dataType:"json",
          beforeSend:function(){
            $('#update_password_button').val('Please wait...');
            $('#update_password_button').attr('disabled', 'disabled');
            $('#cancel_password_button').attr('disabled', 'disabled');
          },success:function(data){
            if (data.status == 'success') {
              $('#password_update_modal_form').modal('hide');
              Notiflix.Notify.Success(data.message);
              $('#update_password_button').val('Update');
              $('#update_password_button').attr('disabled', false);
              $('#cancel_password_button').attr('disabled', false);
            } else if (data.status == 'error') {
              $("#current_password_error_message").html("Your current password does not match with our records.");
              $("#current_password_error_message").show();
              $("#current_password").addClass("is-invalid");
              $('#update_password_button').val('Update');
              $('#update_password_button').attr('disabled', false);
              $('#cancel_password_button').attr('disabled', false);
            }
          },error:function(){
            Notiflix.Notify.Failure('Oops! Something went wrong.');
            $('#update_password_button').val('Update');
            $('#update_password_button').attr('disabled', false);
            $('#cancel_password_button').attr('disabled', false);
          }
        });
      } else {
        Notiflix.Notify.Failure('Please check in on some of the fields.');
      }
    });

  });

</script>