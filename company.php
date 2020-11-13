<?php include('include/header.php'); ?>
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">General Settings</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

      <!-- Update Company Information -->
      <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Update Company Information</h6>
          </div>
          <!-- Card Body -->
          <div class="card-body">
            <form id="update_company_form">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6">
                  <div class="form-group">
                    <label>Company Name <i class="text-danger">*</i></label>
                    <input type="text" class="form-control" id="company_name" name="company_name" maxlength="100" placeholder="Enter company name">
                    <div id="company_name_error_message" class="text-danger"></div>
                  </div>
                  <div class="form-group">
                    <label>Website</label>
                    <input type="text" class="form-control" id="website" name="website" maxlength="100" placeholder="Enter website url">
                    <div id="website_error_message" class="text-danger"></div>
                  </div>
                  <div class="form-group">
                    <label>E-mail</label>
                    <input type="text" class="form-control" id="email" name="email" maxlength="100" placeholder="Enter email">
                    <div id="email_error_message" class="text-danger"></div>
                  </div>
                  <div class="form-group">
                    <label>Address</label>
                    <textarea id="address" name="address" class="form-control" rows="2" maxlength="100" autocomplete="off" placeholder="Enter address"></textarea>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label>City</label>
                      <input type="text" class="form-control" id="city" name="city" maxlength="100" placeholder="Enter city">
                    </div>
                    <div class="form-group col-md-4">
                      <label>Country</label>
                      <input type="text" class="form-control" id="country" name="country" maxlength="100" placeholder="Enter country">
                    </div>
                    <div class="form-group col-md-4">
                      <label>Postal/Zip Code</label>
                      <input type="text" class="form-control" id="zip_code" name="zip_code" maxlength="100" placeholder="Enter zip code">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label>Phone</label>
                      <input type="text" class="form-control" id="phone" name="phone" maxlength="100" placeholder="Enter phone">
                    </div>
                    <div class="form-group col-md-6">
                      <label>Fax</label>
                      <input type="text" class="form-control" id="fax" name="fax" maxlength="100" placeholder="Enter fax">
                    </div>
                  </div>
                  <br>
                  <div class="modal-footer">
                    <button type="button" id="cancel_button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" id="update_profile_button" class="btn btn-info" value="Update" />
                  </div>
                </div>
              </div>
            </form>
          </div>
          <!-- /. Card Body -->
        </div>
      </div>
      <!-- /.Update Company Information -->
    </div>

  </div>
  <!-- /.container-fluid -->

<?php include('include/footer.php'); ?>
<script>
  $(document).ready(function () {

    getCompany();

    // Clear errors.
    function clearField() {
      $("#company_name_error_message").hide();
      $("#company_name").removeClass("is-invalid");

      $("#website_error_message").hide();
      $("#website").removeClass("is-invalid");

      $("#email_error_message").hide();
      $("#email").removeClass("is-invalid");
    }

    var error_company_name = false;
    var error_email = false;
    var error_website = false;

    $("#company_name").focusout(function() {
      checkCompanyName();
    });

    $("#website").focusout(function() {
      checkWebsite();
    });

    $("#email").focusout(function () {
      checkEmail();
    });

    // Valite company company name field. 
    function checkCompanyName() {
      if( $.trim( $('#company_name').val() ) == '' ){
        $("#company_name_error_message").html("Company name is a required field.");
        $("#company_name_error_message").show();
        $("#company_name").addClass("is-invalid");
        error_company_name = true;
      } else {
        $("#company_name_error_message").hide();
        $("#company_name").removeClass("is-invalid");
      }
    }

    // Validate website field.
    function checkWebsite() {
      var pattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
      var website = $("#website").val();

      if ( $.trim( $('#website').val() ) == '' ) {
        $("#website_error_message").hide();
        $("#website").removeClass("is-invalid");
      } else if (!website.match(pattern)) {
        $("#website_error_message").html("Enter a valid URL.");
        $("#website_error_message").show();
        $("#website").addClass("is-invalid");
        error_website = true;
      } else {
        $("#website_error_message").hide();
        $("#website").removeClass("is-invalid");
      }
    }

    // Validate email field.
    function checkEmail() {
        var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
        var email_length = $("#email").val().length;

        if ($.trim($('#email').val()) == ''){
            $("#email_error_message").hide();
            $("#email").removeClass("is-invalid");
        }else if (!(pattern.test($("#email").val()))){
            $("#email_error_message").html("Invalid email address.");
            $("#email_error_message").show();
            $("#email").addClass("is-invalid");
            error_email = true;
        }else{
            error_email = false;
            $("#email_error_message").hide();
            $("#email").removeClass("is-invalid");
        }
    }

    // Cancel confirmation.
    $('#cancel_button').click(function(){
      Notiflix.Confirm.Show(
        'Cancel confirmation',
        'Are you sure you want to cancel updating company information?',
        'Yes',
        'No',
        function(){
          getCompany();
          clearField();
        }
      ); 
    });

    // Bring company information
    function getCompany() {
      $.ajax({
        type: "POST",
        data: {action: 'profile_fetch'},
        url: "company_action.php",
        dataType: "json",
        success: function (data) {
          $('#company_name').val(data.company_name);
          $('#website').val(data.company_website);
          $('#email').val(data.company_email);
          $('#address').val(data.company_address);
          $('#city').val(data.company_city);
          $('#country').val(data.company_country);
          $('#zip_code').val(data.company_zip_code);
          $('#phone').val(data.company_phone);
          $('#fax').val(data.company_fax);
        }
      });
    }

    // Update company information
    $('#update_company_form').on('submit', function (event) {
      event.preventDefault();
      error_company_name = false;
      error_email = false;
      error_website = false;

      checkCompanyName();
      checkWebsite();
      checkEmail();

      if (error_company_name == false && error_website == false && error_email == false) {
        $.ajax({
          type:"POST",
          data: $('#update_company_form').serialize()+'&action=update_company',
          url:"company_action.php",
          dataType:"json",
          beforeSend:function(){
            $('#update_profile_button').val('Please wait...');
            $('#update_profile_button').attr('disabled', 'disabled');
            $('#cancel_button').attr('disabled', 'disabled');
          },success:function(data){
            Notiflix.Notify.Success(data.message);
            $('#update_profile_button').val('Update');
            $('#update_profile_button').attr('disabled', false);
            $('#cancel_button').attr('disabled', false);
          },error:function(){
            Notiflix.Notify.Failure('Oops! Something went wrong.');
            $('#update_profile_button').val('Update');
            $('#update_profile_button').attr('disabled', false);
            $('#cancel_button').attr('disabled', false);
          }
        });
      } else {
        Notiflix.Notify.Failure('Please check in on some of the fields.');
      }
    });
  });
</script>