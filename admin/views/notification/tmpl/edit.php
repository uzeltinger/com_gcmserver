<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	com_gcmserver
 * @copyright	Copyright (C) 2006 - 2016 Fabio Esteban Uzeltinger.
 * @email		fabiouz@gmail.com
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen', 'select');

$this->hiddenFieldsets = array();
$this->hiddenFieldsets[0] = 'basic-limited';
$this->configFieldsets = array();
$this->configFieldsets[0] = 'editorConfig';

// Create shortcut to parameters.
$params = $this->state->get('params');

$app = JFactory::getApplication();
$input = $app->input;
$assoc = JLanguageAssociations::isEnabled();

// This checks if the config options have ever been saved. If they haven't they will fall back to the original settings.
$params = json_decode($params);

?>

<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'notification.cancel' || document.formvalidator.isValid(document.id('item-form')))
		{
			<?php //echo $this->form->getField('articletext')->save(); ?>
			Joomla.submitform(task, document.getElementById('item-form'));
		}
		if (task == 'notification.send')
		{
			Joomla.submitform(task, document.getElementById('item-form'));
		}
		
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_gcmserver&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">
	
    <?php //echo JLayoutHelper::render('joomla.edit.title_alias', $this); ?>
<div class="form-horizontal">    
    <div class="row-fluid form-horizontal-desktop">
		<div class="span6">  
                     
			<div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('profile_id'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('profile_id'); ?>
				</div>
			</div>
            
            <div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('topic_id'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('topic_id'); ?>
				</div>
			</div>
            
            <div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('regid'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('regid'); ?>
				</div>
			</div>
            
             <div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('collapse_key'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('collapse_key'); ?>
				</div>
			</div>
             
             <div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('title'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('title'); ?>
				</div>
			</div>
			
            <div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('message'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('message'); ?>
				</div>
			</div>
            
            <div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('url'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('url'); ?>
				</div>
			</div>
			
			<div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('urlimage'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('urlimage'); ?>
				</div>
			</div>
			
            <div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('published'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('published'); ?>
				</div>
			</div>
                
            <div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('id'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('id'); ?>
				</div>
			</div>
                
					
		</div>
		<div class="span6">
					
		</div>
	</div>
	<div class="row-fluid form-horizontal-desktop">
    <div class="span12">
    	<?php 
		if($this->item->result)
		{
		echo 'Response';
		$result = json_decode($this->item->result);		
		echo '<br>';
		echo 'multicast_id: '.$result->multicast_id;
		echo '<br>';
		echo 'success: '.$result->success;
		echo '<br>';
		echo 'failure: '.$result->failure;
		echo '<br>';
		echo 'canonical_ids: '.$result->canonical_ids;
		echo '<br>Results';
		foreach($result->results as $resultado)
			{
			echo '<br>message_id: '.$resultado->message_id;
			}			
		echo '<br>';
		echo '<br>';		
		}
		?>
    </div>
</div>
</div>



	<input type="hidden" name="task" value="" />
    <input type="hidden" name="return" value="<?php echo $input->getCmd('return'); ?>" />
	<?php echo JHtml::_('form.token'); ?>


<div class="clr"></div>
</form>
