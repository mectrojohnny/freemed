<?php
 // $Id$
 // desc: module prototype for reports
 // lic : GPL, v2

LoadObjectDependency('FreeMED.BaseModule');

class ReportsModule extends BaseModule {

	var $CATEGORY_NAME = "Reports";
	var $CATEGORY_VERSION = "0.2";

	// vars to be passed from child modules
	var $form_vars;

	// user
	var $this_user;

	// contructor method
	function ReportsModule () {
		// call parent constructor
		$this->BaseModule();
	} // end function ReportsModule

	// override check_vars method
	function check_vars ($nullvar = "") {
		global $module;
		if (!isset($module)) 
		{
			trigger_error("Module not Defined", E_ERROR);
		}
		// FIXME!!: check access to facility
		//if (!freemed::check_access_for_patient($patient)) return false;
		return true;
	} // end function check_vars

	// function main
	// - generic main function
	function main ($nullvar = "") {
		global $display_buffer;
		global $action, $patient;

		if (!isset($this_user))
			$this->this_user = CreateObject('FreeMED.User');

		switch ($action) {

			case "display";
				$this->display();
				break;

			case "view":
			default:
				$this->view();
				// Create return links
				$display_buffer .= 
				template::link_bar(array(
				_("Reports") =>
				"reports.php",
				_("Return to Main Menu") =>
				"main.php"
				));
				break;
		} // end switch action

	} // end function main

	// ********************** MODULE SPECIFIC ACTIONS *********************

	// function display
	// by default, a wrapper for view
	function display () { $this->view(); }

	// function view
	// - view stub
	function view () { }

} // end class ReportsModule

?>
