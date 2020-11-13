<?php include('include/header.php'); ?>
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Manage Income Categories</h1>
      <div>
        <button type="button" id="add_income_category"  class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus text-white-50"></i> Add New Income Category</button>
        <a href="print_income_category.php" target="_blank" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-print text-white-50"></i> Print</a>
      </div>
    </div>

    <!-- Income Categories DataTale -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Income Categories</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="incomeCategoryTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th width="5%">ID</th>
                <th>Income Category</th>
                <th width="15%">Status</th>
                <th width="15%">Action</th>
              </tr>
            </thead>
            <tfoot>
              <th width="5%">ID</th>
              <th>Income Category</th>
              <th width="15%">Status</th>
              <th width="15%">Action</th>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- /.Income Categories DataTale -->

  <!-- MODALS -->
  <!-- Add Income Category Modal -->
  <div class="modal fade" id="formModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_title"></h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="income_category_form">
            <div class="form-group">
              <label>Income Category <i class="text-danger">*</i></label>
              <input type="text" id="income_category" name="income_category" class="form-control" maxlength="100" autocomplete="off" placeholder="Enter income category">
              <div id="income_category_error_message" class="text-danger"></div>
            </div>
            <div class="form-group">
              <label>Status <i class="text-danger">*</i></label>
              <select name="status" id="status" class="custom-select">
                <option value="" hidden>Status</option>
                <option>Active</option>
                <option>Inactive</option>
              </select>
              <div id="status_error_message" class="text-danger"></div>
            </div>
            <br>
            <div class="modal-footer">
              <input type="hidden" name="income_category_id" id="income_category_id"/>
              <input type="hidden" name="action" id="action" value="add_income_category"/>
              <button type="button" name="cancel_button" id="cancel_button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <input type="submit" name="save_button" id="save_button" class="btn btn-info" value="Save" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- /.Add Income Category Modal -->

  <!-- View Income Category Modal-->
  <div class="modal fade" id="readModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Income Category Details</h5>
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
              <th>Income Category</th>
              <td>
                <div id="view_income_category"></div>
              </td>
            </tr>
            <tr>
              <th>Status</th>
              <td>
                <div id="view_status"></div>
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
  <!-- /.View Income Category Modal -->

<?php include('include/footer.php'); ?>

<script>

  $(document).ready(function(){
    var datatable = $('#incomeCategoryTable').DataTable({
      'processing': true,
      'serverSide': true,
      'ajax': {
        url:'income_category_action.php',
        type: 'POST',
        data: {action:'income_category_fetch'}
      },
      'columns': [
        { data: 'income_category_id' },
        { data: 'income_category_name'},
        { data: 'income_category_status'},
        { data: 'action',"orderable":false}
      ]
    });

    $('#add_income_category').click(function(){
      $('#modal_title').text('Add Income Category');
      $('#button_action').val('Save');
      $('#action').val('add_income_category');
      $('#formModal').modal('show');
      clearField();
    });

    // Clear form.
    function clearField() {
      $('#income_category_form')[0].reset();
      $("#income_category_error_message").hide();
      $("#income_category").removeClass("is-invalid");
      $("#email_error_message").hide();
      $("#email").removeClass("is-invalid");
      $("#status_error_message").hide();
      $("#status").removeClass("is-invalid");
    }

    var error_income_category = false;
    var error_status = false;

    $("#income_category").focusout(function() {
      checkIncomeCategory();
    });

    $("#status").focusout(function() {
      checkStatus();
    });

    // Validate income category name field.
    function checkIncomeCategory() {
      if ( $.trim( $('#income_category').val() ) == '' ){
        $("#income_category_error_message").html("Income category is a required field.");
        $("#income_category_error_message").show();
        $("#income_category").addClass("is-invalid");
        error_income_category = true;
      } else {
        $("#income_category_error_message").hide();
        $("#income_category").removeClass("is-invalid");
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

    // Create new income category
    $('#income_category_form').on('submit', function(event){
      event.preventDefault();

      error_income_category = false;
      error_status = false;

      checkIncomeCategory();
      checkStatus();

      if (error_income_category == false && error_status == false) {
        $.ajax({
          type:"POST",
          data: $('#income_category_form').serialize(),
          url:"income_category_action.php",
          dataType:"json",
          beforeSend:function(){
            $('#save_button').val('Please wait...');
            $('#save_button').attr('disabled', 'disabled');
            $('#cancel_button').attr('disabled', 'disabled');
          },success:function(data){
            if (data.status == 'success') {
              $('#formModal').modal('hide');
              clearField();
              datatable.ajax.reload();
              Notiflix.Notify.Success(data.message);
              $('#save_button').val('Save');
              $('#save_button').attr('disabled', false);
              $('#cancel_button').attr('disabled', false);
            } else if (data.status=='error') {
              $("#income_category_error_message").html("Income category already exists");
              $("#income_category_error_message").show();
              $("#income_category").addClass("is-invalid");
              $('#save_button').val('Save');
              $('#save_button').attr('disabled', false);
              $('#cancel_button').attr('disabled', false);
            }
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

    // Update income category
    $(document).on('click', '.update_income_category', function(){
      income_category_id = $(this).attr('id');
      $('#modal_title').text('Update Income Category');
      $('#action').val('update_income_category');
      $('#formModal').modal('show');
      clearField();

      $.ajax({
        type:"POST",
        data: {action:'single_fetch', income_category_id:income_category_id},
        url:"income_category_action.php",
        dataType:"json",
        success:function(data){
          $('#income_category_id').val(data.income_category_id);
          $('#income_category').val(data.income_category_name);
          $('#status').val(data.income_category_status);
        }
      });
    });

    // Display income category information.
    $(document).on('click', '.view_income_category', function(){
      income_category_id = $(this).attr('id');
      $.ajax({
        type:"POST",
        data: {action:'single_fetch', income_category_id:income_category_id},
        url:"income_category_action.php",
        dataType:"json",
        success:function(data){
          $('#view_id').text(data['income_category_id']);
          $('#view_income_category').text(data['income_category_name']);
          $('#view_status').text(data['income_category_status']);
          $('#view_created_by').text(data['income_category_created_by']);
          $('#view_created_at').text(data['income_category_created_at']);
          $('#view_last_update_by').text(data['income_category_last_update_by']);
          $('#view_updated_at').text(data['income_category_updated_at']);
        }
      });
    });
  });
</script>