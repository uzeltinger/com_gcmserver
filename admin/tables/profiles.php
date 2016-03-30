<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class GcmserverTableprofiles extends JTable
{    

   function __construct(&$db)
  {
    parent::__construct( '#__gcmserver_profiles', 'id', $db );
  }
    function check()
	{
		// check for http on webpage		
		if(empty($this->alias)) {
			$this->alias = $this->name;
		}
		$this->alias = JFilterOutput::stringURLSafe($this->alias);
		if(trim(str_replace('-','',$this->alias)) == '') {
			
			$this->alias = JFactory::getDate()->format("Y-m-d-H-i-s");
		}
		if(empty($this->mid)) {
		$this->mid = $this->getLastProfile();
		}
		
		$date = JFactory::getDate();
		
		
		if ($this->id)
		{
			// Existing item
			$this->modified = $date->toSql();
		}
		else
		{			
				$this->created = $date->toSql();						
		}
		
		return true;
	}
	
	
	
	public function getLastProfile()
		{
		$db 	= JFactory::getDBO(); 
		$user = JFactory::getUser();
	
		$query = 'SELECT mid FROM #__gcmserver_profiles order by mid desc';		
        $db->setQuery($query);        
		$profile = $db->loadResult();		
		//print_r($profile);
		//require('0');
		
		return $profile+1;
		}
		
		
}
?>