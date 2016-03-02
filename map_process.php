<?php
//PHP 5 +
include "../conn.php";

if (mysqli_connect_errno())
{
	header('HTTP/1.1 500 Error: Could not connect to db!');
	exit();
}

################ Continue generating Map XML #################

//Create a new DOMDocument object
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers"); //Create new element node
$parnode = $dom->appendChild($node); //make the node show up

// Select all the rows in the markers table
if (empty($_GET['act'])){
   $rek = "";
} else{
   $rek = " m.type='".$_GET['act']."' AND";
}

$results = $mysqli->query("SELECT * FROM markers AS m, mkategori AS k WHERE ".$rek." m.type=k.id");
if (!$results) {
	header('HTTP/1.1 500 Error: Could not get markers!');
	exit();
}

//set document header to text/xml
header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each
while($obj = $results->fetch_object())
{
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("name",$obj->name);
  $newnode->setAttribute("address", $obj->address);
  $newnode->setAttribute("lat", $obj->lat);
  $newnode->setAttribute("lng", $obj->lng);
  $newnode->setAttribute("type", $obj->type);
  $newnode->setAttribute("nama_kategori", $obj->nama_kategori);
  $newnode->setAttribute("ket", $obj->ket);
  $newnode->setAttribute("gbr", $obj->gbr);
}

echo $dom->saveXML();
