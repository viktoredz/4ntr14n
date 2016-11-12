  <div class="col-md-12">
    <h3 class="title-poli">{poli}</h3>
  </div>
  <div class="col-md-12">
    <div class="content-poli">
      <ul class="list-poli">
        <?php 
        $x = 0;
        foreach($pasien as $row){
        ?>
        <li <?php if($x==0){?>class="active"<?php }?>><?php echo $row['reg_antrian_poli'].". ".$row['nama']?></li>
        <?php 
        $x=1;
        }
        ?>
      </ul>
    </div>
  </div>
