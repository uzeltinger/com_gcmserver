<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	com_properties
 * @copyright	Copyright (C) 2006 - 2016 Fabio Esteban Uzeltinger.
 * @email		fabiouz@gmail.com
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
class GcmserverTableNotifications extends JTable
{    
	function __construct(&$db)
	{
		parent::__construct( '#__gcmserver_notifications', 'id', $db );
	}
	
	function check()
	{				
		$date = JFactory::getDate();		
		
		if ($this->id)
		{
			// Existing item
			//echo $this->modified; require('0000');
			if(!$this->modified)
			{
				$this->modified = $date->toSql();
			}
		}
		else
		{			
				$this->created = $date->toSql();
				$this->modified = $date->toSql();					
		}
		
		return true;
	}
	
}
?>