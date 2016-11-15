<div id="popup">
  
</div>

<div id="front">
  <img id="logo_pus" src="<?php echo base_url()?>public/themes/sik/dist/img/logo-big.png">
  <div id="pus_name">PUSKESMAS {puskesmas}</div>
  <div id="dinas_name">Dinas Kesehatan {district}</div>
  <div id="daftar">PENDAFTARAN PASIEN</div>
  <div id="daftar_id"><input type="text" name="id_pasien" placeholder="Silahkan Masukkan No BPJS/NIK"></div>
  <div id="daftar_btn"><button type="button" id="btn-daftar" class="btn-lg btn-warning"><i class="fa fa-search"></i> CARI </button></div>
</div>

<div id="main" style="display:none">
  <img id="logo_pus2" src="<?php echo base_url()?>public/themes/sik/dist/img/logo-big.png">
  <div id="pus_name">PUSKESMAS {puskesmas}</div>
  <div id="dinas_name">Dinas Kesehatan {district}</div>
  <div id="poli">
    <div id="poli-header">Nama Pasien 20 Thn</div>
    <div>
      <div id="jssor_1" style="position: relative; margin: 0 auto; top: 20px; left: 0px; width: 1100px; height: 200px; overflow: hidden; visibility: hidden;">
          <!-- Loading Screen -->
          <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
              <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
              <div style="position:absolute;display:block;background:url('<?php echo base_url()?>media/img/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
          </div>
          <div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 1100px; height: 200px; overflow: hidden;">
              <?php foreach ($poli as $rows) { ?>
                <div id="poli-icon"><?php echo $rows['value']?></div>
              <?php }?>
          </div>
          <!-- Bullet Navigator -->
          <div data-u="navigator" class="jssorb03" style="bottom:10px;right:10px;">
              <!-- bullet navigator item prototype -->
              <div data-u="prototype" style="width:21px;height:21px;">
                  <div data-u="numbertemplate"></div>
              </div>
          </div>
          <!-- Arrow Navigator -->
          <span data-u="arrowleft" class="jssora03l" style="top:0px;left:8px;width:55px;height:55px;" data-autocenter="2"></span>
          <span data-u="arrowright" class="jssora03r" style="top:0px;right:8px;width:55px;height:55px;" data-autocenter="2"></span>
      </div>



  </div>
  </div>
</div>

<div id="end" style="display:none">
  <img id="logo_pus2" src="<?php echo base_url()?>public/themes/sik/dist/img/logo-big.png">
  <div id="pus_name">PUSKESMAS {puskesmas}</div>
  <div id="dinas_name">Dinas Kesehatan {district}</div>
</div>

<div id="footer">Powered by Infokes Indonesia</div>
<script type="text/javascript">
  $(function () {

    $("#btn-daftar").click(function(){
      $("#front").hide();
      $("#main").show('fade');

      var jssor_1_options = {
        $AutoPlay: true,
        $AutoPlaySteps: 1,
        $SlideDuration: 600,
        $SlideWidth: 200,
        $SlideSpacing: 25,
        $Cols: 5,
        $ArrowNavigatorOptions: {
          $Class: $JssorArrowNavigator$,
          $Steps: 5
        },
        $BulletNavigatorOptions: {
          $Class: $JssorBulletNavigator$,
          $SpacingX: 1,
          $SpacingY: 1
        }
      };

      var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

      ScaleSlider();
    });
  });

    function ScaleSlider() {
        var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
        if (refSize) {
            refSize = Math.min(refSize, 1100);
            jssor_1_slider.$ScaleWidth(refSize);
        }
        else {
            window.setTimeout(ScaleSlider, 30);
        }
    }
    $(window).bind("load", ScaleSlider);
    $(window).bind("resize", ScaleSlider);
    $(window).bind("orientationchange", ScaleSlider);

</script>
