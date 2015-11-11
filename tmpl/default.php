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
// no direct access
defined('_JEXEC') or die('Restricted access'); 

jimport('joomla.plugin.helper');

$class_sfx = $params->get('class_sfx');


if ($params->get('showimg',1)) {
	echo JHTML::_('image', JURI::base().'/modules/mod_vm_pendingorders/assets/images/pending-150.png', JText::_('MOD_VMPO_PENGING_ORDERS'), array('width' => 150, 'height' => 150));
}

echo $params->get('pretext');
echo '<ul class="'.$class_sfx.'">';
foreach ($pendingorders as $pendingorder) {
	echo '<li>'.JText::_('MOD_VMPO_ORDER_NUMBER').$pendingorder->order_number.'&nbsp;';
	echo '<a class="vm-button-correct" href="'.JRoute::_( "index.php?option=com_virtuemart&view=orders&layout=details&order_number=".$pendingorder->order_number ).'">'.JText::_('MOD_VMPO_VIEW').'</a>';
	if (JPluginHelper::isEnabled('system','vm2finalize') && $params->get('showfinalize',0)) {
		$finalizeparams = $params->get('finalizeparams','');
		if ($finalizeparams) {
			$finalizeparams = '|'.$finalizeparams;
		}
		echo '&nbsp;{finalizeorder orderid='.$pendingorder->order_number.$finalizeparams.'}';
	}
	echo '</li>';
	//echo '<li>'.JText::_('MOD_VMPO_ORDER_NUMBER').'&nbsp;<a href="'.JRoute::_( "index.php?option=com_virtuemart&view=orders&layout=details&order_number=".$pendingorder->order_number ).'">'.$pendingorder->order_number.'</a></li>';
}
echo '</ul>';
echo $params->get('posttext');

?>
