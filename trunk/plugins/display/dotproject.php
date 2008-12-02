<?php
// dotProject Exporter Display Information
//$_MAMBOTS->registerFunction( 'onViewProjectMenu', 'botDisplay_dotProjectApprove' );
class plgDisplayDotProject extends JPlugin {
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
	function pkgDisplayDotProject(& $subject) {
		parent :: __construct($subject);
	}

function onViewProjectMenu($username) {
	$pid = JArrayHelper::getValue($_REQUEST, 'pid');
	$p = JArrayHelper::getValue($_REQUEST, 'p');
	$database = JFactory::getDBO();
	$pid = $pid ? $pid : $p;
	$menu = Array();
	$database->setQuery("SELECT proj_assessment FROM projects WHERE pid = $pid");
	if($pid != '*') {
    	$assessment = $pid ? $database->loadObject() : $pid;
        $assessment = $assessment->proj_assessment;
	} else {
        $assessment = 0;
    }
	
	if($assessment == 0) {
		$menu[] = Array('text'=>"Request Assessment", 
			'link'=>"javascript:requestAssessment();",
			'image'=>"images/forward_f2.png",
			'js'=>"javascript:requestAssessment();");
	} elseif($assessment == 3) {
		$menu[] = Array('text'=>"Note: Project has been approved",
			'link'=>"javascript:alert('Project Approved');",
			'image'=>"images/apply_f2.png",
			'js'=>"alert('Project Approved')");
	}
	if(myGovAuth::isAdmin($username)) {
		if($assessment == 1 || $assessment == 2) {
			$menu[] = Array('text'=>"Approve to dotProject", 
			'link'=>"javascript:approveProject();",
			'image'=>"images/apply_f2.png",
			'js'=>"javascript:approveProject();");
			if($assessment == 2) {
				$menu[] = Array('text'=>"Unmark as Pending Review", 
				'link'=>"javascript:unmarkPending();",
				'image'=>"images/forward_f2.png",
				'js'=>"javascript:unmarkPending();");				
			} else {
				$menu[] = Array('text'=>"Mark as Pending Review", 
				'link'=>"javascript:markPending();",
				'image'=>"images/forward_f2.png",
				'js'=>"javascript:markPending();");
			}
			$menu[] = Array('text'=>"Reject Project", 
			'link'=>"javascript:rejectProject();",
			'image'=>"images/cancel_f2.png",
			'js'=>"javascript:rejectProject();");			
			$menu[] = Array('text'=>"Reschedule Project", 
			'link'=>"javascript:rescheduleProject();",
			'image'=>"images/reload_f2.png",
			'js'=>"javascript:rescheduleProject();");
		}
	}
	return $menu;
}
}