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

class GcmserverViewProfile extends JViewLegacy
{
	protected $form;
	protected $item;
	protected $state;

	public function display($tpl = null)
	{

		$this->form		= $this->get('Form');
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');
		$this->Profile = $this->get('Profile');	
		
		$canDo	= gcmserverHelper::getActions();
		if ($canDo->get('core.admin')) 
		{
			$this->iAmAdmin=true;
			}else{
			$this->iAmAdmin=false;		
		}
		if(!$this->iAmAdmin)
		{
		if(!$this->Profile->id)
			{
			JFactory::getApplication()->enqueueMessage('Error in your account', 'error');
			return false;
			}
		}


		if (count($errors = $this->get('Errors'))) {
			JFactory::getApplication()->enqueueMessage(implode("\n", $errors), 'error');
			return false;
		}

		$this->addToolbar();		
		
		parent::display($tpl);
	}
	
	protected function checkAgent()
	{
	if($this->Profile->id != $this->item->id)
		{		
		JFactory::getApplication()->enqueueMessage(JText::_('USER ERROR AUTHENTICATION FAILED : '. $this->Profile->name), 'error');
		}
	}


	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);
		$canDo	= gcmserverHelper::getActions();

		$user		= JFactory::getUser();
		$isNew		= ($this->item->id == 0);
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
		
		JToolBarHelper::title($isNew ? JText::_('COM_GCMSERVER_MANAGER_PROFILE_NEW') : JText::_('COM_GCMSERVER_MANAGER_PROFILE_EDIT').' : '.$this->item->name, 'profiles.png');
		
		JToolBarHelper::apply('profile.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('profile.save', 'JTOOLBAR_SAVE');
			if ($canDo->get('core.admin')) {
			JToolBarHelper::addNew('profile.save2new', 'JTOOLBAR_SAVE_AND_NEW');
			}
			if (empty($this->item->id))  {
			JToolBarHelper::cancel('profile.cancel', 'JTOOLBAR_CANCEL');
		} else {
			JToolBarHelper::cancel('profile.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}
