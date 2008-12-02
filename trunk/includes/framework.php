<?php
/**
 * Framework Initialization
 * 
 * This file is used to bootstrap the J!1.5 Framework
 * 
 * PHP4/5
 *  
 * Created on Apr 10, 2007
 * 
 * @package myGovernance
 * @author Sam Moffatt <sam.moffatt@toowoombarc.qld.gov.au>
 * @author Toowoomba Regional Council Information Management Department
 * @license GNU/GPL http://www.gnu.org/licenses/gpl.html
 * @copyright 2008 Toowoomba Regional Council/Sam Moffatt 
 * @version SVN: $Id:$
 * @see Project Documentation DM Number: #???????
 * @see Gaza Documentation: http://gaza.toowoomba.qld.gov.au
 * @see Joomla!Forge Project: http://forge.joomla.org
 */

// System Loader
require('libraries/loader.php');	// J!1.5 Libraries

/*
 * Joomla! system checks
 */

@set_magic_quotes_runtime( 0 );
@ini_set('zend.ze1_compatibility_mode', '0');

/*
 * Installation check, and check on removal of the install directory.
 */
if (!file_exists( JPATH_CONFIGURATION . DS . 'configuration.php' ) || (filesize( JPATH_CONFIGURATION . DS . 'configuration.php' ) < 10) /* || file_exists( JPATH_INSTALLATION . DS . 'index.php' )*/) {
	if( file_exists( JPATH_INSTALLATION . DS . 'index.php' ) ) {
		header( 'Location: installation/index.php' );
		exit();
	} else {
		echo 'No configuration file found and no installation code available. Exiting...';
		exit();
	}
}

/*
 * Joomla! system startup
 */

// System includes
require_once( JPATH_LIBRARIES		.DS.'joomla'.DS.'import.php');

// Pre-Load configuration
require_once( JPATH_CONFIGURATION	.DS.'configuration.php' );

// System configuration
$CONFIG = new JConfig();

if (@$CONFIG->error_reporting === 0) {
	error_reporting( 0 );
} else if (@$CONFIG->error_reporting > 0) {
	error_reporting( $CONFIG->error_reporting );
	ini_set( 'display_errors', 1 );
}

define( 'JDEBUG', $CONFIG->debug );

unset( $CONFIG );

/*
 * Joomla! framework loading
 */

// Include object abstract class
jimport( 'joomla.utilities.compat.compat' );

// System profiler
if (JDEBUG) {
	jimport( 'joomla.error.profiler' );
	$_PROFILER =& JProfiler::getInstance( 'Application' );
}

// Include object abstract class
jimport( 'joomla.base.object' );
jimport( 'joomla.utilities.compat.compat' );
// Joomla! library imports
jimport( 'joomla.application.menu' );
jimport( 'joomla.user.user');
jimport( 'joomla.environment.uri' );
jimport( 'joomla.html.html' );
jimport( 'joomla.utilities.utility' );
jimport( 'joomla.event.event');
jimport( 'joomla.event.dispatcher');
jimport( 'joomla.language.language');
jimport( 'joomla.utilities.string' );
jimport( 'joomla.application.application' );
jimport( 'joomla.event.dispatcher' );
jimport( 'joomla.event.helper' );
jimport( 'joomla.application.menu' );
jimport( 'joomla.database.table' );
jimport( 'joomla.client.ldap' );
jimport( 'joomla.database.database' );
jimport( 'joomla.database.database.mysql' );
jimport( 'joomla.factory' );
jimport( 'joomla.html.parameter' );
jimport( 'joomla.utilities.error' );
jimport( 'joomla.utilities.utility' );
jimport( 'joomla.user.user' );
jimport( 'joomla.environment.uri' );
jimport( 'joomla.environment.response' );
jimport( 'joomla.environment.request' );
jimport( 'joomla.utilities.string' );
jimport( 'joomla.error.error' );
jimport( 'joomla.filter.filterinput');

// myGovernance Library Imports
jimport( 'mygovernance.html' );
jimport( 'mygovernance.error' );
jimport( 'mygovernance.common' );
jimport( 'mygovernance.auth' );
jimport( 'mygovernance.database' );

?>