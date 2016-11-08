<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>{title}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="icon" href="<?php echo base_url()?>public/themes/login/img/favicon.ico">
    <style type="text/css">
        @import url(<?php echo base_url()?>public/themes/sik/bootstrap/css/bootstrap.min.css);
        @import url(<?php echo base_url()?>public/themes/sik/bootstrap/css/font-awesome.min.css);
        @import url(<?php echo base_url()?>public/themes/sik/bootstrap/css/ionicons.min.css);
        @import url(<?php echo base_url()?>public/themes/sik/plugins/datatables/dataTables.bootstrap.css);
        @import url(<?php echo base_url()?>public/themes/sik/dist/css/sik.css);
        @import url(<?php echo base_url()?>public/themes/sik/dist/css/skins/skin-green.min.css);
        @import url(<?php echo base_url()?>plugins/js/jqwidgets/styles/jqx.base.css);
        @import url(<?php echo base_url()?>plugins/js/jqwidgets/styles/jqx.bootstrap.css);
    </style>
	
    <script src="<?php echo base_url()?>plugins/js/jQuery-2.1.3.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxinput.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxtooltip.js"></script>
	
	  <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxdatatable.js"></script>
	
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxdropdownlist.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxwindow.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxgrid.selection.js"></script>    
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxgrid.edit.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxgrid.filter.js"></script>   
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxgrid.sort.js"></script>     
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxgrid.pager.js"></script>        
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxgrid.columnsresize.js"></script>        
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxcalendar.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxdatetimeinput.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/globalization/globalize.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxnumberinput.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxmaskedinput.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxnavigationbar.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxtabs.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxcombobox.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript">
        var theme = "bootstrap";
    </script>

  </head>
  <body id="body-main" class="skin-green sidebar-mini wysihtml5-supported">

    <div class="wrapper">
    <div id="top" class="row">
      <div class="col-md-8 col-xs-8">
        <div class="row">
          <div class="col-md-11 col-xs-10">
            <div id="pus_name">SMS Daemon Configuration</div>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-xs-4">
        <img id="logo_epus" src="<?php echo base_url()?>public/themes/sik/dist/img/epuskesmas2.png">
      </div>
    </div>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url()?>"><i class="fa fa-dashboard"></i> {title_group}</a></li>
            <li class="active">{title_form}</li>
          </ol>
        </section>
        {content}
      </div><!-- /.content-wrapper -->

      <footer class="main-footer">
        <div class="row">
          <div class="hidden-xs col-md-6">
            Copyright PT.Infokes Indonesia © 2016 - All Right Reserved<br>
            Hypertension Online Treatment - ePuskesmas
          </div>
          <div class="hidden-xs col-md-6 pull-right" style="text-align:right">
            <img height="30" src="<?php echo base_url()?>public/themes/sik/dist/img/logo.png">
          </div>
        </div>
      </footer>
    </div><!-- ./wrapper -->

    <script src="<?php echo base_url()?>public/themes/sik/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url()?>public/themes/sik/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="<?php echo base_url()?>public/themes/sik/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <script src="<?php echo base_url()?>public/themes/sik/dist/js/app.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url()?>public/themes/sik/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <script src="<?php echo base_url()?>public/themes/sik/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
  </body>
</html>