<?php

	// DO NOT REMOVE OR CHANGE THESE 3 LINES:
//define('TYPO3_MOD_PATH', '../typo3conf/ext/mwimagemap/mod1/');
//$BACK_PATH='../../../../typo3/';
/*if (substr_count($_SERVER['SCRIPT_FILENAME'], 'typo3conf/') > 0)
{*/
	define('TYPO3_MOD_PATH', '../typo3conf/ext/mwimagemap/mod1/');
    $BACK_PATH='../../../../typo3/';
/*} else {
	define('TYPO3_MOD_PATH', '../typo3conf/ext/mwimagemap/mod1/');
	$BACK_PATH='../../../../typo3/';
}*/
$MCONF["name"]="file_txmwimagemapM1";

	
$MCONF["access"]="user,group";
$MCONF["script"]="index.php";

$MLANG["default"]["tabs_images"]["tab"] = "moduleicon.gif";
$MLANG["default"]["ll_ref"]="LLL:EXT:mwimagemap/mod1/locallang_mod.xml";
?>