<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	com_gcmserver
 * @copyright	Copyright (C) 2006 - 2016 Fabio Esteban Uzeltinger.
 * @email		fabiouz@gmail.com
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

class GcmserverModelNotification extends JModelAdmin
{	
	public $typeAlias = 'com_gcmserver.country';

	public function getTable($type = 'Notifications', $prefix = 'GcmserverTable', $config = array())
	{
	$t=JTable::getInstance($type, $prefix, $config);
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function getForm($data = array(), $loadData = true)
	{
		jimport('joomla.form.form');
		JForm::addFieldPath('JPATH_ADMINISTRATOR/components/com_gcmserver/models/fields');

		$form = $this->loadForm('com_gcmserver.notification', 'notification', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}
		return $form;
	}	
	

	protected function loadFormData()
	{
		$data = JFactory::getApplication()->getUserState('com_gcmserver.edit.notification.data', array());
		if (empty($data)) {
			$data = $this->getItem();
		}
		return $data;
	}

	
	
	protected function prepareTable($table)
	{
		jimport('joomla.filter.output');
		
		$user = JFactory::getUser();
		
		//print_r($table);require('a');

		//$table->name		= htmlspecialchars_decode($table->name, ENT_QUOTES);
		//$table->alias		= JApplication::stringURLSafe($table->alias);

		

		if (empty($table->id)) {
			// Set the values
			//$table->created	= $date->toMySQL();

			// Set ordering to the last item if not set
			if (empty($table->ordering)) {
				$db = JFactory::getDbo();
				$db->setQuery('SELECT MAX(ordering) FROM #__gcmserver_notifications');
				$max = $db->loadResult();

				$table->ordering = $max+1;
			}
		}
		else {
		
		}
	}	
	
	protected function getReorderConditions($table = null)
	{
		//$condition = array();
		//$condition[] = 'catid = '.(int) $table->catid;
		//return $condition;
	}
	
	
	
	
	
	
	public function save($data)
	{
	if (parent::save($data)) 
		{
		//print_r($data);				
		//$result = $this->sendMessageToPhone($data);
echo '<br>';

echo '<br>';

echo '<br>';

		$result = $this->sendMessageToGCMserver($data);
		print_r($result);
		require('0');
		}
	}
	
	
function sendMessageToGCMserver($data)  
{

/*
{"multicast_id":6144931601330833200,"success":0,"failure":1,"canonical_ids":0,"results":[{"error":"InvalidRegistration"}]}
*/
$apiKey = 'AIzaSyArZaQkjSGkeS6lS8fT2ORfjz6rQhKmXDs';
 
$headers = array( 
                    'Authorization: key=' . $apiKey,
                    'Content-Type: application/json'
                );
				
// Datos
$msg = array
			(
			'message' 	=> $data['message'],
			'title'		=> 'Título del mensaje.',
			'subtitle'	=> 'This is a subtitle. subtitle',
			'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
			'vibrate'	=> 1,
			'sound'		=> 1,
			'largeIcon'	=> 'large_icon',
			'smallIcon'	=> 'small_icon'
			);
			
$registrationIdsArray = array('feBUqKY7NiQ:APA91bE3nViXUcVhqd-Nvup4Wll3kBGlONmAUuykbjr-p5B7uK6uc8qFOt9gVvD9F2V5B-W0NiW-kLU3BaG4aHPuCeNZpY26qbU0FPpAXNsTpXEhi-zpyqT6pvJM5ZFalwUNosz3yGmM');
 
$data2 = array(
   'data' => $msg,
   'registration_ids' => $registrationIdsArray
);

echo '<br>';
print_r( $registrationIdsArray );
echo '<br>';
print_r( $msg );
echo '<br>';
print_r( $data2 );
echo '<br>';

// Petición
$ch = curl_init();
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch, CURLOPT_URL, "https://android.googleapis.com/gcm/send" );
curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($data2));
 
// Conectamos y recuperamos la respuesta
$response = curl_exec($ch);
 
// Cerramos conexión
curl_close($ch);

return $response;

/*
{"multicast_id":6242649142049142919,"success":1,"failure":0,"canonical_ids":0,"results":[{"message_id":"0:1458855356650611%33590b3ef9fd7ecd"}]}
{"multicast_id":9169518896689919291,"success":1,"failure":0,"canonical_ids":0,"results":[{"message_id":"0:1458855791099241%33590b3ef9fd7ecd"}]}
{"multicast_id":8857321483103116920,"success":1,"failure":0,"canonical_ids":0,"results":[{"message_id":"0:1458858775901500%33590b3ef9fd7ecd"}]}
*/
}
	
	
	
	
function sendMessageToPhone($data)  
{  
// API access key from Google API's Console
define( 'API_ACCESS_KEY', 'YOUR-API-ACCESS-KEY-GOES-HERE' );

$url = 'http://localhost/montehermosoalquila/webapp/index.php?option=com_gcmserver&task=gcmserver.send';

$url = 'http://www.montehermosoalquila.com.ar/webapp/index.php?option=com_gcmserver&task=gcmserver.send';


//$url = 'https://android.googleapis.com/gcm/send';
// prep the bundle

$fields = array
(
	'registration_ids' 	=> $data['regid'],
	'data'			=> $data['message']
);
 
$headers = array
(
	'Authorization: key=' . API_ACCESS_KEY
);

$postData = array(
    'id' => $data['id'],
	'regid' => $data['regid'],
    'message' => $data['message']
);
 

$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, $url );
curl_setopt( $ch,CURLOPT_POST, count($postData) );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
// Get the response back as string instead of printing it       
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_POSTFIELDS,  $postData  );
$result = curl_exec($ch );
curl_close( $ch );
//echo json_encode( $fields );
//echo $result;
return $result;
}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	





function sendGoogleCloudMessage( $data, $ids )
{
    // Insert real GCM API key from Google APIs Console
    // https://code.google.com/apis/console/        
    $apiKey = 'abc';

    // Define URL to GCM endpoint
  //  $url = 'https://gcm-http.googleapis.com/gcm/send';
	$url = 'http://localhost/montehermosoalquila/webapp/index.php?option=com_gcmserver&task=gcmserver.send';

    // Set GCM post variables (device IDs and push payload)     
    $post = array(
                    'registration_ids'  => $ids,
                    'data'              => $data,
                    );

    // Set CURL request headers (authentication and type)       
    $headers = array( 
                        'Authorization: key=' . $apiKey,
                        'Content-Type: application/json'
                    );
					
		$msg = array
			(
			'message' 	=> $data['message'],
			'title'		=> 'This is a title. title',
			'subtitle'	=> 'This is a subtitle. subtitle',
			'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
			'vibrate'	=> 1,
			'sound'		=> 1,
			'largeIcon'	=> 'large_icon',
			'smallIcon'	=> 'small_icon'
			);
			
    // Initialize curl handle       
    $ch = curl_init();

    // Set URL to GCM endpoint      
    curl_setopt( $ch, CURLOPT_URL, $url );

    // Set request method to POST       
    curl_setopt( $ch, CURLOPT_POST, true );

    // Set our custom headers       
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

    // Get the response back as string instead of printing it       
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

    // Set JSON post data
    curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $post ) );

    // Actually send the push   
    $result = curl_exec( $ch );

    // Error handling
    if ( curl_errno( $ch ) )
    {
        echo 'GCM error: ' . curl_error( $ch );
    }

    // Close curl handle
    curl_close( $ch );

    // Debug GCM response       
    echo $result;require('111');
}


public function save2($data)
{
	if (parent::save($data)) 
	{
	print_r($data);
	print_r('fabio');
	/*
	$url = 'http://localhost/montehermosoalquila/webapp/index.php?option=com_gcmserver&task=gcmserver.send';
	*/
	//https://gcm-http.googleapis.com/gcm/send
	$url = 'http://localhost/montehermosoalquila/webapp/index.php?option=com_gcmserver&task=gcmserver.send';
	$data = array('score' => '5x1', 'to' => 'bk3RNwTe3H0HHwgIpoDKCIZvvDMExUdFQ3P1');

// use key 'http' even if you send the request to https://...
	$options = array(
    'http' => array(
        'header'  => "Content-Type:application/json",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	if ($result === FALSE) { /* Handle error */ }

	var_dump($result);require('0');
	return true;
	}	
	return false;
}





/*
https://gcm-http.googleapis.com/gcm/send
Content-Type:application/json
Authorization:key=AIzaSyZ-1u...0GBYzPu7Udno5aA

{ "data": {
    "score": "5x1",
    "time": "15:10"
  },
  "to" : "bk3RNwTe3H0:CI2k_HHwgIpoDKCIZvvDMExUdFQ3P1..."
}
*/






}