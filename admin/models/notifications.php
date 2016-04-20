<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	com_gcmserver
 * @copyright	Copyright (C) 2006 - 2016 Fabio Esteban Uzeltinger.
 * @email		fabiouz@gmail.com
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

class GcmserverModelNotifications extends JModelList
{
	
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'a.id',
				'name', 'a.name',
				'cy.name', 'cy.name',
				'alias', 'a.alias',
				'checked_out', 'a.checked_out',
				'checked_out_time', 'a.checked_out_time',				
				'ordering', 'a.ordering',
				'published', 'a.published',
			);
		}

		parent::__construct($config);
	}
	
	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();
		$jinput = JFactory::getApplication()->input;
		// Adjust the context to support modal layouts.
		//$layout = $jinput->getString('layout', 'default');
		
		
		if ($layout = $jinput->getString('layout', 'default')) {
			$this->context .= '.'.$layout;
		}

		$search = $app->getUserStateFromRequest($this->context.'.search', 'filter_search');
		$this->setState('filter.search', $search);

		$access = $app->getUserStateFromRequest($this->context.'.filter.access', 'filter_access', 0, 'int');
		$this->setState('filter.access', $access);

		$published = $app->getUserStateFromRequest($this->context.'.published', 'filter_published', '');
		$this->setState('filter.published', $published);			

		// List state information.
		parent::populateState('a.regid', 'asc');
	}
	
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id.= ':' . $this->getState('filter.search');
		$id.= ':' . $this->getState('filter.access');
		$id.= ':' . $this->getState('filter.published');
		
		return parent::getStoreId($id);
	}
	
	protected function getListQuery($resolveFKs = true)
	{
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);
				
		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.*')
		);
		$query->from('#__gcmserver_notifications AS a');
		
		// Join over the Agent parent
		$query->select('ag.name AS profile_name');
		$query->join('LEFT', '#__gcmserver_profiles AS ag ON ag.id = a.profile_id');
		
		
		// Join over the Agent parent
		$query->select('t.name AS topic_name');
		$query->join('LEFT', '#__gcmserver_topics AS t ON t.id = a.topic_id');
		
	
		// Filter by published state
		$published = $this->getState('filter.published');
		if (is_numeric($published)) {
			$query->where('a.published = ' . (int) $published);
		} else if ($published === '') {
			$query->where('(a.published = 0 OR a.published = 1)');
		}
		
		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = '.(int) substr($search, 3));
			} else  {
				$search = $db->Quote('%'.$db->escape($search, true).'%');
				$query->where('(a.name LIKE '.$search.' OR a.alias LIKE '.$search.')');
			}
		}		
		$orderCol	= $this->state->get('list.ordering');
		$orderDirn	= $this->state->get('list.direction');		
		$query->order($db->escape($orderCol.' '.$orderDirn));
		//echo nl2br(str_replace('#__','jos_',$query));
		return $query;
	}
}
