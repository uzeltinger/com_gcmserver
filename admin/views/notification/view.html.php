<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	com_gcmserver
 * @copyright	Copyright (C) 2006 - 2016 Fabio Esteban Uzeltinger.
 * @email		fabiouz@gmail.com
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;


class GcmserverViewNotification extends JViewLegacy
{
	protected $form;
	protected $item;
	protected $state;

	public function display($tpl = null)
	{
		$canDo	= GcmserverHelper::getActions();		
		if (!$canDo->get('core.manage')) {
		$app =& JFactory::getApplication();
		$msg = JText::_('USER ERROR AUTHENTICATION FAILED').' : '. $this->Profile->name;
		$app->Redirect(JRoute::_('index.php?option=com_gcmserver', $msg));	
		}
		
		$this->form		= $this->get('Form');
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JFactory::getApplication()->enqueueMessage(implode("\n", $errors), 'error');
			return false;
		}

		$this->addToolbar();
		
		
		
		parent::display($tpl);
	}

	protected function addToolbar()
	{		
		JFactory::getApplication()->input->set('hidemainmenu', true);

		$user		= JFactory::getUser();
		$isNew		= ($this->item->id == 0);
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
		
		JToolBarHelper::title($isNew ? JText::_('COM_GCMSERVER_TITLE_NOTIFICATION_REGID') : JText::_('COM_GCMSERVER_TITLE_NOTIFICATION_REGID'), 'notifications.png');
		
		JToolBarHelper::apply('notification.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('notification.save', 'JTOOLBAR_SAVE');
			JToolBarHelper::addNew('notification.save2new', 'JTOOLBAR_SAVE_AND_NEW');
			
			
			
			if (empty($this->item->id))  {
			JToolBarHelper::cancel('notification.cancel', 'JTOOLBAR_CANCEL');
		} else {
		JToolBarHelper::custom( 'notification.send','save' ,'btn-success', 'send', false);
			JToolBarHelper::cancel('notification.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}
