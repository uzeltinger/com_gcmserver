<?php
/**
 * @version		$Id: gcmserver.php 1 2006-2016 este8an $
 * @package		Joomla.Administrator
 * @subpackage	com_gcmserver
 * @copyright	Copyright (C) 2008 - 2016 Fabio Esteban Uzeltinger.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
class gcmserverController extends JControllerLegacy
{
function __construct()
	{
		parent::__construct();	
	}

	public function display($cachable = false, $urlparams = false)
	{	
	$document = JFactory::getDocument();
	$jinput = JFactory::getApplication()->input;
	//$jinput->set('format','raw');
	$viewName = $jinput->getString('view', 'gcmserver');	

		$safeurlparams = array('catid' => 'INT', 'id' => 'INT', 'cid' => 'ARRAY', 'year' => 'INT', 'month' => 'INT', 'limit' => 'UINT', 'limitstart' => 'UINT',
			'showall' => 'INT', 'return' => 'BASE64', 'filter' => 'STRING', 'filter_order' => 'CMD', 'filter_order_Dir' => 'CMD', 'filter-search' => 'STRING', 'print' => 'BOOLEAN', 'lang' => 'CMD', 'Itemid' => 'INT');
		$cachable = false;
		parent::display($cachable, $safeurlparams);
		return $this;	
		
	}
}