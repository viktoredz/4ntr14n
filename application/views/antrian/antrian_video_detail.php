<section class="content">
	<div id="notice-content">
		<div id="notice"></div>
	</div>
<form method="POST" id="form-ss">
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
              <input type="hidden" value="{id}" name="id">
            </div>
            <div class="form-group">
              <label>Video</label>
              <video controls muted width="100%">
								<source src="<?php echo base_url()?>media/<?php echo $this->session->userdata('puskesmas'); ?>/{video}" type="video/mp4"></source>
							</video>
            </div>
						<div class="form-group">
              <select name="status" class="form-control">
								<option value="{status}"><?php if($status == 1){ echo 'Aktif';}else{ echo 'Non Aktif';} ?></option>
								<option value="0">-</option>
								<option value="1">Aktif</option>
								<option value="0">Non Aktif</option>
							</select>
            </div>
          </div>
          <div class="box-footer pull-right">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="reset" id="btn-close" class="btn btn-warning">Batal</button>
          </div>
      </div><!-- /.box -->
  	</div><!-- /.box -->
  </div><!-- /.box -->
</form>
</section>
<script type="text/javascript">
  $(function () {

    $("#btn-close").on('click',function(){
      close_popup();
    });

		$('#form-ss').submit(function(f){
			  f.preventDefault();
        var data = $(this).serialize();
				console.log(data);
				var url = '<?php echo base_url() . "video/update_video/"; ?>';
				$.post(url, data, function(res){
					console.log(res);
					if(res == "OK"){
						$('#notice-content').html('<div style="text-align:center; margin-bottom: 40px; "><img width="50" src="<?php echo base_url();?>media/images/sign-check.png" alt="loading content.. "><br>Data telah dirubah!</div>');
						$('#notice').show();

						$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
						setTimeout(function(){ close_popup(); }, 1300);
					}else{
						$('#notice-content').html('<div style="text-align:center; margin-bottom: 40px; "><img width="50" src="<?php echo base_url();?>media/images/sign-error.png" alt="loading content.. "><br>Error!</div>');
						$('#notice').show();

						$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
						setTimeout(function(){ close_popup(); }, 1300);
					}
				});
    });

  });
</script>
