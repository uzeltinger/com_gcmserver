<?php
/**
 * @version		$Id: properties.php 1 2010-2014 este8an $
 * @package		Joomla.Administrator
 * @subpackage	com_properties
 * @copyright	Copyright (C) 2008 - 2016 Fabio Esteban Uzeltinger.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * Script file of HelloWorld component
 */

class com_gcmserverInstallerScript
{
	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent) 
	{
		jimport('joomla.filesystem.folder');	
		$path = JPATH_SITE . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "com_gcmserver" . DIRECTORY_SEPARATOR . "profiles";
		$mode = 0755;
		JFolder::create($path, $mode);		
	} 	

    /**
     * method to uninstall the component
     *
     * @return void
     */
    function uninstall($parent)
    {

    }

    /**
     * method to update the component
     *
     * @return void
     */
    function update($parent)
    {
		
    }

    /**
     * method to run before an install/update/uninstall method
     *
     * @return void
     */
	function preflight($type, $parent)
    {
	
	}
	
	/**
     * method to run after an install/update/uninstall method
     *
     * @return void
     */
    function postflight($type, $parent)
    {

    }
	
}