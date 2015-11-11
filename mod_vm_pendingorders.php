<?php
/*------------------------------------------------------------------------
# mod_vm_pendingorders - VirtueMart Pending Orders
# ------------------------------------------------------------------------
# author    Jeremy Magne
# copyright Copyright (C) 2010 Daycounts.com. All Rights Reserved.
# Websites: http://www.daycounts.com
# Technical Support: http://www.daycounts.com/en/contact/
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# See http://daycounts.com/fr/component/content/article/7 for details
-------------------------------------------------------------------------*/
defined('_JEXEC') or die('Restricted access');

	if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR.'/components/com_virtuemart/helpers/config.php');
	VmConfig::loadConfig();
	$myuser		=JFactory::getUser();
	$uid = (int)$myuser->id;
	if ($uid == 0) {
		return ;
	}
	
	$filterorderstates = $params->get('filterorderstates',array('P'));

	$q = "SELECT DISTINCT o.virtuemart_order_id, o.order_number,o.created_on
		FROM #__virtuemart_orders o
		WHERE o.order_status  in ('".implode("','",$filterorderstates)."')
		AND o.virtuemart_user_id='".$uid."'
		";
	$db = JFactory::getDbo();
	$db->setQuery( $q);
	$db->query();
	

$class_sfx = $params->get('class_sfx');
$pendingorders = $db->loadObjectList();
if (!$pendingorders || count($pendingorders) == 0) {
	return;
}

require(JModuleHelper::getLayoutPath('mod_vm_pendingorders'));


?>
