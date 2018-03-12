    <div class="container">
      <div align="center">
              <h2>Reports by Student</h2>
      </div>
        <div>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        <label class="pull-right">&nbsp;&nbsp;&nbsp;Status:
        <select class="btn btn-default" id="view_status" name="status">
            <option value="Active" selected>Active</option>
            <option value="Dormant">Dormant</option>
        </select>
        </label>
        </div>
        <br />
        <br />
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Status</th>
                    <th style="width:50%;">Reports</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Status</th>
                <th>Reports</th>
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
            "url": "<?php echo site_url('student_reports/ajax_list')?>",
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


function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax
}

function info_report_new_tab(url)
{
  window.open(url, '_blank');
}

</script>
