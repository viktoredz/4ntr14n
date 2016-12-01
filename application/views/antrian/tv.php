<section class="content show">
  <div class="row">
      <div class="col-md-12">
  		<div class="row">
	        <div class="col-md-5">
            <input type="hidden" id="id_poli" value="0">
	          <div class="main-poli"></div>
	        </div>
	        <div class="col-md-7 video" >
	            <video autoplay="true" id="video" controls onended="run()">
	            </video>
	        </div>
	      </div>
      </div>
  </div>

  <div class="row" >
    <input type="hidden" id="id_poli_page" value="0">
    <div class="col-md-12" id="list-poli">
    </div>
  </div>
  <div class="row" style="padding-top:10px">
    <div class="running-text">
      <marquee direction="left" scrollamount="5" width="100%" id="marquee">

      </marquee>
      <div class="time">
        <ul>
            <li id="hours"></li>
            <li id="point">:</li>
            <li id="min"></li>
        </ul>
      </div>
    </div>
  </div>
</section>
<script>
var t = 0;
var cc = 0;
var ccc = 0;

var tt = 0;
var ttt = 5;

var video_count = 0;
var v = '';
var video_list  = '';

$(document).ready(function(){
    getAntrian();
    getSubAntrian();
    //getRunningText();
    setInterval( function() {
	  	var minutes = new Date().getMinutes();
	  	$("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
     },1000);

    setInterval( function() {
	  	var hours = new Date().getHours();

	  	$("#hours").html(( hours < 10 ? "0" : "" ) + hours);
    }, 1000);

    var get_video = '<?php echo base_url() . "video/json_video_list"; ?>';
    $.get(get_video, function(response){
      var d = JSON.parse(response);
      video_list = d;
      video.src = "<?php echo base_url() . 'media/'; ?>/"+video_list[0];
      video.play();
    });

});

function run(){
  console.log(video_list);
  if(video_count < video_list.length - 1){
      video_count++;
  }
  else{
      video_count = 0;
  }
  console.log(video_list[video_count]);
  v = "<?php echo base_url() . 'media/'?>"+video_list[video_count];
  video.src = v;
  video.play();
}

function getRunningText(){
  var url = "<?php echo base_url() . 'antrian/tv/json_marquee/' ?>";
  var h = '';
  $.get(url).done(function(res){
    var data = JSON.parse(res);
    h += '<ul>';
    $.each(data, function(a,b){
      h += '<li>' + b.content + '.  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</li>';
    });
    h += '</ul>';
    $('#marquee').html(h);
  });
}

function getAntrian(){
  var next = $("#id_poli").val();
  $.get("<?php echo base_url() . 'antrian/tv/tv_pasien/' ?>" + next).done(function(res){
    $(".main-poli").css({"opacity":"0.1"});
    $(".main-poli").html(res);
    $(".main-poli").animate({ "opacity":"1" }, 2000 );
  });

  $.get("<?php echo base_url() . 'antrian/tv/tv_next/' ?>" + next).done(function(res){
    $("#id_poli").val(res);
    setTimeout('getAntrian()', 10000);
  });
}

function getSubAntrian(){
  var page = $("#id_poli_page").val();
  $.get("<?php echo base_url() . 'antrian/tv/tv_poli/' ?>" + page).done(function(res){
    $("#list-poli").css({"opacity":"0.1"});
    $("#list-poli").html(res);
    $("#list-poli").animate({ "opacity":"1" }, 2000 );
  });

  $.get("<?php echo base_url() . 'antrian/tv/tv_page/' ?>" + page).done(function(res){
    $("#id_poli_page").val(res);
    setTimeout('getSubAntrian()', 10000);
  });
}

setInterval(function(){
  if(t >= cc){
    t = 0;

  }else{
    t = t;
  }
  getRunningText();
  var get_video = '<?php echo base_url() . "antrian/tv/json_video_list"; ?>';
  $.get(get_video, function(response){
    var d = JSON.parse(response);
    video_list = d;
  });
},7000);


</script>
