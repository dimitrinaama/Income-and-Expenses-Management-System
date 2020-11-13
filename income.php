<?php include('include/header.php'); ?>
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Manage Income</h1>
      <div>
        <button type="button" id="add_income"  class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus text-white-50"></i> Add New Income</button>
        <button type="button" id="income_report_id" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-print text-white-50"></i> Print</button>
      </div>
    </div>

    <!-- Income DataTale -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Income</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="incomeTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th width="5%">ID</th>
                <th width="10%">Date</th>
                <th>Description</th>
                <th width="10%">Total Amount</th>
                <th width="10%">Category</th>
                <th width="10%">Customer</th>
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
                <th width="10%">Customer</th>
                <th width="10%">Payment Method</th>
                <th width="15%">Action</th>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- /.Income DataTale -->

  <!-- MODALS -->
  <!-- Add Customer Modal -->
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
          <form id="income_form">
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
                <label>Income Category <i class="text-danger">*</i></label>
                <select class="income_category_id form-control" id="income_category_id"  name="income_category_id"></select>
                <div id="income_category_id_error_message" class="text-danger"></div>
              </div>
              <div class="form-group col-md-6">
                <label>Customer <i class="text-danger">*</i></label>
                <select class="customer_id form-control" id="customer_id"  name="customer_id"></select>
                <div id="customer_id_error_message" class="text-danger"></div>
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
              <input type="hidden" name="income_id" id="income_id"/>
              <input type="hidden" name="action" id="action" value="add_income"/>
              <button type="button" name="cancel_button" id="cancel_button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <input type="submit" name="save_button" id="save_button" class="btn btn-info" value="Save" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- /.Add Customer Modal -->

  <!-- View Income Modal-->
  <div class="modal fade" id="readModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Income Details</h5>
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
              <th>Income Category</th>
              <td>
                <div id="view_income_category"></div>
              </td>
            </tr>
            <tr>
              <th>Customer</th>
              <td>
                <div id="view_customer"></div>
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
  <!-- /.View Customer Modal -->

  <!-- Income Report Modal -->
  <div class="modal fade" id="income_report">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="income_reportLabel">Make Income Report</h5>
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
  <!-- /.Income Report Modal -->

<?php include('include/footer.php'); ?>

<script>

  $(document).ready(function(){
    var datatable = $('#incomeTable').DataTable({
      'processing': true,
      'serverSide': true,
      'ajax': {
        url:'income_action.php',
        type: 'POST',
        data: {action:'income_fetch'}
      },
      'columns': [
        { data: 'income_id' },
        { data: 'income_date'},
        { data: 'income_description'},
        { data: 'income_amount'},
        { data: 'income_category_name'},
        { data: 'customer_full_name'},
        { data: 'payment_name'},
        { data: 'action',"orderable":false}
      ]
    });

    $('#date').datepicker({
      format:'yyyy-mm-dd',
      autoclose:true,
      endDate: new Date()
    });

    $('#add_income').click(function(){
      $('#modal_title').text('Add Income');
      $('#button_action').val('Save');
      $('#action').val('add_income');
      $('#formModal').modal('show');
      clearField();
    });

    $(".custom-file-input").on("change", function() {
      var file_name = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(file_name);
    });

    $('.income_category_id').select2({
      placeholder: '-- Select Income Category --',
      width: '100%',
      ajax: {
        url: 'income_category_list.php',
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

    $('.customer_id').select2({
      placeholder: '-- Select Customer --',
      width: '100%',
      ajax: {
        url: 'customer_list.php',
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

    $('.income_category_id').on('change', function() {
      checkIncomeCategory();
    });

    $('.customer_id').on('change', function() {
      checkCustomer();
    });

    $('.payment_id').on('change', function() {
      checkPayment();
    });

    function clearField() {
      $('#income_form')[0].reset();

      $("#date_error_message").hide();
      $("#date").removeClass("is-invalid");

      $("#description_error_message").hide();
      $("#description").removeClass("is-invalid");

      $("#amount_error_message").hide();
      $("#amount").removeClass("is-invalid");

      $("#amount_error_message").hide();
      $("#amount").removeClass("is-invalid");

      $('#income_category_id').val('0'); 
      $('#income_category_id').trigger('change');
      $("#income_category_id_error_message").hide();

      $('#customer_id').val('0'); 
      $('#customer_id').trigger('change');
      $("#customer_id_error_message").hide();

      $('#payment_id').val('0'); 
      $('#payment_id').trigger('change'); 
      $("#payment_id_error_message").hide();

      $(".custom-file-input").siblings(".custom-file-label").addClass("selected").html("Choose file...");      
    }

    var error_date = false;
    var error_description = false;
    var error_amount = false;
    var error_income_category_id = false;
    var customer_id = false;
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

    $("#income_category_id").focusout(function() {
      checkIncomeCategory();
    });

    $("#customer_id").focusout(function() {
      checkCustomer();
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

    // Validate income category field.
    function checkIncomeCategory() {
      if( $.trim( $('#income_category_id').val() ) == '' ){
        $("#income_category_id_error_message").html("Income Category is a required field.");
        $("#income_category_id_error_message").show();
        $("#income_category_id").addClass("is-invalid");
        error_income_category_id = true;
      } else {
        $("#income_category_id_error_message").hide();
        $("#income_category_id").removeClass("is-invalid");
      }
    }

    // Validate provider field.
    function checkCustomer() {
      if( $.trim( $('#customer_id').val() ) == '' ){
        $("#customer_id_error_message").html("Customer is a required field.");
        $("#customer_id_error_message").show();
        $("#customer_id").addClass("is-invalid");
        error_customer_id = true;
      } else {
        $("#customer_id_error_message").hide();
        $("#customer_id").removeClass("is-invalid");
      }
    }

    // Validate payment field.
    function checkPayment() {
      if( $.trim( $('#payment_id').val() ) == '' ){
        $("#payment_id_error_message").html("Customer is a required field.");
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

    // Add new income.
    $('#income_form').on('submit', function(event){
      event.preventDefault();

      error_date = false;
      error_description = false;
      error_amount = false;
      error_income_category_id = false;
      error_customer_id = false;
      error_payment_id = false;
    
      checkDate();
      checkDescription();
      checkAmount();
      checkIncomeCategory();
      checkCustomer();
      checkPayment();

      if (error_date == false && error_description == false && error_amount == false && error_income_category_id == false&& error_customer_id == false && error_payment_id == false) {
        $.ajax({
          url: "income_action.php",
          type: "POST",
          dataType: "html",
          data: new FormData(document.getElementById("income_form")),
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

    // Display income information.
    $(document).on('click', '.view_income_information', function(){
      income_id = $(this).attr('id');
      $.ajax({
        type:"POST",
        data: {action:'single_fetch', income_id:income_id},
        url:"income_action.php",
        dataType:"json",
        success:function(data){
          $('#view_id').text(data['income_id']);
          $('#view_date').text(data['income_date']);
          $('#view_description').text(data['income_description']);
          $('#view_amount').text(data['income_amount']);
          $('#view_income_category').text(data['income_category_name']);
          $('#view_customer').text(data['customer_full_name']);
          $('#view_payment_method').text(data['payment_name']);
          $('#view_note').text(data['income_note']);
          var url = data['file_storage_path'];
          if(url){
            document.getElementById("h_url").href = url;
            document.getElementById("h_url").target = "_blank";
            $('#view_url').text('Receipt.pdf');
          } else {
            $('#view_url').text('');
          }
          $('#view_created_by').text(data['income_created_by']);
          $('#view_created_at').text(data['income_created_at']);
          $('#view_updated_at').text(data['income_last_update_by']);
          $('#view_last_update_by').text(data['income_updated_at']);
        }
      });
    });

    // Bring current saved income information
    $(document).on('click', '.update_income_information', function(){
      income_id = $(this).attr('id');
      $('#modal_title').text('Update Income Information');
      $('#action').val('update_income');
      $('#formModal').modal('show');
      clearField();

      $.ajax({
        type:"POST",
        data: {action:'single_fetch', income_id:income_id},
        url:"income_action.php",
        dataType:"json",
        success:function(data){
          $('#income_id').val(data.income_id);
          $('#date').val(data.income_date);
          $('#description').val(data.income_description);
          $('#amount').val(data.income_amount);
          var income_category = new Option(data.income_category_name, data.income_category_id, false, false);
          $('.income_category_id').empty();
          $('.income_category_id').append(income_category).trigger('change');
          var customer = new Option(data.customer_full_name, data.customer_id, false, false);
          $('.customer_id').empty();
          $('.customer_id').append(customer).trigger('change');
          var payment = new Option(data.payment_name, data.payment_id, false, false);
          $('.payment_id').empty();
          $('.payment_id').append(payment).trigger('change');
          $('#note').val(data.income_note);
          // Verify if there is a receipt file saved.
          if(data.file_storage_path){
            $(".custom-file-input").siblings(".custom-file-label").addClass("selected").html("Receipt.pdf");
          }
        }
      });
    })

    // Delete income information
    $(document).on('click', '.delete_income_information', function(){
      income_id = $(this).attr('id');
      Notiflix.Confirm.Show(
        'Delete confirmation', 
        'Are you sure you want to delete this income information?', 
        'Yes', 
        'No', 
        function(){ 
          $.ajax({
            type:"POST",
            data: {action:'delete_income', income_id:income_id},
            url:"income_action.php",
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
      container: '#income_report modal-body'
    });

    function clearIncomeReportFields(){
      $('#from_date').val('');
      $('#to_date').val('');
      $('#error_from_date').text('');
      $('#error_to_date').text('');
    }

    $('#income_report_id').click(function(){
      $('#income_report').modal('show');
      clearIncomeReportFields();
    });

    // Create income report
    $('#create_report').click(function(){
      error_from_date = false;
      error_to_date = false;
      
      checkFromDate();
      checkToDate();

      if (error_from_date == false && error_to_date == false) {
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        clearIncomeReportFields();
        $('#income_report').modal('hide');
        window.open("print_income.php?from_date="+from_date+"&to_date="+to_date);
      }
    });
  });
</script>