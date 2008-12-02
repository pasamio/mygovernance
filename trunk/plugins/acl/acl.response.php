<?php

// ACL Subsystem - Add/Del Response Checks
// Samuel Moffatt/Toowoomba Regional Council

jimport('joomla.event.plugin');

//$_MAMBOTS->registerFunction( 'onAddResponse', 'botACLCheck_ProtectedResponse' );
//$_MAMBOTS->registerFunction( 'onDelResponse', 'botACLCheck_ProtectedResponse' );

class plgACLResponse extends JPlugin {
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
	function botACLCheck(& $subject) {
		parent :: __construct($subject);
	}

	function onAddResponse($username) { 
		return plgACLCheck::ACLCheck_ProtectedResponse($username);
	}
	
	function onDelResponse($username) { 
		return plgACLCheck::ACLCheck_ProtectedResponse($username);
	}
	
	function ACLCheck_ProtectedResponse($username) {
		global $database;
		if (myGovAuth :: isAdmin($username)) {
			return true;
		} else {
			return 0;
		}
	}
}
?>
