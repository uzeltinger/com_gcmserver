<?php
/**
 * @version		$Id: properties.php 1 2010-2014 este8an $
 * @package		Joomla.Administrator
 * @subpackage	com_properties
 * @copyright	Copyright (C) 2008 - 2016 Fabio Esteban Uzeltinger.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
class GcmserverHelper //extends JHelperContent
{
	public static $extention = 'com_gcmserver';
	
	public static function addSubmenu($vName)
	{		
	$user = JFactory::getUser();
	$userId	= $user->get('id');	
	//$manageProduct = $user->authorise('core.manage.product', 'com_gcmserver');	
	$coreAdmin = $user->authorise('core.manage', 'com_gcmserver');

	if (JFactory::getUser()->authorise('core.admin', 'com_gcmserver')) {	
		JHtmlSidebar::addEntry(
			JText::_('COM_GCMSERVER_MENU_PANEL'),
			'index.php?option=com_gcmserver&view=panel',
			$vName == 'panel'
		);	
	}

	if($coreAdmin)
		{
		JHtmlSidebar::addEntry(
			JText::_('COM_GCMSERVER_MENU_PROFILES'),
			'index.php?option=com_gcmserver&view=profiles',
			$vName == 'profiles'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_GCMSERVER_MENU_NOTIFICATIONS'),
			'index.php?option=com_gcmserver&view=notifications',
			$vName == 'notifications'
		);	
		}
				
	}
	
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;
		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.delete', 'core.edit', 'core.edit.state'
		);
		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, 'com_gcmserver'));
		}
		return $result;
	}	
}
