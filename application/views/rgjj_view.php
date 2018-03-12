<body>
  <div class="container">
    <div class="row text-center">
      <div class="col-sm-12">
        <img id="lesson_thumb" src="<?php echo $rgjjpath . "/" . $rgjjfile; ?> "></img>
          <p></p>
      </div>
    </div>

    <div class="row text-center">
      <div class="col-sm-4">
        <button class="btn btn-default" onclick="previous_lesson()"><i class="glyphicon glyphicon-arrow-left"></i> Previous</button>
      </div>
      <div class="col-sm-4">
        <button class="btn btn-default" onclick="select_lesson()"><i class="glyphicon glyphicon-ok-sign"></i> Select</button>
      </div>
      <div class="col-sm-4">
        <button class="btn btn-default" onclick="next_lesson()">Next <i class="glyphicon glyphicon-arrow-right"></i></button>
      </div>
    </div>
  </div>
</body>
</html>

<script>

function previous_lesson() {
    var rgjjpath = '<?php echo $rgjjpath; ?>';
    var jsrgjjfile = $('#lesson_thumb').attr('src');
    var filenumber = jsrgjjfile.substring(jsrgjjfile.lastIndexOf("/") + 1, jsrgjjfile.lastIndexOf("."));
    if(eval(filenumber) == 1){
      filenumber = 37;
    }
    filename = rgjjpath + "/" + (eval(filenumber) - 1) + ".jpg";
    $("#lesson_thumb").attr("src",filename);
}

function next_lesson() {
  var rgjjpath = '<?php echo $rgjjpath; ?>';
  var jsrgjjfile = $('#lesson_thumb').attr('src');
  var filenumber = jsrgjjfile.substring(jsrgjjfile.lastIndexOf("/") + 1, jsrgjjfile.lastIndexOf("."));
  if(eval(filenumber) == 36){
    filenumber = 0;
  }
  filename = rgjjpath + "/" + (eval(filenumber) + 1) + ".jpg";
  $("#lesson_thumb").attr("src",filename);
}

function select_lesson()
{
    var jsrgjjfile = $('#lesson_thumb').attr('src');
    var rgjjnumber = jsrgjjfile.substring(jsrgjjfile.lastIndexOf("/") + 1, jsrgjjfile.lastIndexOf("."));

      //alert( rgjjnumber );

      // ajax save rgjj lesson
      $.ajax({
          url : "<?php echo site_url('rgjj/save_rgjj360')?>/"+rgjjnumber,
          type: "POST",
          data: {data:rgjjnumber},
          success: function(data)
          {
        //      alert(data);
          var url = '<?php echo site_url('student/display_home')?>';
          window.location.replace(url);

          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              alert('Error setting data');
          }
       });

}

</script>
