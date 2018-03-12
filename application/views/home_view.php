<div class="container-fluid">
<div class="row">

  <div class="col-md-2 pull-left">
    <button class="btn btn-default" onclick="refresh_classes()"><i class="glyphicon glyphicon-refresh"></i> Refresh</button>
  </div>

  <div class="col-md-8 text-center text-top">
      <h1><?php echo date("l, F jS, Y") ?></h1>

  </div>

  <div class="col-md-2 pull-right">

      <label for="rgjjnumber">RGJJ360:</label>
      <input id="rgjjnumber" name="value" size="5">

  </div>

</div>
</div>
<div align="center">
<h3>Today's Classes</h3>
</div>
  <div class="container">
      <div class="row">
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Class</th>
                    <th>Class Time</th>
                    <th>Checked In</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th>Class</th>
                <th>Class Time</th>
                <th>Checked In</th>
                <th>Action</th>
            </tr>
            </tfoot>
        </table>
      </div>
  </div>

<span id = "result-2"></span>

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

setInterval(refresh_classes, 20000);

function refresh_classes() {
  $('#table').DataTable().ajax.reload();

}

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
            "url": "<?php echo site_url('dashboard/ajax_list')?>",
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

    // ajax get rgjj lesson
    $.ajax({
        url : "<?php echo site_url('dashboard/get_last_rgjj360')?>/",
        type: "POST",
        dataType: "json",
        success: function(data)
        {
            $('#rgjjnumber').val(data);

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error getting data');
        }
    });

});

</script>

<script>
$( function() {
  var spinner = $( "#rgjjnumber" ).spinner({
    required:true,
    increment:1,
    min:1,
    max:36,
    stop: function( event, ui ) {
        var result = $( "#result-2" );
        save_rgjj();
    }
});


} );
</script>

<script>

function save_rgjj() {
rgjjnumber = $('#rgjjnumber').val();

  //alert( $rgjjnumber );

  // ajax save rgjj lesson
  $.ajax({


      url : "<?php echo site_url('dashboard/save_last_rgjj360')?>/"+rgjjnumber,
      type: "POST",
      data: {data:rgjjnumber},
      success: function(data)
      {
          //alert(data);
          //$( "#getvalue" ).on( "click", function() {
          //  alert( spinner.spinner( "value" ) );
          //});

      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error setting data');
      }
  });
}
</script>
