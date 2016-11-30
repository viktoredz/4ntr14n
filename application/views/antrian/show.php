<!-- Info boxes -->
<div class="row">
  <div class="col-md-3 col-sm-6 col-xs-12">
    <a href="<?php echo base_url();?>antrian/pasien">
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="ion ion-ios-people-outline"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Data Pasien</span>
        <span class="info-box-number">{pbk}</span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
    </a>
  </div><!-- /.col -->
  <div class="col-md-3 col-sm-6 col-xs-12">
    <a href="#" onclick="window.open('<?php echo base_url();?>antrian/tv', 'newwindow', 'menubar=no,location=no,resizable=no,scrollbars=no,fullscreen=yes, scrollbars=auto'); return false;">
    <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fa fa-sort-numeric-asc"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">ANTRIAN</span>
        <span class="info-box-number">TV<BR>Screen</span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
    </a>
  </div><!-- /.col -->

  <!-- fix for small devices only -->
  <div class="clearfix visible-sm-block"></div>

  <div class="col-md-3 col-sm-6 col-xs-12">
    <input type="hidden" name="status_panggilan" value="0">
    <input type="hidden" name="status_panggilan_interval">
    <a href="#" id="toogle_sound">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="fa fa-bullhorn"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">PANGGILAN</span>
        <span class="info-box-number">Auto<BR>Sound</span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
    </a>
  </div><!-- /.col -->
  <div class="col-md-3 col-sm-6 col-xs-12">
    <a href="#" onclick="window.open('<?php echo base_url();?>antrian/kiosk', 'newwindow', 'menubar=no,location=no,resizable=no,scrollbars=no,fullscreen=yes, scrollbars=auto'); return false;">
    <div class="info-box">
      <span class="info-box-icon bg-blue"><i class="fa fa-tv"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">KIOSK</span>
        <span class="info-box-number">Full<BR>Screen</span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
    </a>
  </div><!-- /.col -->
</div><!-- /.row -->

<div class="row">
  <div class="col-md-6">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Antrian Pasien </h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div><!-- /.box-header -->
        <div class="box-body" id="antrian">
        </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div><!-- /.col -->
  <div class="col-md-3">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Panggilan </h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div><!-- /.box-header -->
        <div class="box-body" id="panggilan" style="text-align:center;min-height:245px">
          <div style="font-size:70px;margin-top:20px;color:red">
            <i class="fa fa-volume-off"></i>
          </div>
          <label>Auto Sound<br>Not Running</label>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div><!-- /.col -->
  <div class="col-md-3">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Daftar Poli </h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div><!-- /.box-header -->
        <div class="box-body">
          <?php foreach ($poli as $rows) {
          ?>
            <div class="col-md-12">
              <label><?php echo $rows['value']?></label> 
            </div>
          <?php
          }?>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div><!-- /.col -->
</div><!-- /.row -->

<!-- Main row -->
<script>
  $(function () { 
    $("#menu_dashboard").addClass("active");
    $("#menu_morganisasi").addClass("active");

    $("#toogle_sound").click(function(){
      if($("[name='status_panggilan']").val()==0){
        panggilan(1);
        $("[name='status_panggilan']").val(1);
      }else{
        panggilan(0);
        $("[name='status_panggilan']").val(0);
      }
    });
  });


  $.get("<?php echo base_url()?>morganisasi/antrian", function(res){
    $("#antrian").html(res);
  });

  setInterval( function() {
    $.get("<?php echo base_url()?>morganisasi/antrian", function(res){
      $("#antrian").html(res);
    });
   },5000);

  function panggilan(status){
    if(status==1){
      $.get("<?php echo base_url()?>morganisasi/panggilan/1", function(res){
        $("#panggilan").html(res);
      });

      var panggilanLoop = setInterval( function() {
        $.get("<?php echo base_url()?>morganisasi/panggilan/1", function(res){
          $("#panggilan").html(res);
        });
       },10000);
      $("[name='status_panggilan_interval']").val(panggilanLoop);

    }else{
      clearInterval($("[name='status_panggilan_interval']").val());
      $.get("<?php echo base_url()?>morganisasi/panggilan/0", function(res){
        $("#panggilan").html(res);
      });
    }
  }
</script>
