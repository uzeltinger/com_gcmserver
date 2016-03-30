<?php
/**
 * @version		$Id: gcmserver.php 1 2006-2016 este8an $
 * @package		Joomla.Administrator
 * @subpackage	com_gcmserver
 * @copyright	Copyright (C) 2008 - 2016 Fabio Esteban Uzeltinger.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
// no direct access
defined('_JEXEC') or die;
jimport('joomla.application.component.controller');
$params = JComponentHelper::getParams('com_gcmserver');
	if($params->get('loadBootstrapCss',1))
		{
		//$doc = JFactory::getDocument();
		//$doc->addStyleSheet('media/com_gcmserver/css/bootstrap.min.css');
		}
$controller = JControllerLegacy::getInstance('gcmserver');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
?>