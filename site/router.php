<?php
/**
 * @version		$Id: properties.php 1 2006-2016 este8an $
 * @package		Joomla.Administrator
 * @subpackage	com_properties
 * @copyright	Copyright (C) 2008 - 2016 Fabio Esteban Uzeltinger.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
class PropertiesRouter extends JComponentRouterBase
{	
	public function build(&$query)
	{
		$segments = array();
		$app = JFactory::getApplication();
		$menu = $app->getMenu();
		if (empty($query['Itemid']))
		{
			$menuItem = $menu->getActive();
			$menuItemGiven = false;
		}
		else
		{
			$menuItem = $menu->getItem($query['Itemid']);
			$menuItemGiven = true;
		}
		// Check again
		if ($menuItemGiven && isset($menuItem) && $menuItem->component != 'com_properties')
		{
			$menuItemGiven = false;
			unset($query['Itemid']);
		}

		if (isset($query['view']))
		{
			$view = $query['view'];
		}
		else
		{
			// We need to have a view in the query or it is an invalid URL
			return $segments;
		}		
		
		if ($view == 'properties')
		{
		unset( $query['view'] );		
		}
		
		
		
	if ($view == 'property')
	{
	$dataUrl = $this->getDataUrl();
	if($dataUrl['productMenu'])
		{
		unset( $query['view'] );
		}else{
		$segments[] = $view;
		unset( $query['view'] );	
		}	
	if( isset($query['data']))
		{
		$segments[] = $query['data'];
		unset( $query['data'] );
		}
	$segments[] = $query['id'];
    unset( $query['id'] );
	if( isset($query['print']))
		{
		$segments[] = $query['print'];
		unset( $query['print'] );
		}
	}			
		
	if ($view == 'detail')
	{	
	unset( $query['view'] );
	unset( $query['cid'] );	
	$segments[] = $query['id'];
    unset( $query['id'] );
	}	
	
	if ($view == 'agentlistings')
	{	
	unset( $query['view'] );	
	$segments[] = $query['aid'];
    unset( $query['aid'] );
	}	

		return $segments;
	}

	
	
	
	public function parse(&$segments)
	{
//	print_r($segments);
		$total = count($segments);
		$vars = array();
		
		$app = JFactory::getApplication();
		$menu = $app->getMenu();
		$item = $menu->getActive();

		$db = JFactory::getDbo();

		// Count route segments
		$count = count($segments);

	
	if (isset($item)) 
	{
	$Mview=$item->query['view'];

	if($Mview != 'properties')
		{
		$useMenuItem = true;		
		}else{
		$useMenuItem = false;
		}
	}else{
	$useMenuItem = false;	
	} 
	
if($useMenuItem)
 	{
//echo 'useMenuItem';
	 switch($item->query['view'])
			{
			case 'agents2222':
			$vars['view']	= 'agents';	
			$vars['id']	= $segments[0];	
			break;
			
			
			case 'property':				
				$vars['view']	= 'property';				
				$dataUrl = $this->getDataUrl();
				if($dataUrl['useDataInUrl'])
					{
					$vars['data']	= str_replace(':', '-',$segments[0]);
					$vars['id']	= $segments[1];	
					$dataVars = $this->getDataVars($vars['data']);				
					foreach($dataVars as $k=>$v)
						{
						$vars[$k] = $v;	
						}
						
					}else{
					$vars['id']	= $segments[0];	
					}					
				$productId = $this->getProductId($dataUrl,$vars['id']);
				$vars['id']	= $productId;				
			break;
			
			case 'category':
				$dataUrl = $this->getDataUrl();			
				$vars['view']	= 'category';
				$catid=$item->query['cid'];
				$vars['cid'] = $catid;
				
				if(is_numeric($segments[0]))
					{
						$vars['limitstart'] = $segments[0]; 							
					}else{
						$vars['id'] = $segments[0];
						$productId = $this->getProductId($dataUrl,$vars['id']);
						$vars['id']	= $productId;
					}				
			break;			
			
			case 'detail':case 'detalle':
				$dataUrl = $this->getDataUrl();			
				$vars['view']	= 'detail';
				$catid=$item->query['cid'];
				$vars['cid'] = $catid;
					$vars['id'] = $segments[0];
					$productId = $this->getProductId($dataUrl,$vars['id']);
					$vars['id']	= $productId;									
			break;			
			
			case 'search':						
				$vars['view']	= 'search';				
				$vars['limitstart'] = $segments[0]; 				
			break;	
			
			
			case 'agentlistings':
			$vars['view'] = 'agentlistings';
			$vars['aid'] = $segments[0];
			if(isset($segments[1]))
				{
				$vars['limitstart'] = $segments[1];		
				}								
			break;
			
			
			
					
			}
	
	}else{
	
//echo ' NO useMenuItem';
//echo $Mview;
	if($Mview == 'properties' & $segments[0]!='property')
		{		
			$vars['view'] = 'properties'; 			
			$vars['limitstart'] = $segments[0];
		}		
		
		switch($segments[0])
			{
			case 'pdf':
				$dataUrl = $this->getDataUrl();
				$vars['view']	= 'pdf';			
				$vars['id'] = $segments[1];	
				$productId = $this->getProductId($dataUrl,$vars['id']);
					$vars['id'] =	$productId;			
			break;
			case 'print':
				$dataUrl = $this->getDataUrl();
				$vars['view']	= 'print';			
				$vars['id'] = $segments[1];	
				$productId = $this->getProductId($dataUrl,$vars['id']);
					$vars['id'] =	$productId;					
			break;
			case 'contact':
				$vars['view']	= 'contact';			
				$vars['id'] = $segments[1];						
			break;		
			case 'map':
				$vars['view']	= 'map';			
				$vars['id'] = $segments[1];									
			break;
			
			case 'pricelist':
				$vars['view']	= 'pricelist';			
				$vars['id'] = $segments[1];									
			break;
			case 'property':
				$vars['view']	= 'property';				
				$dataUrl = $this->getDataUrl();
				if($dataUrl['useDataInUrl'])
					{
					$vars['data']	= str_replace(':', '-',$segments[1]);
					$vars['id']	= $segments[2];	
					$dataVars = $this->getDataVars($vars['data']);				
					foreach($dataVars as $k=>$v)
						{
						$vars[$k] = $v;	
						}
					$productId = $this->getProductId($dataUrl,$vars['id']);
					$vars['id']	= $productId;			
					}else{
					$vars['id']	= $segments[1];	
					
					}					
						
			break;	
			case 'properties':
				$vars['view'] = 'properties'; 			
				$vars['limitstart'] = $segments[0]; 					
			break;
					
			default:
				$vars['view'] = 'properties'; 			
				$vars['limitstart'] = $segments[0]; 	
					
			break;
			}	
		
	}

   
/*  
echo '<br>';
print_r($segments);
echo '<br>';
print_r($vars);
echo '<br>';
 */
  
       return $vars;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function getDataUrl()
		{
		$lang = JFactory::getLanguage();
		$thisLang = $lang->getTag();
	
		$params		= JComponentHelper::getParams('com_properties');
		$urlRefId = $params->get('urlRefId');
		$useDataInUrl = $params->get('useDataInUrl');
		
		$db = JFactory::getDBO();	
		$and=' AND published = 1';
		if($thisLang)
			{
			$and.=' AND (language = "'.$thisLang.'" OR language = "*")';
			}
		$query = 'SELECT id FROM #__menu' .
				' WHERE link = "index.php?option=com_properties&view=property"'.$and;					
		$db->setQuery( $query );
		$output = $db->loadResult();
//echo 	$query;	
		$dataUrl['urlRefId'] = $params->get('urlRefId');
		$dataUrl['useDataInUrl'] = $params->get('useDataInUrl');
		$dataUrl['productMenu'] = $output;			
		return $dataUrl;
		}
		
		
	function getDataVars( $data )
	{
	$params		= JComponentHelper::getParams('com_properties');
	$urlRefId = $params->get('urlRefId');

	$dataArray=explode('_',$data);
$totalVars = count($dataArray);	
$varId = 0;
	if($dataArray[$varId])
	{
	if($urlCountry=$params->get('urlCountry'))
		{
		$dataVar['cyid']=$dataArray[$varId];
		unset( $dataArray[$varId] );
		$varId++;
		$totalVars--;
		}
	}	
	if($dataArray[$varId])
	{
	if($urlState=$params->get('urlState'))
		{
		$dataVar['sid']=$dataArray[$varId];
		unset( $dataArray[$varId] );
		$varId++;
		$totalVars--;
		}	
	}		
	if($dataArray[$varId])
	{	
	if($urlLocality=$params->get('urlLocality'))
		{
		$dataVar['lid']=$dataArray[$varId];
		unset( $dataArray[$varId] );
		$varId++;
		$totalVars--;
		}	
	}		
	if($dataArray[$varId])
	{	
	if($urlType=$params->get('urlType'))
		{
		$dataVar['tid']=$dataArray[$varId];
		unset( $dataArray[$varId] );
		$varId++;
		$totalVars--;
		}	
	}		
	if($dataArray[$varId])
	{	
	if($urlCategory=$params->get('urlCategory'))
		{
		$dataVar['cid']=$dataArray[$varId];
		unset( $dataArray[$varId] );
		$varId++;
		$totalVars--;
		}
	}	
	return $dataVar;
	}
	
	
	function getProductId($dataUrl,$id)
		{
		//echo $id;
		$db = JFactory::getDBO();	
		$signs = array('#','>','<','\\',',','.'); 	
		$id = trim(str_replace($signs, '', $id));
		$alias = str_replace(':', '-',$id);
		switch($dataUrl['urlRefId'])
			{
			case 0 :/*	alais	*/
			
			$where = ' WHERE alias = '.$db->Quote($alias);//.' OR pt_alias = '.$db->Quote($alias);
			break;
			case 1 :/*	id	*/
			$where = ' WHERE id = '.$id;
			break;
			case 2 :/*	ref	*/
			$where = ' WHERE ref = '.$db->Quote($id);
			break;		
			case 3 :/*	id-alais	*/
			$aliases = explode(':',$id);
			$where = ' WHERE id = '.$aliases[0];
			break;
			case 4 :/*	ref-alais	*/
			$aliases = explode('-',$id);
			$where = ' WHERE ref = '.$db->Quote($aliases[0]);
			break;		
			default :/*	id	*/
			$where = ' WHERE id = '.$id;
			break;
			}		
		$query = 'SELECT id FROM #__properties_products '.
		$where;
		//echo $query;
			$db->setQuery($query);
			$product = $db->loadObject();
		return $product->id;
		}		
		
		
		
		
		
		
		
		
		
		
}

