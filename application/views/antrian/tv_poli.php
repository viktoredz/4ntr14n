<?php 
foreach ($poli as $rows) { ?>
<div class="col-md-2">
  <div class="sub-poli">
    <div class="col-md-12">
      <h3 class="title-sub-poli"><?php echo $rows['kode']?></h3>
    </div>
    <div class="col-md-12">
      <div class="content-sub-poli">
        <h5 class="no-poli">
          <?php echo $rows['nomor']?>
        </h5>
      </div>
    </div>
  </div>
</div>
<?php }?>
