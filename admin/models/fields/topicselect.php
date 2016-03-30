<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	com_properties
 * @copyright	Copyright (C) 2006 - 2016 Fabio Esteban Uzeltinger.
 * @email		fabiouz@gmail.com
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldTopicselect extends JFormFieldList
{
	protected $type = 'Topicselect';
	
	public function getOptions()
	{
		$options = array();

		$params		= JComponentHelper::getParams('com_gcmserver');
		
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('id As value, name As text');
		$query->from('#__gcmserver_topics AS a');
		$query->order('a.name');
		$db->setQuery($query);
		$options = $db->loadObjectList();
		if ($db->getErrorNum()) {
			JFactory::getApplication()->enqueueMessage($db->getErrorMsg(), 'error');
		}
		array_unshift($options, JHtml::_('select.option', '999', JText::_('COM_GCMSERVER_SELECT_ALLTOPICS')));
		array_unshift($options, JHtml::_('select.option', '', JText::_('COM_GCMSERVER_SELECT_TOPIC')));
		
		return $options;
	}
}
