<?php
/**
 * @version		$Id: user.php 17993 2010-07-01 05:15:46Z chdemko $
 * @package		Joomla.Framework
 * @subpackage	Form
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

/**
 * Field to select a user id from a modal list.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_users
 * @since		1.6productprofile
 */
class JFormFieldModalProfiles extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	public $type = 'ModalProfiles';
	
protected function getInput()
	{
		$html = array();
		$link = 'index.php?option=com_gcmserver&amp;view=profiles&layout=modal&amp;tmpl=component&amp;field='.$this->id;
		// Initialize some field attributes.
		$attr = $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
		$attr .= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';
		// Initialize JavaScript field attributes.
		$onchange = (string) $this->element['onchange'];
		// Load the modal behavior script.
		JHtml::_('behavior.modal', 'a.modal_'.$this->id);
		// Build the script.
		
		
		
		
		
		
		
		
		
		
		
		/*
		$script = array();
		$script[] = '	function jSelectUser_'.$this->id.'(id, name) {';
		$script[] = '		var old_id = document.getElementById("'.$this->id.'_id").value;';
		$script[] = '		if (old_id != id) {';
		$script[] = '			document.getElementById("'.$this->id.'_id").value = id;';
		$script[] = '			document.getElementById("'.$this->id.'").value = name;';
		$script[] = '			'.$onchange;
		$script[] = '		}';
		$script[] = '		SqueezeBox.close();';
		$script[] = '	}';

		// Add the script to the document head.
		
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
		*/
		
		
		// Build the script.
		$script = array();
		
		
		// Select button script
		$script[] = '	function jSelectArticle_' . $this->id . '(id, title, catid, object) {';
		$script[] = '		document.getElementById("' . $this->id . '_id").value = id;';
		$script[] = '		document.getElementById("' . $this->id . '_name").value = title;';
		$script[] = '		jQuery("#modalArticle' . $this->id . '").modal("hide");';
		if ($this->required)
		{
			$script[] = '		document.formvalidator.validate(document.getElementById("' . $this->id . '_id"));';
			$script[] = '		document.formvalidator.validate(document.getElementById("' . $this->id . '_name"));';
		}
		$script[] = '	}';

		// Add the script to the document head.
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

	if ((int) $this->value > 0)
		{
		$db			= JFactory::getDBO();
		$query = ' SELECT s.name'
				. ' FROM #__gcmserver_profiles AS s '
				. ' WHERE s.id = '.$this->value;
		$db->setQuery($query);
				
		
		try
			{
				$state_name = $db->loadResult();
			}
			catch (RuntimeException $e)
			{
				JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
			} 

		}else{
		$state_name = '';
		}
		
	
		if (0 == (int) $this->value)
		{
			$value = '';
		}
		else
		{
			$value = (int) $this->value;
		}
		$class = '';
		if ($this->required)
		{
			$class = ' class="required modal-value"';
		}
		$url = $link ;
	
		// The current article display field.
		$html[] = '<span class="input-append">';
		$html[] = '<input type="text" class="input-medium" id="' . $this->id . '_name" value="' . $state_name . '" disabled="disabled" size="35" />';
		$html[] = '<a href="#modalArticle' . $this->id . '" class="btn hasTooltip" role="button"  data-toggle="modal" title="'
			. JHtml::tooltipText('COM_GCMSERVER_CHANGE_PROFIE') . '">'
			. '<span class="icon-file"></span> '
			. JText::_('JSELECT') . '</a>';
		
		
		
		$html[] = '</span>';
		
		$html[] = '<input type="hidden" id="' . $this->id . '_id"' . $class . ' name="' . $this->name . '" value="' . $value . '" />';

		$html[] = JHtml::_(
			'bootstrap.renderModal',
			'modalArticle' . $this->id,
			array(
				'url' => $url,
				'title' => JText::_('COM_GCMSERVER_CHANGE_PROFIE'),
				'width' => '800px',
				'height' => '300px',
				'footer' => '<button class="btn" data-dismiss="modal" aria-hidden="true">'
					. JText::_("JLIB_HTML_BEHAVIOR_CLOSE") . '</button>'
			)
		);

		return implode("\n", $html);
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		//print_r($state_name);require('0');		
/**/
		// Create a dummy text field with the user name.
		$html[] = '<div class="fltlft">';
		$html[] = ' <input type="text" id="'.$this->id.'" name="'.$this->id.'"' .
					' value="'.htmlspecialchars($state_name, ENT_COMPAT, 'UTF-8').'"' .
					' disabled="disabled"'.$attr.' />';
		$html[] = '</div>';

		// Create the user select button.
		$html[] = '<div class="button2-left">';
		$html[] = '  <div class="blank">';
		$html[] = '		<a class="modal_'.$this->id.'" title="'.JText::_('COM_PROPERTIES_CHANGE_AGENT').'"' .
							' href="'.($this->element['readonly'] ? '' : $link).'"' .
							' rel="{handler: \'iframe\', size: {x: 800, y: 500}}">';
		$html[] = '			'.JText::_('COM_GCMSERVER_CHANGE_PROFIE').'</a>';
		$html[] = '  </div>';
		$html[] = '</div>';

		// Create the real field, hidden, that stored the user id.
		$html[] = '<input type="hidden" id="'.$this->id.'_id" name="'.$this->name.'" value="'.(int) $this->value.'" />';

		return implode("\n", $html);
		
	}
}