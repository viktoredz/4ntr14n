<div style="font-size:70px;color:green">
	<i class="fa fa-volume-up"></i>
</div>
<label>
	Auto Sound Running<br>
	{nama}<br>
	{nomor}<br>
	{poli}
</label>

<script type="text/javascript">
	var playlist = ["nomorantrian","{nomor_slice}","{reg_poli}"];
		

	function playmp3(no,playlist){
		var audioElement = document.createElement('audio');
		if(playlist[no]!= undefined){
		    audioElement.setAttribute('src', "<?php echo base_url()?>/public/sound/" + playlist[no] + ".mp3");
	        audioElement.setAttribute('autoplay', 'autoplay');
	        audioElement.play();
		}

        if(playlist[no] == "nomorantrian") timeout = 1500;
        else timeout = 1000;
		setTimeout('playmp3('+(++no)+',playlist)',timeout);
        return true;
	}	

	<?php if($nomor!=""){ ?>playmp3(0, playlist);<?php }?>
</script>