<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	com_properties
 * @copyright	Copyright (C) 2006 - 2016 Fabio Esteban Uzeltinger.
 * @email		fabiouz@gmail.com
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.switcher');

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
		if (task == 'profile.cancel' || document.formvalidator.isValid(document.id('item-form')))
		{
			<?php //echo $this->form->getField('articletext')->save(); ?>
			Joomla.submitform(task, document.getElementById('item-form'));
		}
	}
</script>

<form action="<?php JRoute::_('index.php?option=com_gcmserver'); ?>" method="post" name="adminForm" id="item-form" class="form-validate" enctype="multipart/form-data" >

<div class="form-horizontal">   
 
<?php echo JHtml::_('bootstrap.startTabSet', 'myPropTab', array('active' => 'data')); ?>
<?php echo JHtml::_('bootstrap.addTab', 'myPropTab', 'data', JText::_('COM_GCMSERVER_DATA', true)); ?>     
 
    <div class="row-fluid form-horizontal-desktop">
		<div class="span6">  
                     
			<div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('mid'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('mid'); ?>
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
					<?php echo $this->getForm()->getLabel('name'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('name'); ?>
				</div>
			</div>
            <div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('created'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('created'); ?>
				</div>
			</div>
            <div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('modified'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('modified'); ?>
				</div>
			</div>
            <div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('alias'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('alias'); ?>
				</div>
			</div>
            
            
             <div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('razon_social'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('razon_social'); ?>
				</div>
			</div>
             <div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('nombre_fantasia'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('nombre_fantasia'); ?>
				</div>
			</div>
             <div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('resp_legal'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('resp_legal'); ?>
				</div>
			</div>
             <div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('corredor'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('corredor'); ?>
				</div>
			</div>
             <div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('matricula'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('matricula'); ?>
				</div>
			</div>           
            <div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('address1'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('address1'); ?>
				</div>
			</div>
            <div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('pcode'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('pcode'); ?>
				</div>
			</div>
            <div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('locality'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('locality'); ?>
				</div>
			</div>
            <div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('state'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('state'); ?>
				</div>
			</div>
            <div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('country'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('country'); ?>
				</div>
			</div>
            <div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('email'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('email'); ?>
				</div>
			</div>
            <div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('phone'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('phone'); ?>
				</div>
			</div>
            <div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('fax'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('fax'); ?>
				</div>
			</div>
            <div class="control-group">
				<div class="control-label">
					<?php echo $this->getForm()->getLabel('mobile'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('mobile'); ?>
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
					<?php echo $this->getForm()->getLabel('language'); ?>
				</div>
				<div class="controls">
					<?php echo $this->getForm()->getInput('language'); ?>
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
		<div class="span6"></div>
	</div>
 
<?php echo JHtml::_('bootstrap.endTab'); ?>
<?php echo JHtml::_('bootstrap.addTab', 'myPropTab', 'details', JText::_('COM_GCMSERVER_MANAGER_PROFILE_IMAGES', true)); ?>    
    
<div class="width-100 fltlft"> 
                
            <fieldset class="adminform">
			<legend><?php echo JText::_('COM_GCMSERVER_MANAGER_PROFILE_IMAGES'); ?></legend>   
      <?php
                  if(!$this->item->id)
				  	{
					echo JText::_('COM_GCMSERVER_SAVE_DATA_TO_ADD_IMAGES');
					}else{					
					$profile_path = JURI::root().'images/com_gcmserver/profiles/';
                    ?>   
		<table>  	         
                
				<tr>                
                    <td class="key"><label>
								<?php echo JText::_( 'Logo' ); ?>:
                              
							</label></td>
                    <td>
                    <?php
                  if($this->item->logo_image)
				  	{
					?>
                    <img src="<?php echo $profile_path.$this->item->logo_image; ?>" /><br />
                    <?php } ?>
                    </td>
                </tr>				
                <tr>
                    <td class="key"><label>
								<?php echo JText::_( 'Cambiar' ); ?>:
                                <br />  
							</label></td>
                    <td>
                    <input class="input_box" id="logo_image" name="logo_image" type="file" />
                    </td>              
                </tr>
				
           
	</table> 
    
    <?php } ?>
    


<div class="clr"></div>            
         			</fieldset>    
          		</div>
            </div>  
<?php echo JHtml::_('bootstrap.endTab'); ?>    
<?php echo JHtml::_('bootstrap.endTabSet'); ?>
       
	<input type="hidden" name="task" value="" />
    <input type="hidden" name="return" value="<?php echo $input->getCmd('return'); ?>" />
	<?php echo JHtml::_('form.token'); ?>

</form>