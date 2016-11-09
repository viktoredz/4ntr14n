<section class="content">
	<div id="notice-content">
		<div id="notice"></div>
	</div>
<form method="POST" id="form-sss" enctype="multipart/form-data">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
        </div><!-- /.box-header -->

          <div class="box-body">
            <div class="form-group">
              <label>Video</label>
							<input type="file" class="form-control" name="video" id="video" size="20"/>
            </div>
          </div>
          <div class="box-footer pull-right">
            <button type="button" id="btn-upload" class="btn btn-primary">Upload</button>
            <button type="reset" id="btn-close-d" class="btn btn-warning">Batal</button>
          </div>
      </div><!-- /.box -->
  	</div><!-- /.box -->
  </div><!-- /.box -->
</form>
</section>
<script type="text/javascript">
  $(function () {

    $("#btn-upload").on('click',function(){
      $(this).hide();
      var data = new FormData();
      jQuery.each($("[name='video']")[0].files, function(i, file) {
        data.append('video', file);
      });     
      data.append('puskesmas', '<?php echo $this->session->userdata('puskesmas') ?>');

      $.ajax({ 
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        url: "<?php echo base_url()?>video/submit_video",
        data: data,
        success: function(res){
          if(res == "OK"){
            $('#notice-content').html('<div style="text-align:center; margin-bottom: 40px; "><img width="50" src="<?php echo base_url();?>media/images/sign-check.png" alt="loading content.. "><br>Data telah masuk!</div>');
            $('#notice').show();

            $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
            setTimeout(function(){ close_popup(); }, 1300);
          }else{
            $('#notice-content').html('<div style="text-align:center; margin-bottom: 40px; "><img width="50" src="<?php echo base_url();?>media/images/sign-error.png" alt="loading content.. "><br>'+res+'!</div>');
            $('#notice').show();

            setTimeout(function(){ close_popup(); }, 2000);
          }

          $("#uploadloader").hide();
          $("#uploaddiv").show("fade");
        }
       });    
    });


    $("#btn-close-d").on('click',function(){
      close_popup();
    });

  });
</script>
