<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	com_gcmserver
 * @copyright	Copyright (C) 2006 - 2016 Fabio Esteban Uzeltinger.
 * @email		fabiouz@gmail.com
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

class GcmserverViewProfiles extends JViewLegacy
	{
	protected $items;
	protected $pagination;
	protected $state;
	/**
	 * The active search filters
	 *
	 * @var  array
	 */
	public $activeFilters;
	
	public function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			gcmserverHelper::addSubmenu('profiles');
		}
		
		$canDo	= GcmserverHelper::getActions();		
		if (!$canDo->get('core.manage')) {
		$app =& JFactory::getApplication();
		$msg = JText::_('USER ERROR AUTHENTICATION FAILED').' : '. $this->Profile->name;
		$app->Redirect(JRoute::_('index.php?option=com_gcmserver', $msg));	
		}
		
		$app = JFactory::getApplication();	
		
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		if (count($errors = $this->get('Errors'))) {
			JFactory::getApplication()->enqueueMessage(implode("\n", $errors), 'error');
			return false;
		}

		if ($this->getLayout() !== 'modal')
		{
			$this->addToolbar();
			$this->sidebar = JHtmlSidebar::render();	
		}
		
		$canDo	= gcmserverHelper::getActions();
		if (!$canDo->get('core.manage')) {
		$msg = JText::_('USER ERROR AUTHENTICATION FAILED').' : '. $this->Profile->name;
			$app->Redirect(JRoute::_('index.php?option=com_gcmserver', false));	
		}
		
		parent::display($tpl);
	}
		
		
	
		
	
	protected function addToolbar()
	{
		$state	= $this->get('State');		
		JToolBarHelper::title(JText::_('COM_GCMSERVER_MANAGER_PROFILES'), 'profiles.png');
			JToolBarHelper::custom('profile.add', 'new.png', 'new_f2.png','JTOOLBAR_NEW', false);
		
			JToolBarHelper::custom('profile.edit', 'edit.png', 'edit_f2.png','JTOOLBAR_EDIT', true);		
		
			JToolBarHelper::divider();
			
			JToolBarHelper::custom('profiles.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			JToolBarHelper::custom('profiles.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
			
			JToolBarHelper::divider();
			JToolBarHelper::deleteList('', 'profiles.delete','JTOOLBAR_REMOVE');
			//JToolBarHelper::custom('countries.delete','remove.png','remove_f2.png','JTOOLBAR_REMOVE', true);
		
	}
		
	protected function getSortFields()
	{
		return array(
			'ordering'     => JText::_('JGRID_HEADING_ORDERING'),
			'a.published'        => JText::_('JSTATUS'),
			'a.name'        => JText::_('JGLOBAL_TITLE'),
			'a.id'           => JText::_('JGRID_HEADING_ID')
		);
	}
	
}
