<section class="content show">
  <div class="row">
      <div class="col-md-12">
  		<div class="row">
	        <div class="col-md-5">
	          <div class="main-poli">
	            <div class="col-md-12">
	              <h3 class="title-poli">POLI UMUM</h3>
	            </div>
	            <div class="col-md-12">
	              <div class="content-poli">
	                <ul class="list-poli">
	                  <li class="active">001. Jhoni Gunawan</li>
	                  <li>002. Turki Djunaedi</li>
	                  <li>003. Rayantoro</li>
	                  <li>004. Rana Taufik</li>
	                  <li>005. Rahmat Khan</li>
	                </ul>
	              </div>
	            </div>
	          </div>
	        </div>
	        <div class="col-md-7 video" >
	            <video autoplay="true" id="video" controls onended="run()" muted>
	            </video>
	        </div>
	      </div>
      </div>
  </div>

  <div class="row" >
    <div class="col-md-12">
      <div class="col-md-2">
        <div class="sub-poli">
          <div class="col-md-12">
            <h3 class="title-sub-poli">Poli Kia</h3>
          </div>
          <div class="col-md-12">
            <div class="content-sub-poli">
              <h5 class="no-poli">
                006
              </h5>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="sub-poli">
          <div class="col-md-12">
            <h3 class="title-sub-poli">Poli Kia</h3>
          </div>
          <div class="col-md-12">
            <div class="content-sub-poli">
              <h5 class="no-poli">
                006
              </h5>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="sub-poli">
          <div class="col-md-12">
            <h3 class="title-sub-poli">Poli Kia</h3>
          </div>
          <div class="col-md-12">
            <div class="content-sub-poli">
              <h5 class="no-poli">
                006
              </h5>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="sub-poli">
          <div class="col-md-12">
            <h3 class="title-sub-poli">Poli Kia</h3>
          </div>
          <div class="col-md-12">
            <div class="content-sub-poli">
              <h5 class="no-poli">
                006
              </h5>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="sub-poli">
          <div class="col-md-12">
            <h3 class="title-sub-poli">Poli Kia</h3>
          </div>
          <div class="col-md-12">
            <div class="content-sub-poli">
              <h5 class="no-poli">
                006
              </h5>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="sub-poli">
          <div class="col-md-12">
            <h3 class="title-sub-poli">Poli Kia</h3>
          </div>
          <div class="col-md-12">
            <div class="content-sub-poli">
              <h5 class="no-poli">
                006
              </h5>
            </div>
          </div>
        </div>
      </div>
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
    getAntrian(t);
    getSubAntrian(tt,ttt);
    getRunningText();
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
      video.src = "<?php echo base_url() . 'media/' . $this->session->userdata('puskesmas'); ?>/"+video_list[0];
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
      h += '<li>' + b.content + '</li>';
    });
    h += '</ul>';
    $('#marquee').html(h);
  });
}

function getAntrian(a){
  var url = "<?php echo base_url() . 'antrian/tv/json_show/' ?>";
  var h = '';
  var y = '';
  $.get(url).done(function(res){
    var data = JSON.parse(res);
    var i = 0;
    cc = data.row;

    $.each(data.result.slice(a), function(key,value){
      if(value.pasien_antri.length !== 0){
        h += '<div class="main-poli">';
        h += '<div class="col-md-12">';
        h += '<h3 class="title-poli">';
        h += value.nama_poli;
        h += '</h3>';
        h += '<div class="col-md-12">';
        h += '<div class="content-poli">';
        h += '<ul class="list-poli">';

      if(value.pasien_antri != undefined){
        $.each(value.pasien_antri, function(e,f){
          var no = f.id_kunjungan.substr(-3);
          var nama = f.nama;
          if(e == 0){
            h += '<li class="active">';
          }else{
            h += '<li>';
          }
          h += no + '. ' + nama;
          h += '</li>';
        });
      }

      h += '</ul>';
      h += '<div class="icon">';
      h += '<img src="<?php echo base_url() . 'media/images/show/icon-doktor.svg';?>"';
      h += '</div>';
      h += '</div>';
      h += '</div>';
      h += '</div>';
      h += '</div>';
    }

      t = a + 1;
      if(t >= cc){
        t = 0;
      }

      if(key == 0){
        return false;
        return key < 0;
      }

      i++;

    });
    $("#main-poli").css({"top":"-50px","opacity":"0.5"});
    $("#main-poli").html('');
    $("#main-poli").html(h);
    $("#main-poli").animate({ "top": "0px", "opacity":"1" }, 2000 );

  });

}

function getSubAntrian(p,q){
  var url = "<?php echo base_url() . 'antrian/tv/json_show/' ?>";

  var y = '';
  $.get(url).done(function(res){
    var data = JSON.parse(res);
    var i = p;
    ccc = data.row;
    $.each(data.result.slice(p), function(key,value){
      if(value.pasien_antri.length !== 0){

      y += '<div class="col-md-2">';
      y += '<div class="sub-poli">';
      y += '<div class="col-md-12">';
      y += '<h3 class="title-sub-poli">';
      y += value.nama_poli;
      y += '</h3>';
      y += '<div class="col-md-12">';
      y += '<div class="content-sub-poli">';

      $.each(value.pasien_antri, function(e,f){
        var no = f.id_kunjungan.substr(-3);
        var nama = f.nama;
        if(e == 0){
          y += '<h3 class="no-poli">';
          y += no;
          y += '</h3>';
        }else{
          return false;
        }

      });

      y += '</div>';
      y += '</div>';
      y += '</div>';
      y += '</div>';
      y += '</div>';
      }else{

      }

      tt = q+1;
      ttt = q+6;

      if(ttt >= ccc){
        ttt = ccc;
      }

      if(i == q){
        return false;
      }
      i++;
    });

    $("#sub-poli").css({"bottom":"0px","opacity":"0.5"});
    $("#sub-poli").html('');
    $("#sub-poli").html(y);
    $("#sub-poli").animate({ "bottom": "0px", "opacity":"1" }, 2000 );

  });
}

setInterval(function(){
  if(t >= cc){
    t = 0;

  }else{
    t = t;
  }
  getAntrian(t);
  getRunningText();
  var get_video = '<?php echo base_url() . "antrian/tv/json_video_list"; ?>';
  $.get(get_video, function(response){
    var d = JSON.parse(response);
    video_list = d;
  });
},7000);

setInterval(function(){
  if(tt >= ccc){
    tt = 0;
    ttt = 5;

  }else{
    tt = tt;
    ttt = ttt;
  }

  getSubAntrian(tt, ttt);
},7000);

</script>
