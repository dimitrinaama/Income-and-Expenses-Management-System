<?php 
include('include/header.php');
?>
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Manage Expenses</h1>
      <div>
        <button type="button" id="add_expense"  class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus text-white-50"></i> Add New Expense</button>
        <button type="button" id="expense_report_id" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-print text-white-50"></i> Print</button>
      </div>
    </div>

    <!-- Expenses DataTale -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Expenses</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="expenseTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th width="5%">ID</th>
                <th width="10%">Date</th>
                <th>Description</th>
                <th width="10%">Total Amount</th>
                <th width="10%">Category</th>
                <th width="10%">Provider</th>
                <th width="10%">Payment Method</th>
                <th width="15%">Action</th>
              </tr>
            </thead>
            <tfoot>
                <th width="5%">ID</th>
                <th width="10%">Date</th>
                <th>Description</th>
                <th width="10%">Total Amount</th>
                <th width="10%">Category</th>
                <th width="10%">Provider</th>
                <th width="10%">Payment Method</th>
                <th width="15%">Action</th>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- /.Expenses DataTale -->

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
          <form id="expense_form">
            <div class="form-group">
              <label>Date <i class="text-danger">*</i></label>
              <input type="text" name="date" id="date" class="form-control" autocomplete="off" placeholder="Enter date"/>
              <div id="date_error_message" class="text-danger"></div>
            </div>
            <div class="form-group">
              <label>Description <i class="text-danger">*</i></label>
              <textarea id="description" name="description" class="form-control" rows="2" maxlength="250" autocomplete="off" placeholder="Enter description"></textarea>
              <div id="description_error_message" class="text-danger"></div>
            </div>
            <div class="form-group">
              <label>Amount <i class="text-danger">*</i></label>
              <input type="number" id="amount" name="amount" class="form-control" maxlength="100" autocomplete="off" placeholder="Enter amount" step="any" min="0">
              <div id="amount_error_message" class="text-danger"></div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Expense Category <i class="text-danger">*</i></label>
                <select class="expense_category_id form-control" id="expense_category_id"  name="expense_category_id"></select>
                <div id="expense_category_id_error_message" class="text-danger"></div>
              </div>
              <div class="form-group col-md-6">
                <label>Provider <i class="text-danger">*</i></label>
                <select class="provider_id form-control" id="provider_id"  name="provider_id"></select>
                <div id="provider_id_error_message" class="text-danger"></div>
              </div>
            </div>
            <div class="form-group">            
              <label>Payment Method <i class="text-danger">*</i></label>
              <select class="payment_id form-control" id="payment_id" name="payment_id"></select>
              <div id="payment_id_error_message" class="text-danger"></div>
            </div>
            <div class="form-group">
              <label>Note </i></label>
              <textarea id="note" name="note" class="form-control" rows="3" maxlength="500" autocomplete="off" placeholder="Enter note"></textarea>
            </div>
            <div class="form-group">
              <label>Receipt </label>
              <div class="custom-file">
                <input type="file" id="receipt" name="receipt" class="custom-file-input" accept=".pdf">
                <label class="custom-file-label">Choose file...</label>
              </div>
            </div>
            <br>
            <div class="modal-footer">
              <input type="hidden" name="expense_id" id="expense_id"/>
              <input type="hidden" name="action" id="action" value="add_expense"/>
              <button type="button" name="cancel_button" id="cancel_button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <input type="submit" name="save_button" id="save_button" class="btn btn-info" value="Save" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- /.Add Provider Modal -->

  <!-- View Expense Modal-->
  <div class="modal fade" id="readModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Expense Details</h5>
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
              <th>Date</th>
              <td>
                <div id="view_date"></div>
              </td>
            </tr>
            <tr>
              <th>Description</th>
              <td>
                <div id="view_description"></div>
              </td>
            </tr>
            <tr>
              <th>Amount</th>
              <td>
                <div id="view_amount"></div>
              </td>
            </tr>
            <tr>
              <th>Expense Category</th>
              <td>
                <div id="view_expense_category"></div>
              </td>
            </tr>
            <tr>
              <th>Provider</th>
              <td>
                <div id="view_provider"></div>
              </td>
            </tr>
            <tr>
              <th>Payment Method</th>
              <td>
                <div id="view_payment_method"></div>
              </td>
            </tr>
            <tr>
              <th>Note</th>
              <td>
                <div id="view_note"></div>
              </td>
            </tr>
            <tr>
              <th>Receipt</th>
              <td>
                <div>
                    <a id="h_url"><span id="view_url"></span></i></a>
                </div>
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
  <!-- /.View Provider Modal -->

  <!-- Expense Report Modal -->
  <div class="modal fade" id="expense_report">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="expense_reportLabel">Make Expense Report</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Modal body -->
          <div class="modal-body">
            <div class="form-group">
              <div class="input-daterange">
                <input type="text" name="from_date" id="from_date" class="form-control" placeholder="Start date" readonly />
                <span id="error_from_date" class="text-danger"></span>
                <br />
                <input type="text" name="to_date" id="to_date" class="form-control" placeholder="End date" readonly />
                <span id="error_to_date" class="text-danger"></span>
              </div>
            </div>
          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" name="cancel_button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            <button type="button" name="create_report" id="create_report" class="btn btn-info btn-sm">Create Report</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.Expense Report Modal -->

<?php 
include('include/footer.php');
?>
<script>

  $(document).ready(function(){
    var datatable = $('#expenseTable').DataTable({
      'processing': true,
      'serverSide': true,
      'ajax': {
        url:'expense_action.php',
        type: 'POST',
        data: {action:'expense_fetch'}
      },
      'columns': [
        { data: 'expense_id' },
        { data: 'expense_date'},
        { data: 'expense_description'},
        { data: 'expense_amount'},
        { data: 'expense_category_name'},
        { data: 'provider_full_name'},
        { data: 'payment_name'},
        { data: 'action',"orderable":false}
      ]
    });

    $('#date').datepicker({
      format:'yyyy-mm-dd',
      autoclose:true,
      endDate: new Date()
    });

    $('#add_expense').click(function(){
      $('#modal_title').text('Add Expense');
      $('#button_action').val('Save');
      $('#action').val('add_expense');
      $('#formModal').modal('show');
      clearField();
    });

    $(".custom-file-input").on("change", function() {
      var file_name = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(file_name);
    });

    $('.expense_category_id').select2({
      placeholder: '-- Select Expense Category --',
      width: '100%',
      ajax: {
        url: 'expense_category_list.php',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          return {
            results: data
          };
        },
        cache: true
      }
    });

    $('.provider_id').select2({
      placeholder: '-- Select Provider --',
      width: '100%',
      ajax: {
        url: 'provider_list.php',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          return {
            results: data
          };
        },
        cache: true
      }
    });

    $('.payment_id').select2({
      placeholder: '-- Select Payment Method --',
      width: '100%',
      ajax: {
        url: 'payment_method_list.php',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          return {
            results: data
          };
        },
        cache: true
      }
    });

    $('#date').on('change', function() {
      checkDate();
    });

    $('.expense_category_id').on('change', function() {
      checkExpenseCategory();
    });

    $('.provider_id').on('change', function() {
      checkProvider();
    });

    $('.payment_id').on('change', function() {
      checkPayment();
    });

    function clearField() {
      $('#expense_form')[0].reset();

      $("#date_error_message").hide();
      $("#date").removeClass("is-invalid");

      $("#description_error_message").hide();
      $("#description").removeClass("is-invalid");

      $("#amount_error_message").hide();
      $("#amount").removeClass("is-invalid");

      $("#amount_error_message").hide();
      $("#amount").removeClass("is-invalid");

      $('#expense_category_id').val('0'); 
      $('#expense_category_id').trigger('change');
      $("#expense_category_id_error_message").hide();

      $('#provider_id').val('0'); 
      $('#provider_id').trigger('change');
      $("#provider_id_error_message").hide();

      $('#payment_id').val('0'); 
      $('#payment_id').trigger('change'); 
      $("#payment_id_error_message").hide();

      $(".custom-file-input").siblings(".custom-file-label").addClass("selected").html("Choose file...");      
    }

    var error_date = false;
    var error_description = false;
    var error_amount = false;
    var error_expense_category_id = false;
    var provider_id = false;
    var payment_id = false;
    var from_date = false;
    var to_date = false;

    $("#date").focusout(function() {
      checkDate();
    });

    $("#description").focusout(function() {
      checkDescription();
    });

    $("#amount").focusout(function() {
      checkAmount();
    });

    $("#expense_category_id").focusout(function() {
      checkExpenseCategory();
    });

    $("#provider_id").focusout(function() {
      checkProvider();
    });
  
    $("#payment_id").focusout(function() {
      checkPayment();
    });

    $('#from_date').on('change', function() {
      checkFromDate();
    });

    $('#to_date').on('change', function() {
      checkToDate();
    });

    // Validate date field.
    function checkDate() {
      if ( $.trim( $('#date').val() ) == '' ){
        $("#date_error_message").html("Date is a required field.");
        $("#date_error_message").show();
        $("#date").addClass("is-invalid");
        error_date = true;
      } else {
        $("#date_error_message").hide();
        $("#date").removeClass("is-invalid");
      }
    }

    // Validate description field.
    function checkDescription() {
      if ( $.trim( $('#description').val() ) == '' ){
        $("#description_error_message").html("Description is a required field.");
        $("#description_error_message").show();
        $("#description").addClass("is-invalid");
        error_description = true;
      } else {
        $("#description_error_message").hide();
        $("#description").removeClass("is-invalid");
      }
    }

    // Validate amount field.
    function checkAmount() {
      if ( $.trim( $('#amount').val() ) == '' ){
        $("#amount_error_message").html("Amount is a required field.");
        $("#amount_error_message").show();
        $("#amount").addClass("is-invalid");
        error_amount = true;
      } else {
        $("#amount_error_message").hide();
        $("#amount").removeClass("is-invalid");
      }
    }

    // Validate expense category field.
    function checkExpenseCategory() {
      if( $.trim( $('#expense_category_id').val() ) == '' ){
        $("#expense_category_id_error_message").html("Expense Category is a required field.");
        $("#expense_category_id_error_message").show();
        $("#expense_category_id").addClass("is-invalid");
        error_expense_category_id = true;
      } else {
        $("#expense_category_id_error_message").hide();
        $("#expense_category_id").removeClass("is-invalid");
      }
    }

    // Validate provider field.
    function checkProvider() {
      if( $.trim( $('#provider_id').val() ) == '' ){
        $("#provider_id_error_message").html("Provider is a required field.");
        $("#provider_id_error_message").show();
        $("#provider_id").addClass("is-invalid");
        error_provider_id = true;
      } else {
        $("#provider_id_error_message").hide();
        $("#provider_id").removeClass("is-invalid");
      }
    }

    // Validate payment field.
    function checkPayment() {
      if( $.trim( $('#payment_id').val() ) == '' ){
        $("#payment_id_error_message").html("Provider is a required field.");
        $("#payment_id_error_message").show();
        $("#payment_id").addClass("is-invalid");
        error_payment_id = true;
      } else {
        $("#payment_id_error_message").hide();
        $("#payment_id").removeClass("is-invalid");
      }
    }

    // Validate to_date field.
    function checkToDate() {
      if ( $.trim( $('#to_date').val() ) == '' ){
        $("#error_to_date").html("To date is a required field.");
        $("#error_to_date").show();
        error_to_date = true;
      } else {
        $("#error_to_date").hide();
      }
    }

    // Validate from_date field.
    function checkFromDate() {
      if ( $.trim( $('#from_date').val() ) == '' ){
        $("#error_from_date").html("From date is required.");
        $("#error_from_date").show();
        error_from_date = true;
      } else {
        $("#error_from_date").hide();
      }
    }

    // Add new expense.
    $('#expense_form').on('submit', function(event){
      event.preventDefault();

      error_date = false;
      error_description = false;
      error_amount = false;
      error_expense_category_id = false;
      error_provider_id = false;
      error_payment_id = false;
    
      checkDate();
      checkDescription();
      checkAmount();
      checkExpenseCategory();
      checkProvider();
      checkPayment();

      if (error_date == false && error_description == false && error_amount == false && error_expense_category_id == false&& error_provider_id == false && error_payment_id == false) {
        $.ajax({
          url: "expense_action.php",
          type: "POST",
          dataType: "html",
          data: new FormData(document.getElementById("expense_form")),
          cache: false,
          contentType: false,
          processData: false,
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

    // Display expense information.
    $(document).on('click', '.view_expense_information', function(){
      expense_id = $(this).attr('id');
      $.ajax({
        type:"POST",
        data: {action:'single_fetch', expense_id:expense_id},
        url:"expense_action.php",
        dataType:"json",
        success:function(data){
          $('#view_id').text(data['expense_id']);
          $('#view_date').text(data['expense_date']);
          $('#view_description').text(data['expense_description']);
          $('#view_amount').text(data['expense_amount']);
          $('#view_expense_category').text(data['expense_category_name']);
          $('#view_provider').text(data['provider_full_name']);
          $('#view_payment_method').text(data['payment_name']);
          $('#view_note').text(data['expense_note']);
          var url = data['file_storage_path'];
          if(url){
            document.getElementById("h_url").href = url;
            document.getElementById("h_url").target = "_blank";
            $('#view_url').text('Receipt.pdf');
          } else {
            $('#view_url').text('');
          }
          $('#view_created_by').text(data['expense_created_by']);
          $('#view_created_at').text(data['expense_created_at']);
          $('#view_updated_at').text(data['expense_last_update_by']);
          $('#view_last_update_by').text(data['expense_updated_at']);
        }
      });
    });

    // Bring current saved expense information
    $(document).on('click', '.update_expense_information', function(){
      expense_id = $(this).attr('id');
      $('#modal_title').text('Update Expense Information');
      $('#action').val('update_expense');
      $('#formModal').modal('show');
      clearField();

      $.ajax({
        type:"POST",
        data: {action:'single_fetch', expense_id:expense_id},
        url:"expense_action.php",
        dataType:"json",
        success:function(data){
          $('#expense_id').val(data.expense_id);
          $('#date').val(data.expense_date);
          $('#description').val(data.expense_description);
          $('#amount').val(data.expense_amount);
          var expense_category = new Option(data.expense_category_name, data.expense_category_id, false, false);
          $('.expense_category_id').empty();
          $('.expense_category_id').append(expense_category).trigger('change');
          var provider = new Option(data.provider_full_name, data.provider_id, false, false);
          $('.provider_id').empty();
          $('.provider_id').append(provider).trigger('change');
          var payment = new Option(data.payment_name, data.payment_id, false, false);
          $('.payment_id').empty();
          $('.payment_id').append(payment).trigger('change');
          $('#note').val(data.expense_note);
          // Verify if there is a receipt file saved.
          if(data.file_storage_path){
            $(".custom-file-input").siblings(".custom-file-label").addClass("selected").html("Receipt.pdf");
          }
        }
      });
    })

    // Delete expense information
    $(document).on('click', '.delete_expense_information', function(){
      expense_id = $(this).attr('id');
      Notiflix.Confirm.Show(
        'Delete confirmation', 
        'Are you sure you want to delete this expense information?', 
        'Yes', 
        'No', 
        function(){ 
          $.ajax({
            type:"POST",
            data: {action:'delete_expense', expense_id:expense_id},
            url:"expense_action.php",
            dataType:"json",
            success:function(data){
              datatable.ajax.reload();
              Notiflix.Notify.Success(data.message);
            },error:function(){
              Notiflix.Notify.Failure('Oops! Something went wrong.');
            }
          });
        }
      ); 
    });

    $('.input-daterange').datepicker({
      todayBtn: "linked",
      format: "yyyy-mm-dd",
      autoclose: true,
      container: '#expense_report modal-body'
    });

    function clearExpenseReportFields(){
      $('#from_date').val('');
      $('#to_date').val('');
      $('#error_from_date').text('');
      $('#error_to_date').text('');
    }

    $('#expense_report_id').click(function(){
      $('#expense_report').modal('show');
      clearExpenseReportFields();
    });

    // Create expense report
    $('#create_report').click(function(){
      error_from_date = false;
      error_to_date = false;
      
      checkFromDate();
      checkToDate();

      if (error_from_date == false && error_to_date == false) {
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        clearExpenseReportFields();
        $('#expense_report').modal('hide');
        window.open("print_expense.php?from_date="+from_date+"&to_date="+to_date);
      }
    });
  });
</script>