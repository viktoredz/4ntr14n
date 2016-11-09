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
              <label>Isi Pengumuman</label>
              <textarea class="form-control" placeholder="Konten" name="content" style="height: 180px;" id="konten"></textarea>
            </div>
          </div>
          <div class="box-footer pull-right">
            <button type="submit" class="btn btn-primary">Kirim</button>
            <button  id="btn-close-d" class="btn btn-warning">Batal</button>
          </div>
      </div><!-- /.box -->
  	</div><!-- /.box -->
  </div><!-- /.box -->
</form>
</section>
<script type="text/javascript">
  $(function () {

    $("#btn-close-d").click(function(e){
			e.preventDefault();
      close_popup();
    });

		$('#form-ss').submit(function(f){
			  f.preventDefault();
				var x = $('#konten').val();
				if(x == ''){
					$('#konten').css('border','1px red solid');
					return false;
				}else{
					$('#konten').css('border','none');
				}
        var data = $(this).serialize();
				var url = '<?php echo base_url() . "news/submit_news/"; ?>';
				$.post(url, data, function(res){
					console.log(res);
					if(res == "OK"){
						$('#notice-content').html('<div style="text-align:center; margin-bottom: 40px; "><img width="50" src="<?php echo base_url();?>media/images/sign-check.png" alt="loading content.. "><br>Data telah masuk!</div>');
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
