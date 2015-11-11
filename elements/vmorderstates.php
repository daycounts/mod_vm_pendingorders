<?php
/*------------------------------------------------------------------------
# plg_system_vm2finalize - Finalize order for Virtuemart 2 Plugin
# ------------------------------------------------------------------------
# author    Jeremy Magne
# copyright Copyright (C) 2010 Daycounts.com. All Rights Reserved.
# Websites: http://www.daycounts.com
# Technical Support: http://www.daycounts.com/en/contact/
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
-------------------------------------------------------------------------*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.form.fields' );
jimport( 'joomla.form.fields.list' );
JFormHelper::loadFieldClass('list');

class JFormFieldVMOrderStates extends JFormFieldList {

    /**
     * Element name
     * @access	protected
     * @var		string
     */
    var $_name = 'vmorderstates';

	protected function getOptions() {
		
		$lang = JFactory::getLanguage();
		$lang->load('com_virtuemart',JPATH_ADMINISTRATOR);
		$lang->load('com_virtuemart_orders',JPATH_SITE.'/components/com_virtuemart');		

		$db = JFactory::getDBO ();
		$sql = $db->getQuery(true)
			->select('order_status_code,order_status_name')
			->from($db->qn('#__virtuemart_orderstates'))
			->where($db->qn('virtuemart_vendor_id').'= 1')
			->where($db->qn('order_status_code').'<> \'I\'')
			->order('ordering');
		$db->setQuery($sql);
		$orderstates = $db->loadObjectList ();
		
		$options = array();
		foreach ($orderstates as $orderstate) {
			$orderstate->order_status_name= JText::_ ($orderstate->order_status_name);
			$options[] = JHTML::_('select.option', $orderstate->order_status_code, $orderstate->order_status_name);
		}
		
		return $options;

	}

}
