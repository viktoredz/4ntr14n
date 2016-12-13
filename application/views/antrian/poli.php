<script type="text/javascript">
	function update(type, id, status){
      $.get("<?php echo base_url().'poli/update' ?>/" +type+"/"+id+"/"+status,  function(){
      	var stat = status == "true" ? "diaktifkan" : "di nonaktifkan";
        $("#popup_content").html("<div style='padding:5px'><br><div style='text-align:center'>Status berhasil "+stat+"<br><br><input class='btn btn-success' style='width:100px' type='button' value='OK' onClick='tutup()'></div></div>");
	    $("#popup").jqxWindow({
	      theme: theme, resizable: false,
	      width: 250,
	      height: 150,
	      isModal: true, autoOpen: false, modalOpacity: 0.2
	    });
      });
      $("html, body").animate({ scrollTop: 0 }, "slow");
      $("#popup").jqxWindow('open');
	}

	function tutup(){
		$("#popup").jqxWindow('close');
	}

	$(function() {
		$("input[name^='is_daftar__']").click(function() {
			type   = "is_daftar";
			tmp_id = $(this).prop("name").split("__");
			status = $(this).is(':checked');

			update(type, tmp_id[1], status);
		});

		$("input[name^='is_antrian__']").click(function() {
			type   = "is_daftar";
			tmp_id = $(this).prop("name").split("__");
			status = $(this).is(':checked');

			update(type, tmp_id[1], status);
		});
	});
</script>
<div id="popup" style="display:none;">
  <div id="popup_title">ePuskesmas</div><div id="popup_content">loading . . .</div>
</div>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
        </div>
        <div class="box-body">
              <table id="dataTable" class="table table-bordered table-hover">
                <thead>
					<tr style='font-weight:bold'>
						<td rowspan=2 align='center'>No</td>
						<td rowspan=2 colspan=2 align='center'>Daftar Poli Rawat Jalan</td>
						<td colspan=10 align='center'>Status Tampil</td>
					</tr>
					<tr style='font-weight:bold'>
						<td align='center'>Pendaftaran</td>
						<td align='center'>Antrian</td>
					</tr>
                </thead>
                <tbody>
				<?php 
				$i=1;
				foreach($query as $row):?>
					<tr>
						<td align=center><?php echo $i++?>.</td>
						<td><?php echo ucwords($row->value) ?>&nbsp;</td>
						<td><?php echo ucwords($row->keyword) ?>&nbsp;</td>
						<td align=center><input type="checkbox" value=1 name="is_daftar__<?php echo $row->id ?>" <?php if($row->is_daftar) echo "checked" ?>></td>
						<td align=center><input type="checkbox" value=1 name="is_antrian__<?php echo $row->id ?>" <?php if($row->is_antrian) echo "checked" ?>></td>
					</tr>
				<?php endforeach;?>                   
			</tbody>
          </table>
	    </div>
	  </div>
	</div>
  </div>
</section>

<script>
	$(function () {	
        $("#dataTable").dataTable({
          "bPaginate": false,
          "bLengthChange": false,
          "bFilter": true,
          "bSort": false,
          "bInfo": false,
          "bAutoWidth": false
        });
		$("#menu_poli").addClass("active");
		$("#menu_admin_panel").addClass("active");
	});
</script>

