<?php
/**
* @copyright	Copyright(C) 2008-2010 Fabio Esteban Uzeltinger
* @license 		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @email		admin@com-property.com
**/
defined( '_JEXEC' ) or die( 'Restricted access' );

//jimport('joomla.application.component.modelitem');

jimport('joomla.application.component.modelform');
jimport('joomla.event.dispatcher');
jimport('joomla.plugin.helper');

class GcmserverModelNotification extends JModelForm
{
	public $_context = 'com_gcmserver.notification';
	protected $_extension = 'com_gcmserver';

protected function populateState()
	{
		$app = JFactory::getApplication('site');
		// Load state from the request.
		$pkc = JRequest::getInt('id');
		$this->setState('notification.id', $pkc);
	}	
	
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.			
		return '';
	}	
	
	protected function loadFormData()
	{	
		return '';
	}		
					
		function store($data)
		{		
		$db		 = JFactory::getDBO();		
		JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_gcmserver/tables');			
		$row = JTable::getInstance('notifications', 'GcmserverTable');			
		if (!$row->bind($data)) {
			 $this->setError( $this->_db->getErrorMsg() );
			echo $this->_db->getErrorMsg();
			JError::raiseError(500, $this->_db->getErrorMsg() );
			return false;
		}
		// Make sure the hello record is valid
		if (!$row->check()) {
			$this->setError( $this->_db->getErrorMsg() );
			echo $this->_db->getErrorMsg();
			JError::raiseError(500, $this->_db->getErrorMsg() );
			return false;
		}
		// Store the web link table to the database
		if (!$row->store()) {
			$this->setError( $this->_db->getErrorMsg() );	
			echo $this->_db->getErrorMsg();	
				JError::raiseError(500, $this->_db->getErrorMsg() );
			return false;
		}
		return true;
	}	
	
}//fin clase