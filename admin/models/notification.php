<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	com_gcmserver
 * @copyright	Copyright (C) 2006 - 2016 Fabio Esteban Uzeltinger.
 * @email		fabiouz@gmail.com
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
 
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

class GcmserverModelNotification extends JModelAdmin
{	
	public $typeAlias = 'com_gcmserver.notification';

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
		if (empty($table->id)) {
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
	
	public function send($data)
	{
	
	if (parent::save($data)) {
	
	$params		= JComponentHelper::getParams('com_gcmserver');
	$apikey=$params->get('apikey');	
	$jinput      = JFactory::getApplication()->input; 
	$task = $jinput->get('task');
	$id = $data['id'];
	$collapse_key = $data['collapse_key'];
	$profile_id = $data['profile_id'];
	if(isset($data['topic_id']))
		{
		$topic_id = $data['topic_id'];
		}
	$data['apikey'] = $apikey;	
	$result = false;
	
	if($profile_id>0)
		{
		$profile = $this->getProfileData($profile_id);
		
		if($profile->name)
			{
			$data['profile_name'] = $profile->name;
			}
		if($profile->regid)
			{
			$data['regid'] = $profile->regid;
			$data['registrationIdsArray'] = array($data['regid']);
			$result = $this->sendMessageToGCMserver($data);
			}
		}
		
	
	
	
	if(isset($topic_id))
	{
	if($topic_id == 999)
		{
		$profiles = $this->getAllProfilesRegId();
		if($profiles)
			{
			$data['profile_name'] = '';
			$data['regid'] = '';
			$data['registrationIdsArray'] = $profiles;
			$result = $this->sendMessageToGCMserver($data);
			}
		}
	}
		/*
			print_r($profiles);
			echo '<br><br>';
			print_r($data);
			require('0');
		*/
//print_r($data);
		//$result = $this->sendMessageToGCMserver($data);
		/*
		$result = '{"multicast_id":8731962481179814679,"success":1,"failure":0,"canonical_ids":0,"results":[{"message_id":"0:1458913987873566%33590b3ef9fd7ecd"}]}';
		
		$result = json_decode($result);
		print_r($result);
		echo '<br>'.$result->multicast_id.'<br>';
		echo '<br>'.$result->success.'<br>';
		echo '<br>'.$result->failure.'<br>';
		echo '<br>'.$result->canonical_ids.'<br>';		
		$resultResults = $result->results;				
		echo '<br>'.$resultResults[0]->message_id.'<br>';
		*/
		return $result;
		//print_r($result);
		require('0');
	}	/*	if (parent::save($data)) {	*/	
	}
	
		
		
	
function sendMessageToGCMserver($data)  
{
$apiKey = $data['apikey'];//'AIzaSyArZaQkjSGkeS6lS8fT2ORfjz6rQhKmXDs'; 
$headers = array( 
                    'Authorization: key=' . $apiKey,
                    'Content-Type: application/json'
                );				
$msg = array
			(
			'message_id' 	=> $data['id'],
			'message' 	=> $data['message'],
			'title'		=> $data['title'],
			'url'		=> $data['url'],
			'subtitle'	=> 'This is a subtitle. subtitle',
			'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
			'vibrate'	=> 1,
			'sound'		=> 1,
			'largeIcon'	=> 'ic_info_black_24dp',
			'smallIcon'	=> 'ic_notifications_black_24dp'
			);
 
$data2 = array(
   'data' => $msg,
   'registration_ids' => $data['registrationIdsArray'],
   'collapse_key' => $data['collapse_key']
);

echo '<br>';
print_r( $data['registrationIdsArray'] );
echo '<br>';
print_r( $msg );
echo '<br>';
print_r( $data2 );
echo '<br>';

//print_r($data2);		require('0');

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
	
	
public function getProfileData($id)
		{
		$db 	= JFactory::getDBO(); 
		$user = JFactory::getUser();	
		$query = 'SELECT * FROM #__gcmserver_profiles WHERE id = '.$id;		
        $db->setQuery($query);        
		$profile = $db->loadObject();	
		//	print_r($query);
		return $profile;
		
		}

public function getAllProfilesRegId()
		{
		$db 	= JFactory::getDBO(); 
		$user = JFactory::getUser();	
		$query = 'SELECT regid FROM #__gcmserver_profiles WHERE published = 1';		
        $db->setQuery($query);        
		
		$profiles = $db->loadObjectList();	
		$toArray = array();
		foreach($profiles as $profile)
			{
			$toArray[] = $profile->regid;
			}
		//	print_r($query);
		return $toArray;		
		}
		
function storeResult($data)
	{		
		
		$row = $this->getTable('notifications');		
		$db		 = JFactory::getDBO();
		
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());			
			return false;
		}
		
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());			
			return false;
		}
	/*	if (!$row->id) {
		$where = "parent = " . $db->Quote($row->parent);
		$row->ordering = $row->getNextOrder( $where );
		}*/
		if (!$row->store()) {
			$this->setError( $row->getErrorMsg() );			
			return false;
		}		
		
		return $row;
	}
	
}
