<?php
require_once (PATH_t3lib."class.t3lib_page.php");
require_once (PATH_t3lib."class.t3lib_tstemplate.php");
require_once (PATH_t3lib."class.t3lib_tsparser_ext.php");

class tx_mwimagemap {
	/**
		* Manipulating the input array, $params, adding new selectorbox items.
		*/
	 
	function main(&$params) {
		global $LANG,$FILEMOUNTS, $TSBE;
		$db								 = &$GLOBALS['TYPO3_DB'];
		$params["items"][0] = Array("---------------","0");
		$map_res						= $db->sql_query('SELECT id, name, folder, file FROM tx_mwimagemap_map order by name asc');
		
	if ( $map_res ) {
		while ( $row = $db->sql_fetch_row($map_res) ) {
			foreach((array) $FILEMOUNTS as $val ) {
				/* Juergen Kussmann: corrected check of filename. */
				$filemountDir = substr($val['path'],strlen(PATH_site));
				if (!empty($filemountDir) && preg_match('/^'.preg_quote($filemountDir,'/').'/',$row[2])) {
					$params["items"][] = array($row[1],$row[0].';'.PATH_site.$row[2].$row[3].';'.$row[3]);
					break;
				}
			}
		}
	}
	}
}

if (defined("TYPO3_MODE") && $TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/mwimagemap/class.tx_mwimagemap.php"])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/mwimagemap/class.tx_mwimagemap.php"]);
}
?>
