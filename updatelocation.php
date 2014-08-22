<?php
require '/home/ubuntu/aws.phar';
echo $_GET['long'];
echo $_GET['lat'];

$long =  $_GET['long'];
$lat = $_GET['lat'];

use Aws\DynamoDb\DynamoDbClient;
$dynamoDbClient = DynamoDbClient::factory(array(
    'region'  => 'us-east-1',
));


$t=time();

$result = $dynamoDbClient->putItem(array(
    'TableName' => 'location',
    'Item' => array(
    	'userid' => array('N' => "1"),
        'timestamp'      => array('N' => $t),
        'long'    => array('N' => $long),
        'lat'   => array('N' => $lat),
    )
));



?>
