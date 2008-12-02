<?php
/**
 * myGovernance
 * 
 * myGovernance: Project Evaluation System
 * Original Concept: Mike Strode-Smith
 * Production: Samuel Moffatt
 * All code property of Toowoomba Regional Council and its respective authors
 * PHP4
 * 
 * @package myGovernance
 * @author Sam Moffatt <sam.moffatt@toowoombarc.qld.gov.au>
 * @author Toowoomba Regional Council Information Management Department
 * @license GNU/GPL http://www.gnu.org/licenses/gpl.html
 * @copyright 2008 Toowoomba Regional Council/Sam Moffatt 
 * @version SVN: $Id: index.php 460 2008-04-15 00:41:14Z s.moffatt@toowoomba.qld.gov.au $
 * @see JoomlaCode Project: http://joomlacode.org/gf/project/jauthtools/
 */

// Set flag that this is a parent file
// Mambo compat layer
define('_VALID_MOS', 1);
// Joomla compat layer
define('_JEXEC', 1);
define('JPATH_BASE', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);

// Used to remove output for graphs
ob_start();
// New application host method using J!1.5 Libraries
require ('includes/defines.php');
require ('includes/framework.php');
require ('includes/application.php');

// New Application Handling
$mainframe =& JFactory::getApplication('mygovernance',Array('clientId'=>'mygovernance'));
//$mainframe->loadConfiguration('config.php');
//$mainframe->loadSession(JUtility :: getHash($mainframe->getClientId()));
$mainframe->initialise();

// Error handling system
$error = new myGovError();
// Database Layer
$database = JFactory :: getDBO();

// Do the plugin loader
JPluginHelper :: importPlugin('acl');
JPluginHelper :: importPlugin('authentication');
JPluginHelper :: importPlugin('display');
JPluginHelper :: importPlugin('export');
JPluginHelper :: importPlugin('system');

// Authorization checks - first pass
$admin = 0;
//session_start('governance');
// Give the SSO a chance to run...
$result = $mainframe->triggerEvent('onStartup');

$mainframe->triggerEvent('onAfterInitialise');

// authorization
$Itemid = JRequest::getInt( 'Itemid');
$mainframe->authorize($Itemid);

/*
// Main code
if ($auth) JRequest::setVar('option',JSiteHelper::findOption()); else JRequest::setVar('option', 'com_login');


$mainframe->dispatch();
$mainframe->render();
echo JResponse::toString();
JSession::close();
*/

$mainframe->route();

// trigger the onAfterRoute events
JDEBUG ? $_PROFILER->mark('afterRoute') : null;
$mainframe->triggerEvent('onAfterRoute');

/**
 * DISPATCH THE APPLICATION
 *
 * NOTE :
 */
$option = JRequest::getCmd('option');
$mainframe->dispatch($option);

// trigger the onAfterDispatch events
JDEBUG ? $_PROFILER->mark('afterDispatch') : null;
$mainframe->triggerEvent('onAfterDispatch');

/**
 * RENDER  THE APPLICATION
 *
 * NOTE :
 */
$mainframe->render();

// trigger the onAfterRender events
JDEBUG ? $_PROFILER->mark('afterRender') : null;
$mainframe->triggerEvent('onAfterRender');

/**
 * RETURN THE RESPONSE
 */
echo JResponse::toString($mainframe->getCfg('gzip'));
