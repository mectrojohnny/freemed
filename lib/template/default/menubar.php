<?php
 // $Id$
 // $Author$

function menu_bar_cell($text, $link) {
	return "\t<tr>\n".
		"\t\t<td COLSPAN=\"2\" CLASS=\"menubar_items\" ".
		"onMouseOver=\"this.className='menubar_items_hilite'; return true;\" ".
		"onMouseOut=\"this.className='menubar_items'; return true;\" ".
		"onClick=\"window.location='".$link."'; return true;\"".
		"><a href=\"".$link."\" ".
		">".prepare($text)."</a></td>\n".
		"\t</tr>\n";
} // end function menu_bar_cell

// Check for presence of patient and pagehistories
$patient_history = patient_history_list();
$page_history = page_history_list();
if ($patient_history or $page_history) {
	print "
	<table WIDTH=\"100%\" CELLSPACING=\"0\" CELLPADDING=\"0\" VALIGN=\"TOP\"
	 ALIGN=\"CENTER\">
	";
}
if ($patient_history) {
	print "
	<tr><td ALIGN=\"RIGHT\">
	<form ACTION=\"manage.php\" METHOD=\"POST\">
	".html_form::select_widget("id", $patient_history)."
	</td><td ALIGN=\"CENTER\">
	<input TYPE=\"IMAGE\" SRC=\"lib/template/default/magnifying_glass.".
	IMAGE_TYPE."\"
		WIDTH=\"16\" HEIGHT=\"16\" ALT=\"[Manage]\"/>
	</form>
	</td></tr>
	";
} // end checking for patient history

if ($page_history) {
	// Set current page as default selection
	$location = basename($PHP_SELF);
	
	// Show the actual pick list
	print "
	<tr><td ALIGN=\"RIGHT\">
	<form ACTION=\"redirect.php\" METHOD=\"POST\">
	".html_form::select_widget("location", $page_history)."
	</td><td ALIGN=\"CENTER\">
	<input TYPE=\"IMAGE\" SRC=\"lib/template/default/forward.".
	IMAGE_TYPE."\"
		WIDTH=\"16\" HEIGHT=\"16\" ALT=\"[Jump to page]\"/>
	</form>
	</td></tr>
	";
} // end checking for page history

if ($patient_history or $page_history) {
	print "
	</table>
	";
}

?>

<div ALIGN="CENTER">
<img src="lib/template/default/img/black_pixel.png" height="1" width="250" alt=""/>
</div>

<table CLASS="menubar" WIDTH="100%" BORDER="0">
<?php
	print menu_bar_cell(_("Administration Menu"), "admin.php");
	print menu_bar_cell(_("Billing Functions"), "billing_functions.php?patient=".$SESSION["current_patient"]);
	print menu_bar_cell(_("Calendar"), "calendar.php");
	print menu_bar_cell(_("Call-In"), "call-in.php");
	print menu_bar_cell(_("Database Maintenance"), "db_maintenance.php");
	print "\t<tr>\n".
		"\t\t<td COLSPAN=\"1\" CLASS=\"menubar_items\" ".
		"onMouseOver=\"this.className='menubar_items_hilite'; return true;\" ".
		"onMouseOut=\"this.className='menubar_items'; return true;\" ".
		"onClick=\"window.location='messages.php'; return true;\"".
		"><a href=\"messages.php\" ".
		"onMouseOver=\"this.className='menubar_hilite'; return true;\" ".
		"onMouseOut=\"this.className='menubar_items'; return true;\" ".
		">".prepare(_("Messages"))."</a></td>\n".
		"\t\t<td COLSPAN=\"1\" CLASS=\"menubar_items\" ".
		"onMouseOver=\"this.className='menubar_items_hilite'; return true;\" ".
		"onMouseOut=\"this.className='menubar_items'; return true;\" ".
		"onClick=\"window.location='messages.php?action=addform'; return true;\"".
		"<a href=\"messages.php?action=addform\" ".
		"onMouseOver=\"this.className='menubar_hilite'; return true;\" ".
		"onMouseOut=\"this.className='menubar_items'; return true;\" ".
		">".prepare(_("Add"))."</a></td>\n".
		"\t</tr>\n";
	print "\t<tr>\n".
		"\t\t<td COLSPAN=\"1\" CLASS=\"menubar_items\" ".
		"onMouseOver=\"this.className='menubar_items_hilite'; return true;\" ".
		"onMouseOut=\"this.className='menubar_items'; return true;\" ".
		"onClick=\"window.location='patient.php'; return true;\"".
		"><a href=\"patient.php\">".
		prepare(_("Patients"))."</a></td>\n".
		"\t\t<td COLSPAN=\"1\" CLASS=\"menubar_items\" ".
		"onMouseOver=\"this.className='menubar_items_hilite'; return true;\" ".
		"onMouseOut=\"this.className='menubar_items'; return true;\" ".
		"onClick=\"window.location='patient.php?action=addform'; return true;\"".
		"><a href=\"patient.php?action=addform\">".
		prepare(_("New"))."</a></td>\n".
		"\t</tr>\n";
	print menu_bar_cell(_("Reports"), "reports.php");
?>
</table>

<div ALIGN="CENTER">
<img src="lib/template/default/img/black_pixel.png" height="1" width="250" alt=""/>
</div>

<table CLASS="menubar" WIDTH="100%" BORDER="0">
<?php
//----- Check for help file link
if ( ($help_url = help_url()) != "help.php" ) {
	print "\t<tr>\n".
		"\t\t<td COLSPAN=\"2\" CLASS=\"menubar_items\" ".
		"onMouseOver=\"this.className='menubar_items_hilite'; return true;\" ".
		"onMouseOut=\"this.className='menubar_items'; return true;\" ".
		"onClick=\"window.open('".$help_url."', 'Help', 'width=600,height=400,".
			"resizable=yes'); return true;\" ".
		"><a href=\"#\">".
		prepare(_("Help"))."</a></td>\n".
		"\t</tr>\n";
}

	// Create the rest of the stock menubar entries

	print menu_bar_cell(_("Preferences"), "preferences.php");
	print menu_bar_cell(_("Return to Main Menu"), "main.php");
	print menu_bar_cell(_("Logout"), "logout.php");
?>
</table>
<!-- new functions come *after* everything else -->
<?php 

//----- Check to see if a menubar array exists
if (is_array($menu_bar)) {
	print "<div ALIGN=\"CENTER\">".
		"<img src=\"lib/template/default/img/black_pixel.png\" height=\"1\" ".
		"width=\"250\" alt=\"\"/></div>\n";
	print "<table WIDTH=\"100%\" BORDER=\"0\" CLASS=\"menubar\">\n";
	foreach ($menu_bar AS $k => $v) {
		if ($v != NULL) {
		if (strpos($v, "help.php")===false) {
			print menu_bar_cell(_($k), $v);
		} else { // if there *is* a help string in there
		// Make sure that bad help links aren't displayed
		if ($v != "help.php") print "\t<LI><A HREF=\"#\" ".
			"onClick=\"window.open('".$v."', 'Help', ".
			"'width=600,height=400,resizable=yes');\" ".
			"onMouseOver=\"window.status='".prepare(_($k))."'; ".
			"return true;\" ".
			"onMouseOut=\"window.status=''; return true;\">".
			prepare(_($k))."</A>\n";
		} // end checking for help.php
		} // end checking for null
	} // end foreach
	print "</table>\n";
} else { // if is array
	print "&nbsp;\n";
} // end if is array


?>
