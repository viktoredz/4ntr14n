<?php foreach ($antrian as $rows) {
?>
<div class="col-md-12">
  <label><?php echo $rows['reg_antrian_poli']?> . <?php echo $rows['nama']?></label> 
  <span style="float:right"><?php echo $rows['reg_poli']?></span>
</div>
<?php
}?>
