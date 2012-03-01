<?php
class tx_mwimagemap_ufunc {
	function user_TCAform_procWizard($PA, $fobj) {
		$old = '';
		if ( preg_match('/value="([^"]+)"[^>]+selected="selected"/', $PA['item'], $m) ) { $old = $m[1]; }
		$PA['item'] = str_replace('<select name="', '<script language="JavaScript">
		var mwimage_old_sel = "'.$old.'";
		function mwimage_selchange() {
			var fName = "data[tt_content]['.$PA['uid'].'][image]";
			var tmp;
			if ( mwimage_old_sel != "" ) {
				tmp = setFormValue_getFObj(fName);
				tmp = tmp[fName+"_list"];
				var l = tmp.length;
				var a;
				for (a=0;a<l;a++) {
					if (tmp.options[a].value==mwimage_old_sel) {
						tmp.selectedIndex = a;
						break;
					}
				}
				if ( a != l ) { setFormValueManipulate(fName,"Remove"); }
			}
			tmp = document.getElementById("mwimagemapsel").options[document.getElementById("mwimagemapsel").selectedIndex].value;
			if ( tmp+"" == "0" ) {
				mwimage_old_sel = "";
				return;
			}
			tmp = tmp.split(";");
			setFormValueFromBrowseWin(fName,tmp[1],tmp[2]);
			mwimage_old_sel = tmp[1];
		}
		</script><select id="mwimagemapsel" onchange="mwimage_selchange();" name="', $PA['item']);
	}
}

if (defined("TYPO3_MODE") && $TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/mwimagemap/class.tx_mwimagemap_ufunc.php"]) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/mwimagemap/class.tx_mwimagemap_ufunc.php"]);
}
?>
