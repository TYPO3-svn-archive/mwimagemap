<?php
define('TYPO3_MODE', 'BE');

$confdir = (preg_match('/win/i',PHP_OS) && !preg_match('/darwin/i',PHP_OS)) ? 'ext\mwimagemap\mod1\conf.php' : 'ext/mwimagemap/mod1/conf.php';
$confdir = (strlen($confdir) == 0) ? 'ext/mwimagemap/mod1/conf.php' : $confdir;
$damconfdir = str_replace(array('mod1/conf.php','mod1\conf.php'),'',__FILE__);
$damconfdir .= 'dam.txt';
$dam = file_get_contents($damconfdir);

define('TYPO3_MOD_PATH', '../typo3conf/ext/mwimagemap/mod1/');
$BACK_PATH='../../../../typo3/';
 
$MCONF['navFrameScriptParam']='&folderOnly=1';

if($dam == 'true') {
	$MCONF["name"]="txdamM1_mwimagemap";
	$MCONF['navFrameScript']='tx_dam_navframe.php';
}
else {
	$MCONF["name"]="file_txmwimagemapM1";
}

$MCONF["access"]="user,group";
$MCONF["script"]="index.php";

$MLANG["default"]["tabs_images"]["tab"] = "moduleicon.gif";
$MLANG["default"]["ll_ref"]="LLL:EXT:mwimagemap/mod1/locallang_mod.xml";

?>