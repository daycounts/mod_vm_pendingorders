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

jimport( 'joomla.form.fields.list' );

class JFormFieldVMPaymentMethods extends JFormFieldList {

    /**
     * Element name
     * @access	protected
     * @var		string
     */
    var $_name = 'vmpaymentmethods';

	protected function getOptions() {
		
		if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR.'/components/com_virtuemart/helpers/config.php');
		VmConfig::loadConfig();
		
		$options = array();
		if (!class_exists( 'VirtueMartModelPaymentmethod' )){
			JLoader::import( 'paymentmethod', JPATH_ADMINISTRATOR.'/components/com_virtuemart/models' );
		}
		$model = new VirtueMartModelPaymentmethod();
		$allmethods = $model->getPayments(true);
		foreach ($allmethods as $method) {
			$options[] = JHTML::_('select.option', $method->virtuemart_paymentmethod_id, $method->payment_name);
		}
		
		return $options;

	}

}
