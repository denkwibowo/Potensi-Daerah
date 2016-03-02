<?php
    include "../conn.php";
    if(empty($_GET['act'])){
      $getnya="";
    }else{
      $getnya="?act=".$_GET['act'];
    }
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Potensi Wilayah Kab. Sampang</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCkA5B0bPsxKV8ziY4nZbgAzR8F3XGk9QQ&sensor=false"></script>
    <script type="text/javascript">
    $(document).ready(function() {

    	var mapCenter = new google.maps.LatLng(-7.19348, 113.2495504); //Google map Coordinates
    	var map;

    	map_initialize(); // initialize google map

    	//############### Google Map Initialize ##############
    	function map_initialize()
    	{
    			var googleMapOptions =
    			{
    				center: mapCenter, // map center
    				zoom: 14, //zoom level, 0 = earth view to higher value
    				maxZoom: 20,
    				minZoom: 5,
    				zoomControlOptions: {
    				style: google.maps.ZoomControlStyle.SMALL //zoom control size
    			},
    				scaleControl: true, // enable scale control
    				mapTypeId: google.maps.MapTypeId.ROADMAP // google map type
    			};

    		   	map = new google.maps.Map(document.getElementById("google_map"), googleMapOptions);

    			//Load Markers from the XML File, Check (map_process.php)
    			$.get("map_process.php<?=$getnya?>", function (data) {
    				$(data).find("marker").each(function () {
    					  var name 		= $(this).attr('name');
    					  var address 	= '<p>'+ $(this).attr('address') +'</p>';
    					  var type 		= $(this).attr('type');
    					  var gbr 		= $(this).attr('gbr');
    					  var nama_kategori 		= $(this).attr('nama_kategori');
    					  var ket 		= $(this).attr('ket');
    					  var point 	= new google.maps.LatLng(parseFloat($(this).attr('lat')),parseFloat($(this).attr('lng')));
    					  create_marker(point, name, address, nama_kategori, ket, false, false, false, "<?=$wwwadmin?>/icons/"+gbr);

    				});
    			});

    	}

    //############### Create Marker Function ##############
	function create_marker(MapPos, MapTitle, MapDesc, Kategori, Keterangan, InfoOpenDefault, DragAble, Removable, iconPath)
	{

		//new marker
		var marker = new google.maps.Marker({
			position: MapPos,
			map: map,
			draggable:DragAble,
			animation: google.maps.Animation.DROP,
			title:"Hello World!",
			icon: iconPath
		});

		//Content structure of info Window for the Markers
		var contentString = $('<div class="marker-info-win">'+
		'<div class="marker-inner-win"><span class="info-content">'+
		'<h1 class="marker-heading">'+MapTitle+'</h1><p>'+Keterangan+'</p></span>'+
		'<p><b>Ketegori Potensi:&nbsp;</b>'+Kategori+'</p><b>Lokasi:</b>'+MapDesc+'</div></div>');


		//Create an infoWindow
		var infowindow = new google.maps.InfoWindow();
		//set the content of infoWindow
		infowindow.setContent(contentString[0]);

		//add click listner to save marker button
		google.maps.event.addListener(marker, 'click', function() {
				infowindow.open(map,marker); // click on marker opens info window
	    });

		if(InfoOpenDefault) //whether info window should be open by default
		{
		  infowindow.open(map,marker);
		}
	}
    });
    </script>
  </head>

  <body>
    <div class="navbar navbar-inverse navbar-static-top">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-1 text-center">
                    <a title="" href="#" class="place-left">
                        <img width="85" alt="" src="../logo.png">
                    </a>
            </div>
            <div class="col-md-11 text-left" style="padding: 20px 0;">
                <h3>Anjungan Informasi</h3>
                <h5>Kantor Pelayanan Perijinan dan Penanaman Modal Kabupaten Sampang</h5>
            </div>
        </div>
      </div>
    </div>

    <div class="album text-muted">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <ul class="nav of nav-stacked">
                  <li class="tq">Menu Utama</li>
                  <li><a href="http://kp3m.sampangkab.go.id/">Website</a></li>
                  <li><a href="../survey">Survey Pelanggan</a></li>
                  <li><a href="../syarat">Persyaratan Ijin</a></li>
                  <li><a href="../status">Status Perijinan</a></li>
                  <li><a href="../potensi">Potensi</a></li>
                  <li><a href="../prosedur">Prosedur Perijinan</a></li>
                  <li class="tq">Potensi</li>
                  <?php
                      $results = $mysqli->query("SELECT * FROM mkategori");
                      while($obj = $results->fetch_object())
                      {
                        echo '<li><a href="'.$www.'/?act='.$obj->id.'"><img src="'.$wwwadmin.'/icons/'.$obj->gbr.'" width="32" alt="Link to '.$obj->nama_kategori.'" />&nbsp;&nbsp;'.$obj->nama_kategori.'</a></li>';
                      }
                      ?>
                </ul>
            </div>
            <div class="col-md-10">
                <div class="qv rc aog alu">
                    <div class="row">
                        <div class="col-md-6"><a class="btn btn-primary" href="../">Beranda</a></div>
                        <div class="col-md-6 text-right"><a class="btn btn-primary" href="../potensi">Wilayah Potensi</a></div>
                    </div>
                    <div class="row">
                      <h1 class="heading text-muted">POTENSI DAERAH KABUPATEN SAMPANG</h1>
                      <div align="center">Berikut ini Daerah yang Memiliki Potensi Berkembang:</div> <br>
                      <div id="google_map"></div>
                      <ul id="list"></ul>
                    </div>
                </div>

            </div>
        </div>

      </div>
    </div>
    <hr />
    <footer class="text-muted">
      <div class="container-fluid">
        <p class="pull-right">
          <a href="#">Back to top</a>
        </p>
        <p>&copy;&nbsp;2016</p>
      </div>
    </footer>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="assets/js/vendor/holder.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>

  </body>
</html>
