<div class="container">
  <div align="center"><h3>Class Schedule</h3></div>
</div>
    <div class="container">
        <button class="btn btn-success" onclick="add_program()"><i class="glyphicon glyphicon-plus"></i> Add Program</button>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        <br />
        <br />
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Week Day</th>
                    <th>Start Time</th>
                    <th>Program Name</th>
                    <th>Check In Time</th>
                    <th>Check In Closed</th>
                    <th>RGJJ360</th>
                    <th style="width:250px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
              <th>Week Day</th>
              <th>Start Time</th>
              <th>Program Name</th>
              <th>Check In Time</th>
              <th>Check In Closed</th>
              <th>RGJJ360</th>
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
            "url": "<?php echo site_url('programs/ajax_list')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [ -1 ], //last column
            "orderable": true, //set not orderable
        },
        ],

    });

    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,
    });

    $('.clockpicker').clockpicker({
    placement: 'right',
    align: 'bottom',
    donetext: 'OK',
    twelvehour: 'false'
});


});



function add_program()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Program'); // Set Title to Bootstrap modal title
}

function edit_program(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('programs/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="programID"]').val(data.programID);
            $('[name="weekday"]').val(data.weekday);
            $('[name="starttime"]').val(data.starttime);
            $('[name="ProgramName"]').val(data.ProgramName);
            $('[name="check_in_time"]').val(formatDate(data.check_in_time));
            $('[name="check_in_closed"]').val(data.check_in_closed);
            $('[name="rgjj360"]').val(data.rgjj360);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Programs'); // Set title to Bootstrap modal title

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
        url = "<?php echo site_url('programs/ajax_add')?>";
    } else {
        url = "<?php echo site_url('programs/ajax_update')?>";
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

function delete_program(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('programs/ajax_delete')?>/"+id,
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

function formatDate(date) {
  var d = new Date(date);
  var hh = d.getHours();
  var m = d.getMinutes();
  var s = d.getSeconds();
  var dd = "AM";
  var h = hh;
  if (h >= 12) {
    h = hh - 12;
    dd = "PM";
  }
  if (h == 0) {
    h = 12;
  }
  m = m < 10 ? "0" + m : m;

  s = s < 10 ? "0" + s : s;

  /* if you want 2 digit hours:
  h = h<10?"0"+h:h; */

  var pattern = new RegExp("0?" + hh + ":" + m + ":" + s);

  var replacement = h + ":" + m;
  /* if you want to add seconds
  replacement += ":"+s;  */
  replacement += " " + dd;

  return date.replace(pattern, replacement);
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
                    <input type="hidden" value="" name="programID"/>
                <div class="form-body">
					<div class="row">
                        <div class="form-inline">
                            <label class="control-label col-md-4">Program Name</label>
                            <div class="col-md-8">
                                <input name="ProgramName" placeholder="Program Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-inline">
                            <label class="control-label col-md-4">RGJJ360</label>
                            <div class="col-md-8">
                              <select class="form-control" type="text" name="rgjj360">
                                  <option value="">Select...</option>
                                  <option value="No" selected>No</option>
                                  <option value="Yes">Yes</option>
                              </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
          </div>
          <div class="row">
                        <div class="form-inline">
                            <label class="control-label col-md-4">Week Day</label>
                            <div class="col-md-8">
                              <select class="form-control" type="text" name="weekday">
                                  <option value="">Select...</option>
                                  <option value="Monday">Monday</option>
                                  <option value="Tuesday">Tuesday</option>
                                  <option value="Wednesday">Wednesday</option>
                                  <option value="Thursday">Thursday</option>
                                  <option value="Friday">Friday</option>
                                  <option value="Saturday">Saturday</option>
                                  <option value="Sunday">Sunday</option>
                              </select>




                                <span class="help-block"></span>
                            </div>
                        </div>
          </div>
          <div class="row">
                        <div class="form-inline">
                            <label class="control-label col-md-4">Start Time</label>
                            <div class="col-md-4 input-group clockpicker">
                                <input name="starttime" placeholder="Start Time" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
					</div>
          <div class="row">
                        <div class="form-inline">
                            <label class="control-label col-md-4">Check In Time</label>
                            <div class="col-md-4 input-group clockpicker">
                                <input name="check_in_time" placeholder="Check In Time" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
					</div>
					<div class="row">
                        <div class="form-inline">
                            <label class="control-label col-md-4">Check In Closed</label>
                            <div class="col-md-4 input-group clockpicker">
                                <input name="check_in_closed" placeholder="Check In Closed" class="form-control" type="text">
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
