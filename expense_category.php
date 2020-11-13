<?php include('include/header.php'); ?>
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Manage Expense Categories</h1>
      <div>
        <button type="button" id="add_expense_category"  class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus text-white-50"></i> Add New Expense Category</button>
        <a href="print_expense_category.php" target="_blank" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-print text-white-50"></i> Print</a>
      </div>
    </div>

    <!-- Expense Categories DataTale -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Expense Categories</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="expenseCategoryTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th width="5%">ID</th>
                <th>Expense Category</th>
                <th width="15%">Status</th>
                <th width="15%">Action</th>
              </tr>
            </thead>
            <tfoot>
              <th width="5%">ID</th>
              <th>Expense Category</th>
              <th width="15%">Status</th>
              <th width="15%">Action</th>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- /.Expense Categories DataTale -->

  <!-- MODALS -->
  <!-- Add Expense Category Modal -->
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
          <form id="expense_category_name">
            <div class="form-group">
              <label>Expense Category <i class="text-danger">*</i></label>
              <input type="text" id="expense_category" name="expense_category" class="form-control" maxlength="100" autocomplete="off" placeholder="Enter expense category">
              <div id="expense_category_error_message" class="text-danger"></div>
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
              <input type="hidden" name="expense_category_id" id="expense_category_id"/>
              <input type="hidden" name="action" id="action" value="add_expense_category"/>
              <button type="button" name="cancel_button" id="cancel_button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <input type="submit" name="save_button" id="save_button" class="btn btn-info" value="Save" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- /.Add Expense Category Modal -->

  <!-- View Expense Category Modal-->
  <div class="modal fade" id="readModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Expense Category Details</h5>
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
              <th>Expense Category</th>
              <td>
                <div id="view_expense_category"></div>
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
  <!-- /.View Expense Category Modal -->

<?php include('include/footer.php'); ?>

<script>

  $(document).ready(function(){
    var datatable = $('#expenseCategoryTable').DataTable({
      'processing': true,
      'serverSide': true,
      'ajax': {
        url:'expense_category_action.php',
        type: 'POST',
        data: {action:'expense_category_fetch'}
      },
      'columns': [
        { data: 'expense_category_id' },
        { data: 'expense_category_name'},
        { data: 'expense_category_status'},
        { data: 'action',"orderable":false}
      ]
    });

    $('#add_expense_category').click(function(){
      $('#modal_title').text('Add Expense Category');
      $('#button_action').val('Save');
      $('#action').val('add_expense_category');
      $('#formModal').modal('show');
      clearField();
    });

    // Clear form.
    function clearField() {
      $('#expense_category_name')[0].reset();
      $("#expense_category_error_message").hide();
      $("#expense_category").removeClass("is-invalid");
      $("#email_error_message").hide();
      $("#email").removeClass("is-invalid");
      $("#status_error_message").hide();
      $("#status").removeClass("is-invalid");
    }

    var error_expense_category = false;
    var error_status = false;

    $("#expense_category").focusout(function() {
      checkExpenseCategory();
    });

    $("#status").focusout(function() {
      checkStatus();
    });

    // Validate expense category name field.
    function checkExpenseCategory() {
      if ( $.trim( $('#expense_category').val() ) == '' ){
        $("#expense_category_error_message").html("Expense category is a required field.");
        $("#expense_category_error_message").show();
        $("#expense_category").addClass("is-invalid");
        error_expense_category = true;
      } else {
        $("#expense_category_error_message").hide();
        $("#expense_category").removeClass("is-invalid");
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

    // Create new expense category
    $('#expense_category_name').on('submit', function(event){
      event.preventDefault();

      error_expense_category = false;
      error_status = false;

      checkExpenseCategory();
      checkStatus();

      if (error_expense_category == false && error_status == false) {
        $.ajax({
          type:"POST",
          data: $('#expense_category_name').serialize(),
          url:"expense_category_action.php",
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
              $("#expense_category_error_message").html("Expense category already exists");
              $("#expense_category_error_message").show();
              $("#expense_category").addClass("is-invalid");
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

    // Update expense category
    $(document).on('click', '.update_expense_category', function(){
      expense_category_id = $(this).attr('id');
      $('#modal_title').text('Update Expense Category');
      $('#action').val('update_expense_category');
      $('#formModal').modal('show');
      clearField();

      $.ajax({
        type:"POST",
        data: {action:'single_fetch', expense_category_id:expense_category_id},
        url:"expense_category_action.php",
        dataType:"json",
        success:function(data){
          $('#expense_category_id').val(data.expense_category_id);
          $('#expense_category').val(data.expense_category_name);
          $('#status').val(data.expense_category_status);
        }
      });
    });

    // Display expense category information.
    $(document).on('click', '.view_expense_category', function(){
      expense_category_id = $(this).attr('id');
      $.ajax({
        type:"POST",
        data: {action:'single_fetch', expense_category_id:expense_category_id},
        url:"expense_category_action.php",
        dataType:"json",
        success:function(data){
          $('#view_id').text(data['expense_category_id']);
          $('#view_expense_category').text(data['expense_category_name']);
          $('#view_status').text(data['expense_category_status']);
          $('#view_created_by').text(data['expense_category_created_by']);
          $('#view_created_at').text(data['expense_category_created_at']);
          $('#view_last_update_by').text(data['expense_category_last_update_by']);
          $('#view_updated_at').text(data['expense_category_updated_at']);
        }
      });
    });
  });
</script>