<div id="popup" style="display:none;">
  <div id="popup_title">ePuskesmas</div><div id="popup_content">{popup}</div>
</div>
<div id="popup1" style="display:none;">
  <div id="popup_title1">ePuskesmas</div><div id="popup_content1">{popup}</div>
</div>
<div id="popup_del" style="display:none;">
  <div id="popup_title_del">ePuskesmas</div><div id="popup_content_del">{popup}</div>
</div>
<div id="popup_add" style="display:none;">
  <div id="popup_title_add">ePuskesmas</div><div id="popup_content_add">{popup}</div>
</div>
<section class="content">
<form action="<?php echo base_url()?>mst/agama/dodel_multi" method="POST" name="">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
        </div>
      <div class="box-body">
        <button id="btn-add" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;<b>Tambah</b></button>
        <button id="btn-refresh" class="btn btn-success"><i class="fa fa-refresh"></i>&nbsp;<b>Refresh</b></button>
      </div>
		  <div class="box-body">
		    <div class="div-grid">
		        <div id="jqxgrid"></div>
			  </div>
	    </div>
	  </div>
	</div>
  </div>
</form>
</section>
<script type="text/javascript">
	$(function () {
    $("#menu_admin_panel").addClass("active");
		$("#menu_news").addClass("active");

    $("#popup").jqxWindow({
			theme: theme, resizable: false,
			width: 250,
			height: 200,
			isModal: true, autoOpen: false, modalOpacity: 0.4
		});

	});

   var source = {
		datatype: "json",
		type	: "POST",
		datafields: [
		{ name: 'id', type: 'string'},
		{ name: 'content', type: 'string'},
		{ name: 'status', type: 'string'}
      ],
		url: "<?php echo site_url('news/json_news'); ?>",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgrid").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgrid").jqxGrid('updatebounddata', 'sort');
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

		$('#btn-refresh').click(function (e) {
      e.preventDefault();
			$("#jqxgrid").jqxGrid('clearfilters');
		});

    $('#btn-add').click(function(e){
      e.preventDefault();
  		$("#popup_content_add").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
  		$.get("<?php echo base_url().'news/add_news/'; ?>", function(data) {
  			$("#popup_content_add").html(data);
  		});
  		$("#popup_add").jqxWindow({
  			theme: theme, resizable: false,
  			width: 600,
  			height: 400,
  			isModal: true, autoOpen: false, modalOpacity: 0.4
  		});
      $("html, body").animate({ scrollTop: 0 }, "slow");
      $(".jqx-window-close-button").css('display','none');
  		$("#popup_add").jqxWindow('open');
    });

		$("#jqxgrid").jqxGrid(
		{
			width: '100%', autoheight: true,autorowheight: true,
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100'],
			showfilterrow: false, filterable: false, sortable: false, autoheight: true, pageable: true, virtualmode: true, editable: false,
			rendergridrows: function(obj)
			{
				return obj.data;
			},
			columns: [
        { text: 'Konten', datafield: 'content', align: 'center', width: '60%', cellsrenderer: function (row) {
				    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
					  return "<div style='width:100%;padding-top:20px;text-align:center'>"+dataRecord.content+"</div>";
          }
        },
        { text: 'Status', datafield: 'status', align: 'center', width: '40%', cellsrenderer: function (row) {
				    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
            var x = '';
            if(dataRecord.status == 1){
              x = 'Aktif';
            }else{
              x = 'Non Aktif';
            }
					  return "<div style='width:100%;padding-top:20px;text-align:center'>"+x+"</div>";
          }
        }
      ]
		});

    $("#jqxgrid").on('rowselect', function (event) {
        var args = event.args;
        var rowData = args.row;
        var content = rowData.content.substr(0,20);
        $("#popup_content").html("<div style='padding:15px' align='center'><br>"+content+"..."
        +"</br><br><div style='text-align:center'><input class='btn btn-success' style='width:100%' type='button' value='Detail' onClick='detail(\""
        +rowData.id+"\")'>"
        +"</br><br><input class='btn btn-warning' style='margin-top: 0px; width:100px' type='button' value='Close' onClick='close_popup();'>"
        +"&nbsp;&nbsp;<input class='btn btn-danger' style='width:100px' type='button' value='Delete' onClick='del(\""
        +rowData.id+"\")'></div></div>");

        $("html, body").animate({ scrollTop: 0 }, "slow");
        $("#popup").jqxWindow('open');
        $(".jqx-window-close-button").css('display','none');

    });

    function detail(id){
      $("#popup").jqxWindow('close');
      $("#popup_add").jqxWindow('close');
      $("#popup_content1").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
      $.get("<?php echo base_url().'news/detail_news/'; ?>" + id , function(data) {
        $("#popup_content1").html(data);
      });
      $("#popup1").jqxWindow({
        theme: theme, resizable: false,
        width: 600,
        height: 400,
        isModal: true, autoOpen: false, modalOpacity: 0.2
      });
      $("html, body").animate({ scrollTop: 0 }, "slow");
      $(".jqx-window-close-button").css('display','none');
      $("#popup1").jqxWindow('open');
    }

    function del(id){
      $("#popup").jqxWindow('close');
      $("#popup1").jqxWindow('close');
      $("#popup_add").jqxWindow('close');
  		$("#popup_content_del").html("<div style='padding:5px'><br><div style='text-align:center'>Hapus Data?<br><br>"
      +"<input class='btn btn-danger' style='width:100px' type='button' value='Delete' onClick='del_senditm("
      +id+")'>&nbsp;&nbsp;<input class='btn btn-success' style='width:100px' type='button' value='Batal' onClick='close_popup()'></div></div>");
      $("#popup_del").jqxWindow({
        theme: theme, resizable: false,
        width: 250,
        height: 150,
        isModal: true, autoOpen: false, modalOpacity: 0.2
      });
      $("#popup_del").jqxWindow('open');
  	}

    function del_senditm(id){
      $("#popup").jqxWindow('close');
      $("#popup1").jqxWindow('close');
      $("#popup_add").jqxWindow('close');
  		$.post("<?php echo base_url().'news/delete_news' ?>/" +id,  function(){
  		  $("#popup_content_del").html("<div style='padding:5px'><br><div style='text-align:center'>Data berhasil dihapus<br><br><input class='btn btn-success' style='width:100px' type='button' value='OK' onClick='close_popup()'></div></div>");
            $("#popup_del").jqxWindow({
              theme: theme, resizable: false,
              width: 250,
              height: 150,
              isModal: true, autoOpen: false, modalOpacity: 0.2
            });
        $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
  			$("#popup_del").jqxWindow('open');
  		});
  	}

	  function close_popup(){
        $("#jqxgrid").jqxGrid('clearselection');
        $("#popup").jqxWindow('close');
        $("#popup1").jqxWindow('close');
        $("#popup_add").jqxWindow('close');
        $("#popup_del").jqxWindow('close');
    }
</script>
