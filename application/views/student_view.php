    <div class="container">

        <button class="btn btn-success" onclick="add_student()"><i class="glyphicon glyphicon-plus"></i> Add Student</button>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        <label for="status">&nbsp;&nbsp;&nbsp;Status:</label>
        <select class="btn btn-default" id="view_status" name="status">
            <option value="Active" selected>Active</option>
              <option value="Dormant">Dormant</option>
        </select>

        <br />
        <br />
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Mobile</th>
                    <th>Paid to</th>
                    <th>Status</th>
                    <th style="width:250px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone</th>
                <th>Mobile</th>
                <th>Paid to</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </tfoot>
        </table>
    </div>

<script type="text/javascript">
(function($){
	$(document).ready(function(){
		$('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
			event.preventDefault();
			event.stopPropagation();
			$(this).parent().siblings().removeClass('open');
			$(this).parent().toggleClass('open');
		});
	});
})(jQuery);
</script>

<script type="text/javascript">

var save_method; //for save method string
var table;

$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.


        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('student/ajax_list')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable

        },
        ],


    });

    table.search("Active").draw() ;

    $('#view_status').change(function(){

      table.search($(this).val()).draw() ;
    })

});


function add_student()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Student'); // Set Title to Bootstrap modal title
}

function edit_student(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('student/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="id"]').val(data.id);
            $('[name="first"]').val(data.first);
            $('[name="last"]').val(data.last);
            $('[name="phone"]').val(data.phone);
            $('[name="mobile"]').val(data.mobile);
            $('[name="email"]').val(data.email);
            $('[name="carecard"]').val(data.carecard);
			$('[name="emergcontact"]').val(data.emergcontact);
			$('[name="emergphone"]').val(data.emergphone);
			$('[name="emergemobile"]').val(data.emergemobile);
			$('[name="emergeRelation"]').val(data.emergeRelation);
			$('[name="rgjjlessonscomplete"]').val(data.rgjjlessonscomplete);
			$('[name="subscription"]').val(data.subscription);
			$('[name="punches"]').val(data.punches);
			$('[name="startdate"]').val(data.startdate);
			$('[name="paidtodate"]').val(data.paidtodate);
      $('[name="status"]').val(data.status);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Student'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function payment_student(id)
{
    save_method = 'update';
    $('#paymentform')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('student/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
              $('[name="id"]').val(data.id);
              $('[name="subscription"]').val(data.subscription);
			        $('[name="punches"]').val(data.punches);
			        $('[name="paidtodate"]').val(data.paidtodate);
              $('#payment_form').modal('show'); // show bootstrap modal when complete loaded
              $('.modal-title').text('Student Payment - '+data.first+' '+data.last); // Set title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax
}

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('student/ajax_add')?>";
    } else {
        url = "<?php echo site_url('student/ajax_update')?>";
    }

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
            }

            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable

        }
    });
}

function savepayment()
{

    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable
    var url;
    url = "<?php echo site_url('student/ajax_update_payment')?>";

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#paymentform').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            if(data.status) //if success close modal and reload ajax table
            {
              console.log(data);
                $('#payment_form').modal('hide');
                reload_table();
            }

            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable

        }
    });
}

function delete_student(id)
{
    if(confirm('This will delete all information about this student. Are you sure delete?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('student/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}

</script>

<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Student Form</h3>
            </div>
            <div class="modal-body">
			<div class="container-fluid">
                <form action="#" id="form">
                    <input type="hidden" value="" name="id"/>
                <div class="form-body">
					<div class="row">
                        <div class="form-inline">
                            <label class="control-label col-md-2">First Name</label>
                            <div class="col-md-4">
                                <input name="first" placeholder="First Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-inline">
                            <label class="control-label col-md-2">Last Name</label>
                            <div class="col-md-4">
                                <input name="last" placeholder="Last Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
					</div>
					<div class="row">
                        <div class="form-inline">
                            <label class="control-label col-md-2">Phone</label>
                            <div class="col-md-4">
                                <input name="phone" placeholder="Phone" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-inline">
                            <label class="control-label col-md-2">Mobile</label>
                            <div class="col-md-4">
                                <input name="mobile" placeholder="Mobile" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
					</div>
					<div class="row">
                        <div class="form-inline">
                            <label class="control-label col-md-2">Email</label>
                            <div class="col-md-4">
                                <input name="email" placeholder="Email" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-inline">
                            <label class="control-label col-md-2">Care Card #</label>
                            <div class="col-md-4">
                                <input name="carecard" placeholder="Care Card" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
					</div>
					<div class="row">
						<div class="form-inline">

						</div>
						<div class="form-inline">
                            <label class="control-label col-md-2">Emergency Contact</label>
                            <div class="col-md-4">
                                <input name="emergcontact" placeholder="Emergency Contact" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
						<div class="form-inline">
                            <label class="control-label col-md-2">Relationship</label>
                            <div class="col-md-4">
                                <input name="emergeRelation" placeholder="Emergency Relationship" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
					</div>
					<div class="row">
						 <div class="form-inline">
                            <label class="control-label col-md-2">Emergency Phone</label>
                            <div class="col-md-4">
                                <input name="emergphone" placeholder="Emergency Phone" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

						<div class="form-inline">
                            <label class="control-label col-md-2">Emergency Mobile</label>
                            <div class="col-md-4">
                                <input name="emergemobile" placeholder="Emergency Mobile" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

					</div>
					<div class="row">
						<div class="form-inline">
                            <label class="control-label col-md-2">Start Date</label>
                            <div class="col-md-4">
							    <input name="startdate" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
						<div class="form-inline">
                            <label class="control-label col-md-2">RGJJ360 Complete</label>
                            <div class="col-md-4 pull-left">
                              <select name="rgjjlessonscomplete">
              								 	  <option value="Yes">Yes</option>
              								  	<option value="No" selected>No</option>
              								</select>

                                <span class="help-block"></span>
                            </div>
                        </div>
					</div>
					<div class="row">
						<div class="form-inline">
                            <label class="control-label col-md-2">Subscription</label>
                            <div class="col-md-4">

								<select name="subscription">
									  <option value="">Select...</option>
								 	  <option value="Monthly">Monthly</option>
								  	  <option value="PunchCard">Punch Card</option>
								</select>
                                <span class="help-block"></span>
                            </div>
            </div>
						<div class="form-inline">
                            <label class="control-label col-md-2">Punches</label>
                            <div class="col-md-4">
                                <input name="punches" placeholder="Punches" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
					</div>
					<div class="row">
						<div class="form-inline">
                            <label class="control-label col-md-2">Paid to Date</label>
                            <div class="col-md-4">
							    <input name="paidtodate" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
                                <span class="help-block"></span>
                            </div>
							<label class="control-label col-md-2"></label>
                            <div class="col-md-4">

                            </div>
            </div>
            <div class="form-inline">
                            <label class="control-label col-md-2">Status</label>
                            <div class="col-md-4">

								<select name="status">
								 	  <option value="Active" selected>Active</option>
								  	  <option value="Dormant">Dormant</option>
								</select>
                                <span class="help-block"></span>
                            </div>
            </div>
				</div>
                </form>
			</div>
			</div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="payment_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Payment Form</h3>
            </div>
            <div class="modal-body">
			<div class="container-fluid">
                <form action="#" id="paymentform">
                    <input type="hidden" value="" name="id"/>
                <div class="form-body">
					<div class="row">

					</div>

					<div class="row">
						<div class="form-inline">
                            <label class="control-label col-md-2">Subscription</label>
                            <div class="col-md-4">

								<input name="subscription" class="form-control" type="text" readonly="readonly">
                                <span class="help-block"></span>
                            </div>
                        </div>
						<div class="form-inline">
                            <label class="control-label col-md-2">Punches</label>
                            <div class="col-md-4">
                                <input name="punches" placeholder="Punches" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
					</div>
					<div class="row">
						<div class="form-inline">
                            <label class="control-label col-md-2">Paid to Date</label>
                            <div class="col-md-4">
							    <input name="paidtodate" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
                                <span class="help-block"></span>
                            </div>
							<label class="control-label col-md-2"></label>
                            <div class="col-md-4">

                            </div>
                        </div>
				</div>
                </form>
			</div>
			</div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="savepayment()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
