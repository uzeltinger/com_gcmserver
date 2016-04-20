<?php
/*------------------------------------------------------------------------
# com_properties
# ------------------------------------------------------------------------
# author Fabio Esteban Uzeltinger
# copyright Copyright (C) 2011 com-property.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites:  www.com-property.com
# Technical Support: www.com-property.com/forum-v4
*/

/*
http://localhost/montehermosoalquila/webapp/index.php?option=com_gcmserver&task=gcmserver.register&id=1
*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class GcmserverControllerGcmserver extends JControllerForm
{	
	public function __construct($config = array())
	{
		parent::__construct($config);
		$id = $this->input->get('id');			
	}
	

	public function register()
	{
	$input      = JFactory::getApplication()->input; 
	$id = $this->input->get('id');
	$regid = $this->input->getString('regid');
	$username = $this->input->getString('username');
	$message = $this->input->getString('message');
	
	$model = $this->getModel('profile');
	$profile = $model->getProfileDatabyRegid($regid);
	
	if($profile)
		{
		$dataSave['id'] = $profile->id;
		}else{
		$dataSave['id'] = 0;
		$dataSave['published'] = 1;
		}	
	
	$dataSave['regid'] = $regid;
	$dataSave['name'] = $username;
	
	if (!$model->store($dataSave))		
	{		
	echo 'no save data in model';		
	}else{
	echo 'SUCESS';
	if($username == 'username')
		{		
		$profileSaved = $model->getProfileDatabyRegid($regid);
		$response = $this->enviarNotificacionCambiarUsername($profileSaved);
		//print_r($response);
		}
	}
		//print_r($id);Fabio Uzeltinger
		exit();
	//require('a');
	}
	
	
	public function enviarNotificacionCambiarUsername($profileSaved)
		{
		//	public static final String CATEGORY_RECOMMENDATION  Constant Value: "recommendation" 
		$params = JComponentHelper::getParams('com_gcmserver');
		$apikey=$params->get('apikey');	

	if($profileSaved->regid)
		{
		$data['profile_name'] = $profileSaved->name;
		$data['regid'] = $profileSaved->regid;
		$data['registrationIdsArray'] = array($profileSaved->regid);		
		}
		$mensaje = 'Hola: '.$data['profile_name'].' por favor cambia tu nombre de usuario para poder identificarte, puedes poner cualquier texto. Gracias!!';
		
//'AIzaSyArZaQkjSGkeS6lS8fT2ORfjz6rQhKmXDs'; 
$headers = array( 
                    'Authorization: key=' . $apikey,
                    'Content-Type: application/json'
                );				
$msg = array
			(
			'action'	=> 'changeusername',
			'message' 	=> $mensaje,
			'title'		=> 'Cambie su Nombre de usuario.',
			'subtitle'	=> 'This is a subtitle. subtitle',
			'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
			'vibrate'	=> 1,
			'sound'		=> 1,
			'largeIcon'	=> 'ic_stat_ic_notification',
			'smallIcon'	=> 'ic_stat_ic_notification'
			);
 
$data2 = array(
   'data' => $msg,
   'registration_ids' => $data['registrationIdsArray']
);

echo '<br>';
print_r( $data['registrationIdsArray'] );
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
		
	
	
	
	
	public function send()
	{
	
	
	
	$input      = JFactory::getApplication()->input; 
	$id = $this->input->get('id');
	$regid = $this->input->get('regid');
	$message = $this->input->get('message');

	$model = $this->getModel('notification');	
	
	$dataSave['id'] = 0;
	$dataSave['regid'] = $regid;
	//$dataSave['name'] = 1;
	//print_r($model);
	
	if (!$model->store($dataSave))		
	{		
	echo 'no save data in model';		
	}else{
	echo 'SUCESS';	
	}
			
		exit();
		
	}
	
	
}
