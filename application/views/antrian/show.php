<!-- Info boxes -->
<div class="row">
  <div class="col-md-3 col-sm-6 col-xs-12">
    <a href="<?php echo base_url();?>">
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
    <a href="<?php echo base_url();?>">
    <div class="info-box">
      <span class="info-box-icon bg-blue"><i class="fa fa-hand-o-up"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">KIOSK</span>
        <span class="info-box-number">Touch<BR>Screen</span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
    </a>
  </div><!-- /.col -->
  <div class="col-md-3 col-sm-6 col-xs-12">
    <a href="<?php echo base_url();?>">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="fa fa-volume-up"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">PANGGINAL</span>
        <span class="info-box-number">Auto<BR>Sound</span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
    </a>
  </div><!-- /.col -->
</div><!-- /.row -->

<div class="row">
  <div class="col-md-4">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Antrian Pasien </h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div><!-- /.box-header -->
        <div class="box-body">
          <div class="col-md-12">
              <div class="bux"></div> &nbsp; <label>SMS Diterima</label>
          </div>
          <div class="col-md-12">
              <div class="bux1"></div> &nbsp; <label>SMS Dikirim</label>
          </div>
          <div class="col-md-12">
              <div class="bux2"></div> &nbsp; <label>SMS Error</label>
          </div>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div><!-- /.col -->
  <div class="col-md-4">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Daftar Panggilan </h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div><!-- /.box-header -->
        <div class="box-body">
          <div class="col-md-12">
              <div class="bux"></div> &nbsp; <label>SMS Diterima</label>
          </div>
          <div class="col-md-12">
              <div class="bux1"></div> &nbsp; <label>SMS Dikirim</label>
          </div>
          <div class="col-md-12">
              <div class="bux2"></div> &nbsp; <label>SMS Error</label>
          </div>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div><!-- /.col -->
  <div class="col-md-4">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Daftar Poli </h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div><!-- /.box-header -->
        <div class="box-body">
          <div class="col-md-12">
              <div class="bux"></div> &nbsp; <label>SMS Diterima</label>
          </div>
          <div class="col-md-12">
              <div class="bux1"></div> &nbsp; <label>SMS Dikirim</label>
          </div>
          <div class="col-md-12">
              <div class="bux2"></div> &nbsp; <label>SMS Error</label>
          </div>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div><!-- /.col -->
</div><!-- /.row -->

<!-- Main row -->
<script>
  $(function () { 
    $("#menu_dashboard").addClass("active");
    $("#menu_morganisasi").addClass("active");
  });
</script>
