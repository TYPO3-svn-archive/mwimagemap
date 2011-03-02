<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2007,2008 Michael Perlbach (typo3@metaways.de)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * Plugin 'Image Map' for the 'mwimagemap' extension.
 *
 * @author	Michael Perlbach <typo3@metaways.de>
 */

require_once(PATH_tslib.'class.tslib_pibase.php');
require_once(t3lib_extMgm::extPath('mwimagemap').'constants.php');

class tx_mwimagemap_pi1 extends tslib_pibase {
	var $prefixId = 'tx_mwimagemap_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_mwimagemap_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey = 'mwimagemap';	// The extension key.
	var $pi_checkCHash = TRUE;

	/**
	 * Returns the imagemap
	 */
	function main($content,$conf)  {
	  global $CLIENT;
	  $this->conf = $conf;
	  $this->pi_setPiVarDefaults();
	  $this->pi_loadLL();
	  $this->pi_USER_INT_obj=0;  // Configuring so caching is not expected. This value means that no cHash params are ever set. We do this, because it's a USER_INT object!
    $this->extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['mwimagemap']);
		$this->title   = $this->extConf['fe_title'];
    $this->getarea = t3lib_div::_GP('mwi_area');
		
	  $this->pi_initPIflexForm();
	  if ( ! ( $map_id = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'imagemap') ) ) { return ; }

		$db = &$GLOBALS['TYPO3_DB'];
		
		$template = $this->cObj->fileResource('EXT:'.$this->extKey.'/pi1/template.html');
		$tmpl = $this->cObj->getSubpart($template, '###OVERLAY###' );

		$markerArray['###ID###'] = $this->cObj->data['uid'];
		$markerArray['###AREAS###'] = '';

		if ( ! ( $map_res = $db->sql_query('SELECT name, file, folder, alt_file FROM tx_mwimagemap_map WHERE id = '.$map_id) ) ) { return; }
		$map = $db->sql_fetch_row($map_res);
		$ov_ext = '.png';
		if($this->extConf['fe_auto_overlay'] != '1' && $this->extConf['fe_force_overlay'] != '1') { $ov_ext = '.gif'; }
		else if($CLIENT['BROWSER'] == 'msie' && $CLIENT['VERSION'] == '6') { $ov_ext = '.gif'; }
    
		$canvas = 'canvas'.$ov_ext;	
		$picsize = getimagesize(PATH_site.$map[2].$map[1]);
    
		$markerArray['###MAP###'] = $map[2].$map[1];
		$markerArray['###MAPCANVAS###'] = 'typo3conf/ext/mwimagemap/pi1/'.$canvas;
		$markerArray['###W###'] = $picsize[0];
		$markerArray['###H###'] = $picsize[1];
		
		if(strlen($map[3]) != 0) {
		  $map[3] = str_replace('.png',$ov_ext,$map[3]);
			$map[3] = str_replace('.gif',$ov_ext,$map[3]);
		  $markerArray['###MAPCANVAS###'] = 'uploads/tx_mwimagemap/'.$map[3];
		}
    
		$markerArray['###ALT_IMG###'] = $map[0]; // alternative text for image used in imagemap
		$def_link = $def_param = '';

		if ( ! ( $area_res = $db->sql_query('SELECT id, type, link, param, description, fe_visible, fe_bordercolor, fe_borderthickness, fe_altfile FROM tx_mwimagemap_area WHERE mid = '.$map_id) ) ) {
			return;
    }
		
		$borderoptions = array();
		$markerArray['###ROIMAGES###'] = '';
		while ( $area_row = $db->sql_fetch_row( $area_res ) ) {
		  if($this->title == 1) {
			  if(!preg_match("/title\=/i", $area_row[3]) && !preg_match("/title \=/i", $area_row[3])) { $area_row[3] .= ' title="'.$area_row[4].'" '; }
			}
		
		  if(intval($area_row[5]) == 2) {
		    $area_row[8] = str_replace('.png',$ov_ext,$area_row[8]);
			  $area_row[8] = str_replace('.gif',$ov_ext,$area_row[8]);
			  if(file_exists(PATH_site.'uploads/tx_mwimagemap/'.$area_row[8])) {
				  $defimg = '';
			    $markerArray['###ROIMAGES###'] .= "\n".'<img src="uploads/tx_mwimagemap/'.$area_row[8].'" id="tx_mwimagemap_altfefile_'.$area_row[0].'" alt="" usemap="#map_'.$this->cObj->data['uid'].'" style="border:0px;visibility:hidden;display:none;" />';
					
					$romov  = 'onmouseover="Javascript:document.getElementById(\'tx_mwimagemap_img_'.$this->cObj->data['uid'].'\').src = document.getElementById(\'tx_mwimagemap_altfefile_'.$area_row[0].'\').src;';
					if(strlen($defimg) != 0) {
					  $romov  = 'onmouseover="Javascript:document.getElementById(\'tx_mwimagemap_img_'.$this->cObj->data['uid'].'\').src = document.getElementById(\'tx_mwimagemap_altfefile_'.$area_row[0].'\').src;';
					}
					$xmap    = (strlen($map[3]) != 0) ? 'uploads/tx_mwimagemap/'.$map[3] : 'typo3conf/ext/mwimagemap/pi1/'.$canvas;
					
					// If an area was preselected by a GET-parameter, show this area as default.
					if($this->getarea == $area_row[0]) {
						$markerArray['###MAPCANVAS###'] = 'uploads/tx_mwimagemap/'.$area_row[8];
						$xmap = 'uploads/tx_mwimagemap/'.$area_row[8];
					}
					$romout = 'onmouseout="Javascript:document.getElementById(\'tx_mwimagemap_img_'.$this->cObj->data['uid'].'\').src = \''.$xmap.'\';';
					
					if(preg_match("/onmouseover/i", $area_row[3])) {
					  $aparams = explode (" ",$area_row[3]);
						$i=0;
						while($i<count($aparams)) {
						  if (preg_match("/onmouseover/i", $aparams[$i])) {
                $aparams[$i] = $this->correctParams('onmouseover',$aparams[$i]);
								$aparams[$i] = $romov.$aparams[$i].'"';
								break;
							}
							$i++;
						}
						$area_row[3] = join(' ',$aparams);
					}
					else if(preg_match("/onmouseout/i", $area_row[3])) {
					  $aparams = explode (" ",$area_row[3]);
						$i=0;
						while($i<count($aparams)) {
						  if (preg_match("/onmouseout/i", $aparams[$i])) {
                $aparams[$i] = $this->correctParams('onmouseout',$aparams[$i]);
								$aparams[$i] = $romout.$aparams[$i].'"';
								break;
							}
							$i++;
						}
						$area_row[3] = join(' ',$aparams);
					}
					else { $area_row[3] = $romov.'" '.$romout.'"'; }
				}
			}
		
		  if($area_row[5] == 1 || $area_row[5] == 2) {
			  $borderoptions[] = array($area_row[0],$area_row[5],$area_row[6],$area_row[7],$area_row[8]);
			}

			if(strlen($area_row[3]) == 0 || !preg_match("/alt\=/i", $area_row[3])) { $area_row[3] .= ' alt="'.$area_row[4].'"'; } // adding default alt-attribute in case of its absence
			if ( ! ( $point_res = $db->sql_query('SELECT x, y FROM tx_mwimagemap_point WHERE aid = '.$area_row[0].' ORDER BY num') ) ) { continue; }

			$link = $this->create_link_from_browser( $area_row[2] );
			switch( $area_row[1] ) {
			  case MWIM_RECTANGLE:
				  if ( $db->sql_num_rows( $point_res ) != 2 ) { continue; }
				  $markerArray['###AREAS###'] .= '<area shape="rect" '.$area_row[3].' coords="';
				  $row = $db->sql_fetch_row($point_res);
				  $row1 = $db->sql_fetch_row($point_res);
				  $markerArray['###AREAS###'] .= $row1[0].','.$row1[1].','.($row[0]+$row1[0]).','.($row[1]+$row1[1]).'" '.$link.' />'."\n";
			  break;
				
			  case MWIM_CIRCLE:
				  if ( $db->sql_num_rows( $point_res ) != 2 ) { continue; }
				  $markerArray['###AREAS###'] .= '<area shape="circle" '.$area_row[3].' coords="';
				  $row = $db->sql_fetch_row($point_res);
				  $row1 = $db->sql_fetch_row($point_res);
				  $markerArray['###AREAS###'] .= $row1[0].','.$row1[1].','.$row[0].'" '.$link.' />'."\n";
			  break;
			
			  case MWIM_POLYGON:
			    // polygon with less than 3 points doesnt make much sense!
				  if ( $db->sql_num_rows( $point_res ) < 3 ) { continue; }
				  $markerArray['###AREAS###'] .= '<area shape="poly" '.$area_row[3].' coords="';
				  $i = 0;
				  while ( $row = $db->sql_fetch_row($point_res) ) {
					  $markerArray['###AREAS###'] .= ($i++?',':'').$row[0].','.$row[1];
				  }
				  $markerArray['###AREAS###'] .= '" '.$link.' />'."\n";
			  break;
			
			  case MWIM_DEFAULT:
				  $def_link = $area_row[2];
				  $def_param = $area_row[3];
			  break;
			
			  default:
			  break;
			}
		}

		if ( $def_link != '' ) {
			$imgsize = getimagesize(PATH_site.$map[2].$map[1]);
			$markerArray['###AREAS###'] .= '<area shape="rect" coords="0,0,'.$imgsize[0].','.$imgsize[1].'" '.$this->create_link_from_browser($def_link).' '.$def_param.' />'."\n";
		}

		// if no frontend borders and no mouseovers were defined, don't use overlay.
		if(strlen($map[3]) == 0 && strlen($markerArray['###ROIMAGES###']) == 0) {
		  $tmpl = $this->cObj->getSubpart($template, '###NON_OVERLAY###' );
		}
		
		return $this->cObj->substituteMarkerArray($tmpl, $markerArray);
	}


	function create_link_from_browser( $txt ) {
		$txt = trim($txt);
		if ( ( $pos = strpos($txt, ' ') ) !== FALSE ) {
			if ( ctype_digit($txt[$pos+1]) ) {
				$url[1] = '_blank';
				$url[2] = intval(substr($txt, $pos+1, strpos($txt, 'x', $pos)-$pos-1));
				$url[3] = intval(substr($txt, strpos($txt, 'x', $pos)+1));
				if ( $url[2] < 1 || $url[3] < 1 ) { $url[2] = $url[3] = ''; }
			}
			else {
				$linkparams = explode(' ',$txt);
				$url[1] = substr($txt, $pos + 1);
				$url[2] = '';
				$url[3] = '';
			}
			$url[0] = $this->pi_getPageLink( substr($txt, 0, $pos), '', array() );
		}
		else { $url = array($this->pi_getPageLink($txt, '', array()), '', '', ''); }

		if ( $url[2] ) {
			if (preg_match('/(http|https|ftp|mailto).*/i', $url[0]) == false && $GLOBALS['TSFE']->baseUrl != '') {
				$url[0] = $GLOBALS['TSFE']->baseUrl.$url[0];
			}
			$ret = 'href=\'Javascript:var a = new function() { window.open("'.$url[0].'", "'.$url[1].'", "width='.$url[2].',height='.$url[3].'"); }\'';
		}
		else { 
			$ret = 'href="'.$url[0].'"';
			if (trim($linkparams[1]) != '-') { $ret .= ' target="'.$linkparams[1].'"';}
			if (trim($linkparams[2]) != '-') { $ret .= ' class="'.$linkparams[2].'"';}
		}

		return $ret;
	}
	
	function correctParams($event,$pstring) {
    $pstring = str_ireplace('javascript:','',trim(rtrim($pstring)));
		$pstring = str_ireplace($event,'',$pstring);
		$pstring = str_ireplace('=','',$pstring);
    $quotepos = strpos($pstring, '"');
    $quotepos_end = strrpos($pstring, '"');
    $str_len = $quotepos_end - $quotepos;
    $badquote = substr($pstring, $quotepos, $str_len+1);
    $badquote2 = str_replace('"',"",$badquote);
    $badquote3 = str_replace(",","",$badquote2);
    $pstring      = str_replace($badquote, $badquote3, $pstring);
		return $pstring;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mwimagemap/pi1/class.tx_mwimagemap_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mwimagemap/pi1/class.tx_mwimagemap_pi1.php']);
}

?>
