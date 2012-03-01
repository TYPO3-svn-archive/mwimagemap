<?php
if(!TYPO3_MODE) { die("This script cannot be called directly."); }

function mwimagemap_getitems() {
	if (TYPO3_MODE == 'BE') {
	  require_once (PATH_t3lib.'class.t3lib_userauth.php');
	  require_once (PATH_t3lib.'class.t3lib_userauthgroup.php');
	  require_once (PATH_t3lib.'class.t3lib_beuserauth.php');
		require_once (PATH_t3lib.'class.t3lib_tsfebeuserauth.php');
		$BE_USER = t3lib_div::makeInstance('t3lib_tsfeBeUserAuth');
		$BE_USER->start();
		$BE_USER->unpack_uc('');
		if ($BE_USER->user['uid']) { $BE_USER->fetchGroupData(); }
		$filemounts = $BE_USER->groupData['filemounts'];
		
		$i = 0;
		$opt = '';
		if ( ! ($res = $GLOBALS['TYPO3_DB']->sql_query("SELECT id, name, folder FROM tx_mwimagemap_map order by name asc")) ) { return; }
		while ( $row = $GLOBALS['TYPO3_DB']->sql_fetch_row( $res ) ) {
			$show = false;
			if($BE_USER->user['admin'] == 1) { $show = true; }
			foreach( $filemounts as $val) {
				$filemountDir = substr($val['path'],strlen(PATH_site));
				if (!empty($filemountDir) && preg_match('/^'.preg_quote($filemountDir,'/').'/',$row[2]) || $BE_USER->user['admin'] == 1) {
					$show = true;
					break;
				}
			}
			if ( $show ) {
				$opt .= '<numIndex index="'.$i++.'" type="array">'."\n";
				$opt .= '<numIndex index="0"><![CDATA[ '.$row[1].' ]]></numIndex>'."\n";
				$opt .= '<numIndex index="1">'.$row[0].'</numIndex>'."\n";
				$opt .= '</numIndex>'."\n";
			}
		}
		unset($BE_USER);
		return $opt;
	}
}
?>
