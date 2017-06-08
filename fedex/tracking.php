<?php

// Copyright 2009, FedEx Corporation. All rights reserved.
// Version 6.0.0

require_once('./library/fedex-common.php');


//The WSDL is not included with the sample code.
//Please include and reference in $path_to_wsdl variable.
$path_to_wsdl = "./wsdl/TrackService_v6.wsdl";

ini_set("soap.wsdl_cache_enabled", "0");

$client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information



$tNum = $_GET['tNum'];

if(empty($tNum)){

	echo "<p align=center>No tracking Number</p>";
	exit;
}


$request['WebAuthenticationDetail'] = array(
	'UserCredential' =>array(
		'Key' => getProperty('key'), 
		'Password' => getProperty('password')
	)
);
$request['ClientDetail'] = array(
	'AccountNumber' => getProperty('shipaccount'), 
	'MeterNumber' => getProperty('meter')
);
$request['TransactionDetail'] = array('CustomerTransactionId' => '*** Track Request v6 using PHP ***');
$request['Version'] = array(
	'ServiceId' => 'trck', 
	'Major' => '6', 
	'Intermediate' => '0', 
	'Minor' => '0'
);
$request['PackageIdentifier'] = array(
	'Value' => $tNum, // Replace 'XXX' with a valid tracking identifier
	'Type' => 'TRACKING_NUMBER_OR_DOORTAG');

$request['IncludeDetailedScans'] = '1';

try 
{
	if(setEndpoint('changeEndpoint'))
	{
		$newLocation = $client->__setLocation(setEndpoint('endpoint'));
	}
	
	$response = $client ->track($request);

    if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR')
    {
		echo "<table width=100% border=0>";
		echo "<tr><td height=25><b>Shipping Tracking</b></td></tr>";

		echo "<tr><td>Tracking : ". $response -> TrackDetails -> TrackingNumber."</td></tr>";

		echo "<tr><td>Status : <b>". $response -> TrackDetails -> StatusDescription."</b></td></tr>";

		echo "<tr><td>Signed for by: ". $response -> TrackDetails -> DeliverySignatureName."</td></tr>";
		echo "</table><br>";
		echo "<table width=100% border=0 cellpadding=0 cellspacing=1>";
		echo "<tr><td height=25 colspan=4 >&nbsp;<b>History</b></td></tr>";
		echo "<tr bgcolor=#f4f4f4>
		<td align=center>Time</td>
		<td align=center>Status</td>
		<td align=center>Location</td>
		<td align=center>State</td>
		</tr>";

		$lineCnt = count($response -> TrackDetails -> Events);

		//echo "Cnt : ".$lineCnt;
		//echo "<br>";

        foreach ($response -> TrackDetails -> Events as $event)
         {
             if(is_array($response -> TrackDetails -> Events))
             {            
				echo "<tr bgcolor=#FFFFFF>";
                echo "<td>&nbsp;".$event -> Timestamp . '</td>';
                echo "<td>&nbsp;".$event -> EventDescription . '</td>';
                echo "<td>&nbsp;".$event -> Address -> City . '</td>';
                echo "<td>&nbsp;".$event -> Address -> StateOrProvinceCode . '</td>';
				echo "</tr>";
				echo "<tr><td height=1 bgcolor=#cccccc colspan=4></td></tr>";
             }
             else
             {
                 echo "<tr><td>".$location . $newline."</td></tr>";;
             }
         }

		echo "</table>";

		/*
		for($i=0; $i<$lineCnt; $i++)
		{
			echo "Time : ". $response -> TrackDetails -> Events[$i] - > Timestamp;
			echo "<br>";
		}


		echo "<br><br>";

    	echo '<table border="1">';
    	echo '<tr><th>Tracking Details</th><th>&nbsp;</th></tr>';
        trackDetails($response->TrackDetails, '');
		echo '</table>';
		*/

        //printSuccess($client, $response);
    }
    else
    {
    	echo '<table border=0 width=100%>';
        echo '<tr><td align=center height=300>Please try later again.</td></tr>';
		echo '</table>';
    } 
    
    //writeToLog($client);    // Write to log file   

} catch (SoapFault $exception) {
    printFault($exception, $client);
}

?>