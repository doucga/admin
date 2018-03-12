    <div class="container">
      <div align="center">

            <h1>
              <?php
                $programID =  $this->uri->segment(3);
                $programName =  $this->uri->segment(4);
                echo urldecode($programName) . " Class List";
              ?>
            </h1>
            <h2><?php echo date("l, F jS, Y") ?></h2>
        </div>
    </div>

    <div class="container">

        <br />
        <br />
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Checked In Time</th>

                </tr>
            </thead>

            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Checked In Time</th>
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
            "url": "<?php echo site_url('classlist/ajax_classlist/' . $programID)  ?>",
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

    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,
    });

});


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
			$('[name="emergcontact"]').val(data.emergcontact);
			$('[name="emergphone"]').val(data.emergphone);
			$('[name="emergemobile"]').val(data.emergemobile);
			$('[name="emergeRelation"]').val(data.emergeRelation);
			$('[name="rgjjlessons"]').val(data.rgjjlessons);
			$('[name="subscription"]').val(data.subscription);
			$('[name="punches"]').val(data.punches);
			$('[name="startdate"]').val(data.startdate);
			$('[name="paidtodate"]').val(data.paidtodate);
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
    if(confirm('Are you sure delete this data?'))
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
