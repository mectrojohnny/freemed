<?php
  // $Id$
  // note: Insurance Coverage types database module
  // code: Fred Forester (fforest@netcarrier.com) -- modified a lot
  // lic : GPL, v2

LoadObjectDependency('FreeMED.MaintenanceModule');

class CovtypesMaintenance extends MaintenanceModule {

	var $MODULE_NAME = "Insurance Coverage Types";
	var $MODULE_AUTHOR = "Fred Forester (fforest@netcarrier.com)";
	var $MODULE_VERSION = "0.1";
	var $MODULE_FILE = __FILE__;

	var $PACKAGE_MINIMUM_VERSION = '0.6.0';

	var $record_name = "Coverage Types";
	var $table_name  = "covtypes";
	var $order_field = "covtpname,covtpdescrip";

	var $variables = array (
			"covtpname",
			"covtpdescrip",
			"covtpdtadd",
			"covtpdtmod"
	);

	function CovtypesMaintenance () {
		global $covtpdtmod;
		$covtpdtmod = date("Y-m-d");

		// Table definition
		$this->table_definition = array (
			'covtpname' => SQL_VARCHAR(5),
			'covtpdescrip' => SQL_VARCHAR(60),
			'covtpdtadd' => SQL_DATE,
			'covtpdtmod' => SQL_DATE,
			'id' => SQL_SERIAL
		);
		
		// Run parent constructor
		$this->MaintenanceModule();
	} // end constructor CovtypesMaintenance	

	function view () {
		global $display_buffer;
		reset ($GLOBALS);
		while (list($k, $v)=each($GLOBALS)) global $$k;

		$display_buffer .= freemed_display_itemlist (
			$sql->query("SELECT covtpname,covtpdescrip,id FROM ".$this->table_name.
				" ORDER BY ".prepare($this->order_field)),
			$this->page_name,
			array (
				_("Code") => "covtpname",
				_("Description") => "covtpdescrip"
			),
			array ("", _("NO DESCRIPTION")), "", "t_page"
		);
	} // end function module->view

	function form () {
		global $display_buffer;
		reset ($GLOBALS);
		while (list($k, $v)=each($GLOBALS)) global $$k;
  		if ($action=="modform") { 
    		$result = $sql->query("SELECT covtpname,covtpdescrip FROM $this->table_name
				WHERE ( id = '$id' )");
			$r = $sql->fetch_array($result); // dump into array r[]
			extract ($r);
		} // if loading values

		// display itemlist first
		$this->view ();

		$display_buffer .= "
			<FORM ACTION=\"$this->page_name\" METHOD=POST>
			<INPUT TYPE=HIDDEN NAME=\"covtpdtadd\"".prepare($cur_date)."\">
			<INPUT TYPE=HIDDEN NAME=\"module\" VALUE=\"".prepare($module)."\">
			<INPUT TYPE=HIDDEN NAME=\"action\" VALUE=\"".
			($action=="modform" ? "mod" : "add")."\">";
		if ($action=="modform")
			$display_buffer .= "<INPUT TYPE=HIDDEN NAME=\"id\" VALUE=\"".prepare($id)."\">";

		$display_buffer .= "
			<TABLE WIDTH=\"100%\" BORDER=0 CELLPADDING=2 CELLSPACING=2>
			<TR><TD ALIGN=RIGHT>
			 "._("Coverage Type")." :
			</TD><TD ALIGN=LEFT>
			 <INPUT TYPE=TEXT NAME=\"covtpname\" SIZE=20 MAXLENGTH=75
 			  VALUE=\"".prepare($covtpname)."\">
			</TD></TR>

			<TR><TD ALIGN=RIGHT>
			 "._("Description")." :
			</TD><TD ALIGN=LEFT>
			 <INPUT TYPE=TEXT NAME=\"covtpdescrip\" SIZE=25 MAXLENGTH=200
			  VALUE=\"".prepare($covtpdescrip)."\">
			</TD></TR>

			<TR><TD ALIGN=CENTER COLSPAN=2>
			 <INPUT TYPE=SUBMIT VALUE=\"".(
			 ($action=="modform") ? _("Modify") : _("Add"))."\">
			 <INPUT TYPE=RESET  VALUE=\""._("Remove Changes")."\">
			 </FORM>
			</TD></TR>
			</TABLE>
		";
		if ($action=="modform") $display_buffer .= "
			<P>
			<CENTER>
			<A HREF=\"$this->page_name?module=$module&action=view\"
			>"._("Abandon Modification")."</A>
			</CENTER>
			";
	} // end function CovtypesMaintenance->form

} // end of class CovtypesMaintenance

register_module ("CovtypesMaintenance");

?>
