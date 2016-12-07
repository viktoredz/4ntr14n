<div id="popup" style="display:none;">
  <div id="popup_title">ePuskesmas</div><div id="popup_content">loading . . .</div>
</div>
<div id="front">
  <img id="logo_pus" src="<?php echo base_url()?>public/themes/sik/dist/img/logo-big.png">
  <div id="pus_name">PUSKESMAS {puskesmas}</div>
  <div id="dinas_name">Dinas Kesehatan {district}</div>
  <div id="pilih">Selamat Datang Di Puskesmas Kami</div>
  <div id="daftar_btn">
    <button type="button" id="btn-search" class="btn-lg btn-warning"><i class="fa fa-vcard-o" style="font-size:50px"></i><br>PASIEN LAMA </button>
    <button type="button" id="btn-loket" class="btn-lg btn-primary"><i class="fa fa-user-circle" style="font-size:50px"></i><br>PASIEN BARU </button>
  </div>
</div>

<div id="search" style="display:none">
  <img id="logo_pus" src="<?php echo base_url()?>public/themes/sik/dist/img/logo-big.png">
  <div id="pus_name">PUSKESMAS {puskesmas}</div>
  <div id="dinas_name">Dinas Kesehatan {district}</div>
  <div id="daftar">PENDAFTARAN PASIEN</div>
  <div id="daftar_id"><input type="text" name="id_pasien" maxlength="16" placeholder="Silahkan Masukkan No RM / NIK / No BPJS"></div>
  <div id="daftar_btn">
    <button type="button" id="btn-daftar" class="btn-lg btn-warning"><i class="fa fa-search"></i> &nbsp; CARI </button>
    <button type="button" id="btn-kembali" class="btn-lg btn-primary"><i class="fa fa-reply"></i> &nbsp; KEMBALI </button>
  </div>
</div>

<div id="main" style="display:none">
  <img id="logo_pus2" src="<?php echo base_url()?>public/themes/sik/dist/img/logo-big.png">
  <div id="pus_name">PUSKESMAS {puskesmas}</div>
  <div id="dinas_name">Dinas Kesehatan {district}</div>
  <div id="poli">
    <input type="hidden" id="cl_pid">
    <input type="hidden" id="poli">
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
                <div id="poli-icon" onClick="daftar('<?php echo $rows['kode']?>','<?php echo $rows['value']?>')">
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
<div id="footer">Powered by Infokes Indonesia</div>
<div id="print_area" style="display:none"></div>
<script type="text/javascript">
  $(function () {
    theme = "bootstrap";

    $("#popup").jqxWindow({
      theme: theme, resizable: false,
      width: 460,
      height: 350,
      isModal: true, autoOpen: false, modalOpacity: 0.4
    });

    $("#btn-loket").click(function(){
        $.ajax({ 
          type: 'GET', 
          url: '<?php echo base_url().'antrian/kiosk/loket'; ?>', 
          dataType: 'json',
          success: function (data) { 
            $("#popup_content").html("<div style='padding-top:35px;font-size:18px' align='center'>"+data.content+"</div>");
            $("#print_area").html(data.print);
          }
        });
      $("html, body").animate({ scrollTop: 0 }, "slow");
      $("#popup").jqxWindow('open');
    });

    $("#btn-search").click(function(){
      $("#front").hide();
      $("#search").show('fade');
    });

    $("#btn-kembali").click(function(){
      $("#search").hide();
      $("#front").show('fade');
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

              $("#popup_content").html("<div style='padding-top:35px;font-size:18px' align='center'>"+data.content+"</div>");
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

  function daftar(kode,poli){
      var nama = $("#poli-header").html();
      $("#poli").val(kode);

      $("#popup_content").html("<div style='padding-top:35px;font-size:24px' align='center'>"+nama+"<br><br>Lanjutkan pendaftaran<br><br>ke <b> "+poli+"</b> ? <br><div class='row' style='padding-top:40px'><div class='col-md-6'><button type='button' class='btn-lg btn-success' onClick='lanjut()' style='width:90%'>YA</button></div><div class='col-md-6'><button type='button' onClick='tutup()' class='btn-lg btn-danger' style='width:90%'>TIDAK</button></div></div></div>");
      $("html, body").animate({ scrollTop: 0 }, "slow");
      $("#popup").jqxWindow('open');
  }

  function lanjut(){
      var poli = $("#poli").val();
      var cl_pid = $("#cl_pid").val();

      $("#popup_content").html("<div style='padding-top:35px;font-size:24px' align='center'><br>Silahkan tunggu..<br><br>Mendaftarkan ke <br><b> "+poli+"</b><br><br>Terimakasih.</div>");
      $.ajax({ 
        type: 'GET', 
        url: '<?php echo base_url().'antrian/kiosk/daftar/'; ?>'+ cl_pid +"/"+poli, 
        dataType: 'json',
        success: function (data) { 
          $("#popup_content").html("<div style='padding-top:35px;font-size:18px' align='center'>"+data.content+"</div>");
          $("#print_area").html(data.print);
        }
      });

      $("html, body").animate({ scrollTop: 0 }, "slow");
      $("#popup").jqxWindow('open');
  }

  function mainpage(){
    setTimeout('window.location.href="<?php echo base_url();?>antrian/kiosk"', 60000);

    $("#search").hide();
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

  function print(){
    setTimeout('window.location.href="<?php echo base_url();?>antrian/kiosk"', 1000);

    $("#print_area").show();
    jQuery.print("#print_area");
  }

  function loket(){
    setTimeout('window.location.href="<?php echo base_url();?>antrian/kiosk"', 1000);

    $("#print_area").show();
    jQuery.print("#print_area");
  }

  function tutup(){
    $("#popup").jqxWindow('close');
  }

</script>
