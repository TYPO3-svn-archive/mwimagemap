<?php
/***************************************************************
*	Copyright notice
*
*	(c) 2007,2013 Michael Perlbach (info@mikelmade.de)
*	All rights reserved
*
*	This script is part of the TYPO3 project. The TYPO3 project is
*	free software; you can redistribute it and/or modify
*	it under the terms of the GNU General Public License as published by
*	the Free Software Foundation; either version 2 of the License, or
*	(at your option) any later version.
*
*	The GNU General Public License can be found at
*	http://www.gnu.org/copyleft/gpl.html.
*
*	This script is distributed in the hope that it will be useful,
*	but WITHOUT ANY WARRANTY; without even the implied warranty of
*	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.	See the
*	GNU General Public License for more details.
*
*	This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * Plugin 'Image Map' for the 'mwimagemap' extension.
 *
 * @author	Michael Perlbach <info@mikelmade.de>
 */

require_once(PATH_tslib.'class.tslib_pibase.php');
require_once(t3lib_extMgm::extPath('mwimagemap').'constants.php');

class tx_mwimagemap_pi1 extends tslib_pibase {
	var $prefixId = 'tx_mwimagemap_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_mwimagemap_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey = 'mwimagemap';	// The extension key.
	var $pi_checkCHash = TRUE;
	protected $contentboxes = '';
	var $add_cbox_css = '';

	/**
	 * Returns the imagemap
	 */
	function main($content,$conf)	{
		global $CLIENT;
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		$this->pi_USER_INT_obj=0;
		$this->extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['mwimagemap']);
		$this->title	 = $this->extConf['fe_title'];
		$this->getarea = t3lib_div::_GP('mwi_area');
		
		$this->pi_initPIflexForm();
		if ( ! ( $this->map_id = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'imagemap') ) ) { return ; }

		$db = &$GLOBALS['TYPO3_DB'];
		
		$this->add_cbox_css = $this->conf['contentbox_additionalcss'];
		
		$this->template = $this->cObj->fileResource($this->conf['template']);
		$this->javascript = $this->conf['javascript'];
		
		if(!isset($GLOBALS['TSFE']->additionalHeaderData['mwimagemap'])) {
			$GLOBALS['TSFE']->additionalHeaderData['mwimagemap'] = '<script type="text/javascript" src="'.$this->javascript.'"></script>';
		}
		
		$this->overlay = $this->cObj->getSubpart($this->template, '###OVERLAY###' );
		$this->areasubpart = $this->cObj->getSubpart($this->template, '###AREA###' );
		$this->cboxsubpart = $this->cObj->getSubpart($this->template, '###CBOX###' );
		$this->markerArray['###ID###'] = $this->cObj->data['uid'];
		$this->areas = '';

		if ( ! ( $this->map_res = $db->sql_query('SELECT name, file, folder, alt_file FROM tx_mwimagemap_map WHERE id = '.$this->map_id) ) ) { return; }
		$this->map = $db->sql_fetch_row($this->map_res);
		$this->ov_ext = '.png';
		if($this->extConf['fe_auto_overlay'] != '1' && $this->extConf['fe_force_overlay'] != '1') { $this->ov_ext = '.gif'; }
		else if($CLIENT['BROWSER'] == 'msie' && $CLIENT['VERSION'] == '6') { $this->ov_ext = '.gif'; }
		
		$this->canvas = 'canvas'.$this->ov_ext;
		$picsize = getimagesize(PATH_site.$this->map[2].$this->map[1]);
		
		$this->markerArray['###MAP###'] = $this->map[2].$this->map[1];
		$this->markerArray['###MAPCANVAS###'] = 'typo3conf/ext/mwimagemap/pi1/'.$this->canvas;
		$this->markerArray['###IMAGE_WIDTH###'] = $picsize[0];
		$this->markerArray['###IMAGE_HEIGHT###'] = $picsize[1];
		
		if(strlen($this->map[3]) != 0) {
			$this->map[3] = str_replace('.png',$this->ov_ext,$this->map[3]);
			$this->map[3] = str_replace('.gif',$this->ov_ext,$this->map[3]);
			$this->markerArray['###MAPCANVAS###'] = 'uploads/tx_mwimagemap/'.$this->map[3];
		}
		
		$this->markerArray['###MAP_TITLE###'] = $this->map[0]; // alternative text for image used in imagemap
		$this->def_link = $this->def_param = '';

		if ( ! ( $this->area_res = $db->sql_query('SELECT id, type, link, param, description, fe_visible, fe_bordercolor, fe_borderthickness, fe_altfile FROM tx_mwimagemap_area WHERE mid = '.$this->map_id) ) ) {
			return;
	 }

		$this->cbox = false;
		$this->borderoptions = array();
		$this->markerArray['###ROIMAGES###'] = '';
		while ( $this->area_row = $db->sql_fetch_row( $this->area_res ) ) {
			if ( ! ( $this->content_res = $db->sql_query('SELECT content_id,popup_width,popup_height,popup_x,popup_y,popup_bordercolor,popup_borderwidth,popup_backgroundcolor FROM tx_mwimagemap_contentpopup WHERE aid = '.$this->area_row[0].' and active=1') ) ) {
				return;
			}
			else {
				while ( $this->content_row = $db->sql_fetch_row( $this->content_res ) ) {
					$this->cbox = true;
					$this->contentboxes .= $this->generateContentBox();
				}
			}
		
			if($this->title == 1) {
				if(!preg_match("/title\=/i", $this->area_row[3]) && !preg_match("/title \=/i", $this->area_row[3])) { $this->area_row[3] .= ' title="'.$this->area_row[4].'" '; }
			}
		
			if(intval($this->area_row[5]) == 2) {
				$this->area_row[8] = str_replace('.png',$this->ov_ext,$this->area_row[8]);
				$this->area_row[8] = str_replace('.gif',$this->ov_ext,$this->area_row[8]);
				if(file_exists(PATH_site.'uploads/tx_mwimagemap/'.$this->area_row[8])) {
					$this->defimg = '';
					$this->markerArray['###ROIMAGES###'] .= "\n".'<img src="uploads/tx_mwimagemap/'.$this->area_row[8].'" id="tx_mwimagemap_altfefile_'.$this->area_row[0].'" alt="" usemap="#map_'.$this->cObj->data['uid'].'" style="border:0px;visibility:hidden;display:none;" />';
					
					$this->romov	= 'Javascript:mwimagemap_changearea(\'tx_mwimagemap_img_'.$this->cObj->data['uid'].'\',\'tx_mwimagemap_altfefile_'.$this->area_row[0].'\'); ';
					if(strlen($this->defimg) != 0) {
						$this->romov	= 'Javascript::mwimagemap_changearea(\'tx_mwimagemap_img_'.$this->cObj->data['uid'].'\',\'tx_mwimagemap_altfefile_'.$this->area_row[0].'\'); ';
					}
					
					if(strlen($this->romov) > 0) { $this->romov = 'onmouseover="'.$this->romov; }
					$this->xmap = (strlen($this->map[3]) != 0) ? 'uploads/tx_mwimagemap/'.$this->map[3] : 'typo3conf/ext/mwimagemap/pi1/'.$this->canvas;
					
					// If an area was preselected by a GET-parameter, show this area as default.
					if($this->getarea == $this->area_row[0]) {
						$this->markerArray['###MAPCANVAS###'] = 'uploads/tx_mwimagemap/'.$this->area_row[8];
						$this->xmap = 'uploads/tx_mwimagemap/'.$this->area_row[8];
					}
					$this->romout = 'onmouseout="Javascript:mwimagemap_resetarea(\'tx_mwimagemap_img_'.$this->cObj->data['uid'].'\',\''.$this->xmap.'\'); ';
					
					if(preg_match("/onmouseover/i", $this->area_row[3])) {
						$this->aparams = explode (" ",$this->area_row[3]);
						$i=0;
						while($i<count($this->aparams)) {
							if (preg_match("/onmouseover/i", $this->aparams[$i])) {
								$this->aparams[$i] = $this->correctParams('onmouseover',$this->aparams[$i]);
								$this->aparams[$i] = $this->romov.$this->aparams[$i].'"';
								break;
							}
							$i++;
						}
						$this->area_row[3] = join(' ',$this->aparams);
					}
					else if(preg_match("/onmouseout/i", $this->area_row[3])) {
						$this->aparams = explode (" ",$this->area_row[3]);
						$i=0;
						while($i<count($this->aparams)) {
							if (preg_match("/onmouseout/i", $this->aparams[$i])) {
								$this->aparams[$i] = $this->correctParams('onmouseout',$this->aparams[$i]);
								$this->aparams[$i] = $this->romout.$this->aparams[$i].'"';
								break;
							}
							$i++;
						}
						$this->area_row[3] = join(' ',$this->aparams);
					}
					else { $this->area_row[3] = $this->romov.'" '.$this->romout.'"'; }
				}
			}
		
			if($this->area_row[5] == 1 || $this->area_row[5] == 2) {
				$this->borderoptions[] = array($this->area_row[0],$this->area_row[5],$this->area_row[6],$this->area_row[7],$this->area_row[8]);
			}

			if(strlen($this->area_row[3]) == 0 || !preg_match("/alt\=/i", $this->area_row[3])) { $this->area_row[3] .= ' alt="'.$this->area_row[4].'"'; } // adding default alt-attribute in case of its absence
			if ( ! ( $this->point_res = $db->sql_query('SELECT x, y FROM tx_mwimagemap_point WHERE aid = '.$this->area_row[0].' ORDER BY num') ) ) { continue; }

			if($this->cbox == true) {
				if(preg_match("/onmouseover/i", $this->area_row[3])) {
					$this->aparams = explode (" ",$this->area_row[3]);
					$i=0;
					while($i<count($this->aparams)) {
						if (preg_match("/onmouseover/i", $this->aparams[$i])) {
							$this->romov = 'onmouseover="';
							$this->aparams[$i] = $this->correctParams('onmouseover',$this->aparams[$i]);
							$this->romov = str_replace('onmouseover="','onmouseover="Javascript:mwimagemap_showCBox(\'txmwimagemap_cbox_'.$this->cObj->data['uid'].'_'.$this->area_row[0].'\'); ',$this->romov);
							$this->aparams[$i] = $this->romov.$this->aparams[$i];
							break;
						}
						$i++;
					}
					$this->area_row[3] = join(' ',$this->aparams);
					$this->area_row[3] .= '"';
				}
				else { $this->area_row[3] .= ' onmouseover="Javascript:mwimagemap_showCBox(\'txmwimagemap_cbox_'.$this->cObj->data['uid'].'_'.$this->area_row[0].'\');"'; }
				if(preg_match("/onmouseout/i", $this->area_row[3])) {
					$this->aparams = explode (" ",$this->area_row[3]);
					$i=0;
					$this->romout = '';
					while($i<count($this->aparams)) {
						if (preg_match("/onmouseout/i", $this->aparams[$i])) {
							$this->romout = 'onmouseout="';
							$this->aparams[$i] = $this->correctParams('onmouseout',$this->aparams[$i]);
							$this->romout = str_replace('onmouseout="','onmouseout="Javascript:mwimagemap_hideCBox(\'txmwimagemap_cbox_'.$this->cObj->data['uid'].'_'.$this->area_row[0].'\'); ',$this->romout);
							$this->aparams[$i] = $this->romout.$this->aparams[$i];
							break;
						}
						$i++;
					}
					$this->area_row[3] = join(' ',$this->aparams);
					$this->area_row[3] .= '"';
				}
				else { $this->area_row[3] .= ' onmouseout="Javascript:mwimagemap_hideCBox(\'txmwimagemap_cbox_'.$this->cObj->data['uid'].'_'.$this->area_row[0].'\');"'; }
			}
			$this->area_row[3] = str_replace(';Javascript:',';',$this->area_row[3]);
			$this->area_row[3] = str_replace('"""','"',$this->area_row[3]);
			
			$this->link = $this->create_link_from_browser( $this->area_row[2] );
			switch( $this->area_row[1] ) {
				case MWIM_RECTANGLE:
					if ( $db->sql_num_rows( $this->point_res ) != 2 ) { continue; }
					$this->row = $db->sql_fetch_row($this->point_res);
					$this->row1 = $db->sql_fetch_row($this->point_res);
					$this->areas .= $this->generateArea('rect',$this->row1[0].','.$this->row1[1].','.($this->row[0]+$this->row1[0]).','.($this->row[1]+$this->row1[1]));
				break;
				
				case MWIM_CIRCLE:
					if ( $db->sql_num_rows( $this->point_res ) != 2 ) { continue; }
					$this->row = $db->sql_fetch_row($this->point_res);
					$this->row1 = $db->sql_fetch_row($this->point_res);
					$this->areas .= $this->generateArea('circle',$this->row1[0].','.$this->row1[1].','.$this->row[0]);
				break;
			
				case MWIM_POLYGON:
					if ( $db->sql_num_rows( $this->point_res ) < 3 ) { continue; } // polygon with less than 3 points doesn't make much sense!
					$i = 0;
					$this->coords = '';
					while ( $this->row = $db->sql_fetch_row($this->point_res) ) { $this->coords .= ($i++?',':'').$this->row[0].','.$this->row[1]; }
					$this->areas .= $this->generateArea('poly',$this->coords);
				break;
			
				case MWIM_DEFAULT:
					$this->areas .= $this->generateArea('def','0,0,'.$this->imgsize[0].','.$this->imgsize[1]);
				break;
			
				default:
				break;
			}
		}

		// if no frontend borders and no mouseovers were set, don't use overlay.
		if(strlen($this->map[3]) == 0 && strlen($this->markerArray['###ROIMAGES###']) == 0) {
			$this->overlay = $this->cObj->getSubpart($this->template, '###NON_OVERLAY###' );
		}
		
		$this->markerArray['###AREAS###'] = $this->areas; 
		$this->markerArray['###CBOXES###'] = $this->contentboxes;
		
		if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['mwimagemap']['hook'])) {
			foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['mwimagemap']['hook'] as $_classRef) {
				$_procObj = &t3lib_div::getUserObj($_classRef);
				$_procObj->additionalMarkerProcessor($this);
			}
		}

		$this->content = $this->cObj->substituteMarkerArray($this->overlay, $this->markerArray);
		return $this->content;
	}

	/**
	* Generates a link.
	*
	* @param	string		a string containing the link data.
	* @return string
	*/
	function create_link_from_browser( $txt ) {
		$txt = trim($txt);
		if($txt == '#') { return $txt; }
		if ( ( $pos = strpos($txt, ' ') ) !== FALSE ) {
			if ( ctype_digit($txt[$pos+1]) ) {
				$url[1] = '_blank';
				$url[2] = intval(substr($txt, $pos+1, strpos($txt, 'x', $pos)-$pos-1));
				$url[3] = intval(substr($txt, strpos($txt, 'x', $pos)+1));
				if ( $url[2] < 1 || $url[3] < 1 ) { $url[2] = $url[3] = ''; }
			}
			else {
				$this->linkparams = explode(' ',$txt);
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
			if (trim($this->linkparams[1]) != '-') { $ret .= ' target="'.$this->linkparams[1].'"';}
			if (trim($this->linkparams[2]) != '-') { $ret .= ' class="'.$this->linkparams[2].'"';}
		}
		return $ret;
	}
	
	/**
	* Corrects the additional parameters for a given area - removes expressions not needed and excess quotes.
	*
	* @param	string		an event (e.g. "onclick").
	* @param	string		a string containing the parameters.
	* @return string
	*/
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
		$pstring			= str_replace($badquote, $badquote3, $pstring);
		return $pstring;
	}

	/**
	* Creates an area
	*
	*	@param	string		area shape.
	*	@param	string		coordinates.	
	* @return string
	*/
	protected function generateArea ($shape='def',$coords) {
		$mA['###SHAPE###'] = $shape;
		$mA['###ADDPARAMS###'] = $this->area_row[3];
		$mA['###COORDS###'] = $coords;
		$linkparts = explode(' ',$this->link);
		$mA['###LINK###'] = '';
		$mA['###TARGET###'] = '';
	
		foreach($linkparts as $linkpart) {
			if(preg_match('/href\=/',$linkpart)) { $mA['###LINK###'] = str_replace(array('href=','"'),'',$linkpart); }
			else if(preg_match('/target\=/',$linkpart)) { $mA['###TARGET###'] = str_replace(array('target=','"'),'',$linkpart); }
		}
		$area = str_replace('target=""','',$this->cObj->substituteMarkerArray($this->areasubpart, $mA));
		return $area;
	}
	
	/**
	* Creates a contentbox
	*
	* @return string
	*/
	protected function generateContentBox () {
		$mA['###CBOX_ID###'] = $this->cObj->data['uid'].'_'.$this->area_row[0];
		$mA['###CSS_BACKGROUND###'] = (!empty($this->content_row[7])) ? 'background-color:'.$this->content_row[7].';' : '';
		$mA['###CSS_WIDTH###'] = (!empty($this->content_row[1])) ? 'width:'.$this->content_row[1].'px;' : '';
		$mA['###CSS_HEIGHT###'] = (!empty($this->content_row[2])) ? 'height:'.$this->content_row[2].'px;' : '';
		$mA['###CSS_LEFT###'] = (!empty($this->content_row[3])) ? 'left:'.$this->content_row[3].'px;' : 'left:0px;';
		$mA['###CSS_TOP###'] = (!empty($this->content_row[4])) ? 'top:'.$this->content_row[4].'px;' : 'top:0px;';
		$mA['###CSS_BORDER###'] = (!empty($this->content_row[6]) && !empty($this->content_row[5])) ? 'border:'.$this->content_row[6].'px solid '.$this->content_row[5].';' : '';
		$mA['###CSS_ADDITIONAL###'] = $this->add_cbox_css;
		$tt_content_conf = array('tables' => 'tt_content','source' => $this->content_row[0],'dontCheckPid' => 1);
		$mA['###CONTENT###'] = $this->cObj->RECORDS($tt_content_conf);
		return $this->cObj->substituteMarkerArray($this->cboxsubpart, $mA);
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mwimagemap/pi1/class.tx_mwimagemap_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mwimagemap/pi1/class.tx_mwimagemap_pi1.php']);
}

?>
