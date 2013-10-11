<?php
  require_once(PATH_tslib."class.tslib_content.php");

  class ux_tslib_content { }

  class ux_tslib_cObj extends tslib_cObj {

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
				  $url[1] = substr($txt, $pos + 1);
				  $url[2] = '';
				  $url[3] = '';
			  }
			  $url[0] = $this->getTypoLink_URL( substr($txt, 0, $pos), '', array() );
		  }
		  else { $url = array($this->getTypoLink_URL($txt, '', array()), '', '', ''); }

		  if ( $url[2] ) {
		    if (preg_match('/(http|https|ftp|mailto).*/i', $url[0]) == false && $GLOBALS['TSFE']->baseUrl != '') {
			    $url[0] = $GLOBALS['TSFE']->baseUrl.$url[0];
		    }
			  $ret = 'href=\'Javascript:var a = new function() { window.open("'.$url[0].'", "'.$url[1].'", "width='.$url[2].',height='.$url[3].'"); }\'';
		  }
		  else { $ret = 'href="'.$url[0].'"'.($url[1]?' target="'.$url[1].'"':''); }
		  return $ret;
	  }

	  function cImage($file, $conf) {
		  $info = $this->getImgResource($file, $conf['file.']);
	
		  $GLOBALS['TSFE']->lastImageInfo=$info;
		  if (is_array($info)) {
			  $info[3] = t3lib_div::png_to_gif_by_imagemagick($info[3]);
			  $GLOBALS['TSFE']->imagesOnPage[]=$info[3];		// This array is used to collect the image-refs on the page...
			
			  // create the "usemap"-attribute.
			  $usemap	 = '';
			  $imagemap = '';
			  $db	= &$GLOBALS['TYPO3_DB'];
		    if ( strpos($this->data['tx_mwimagemap'], ';') !== FALSE ) {
		      $mwim_id = explode(';', $this->data['tx_mwimagemap']);
		      $mwim_id = intval($mwim_id[0]);
			    $res = $db->sql_query('SELECT id, name FROM tx_mwimagemap_map where id='.$mwim_id);
		      $def_link = $def_param = '';
		      if ( $res && ( $row = $db->sql_fetch_row($res) ) ) {
		        $usemap	= ' usemap="#map_'.$this->data['uid'].'"';
		        $imagemap = '<map name="map_'.$this->data['uid'].'" id="map_'.$this->data['uid'].'">';
				  
					  $area_res = $db->sql_query('SELECT id, type, link, param, description FROM tx_mwimagemap_area WHERE mid = \''.$row[0].'\'');
				    while ( $area_row = $db->sql_fetch_row( $area_res ) ) {
					    if(strlen($area_row[3]) == 0 || !preg_match("/alt\=/i", $area_row[3])) { $area_row[3] .= ' alt="'.$area_row[4].'"'; } // adding default alt-attribute in case of its absence
					    if ( ! ( $point_res = $db->sql_query('SELECT x, y FROM tx_mwimagemap_point WHERE aid = '.$area_row[0].' ORDER BY num') ) ) {
						    continue;
					    }
						  $link = $this->create_link_from_browser( $area_row[2] );
						
						  switch( $area_row[1] ) {
							  case MWIM_RECTANGLE:
								  if ( $db->sql_num_rows( $point_res ) != 2 ) { continue; }
								  $imagemap .= '<area shape="rect" '.$area_row[3].' coords="';
								  $xrow = $db->sql_fetch_row($point_res);
								  $xrow1 = $db->sql_fetch_row($point_res);
								  $imagemap .= $xrow1[0].','.$xrow1[1].','.($xrow[0]+$xrow1[0]).','.($xrow[1]+$xrow1[1]).'" '.$link.' />'."\n";
							  break;
							
							  case MWIM_CIRCLE:
								  if ( $db->sql_num_rows( $point_res ) != 2 ) { continue; }
								  $imagemap .= '<area shape="circle" '.$area_row[3].' coords="';
								  $xrow	= $db->sql_fetch_row($point_res);
								  $xrow1 = $db->sql_fetch_row($point_res);
								  $imagemap .= $xrow1[0].','.$xrow1[1].','.$xrow[0].'" '.$link.' />'."\n";
							  break;
							
							  case MWIM_POLYGON:
							    // polygon with less than 3 points doesnt make much sense! 
							    if ( $db->sql_num_rows( $point_res ) < 3 ) { continue; }
								  $imagemap .= '<area shape="poly" '.$area_row[3].' coords="';
								  $i = 0;
								  while ( $xrow = $db->sql_fetch_row($point_res) ) { $imagemap .= ($i++?',':'').$xrow[0].','.$xrow[1]; }
							    $imagemap .= '" '.$link.' />'."\n";
							  break;
				      
							  case MWIM_DEFAULT:
					        $def_link = $area_row[2];
					        $def_param = $area_row[3];
							
							  default:
						    break;
					    }
				    }
			      if ( $def_link != '' ) {
				      $imagemap .= '<area shape="rect" coords="0,0,'.$info[0].','.$info[1].'" '.$this->create_link_from_browser($def_link).' '.$def_param.' />'."\n";
			      }
				    if(strlen($imagemap) != 0) { $imagemap .= "</map>"; }
		      }
		    }

			  if (!strlen($conf['altText']) && !is_array($conf['altText.']))	{	// Backwards compatible:
				  $conf['altText'] = $conf['alttext'];
				  $conf['altText.'] = $conf['alttext.'];
			  }
			  $altParam = $this->getAltParam($conf);
			  $theValue = '<img src="'.htmlspecialchars($GLOBALS['TSFE']->absRefPrefix.t3lib_div::rawUrlEncodeFP($info[3])).'" width="'.$info[0].'" height="'.$info[1].'"'.$this->getBorderAttr(' border="'.intval($conf['border']).'"').($conf['params']?' '.$conf['params']:'').($altParam).$usemap.' />'.$imagemap;
			  if ($conf['linkWrap']) { $theValue = $this->linkWrap($theValue, $conf['linkWrap']); }
			  elseif ($conf['imageLinkWrap']) { $theValue = $this->imageLinkWrap($theValue, $info['origFile'], $conf['imageLinkWrap.']); }
			  return $this->wrap($theValue, $conf['wrap']);
		  }
	  }
  }
?>