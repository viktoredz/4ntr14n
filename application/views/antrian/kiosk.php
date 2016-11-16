<div id="popup" style="display:none;">
  <div id="popup_title">ePuskesmas</div><div id="popup_content">{popup}</div>
</div>
<div id="front">
  <img id="logo_pus" src="<?php echo base_url()?>public/themes/sik/dist/img/logo-big.png">
  <div id="pus_name">PUSKESMAS {puskesmas}</div>
  <div id="dinas_name">Dinas Kesehatan {district}</div>
  <div id="daftar">PENDAFTARAN PASIEN</div>
  <div id="daftar_id"><input type="text" name="id_pasien" maxlength="16" placeholder="Silahkan Masukkan NIK / No BPJS"></div>
  <div id="daftar_btn"><button type="button" id="btn-daftar" class="btn-lg btn-warning"><i class="fa fa-search"></i> CARI </button></div>
</div>

<div id="main" style="display:none">
  <img id="logo_pus2" src="<?php echo base_url()?>public/themes/sik/dist/img/logo-big.png">
  <div id="pus_name">PUSKESMAS {puskesmas}</div>
  <div id="dinas_name">Dinas Kesehatan {district}</div>
  <div id="poli">
    <input type="hidden" id="cl_pid">
    <div id="poli-header">Nama Pasien</div>
    <div>
      <div id="jssor_1" style="position: relative; margin: 0 auto; top: 20px; left: 0px; width: 1100px; height: 200px; overflow: hidden; visibility: hidden;">
          <!-- Loading Screen -->
          <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
              <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
              <div style="position:absolute;display:block;background:url('<?php echo base_url()?>media/img/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
          </div>
          <div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 1100px; height: 200px; overflow: hidden;">
              <?php foreach ($poli as $rows) { ?>
                <div id="poli-icon">
                  <img src="<?php echo base_url()?>media/img/<?php echo $rows['kode']?>.svg">
                  <label><?php echo $rows['value']?></label>
                </div>
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
    theme = "bootstrap";

    $("#popup").jqxWindow({
      theme: theme, resizable: false,
      width: 450,
      height: 350,
      isModal: true, autoOpen: false, modalOpacity: 0.4
    });

    $("#btn-daftar").click(function(){
      var idpasien = $("[name='id_pasien']").val();
      if(idpasien.length < 13){
        $("#popup_content").html("<div style='padding-top:35px;font-size:18px' align='center'>Nomor NIK atau BPJS tidak benar.<br>Silahkan periksa kembali.<br><br>Terimakasih.<br><br><br><br><button class='btn-lg btn-danger' onClick='tutup()'>TUTUP</button><br><br></div>");
      }else{
        if(idpasien.length == 13){
          $.ajax({ 
            type: 'GET', 
            url: '<?php echo base_url().'antrian/kiosk/bpjs/'; ?>'+ idpasien, 
            dataType: 'json',
            success: function (data) { 

              $("#cl_pid").val(data.cl_pid);
              $("#poli-header").html(data.nama);

              $("#popup_content").html("<div style='padding-top:35px;font-size:18px' align='center'>Nomor BPJS anda: "+idpasien+"<br>"+data+".<br><br>Terimakasih.<br><br><br><button class='btn-lg btn-success' onClick='mainpage()'>OK</button></div>");
            }
          });
        }else{
          $.ajax({ 
            type: 'GET', 
            url: '<?php echo base_url().'antrian/kiosk/nik/'; ?>'+ idpasien, 
            dataType: 'json',
            success: function (data) { 

              $("#cl_pid").val(data.cl_pid);
              $("#poli-header").html(data.nama);

              $("#popup_content").html("<div style='padding-top:35px;font-size:18px' align='center'>"+data.content+"</div>");
            }
          });
        }
      }

      $("html, body").animate({ scrollTop: 0 }, "slow");
      $("#popup").jqxWindow('open');
    });
  });

  function mainpage(){
    setTimeout('window.location.href="<?php echo base_url();?>antrian/kiosk"', 60000);

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

    $("#popup").jqxWindow('close');
  }

  function tutup(){
    $("#popup").jqxWindow('close');
  }

</script>
