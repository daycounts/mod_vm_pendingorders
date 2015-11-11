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

defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');
jimport('joomla.filesystem.file');

class mod_vm_pendingordersInstallerScript {

	/**
	* Called on installation
	*
	* @param   JAdapterInstance  $adapter  The object responsible for running this script
	*
	* @return  boolean  True on success
	*/
	function install($adapter) {
		if (JFile::exists(JPATH_ADMINISTRATOR.'/components/com_virtuemart/version.php' )) { 
			include_once (JPATH_ADMINISTRATOR.'/components/com_virtuemart/version.php' );
			$VMVERSION = new vmVersion();
			if (isset($VMVERSION->RELEASE)) {
				$version = $VMVERSION->RELEASE;
			} else {
				$version = vmVersion::$RELEASE;
			}

			if (version_compare($version,'2','<')) {
				//Wrong version of Virtuemart
				$msg = 'The module is designed for Virtuemart 2.x or newer';
				JFactory::getApplication()->enqueueMessage($msg, 'error');
				return false;
			}
		} else {
			//Virtuemart not found
			$msg = 'The module requires Virtuemart 2.x or newer';
			JFactory::getApplication()->enqueueMessage($msg, 'error');
			return false;
		}
	}

	/**
	* Called on uninstallation
	*
	* @param   JAdapterInstance  $adapter  The object responsible for running this script
	*/
	function uninstall($adapter) {
		//echo '<p>'. JText::_('1.6 Custom uninstall script') .'</p>';
	}

	/**
	* Called on update
	*
	* @param   JAdapterInstance  $adapter  The object responsible for running this script
	*
	* @return  boolean  True on success
	*/
	function update($adapter) {
		//echo '<p>'. JText::_('1.6 Custom update script') .'</p>';
	}

	/**
	* Called before any type of action
	*
	* @param   string  $route  Which action is happening (install|uninstall|discover_install)
	* @param   JAdapterInstance  $adapter  The object responsible for running this script
	*
	* @return  boolean  True on success
	*/
	function preflight($route, $adapter) {
		//echo '<p>'. JText::sprintf('1.6 Preflight for %s', $route) .'</p>';
	}

	/**
	* Called after any type of action
	*
	* @param   string  $route  Which action is happening (install|uninstall|discover_install)
	* @param   JAdapterInstance  $adapter  The object responsible for running this script
	*
	* @return  boolean  True on success
	*/
	function postflight($route, $adapter) {
		if ($route=='install' || $route=='update') {

			$oldfiles = array();
			$oldfiles[] = JPATH_SITE."/language/en-GB/en-GB.mod_vm_pendingorders.ini";
			$oldfiles[] = JPATH_SITE."/language/fr-FR/fr-FR.mod_vm_pendingorders.ini";
			foreach ($oldfiles as $oldfile) {
				if (JFile::exists($oldfile))
					JFile::delete($oldfile);
			}

			?>
            <div class="well clearfix">
                <h2><img src="../modules/mod_vm_pendingorders/assets/images/pending_48.png" width="48" height="48" alt="Virtuemart Pending Orders"/>&nbsp; Virtuemart Pending Orders</h2>
                <p class="lead">Module installed</p>
                <div class="row-fluid">
                    <a class="btn btn-large btn-primary pull-left span5" href="index.php?option=com_modules&filter_search=Pending%20Orders"><?php echo JText::_('MOD_VMPO_CONFIGURE'); ?></a>
                    <a href="https://www.daycounts.com/" target="new" class="pull-right span5"><img src="../modules/mod_vm_pendingorders/assets/images/daycounts.png" style="" alt="Daycounts.com"/></a>
                </div>
            </div>
            <br />
        	<?php
		}
	}
}