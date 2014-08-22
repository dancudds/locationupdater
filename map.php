<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Marker animations with <code>setTimeout()</code></title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
      #panel {
        position: absolute;
        top: 5px;
        left: 50%;
        margin-left: -180px;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script>
// If you're adding a number of markers, you may want to
// drop them on the map consecutively rather than all at once.
// This example shows how to use setTimeout() to space
// your markers' animation.


<?php
require '/home/ubuntu/aws.phar';


use Aws\DynamoDb\DynamoDbClient;
$dynamoDbClient = DynamoDbClient::factory(array(
    'region'  => 'us-east-1',
));



$iterator = $dynamoDbClient->getIterator('Query', array(
    'TableName'     => 'location',
    'KeyConditions' => array(
        'userid' => array(
            'AttributeValueList' => array(
                array('N' => '1')
            ),
            'ComparisonOperator' => 'EQ'
 ),
        'time' => array(
            'AttributeValueList' => array(
                array('N' => strtotime("-120 minutes"))
            ),
            'ComparisonOperator' => 'GT'
        )
    )
));

// Each item will contain the attributes we added
$i=0;

echo "var neighborhoods = [";
foreach ($iterator as $item) {

    $i++;

   echo "new google.maps.LatLng(";
   echo $item['lat']['N'];
   echo ", ";
   echo $item['long']['N'];
   echo "), \n";

    
}
echo "];";


?>


var markers = [];
var iterator = 0;

var map;

function initialize() {
  var mapOptions = {
zoom: 12,
    center: neighborhoods[0]
  };
  var bounds = new google.maps.LatLngBounds();

  map = new google.maps.Map(document.getElementById('map-canvas'),
          mapOptions);
}

function drop() {
  for (var i = 0; i < neighborhoods.length; i++) {
    setTimeout(function() {
      addMarker();
    }, i * 200);
  }
}

function addMarker() {
  markers.push(new google.maps.Marker({
    position: neighborhoods[iterator],
    map: map,
    draggable: false,
    animation: google.maps.Animation.DROP
  }));
  iterator++;
}

google.maps.event.addDomListener(window, 'load', initialize);




    </script>
  </head>
  <body>
    <div id="panel" style="margin-left: -52px">
      <button id="drop" onclick="drop()">Drop Markers</button>
     </div>
    <div id="map-canvas"></div>
  </body>
</html>

