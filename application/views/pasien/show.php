<div id="popup" style="display:none;">
  <div id="popup_title">eSMS Gateway</div><div id="popup_content">{popup}</div>
</div>
<div id="popup1" style="display:none;">
  <div id="popup_title1">eSMS Gateway</div><div id="popup_content1">{popup}</div>
</div>
<div id="popup_del" style="display:none;">
  <div id="popup_title_del">eSMS Gateway</div><div id="popup_content_del">{popup}</div>
</div>
<form>
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
	    </div>
	      <div class="box-footer">
    		<div class="col-md-8">
			 	<button type="button" class="btn btn-success" id="btn-refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
			 </div>
    		<div class="col-md-4">
	     		<select id="id_puskesmas" class="form-control">
	     			<option value="">-- Pilih Puskesmas --</option>
					<?php foreach ($phc as $row ) { ?>
						<option value="<?php echo $row->code; ?>" <?php if($cl_phc==$row->code) echo "selected"; ?>><?php echo $row->keyword; ?> : <?php echo $row->value; ?></option>
					<?php }?>
	     	</select>
			</div>
	     </div>
        <div class="box-body">
		    <div class="div-grid">
		        <div id="jqxgrid_pbk"></div>
			</div>
	    </div>
	  </div>
	</div>
  </div>
</form>
<script type="text/javascript">
	$(function () {
		$("#menu_dashboard").addClass("active");
		$("#menu_antrian_pasien").addClass("active");

		$("#popup").jqxWindow({
			theme: theme, resizable: false,
			width: 250,
			height: 180,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});

		$("#id_puskesmas").change(function(){
			$.post("<?php echo base_url().'antrian/pasien/filter' ?>", 'id_puskesmas='+$(this).val()+'&id_sms_grup='+$("#id_sms_grup").val(),  function(){
				$("#jqxgrid_pbk").jqxGrid('updatebounddata', 'cells');
			});
		});

	});

      var btn_confirm = "</br></br><input class='btn btn-danger' style='width:100px' type='button' value='Ya' onClick='sync()'> <input class='btn btn-success' style='width:100px' type='button' value='Tidak' onClick='close_popup()'>";
      var btn_ok = "</br></br><input class='btn btn-success' style='width:100px' type='button' value='OK' onClick='close_popup()'>";

	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'no', type: 'number'},
			{ name: 'cl_pid', type: 'string'},
			{ name: 'nomor', type: 'string'},
			{ name: 'nik', type: 'string'},
			{ name: 'alamat', type: 'string'},
			{ name: 'nama', type: 'string'},
        ],
		url: "<?php echo site_url('antrian/pasien/json'); ?>",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgrid_pbk").jqxGrid('updateBoundData', 'filter');
		},
		sort: function(){
			$("#jqxgrid_pbk").jqxGrid('updateBoundData', 'sort');
		},
		root: 'Rows',
        pagesize: 10,
        beforeprocessing: function(data){
			if (data != null){
				source.totalrecords = data[0].TotalRows;
			}
		}
		};
		var dataadapter = new $.jqx.dataAdapter(source, {
			loadError: function(xhr, status, error){
				alert(error);
			}
		});

		$('#btn-refresh').click(function () {
			$("#jqxgrid_pbk").jqxGrid('clearfilters');
		});

		$("#jqxgrid_pbk").jqxGrid(
		{
			width: '100%', autoheight: true,autorowheight: true,
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100'],
			showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
			rendergridrows: function(obj)
			{
				return obj.data;
			},
			columns: [
				{ text: 'Nomor RM', datafield: 'cl_pid', columntype: 'textbox', filtertype: 'textbox', width: '25%' },
				{ text: 'Nama', datafield: 'nama', columntype: 'textbox', filtertype: 'textbox', width: '25%' },
				{ text: 'Alamat', datafield: 'alamat', columntype: 'textbox', filtertype: 'textbox', width: '30%' },
				{ text: 'NIK', datafield: 'nik', columntype: 'textbox', filtertype: 'textbox', width: '20%' }
      ]
		});
</script>
