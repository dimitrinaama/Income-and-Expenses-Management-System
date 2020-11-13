<?php 
include('include/header.php');
?>
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Manage Payment Methods</h1>
      <div>
        <button type="button" id="add_payment"  class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus text-white-50"></i> Add New Payment Method</button>
        <a href="print_payment.php" target="_blank" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-print text-white-50"></i> Print</a>
      </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Payments</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="paymentTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th width="5%">ID</th>
                <th>Payment Method</th>
                <th width="15%">Status</th>
                <th width="15%">Action</th>
              </tr>
            </thead>
            <tfoot>
              <th width="5%">ID</th>
              <th>Payment Method</th>
              <th width="15%">Status</th>
              <th width="15%">Action</th>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- /.container-fluid -->

  <!-- MODALS -->
  <!-- Add Payment Modal -->
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
          <form id="payment_form">
            <div class="form-group">
              <label>Name <i class="text-danger">*</i></label>
              <input type="text" id="payment_name" name="payment_name" class="form-control" maxlength="100" autocomplete="off" placeholder="Enter payment method">
              <div id="payment_name_error_message" class="text-danger"></div>
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
              <input type="hidden" name="payment_id" id="payment_id"/>
              <input type="hidden" name="action" id="action" value="add_payment"/>
              <button type="button" name="cancel_button" id="cancel_button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <input type="submit" name="save_button" id="save_button" class="btn btn-info" value="Save" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- End Add Payment Modal -->

  <!-- View Payment Method Modal-->
  <div class="modal fade" id="readModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Payment Details</h5>
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
                <div id="view_payment_name"></div>
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
                <div id="view_updated_at"></div>
              </td>
            </tr>
            <tr>
              <th>Last updated</th>
              <td>
                <div id="view_last_update_by"></div>
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
  <!-- End View Payment Modal -->

<?php 
include('include/footer.php');
?>

<script>

  $(document).ready(function(){
    
    // Fill payment method datatable.
    var datatable = $('#paymentTable').DataTable({
      'processing': true,
      'serverSide': true,
      'ajax': {
        url:'payment_action.php',
        type: 'POST',
        data: {action:'payment_fetch'}
      },
      'columns': [
        { data: 'payment_id' },
        { data: 'payment_name'},
        { data: 'payment_status'},
        { data: 'action',"orderable":false}
      ]
    });

    // Display payment method modal.
    $('#add_payment').click(function(){
      $('#modal_title').text('Add Payment');
      $('#button_action').val('Save');
      $('#action').val('add_payment');
      $('#formModal').modal('show');
      clearField();
    });

    // Clean payment method form.
    function clearField() {
      $('#payment_form')[0].reset();
      $("#payment_name_error_message").hide();
      $("#payment_name").removeClass("is-invalid");
      $("#email_error_message").hide();
      $("#email").removeClass("is-invalid");
      $("#status_error_message").hide();
      $("#status").removeClass("is-invalid");
    }

    var error_payment_name = false;
    var error_status = false;

    $("#payment_name").focusout(function() {
      checkFullName();
    });

    $("#status").focusout(function() {
      checkStatus();
    });

    // Validate full name field.
    function checkFullName() {
      if ( $.trim( $('#payment_name').val() ) == '' ){
        $("#payment_name_error_message").html("Payment method is a required field.");
        $("#payment_name_error_message").show();
        $("#payment_name").addClass("is-invalid");
        error_payment_name = true;
      } else {
        $("#payment_name_error_message").hide();
        $("#payment_name").removeClass("is-invalid");
      }
    }

    // validate status field
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

    // Add new payment method.
    $('#payment_form').on('submit', function(event){
      event.preventDefault();
      error_payment_name = false;
      error_status = false;

      checkFullName();
      checkStatus();

      if (error_payment_name == false && error_status == false) {
        $.ajax({
          type:"POST",
          data: $('#payment_form').serialize(),
          url:"payment_action.php",
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
              $("#payment_name_error_message").html("Payment method already exists");
              $("#payment_name_error_message").show();
              $("#payment_name").addClass("is-invalid");
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

    // Update payment method information
    $(document).on('click', '.update_payment', function(){
      payment_id = $(this).attr('id');
      $('#modal_title').text('Update Payment');
      $('#action').val('update_payment');
      $('#formModal').modal('show');
      clearField();

      $.ajax({
        type:"POST",
        data: {action:'single_fetch', payment_id:payment_id},
        url:"payment_action.php",
        dataType:"json",
        success:function(data){
          $('#payment_id').val(data.payment_id);
          $('#payment_name').val(data.payment_name);
          $('#status').val(data.payment_status);
        }
      });
    });

    // Bring payment information.
    $(document).on('click', '.view_payment', function(){
      payment_id = $(this).attr('id');
      $.ajax({
        type:"POST",
        data: {action:'single_fetch', payment_id:payment_id},
        url:"payment_action.php",
        dataType:"json",
        success:function(data){
          $('#view_id').text(data['payment_id']);
          $('#view_payment_name').text(data['payment_name']);
          $('#view_status').text(data['payment_status']);
          $('#view_created_by').text(data['payment_created_by']);
          $('#view_last_update_by').text(data['payment_updated_at']);
          $('#view_created_at').text(data['payment_created_at']);
          $('#view_updated_at').text(data['payment_last_update_by']);
        }
      });
    });
  });
</script>