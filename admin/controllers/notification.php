<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	com_gcmserver
 * @copyright	Copyright (C) 2006 - 2016 Fabio Esteban Uzeltinger.
 * @email		fabiouz@gmail.com
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class GcmserverControllerNotification extends JControllerForm
{
public function send()
	{
		
	$jinput      = JFactory::getApplication()->input; 
	$id = $jinput->get('id');
	$data	= $jinput->get('jform',  array(), 'post', 'array');
	//echo '<br>'.$data['id'].'<br>';
	print_r($data);
	$model = $this->getModel();
	$result = $model->send($data);
	$data['result'] = $result;
	
	$result = json_decode($result);
		print_r($result);
		echo '<br>'.$result->multicast_id.'<br>';
		echo '<br>'.$result->success.'<br>';
		echo '<br>'.$result->failure.'<br>';
		echo '<br>'.$result->canonical_ids.'<br>';		
		$resultResults = $result->results;				
		echo '<br>'.$resultResults[0]->message_id.'<br>';
		
		
		if($result->success>0)
			{
			$data['published'] = 1;
			$date = JFactory::getDate();
			$data['sent'] = $date->toSql();
			}else{
			$data['published'] = 0;
			}
			$data['changemodified'] = 1;
			
			
		$resultSaved = $model->storeResult($data);
		
	if($result->success>0)
		{
		
		JFactory::getApplication()->enqueueMessage('Enviado', 'message');
		}else{
		JFactory::getApplication()->enqueueMessage('error', 'error');
		}
	$app = JFactory::getApplication();
//require('0');
$url = JRoute::_('index.php?option=com_gcmserver&view=notification&layout=edit&id=' . (int)$id, false);
$app->redirect($url);
	/*
	Where type can be one of
    'message' (or empty) - green
    'notice' - blue
    'warning' - yellow
    'error' - red
*/
		
	}
}
