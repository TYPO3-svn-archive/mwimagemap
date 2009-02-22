<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

  ## Extending TypoScript from static template uid=43 to set up userdefined tag:
t3lib_extMgm::addTypoScript($_EXTKEY,'editorcfg','
	tt_content.CSS_editor.ch.tx_mwimagemap_pi1 = < plugin.tx_mwimagemap_pi1.CSS_editor
',43);

$tx_mwimagemap_extconf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['mwimagemap']);
if($tx_mwimagemap_extconf['disable_IMAGE'] == 0) {
	# extending the tslib_content.php to display the "usemap"-attribute.
$TYPO3_CONF_VARS["FE"]["XCLASS"][/*"tslib/class.tslib_cObj.php"*/"tslib/class.tslib_content.php"]=t3lib_extMgm::extPath($_EXTKEY)."class.ux_tslib_content.php";
}

t3lib_extMgm::addPItoST43($_EXTKEY,'pi1/class.tx_mwimagemap_pi1.php','_pi1','list_type',1);
?>