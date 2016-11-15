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
    <div>POLI UMUM</poli>
    <div>POLI KIA</poli>
    <div>POLI GIGI</poli>
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
    });

  });
</script>