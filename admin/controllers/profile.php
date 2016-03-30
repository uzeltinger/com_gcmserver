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

class GcmserverControllerProfile extends JControllerForm
{

	public function __construct($config = array())
	{
		parent::__construct($config);
		$id = $this->input->get('id');
		if($id)
		{
		$this->SaveImages();
		}		
	}
	
	protected function allowAdd($data = array())
	{
	$user = JFactory::getUser();
	$allow = $user->authorise('core.admin', 'com_gcmserver');		
	return $allow;
	}
	
	
	protected function allowEdit($data = array(), $key = 'id')
	{
	$user = JFactory::getUser();
	$recordId	= (int) isset($data[$key]) ? $data[$key] : 0;
	$userId		= $user->get('id');
	
	if($user->authorise('core.admin', 'com_gcmserver'))
		{
		$allow = true;
		}else{
		
		$allow = $user->authorise('core.manage.product', 'com_gcmserver');		

		if($allow)
			{
			if($recordId != 0)
				{
				echo $recordId;
				$record		= $this->getModel()->getItem($recordId);			
				$agentId = $record->id;	
				$joomlaId = $record->mid;
					
					if($joomlaId != $userId){$allow = false;}	
			
				}else{
					$Profile = $this->getModel()->getProfile();	
					$this->input->set('id',$Profile->id);			

					$link = 'index.php?option=com_gcmserver&task=profile.edit&id='.$Profile->id;
					$this->setRedirect(JRoute::_($link, false));
				}
				
			}	
				
		}
		//echo $recordId;
	
		//print_r($data);require('a');
		
	return $allow;
	}
	
	public function load($data = array(), $key = 'id')
		{
		$Profile = $this->getModel()->getProfile();				
					$this->input->set('id',$Profile->id);		
					$link = 'index.php?option=com_gcmserver&task=profile.edit&id='.$Profile->id;
					$this->setRedirect(JRoute::_($link, false));
		}
		
		
	public function SaveImages()
	{
	jimport('joomla.filesystem.folder');
	jimport('joomla.filesystem.file');	
	$model		= $this->getModel();
	
	$form	= $model->getForm();
	$data	= $this->input->get('jform', array(), 'post', 'array');
	
	$data = $model->validate($form, $data);	
	
	$path_images = JPATH_SITE.'/images/gcmserver/';
	$path_image = JPATH_SITE.'/images/gcmserver/profiles/';
	if(!JFolder::exists($path_images))
		{
		JFolder::create($path_images,0755);
		}
	if(!JFolder::exists($path_image))
		{
		JFolder::create($path_image,0755);
		}
	
	$image = $this->input->get('image', null, 'files', 'array');

	if (!empty($image['name'])) 
		{		
			$ext = '.'.JFile::getExt($image['name']);
			if(!JFile::upload($image['tmp_name'], $path_image.$data['id'].'_p'.$ext) )
				{
				echo $image['tmp_name'];
				require('0');
				}; 
				
			$data['image'] = $data['id'].'_p'.$ext;
			
			
			
		}
	
	$logo_image = $this->input->files->get('logo_image', '', 'files', 'array');


	if (!empty($logo_image['name'])) 
		{		
			$ext = '.'.JFile::getExt($logo_image['name']);
			
			if(!JFile::upload($logo_image['tmp_name'], $path_image.$data['id'].'_l'.$ext) )
				{
				
				}; 
			
			
			$data['logo_image'] = $data['id'].'_l'.$ext;
		}
		
		
	$logo_image_large = $this->input->get('logo_image_large', null, 'files', 'array');

	if (!empty($logo_image_large['name'])) 
		{		
			$ext = '.'.JFile::getExt($logo_image_large['name']);
			JFile::upload($logo_image_large['tmp_name'], $path_image.$data['id'].'_ll'.$ext); 
			$data['logo_image_large'] = $data['id'].'_ll'.$ext;
		}	
		
		
if (!$model->save($data))
		{
		
		}
	
	print_r($data);
	//require('a');
	}
	
	
}