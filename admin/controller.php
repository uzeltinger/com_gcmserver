<?php
/**
 * @version		$Id: properties.php 1 2006-2016 este8an $
 * @package		Joomla.Administrator
 * @subpackage	com_properties
 * @copyright	Copyright (C) 2006 - 2016 Fabio Esteban Uzeltinger.
 * @email		fabiouz@gmail.com
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

class GcmserverController extends JControllerLegacy
{		
	protected $default_view = 'profiles';	
	public function display($cachable = false, $urlparams = false)
	{
		parent::display();		
		return $this;
	}
}