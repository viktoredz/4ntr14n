<?php 
foreach ($poli as $rows) { ?>
<div class="col-md-2">
  <div class="sub-poli">
    <div class="col-md-12">
      <h3 class="title-sub-poli"><?php echo $rows['kode']?></h3>
    </div>
    <div class="col-md-12">
      <div class="content-sub-poli">
        <?php if($rows['kode']=="APOTEK"){?>
          <h5 class="no-apotek">
            <?php echo $rows['nomor']?>
          </h5>
        <?php }else{ ?>
          <h5 class="no-poli">
            <?php echo $rows['nomor']?>
          </h5>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php }?>
