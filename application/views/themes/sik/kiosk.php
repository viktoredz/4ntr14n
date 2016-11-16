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
        @import url(<?php echo base_url()?>public/themes/sik/dist/css/kiosk.css);
        @import url(<?php echo base_url()?>plugins/js/jqwidgets/styles/jqx.base.css);
    </style>
  
    <script src="<?php echo base_url()?>plugins/js/jQuery-2.1.3.min.js"></script>
    <script src="<?php echo base_url()?>plugins/js/jssor.slider-21.1.6.mini.js" type="text/javascript"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jqwidgets/jqxwindow.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery.printPage.js"></script>
  </head>
  <body class="skin-green sidebar-mini wysihtml5-supported">
    <div class="wrapper">
          {content}
    </div>
  </body>
</html>