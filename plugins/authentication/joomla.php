<?php
/**
* @version		$Id: joomla.php 7104 2007-04-08 16:17:14Z jinx $
* @package		Joomla
* @subpackage	JFramework
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.event.plugin');


/**
 * Joomla Authentication plugin
 *
 * @author Louis Landry <louis.landry@joomla.org>
 * @package		Joomla
 * @subpackage	JFramework
 * @since 1.5
 */
class plgAuthenticationJoomla extends JPlugin
{

	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @param object $subject The object to observe
	 * @since 1.5
	 */
	function plgAuthenticationJoomla(& $subject) {
		parent::__construct($subject);
	}

	/**
	 * This method should handle any authentication and report back to the subject
	 *
	 * @access	public
	 * @param	string	$username	Username for authentication
	 * @param	string	$password	Password for authentication
	 * @param	object	$response	Authentication response object
	 * @return	boolean
	 * @since 1.5
	 */
	function onAuthenticate( $username, $password, &$response )
	{
		jimport('joomla.user.helper');

		global $mainframe;

		// Initialize variables
		$conditions = '';

		// If we are in the admin panel, make sure we have access to it
		if($mainframe->isAdmin()) {
			$conditions = ' AND gid > 22';
		}

		// Get a database object
		$db =& JFactory::getDBO();

		$query = 'SELECT `id`'
			. ' FROM `#__users`'
			. ' WHERE username=' . $db->Quote( $username )
			. ' AND password=' . $db->Quote( JUserHelper::getCryptedPassword( $password ) )
			. $conditions;

		$db->setQuery( $query );
		$result = $db->loadResult();

		if($result)
		{
			$response->status = JAUTHENTICATE_STATUS_SUCCESS;
		}
		else
		{
			$response->status = JAUTHENTICATE_STATUS_FAILURE;
			$response->error_message = 'Invalid response from database';
		}
	}
}
?>
