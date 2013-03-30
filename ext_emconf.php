<?php

########################################################################
# Extension Manager/Repository config file for ext "mwimagemap".
#
# Auto generated 30-03-2013 15:55
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'MW Imagemap',
	'description' => 'create image maps',
	'category' => 'module',
	'shy' => 0,
	'version' => '1.2.14',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => 'mod1',
	'state' => 'stable',
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => 'tt_content',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Michael Perlbach',
	'author_email' => 'info@mikelmade.de',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'typo3' => '4.5.0-6.0.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:144:{s:13:"Changelog.txt";s:4:"55c6";s:19:"PostInstallHook.php";s:4:"d1dc";s:10:"README.txt";s:4:"9fa9";s:23:"class.tx_mwimagemap.php";s:4:"6624";s:29:"class.tx_mwimagemap_ufunc.php";s:4:"552b";s:26:"class.ux_tslib_content.php";s:4:"81a3";s:14:"config_inc.php";s:4:"51bb";s:13:"constants.php";s:4:"3bb6";s:7:"dam.txt";s:4:"b326";s:21:"ext_conf_template.txt";s:4:"5da5";s:12:"ext_icon.gif";s:4:"2c77";s:17:"ext_localconf.php";s:4:"7213";s:14:"ext_tables.php";s:4:"ef4d";s:14:"ext_tables.sql";s:4:"234d";s:13:"locallang.xml";s:4:"b98f";s:16:"locallang_db.xml";s:4:"64a1";s:14:"doc/manual.sxw";s:4:"248c";s:19:"doc/wizard_form.dat";s:4:"b0f6";s:20:"doc/wizard_form.html";s:4:"9c1a";s:10:"mod1/cg.js";s:4:"372a";s:14:"mod1/clear.gif";s:4:"cc11";s:13:"mod1/conf.php";s:4:"677f";s:14:"mod1/index.php";s:4:"4aea";s:22:"mod1/locallang_mod.xml";s:4:"4528";s:19:"mod1/moduleicon.gif";s:4:"9eee";s:24:"mod1/tx_dam_navframe.php";s:4:"71df";s:33:"mod1/colpicker/color_functions.js";s:4:"d7ae";s:37:"mod1/colpicker/js_color_picker_v2.css";s:4:"5523";s:36:"mod1/colpicker/js_color_picker_v2.js";s:4:"714d";s:35:"mod1/colpicker/img/select_arrow.gif";s:4:"e3b6";s:40:"mod1/colpicker/img/select_arrow_down.gif";s:4:"ce4d";s:40:"mod1/colpicker/img/select_arrow_over.gif";s:4:"2b9f";s:36:"mod1/colpicker/img/slider_handle.gif";s:4:"fee1";s:40:"mod1/colpicker/img/tab_center_active.gif";s:4:"aacf";s:38:"mod1/colpicker/img/tab_left_active.gif";s:4:"aef1";s:40:"mod1/colpicker/img/tab_left_inactive.gif";s:4:"77f3";s:39:"mod1/colpicker/img/tab_right_active.gif";s:4:"0b16";s:41:"mod1/colpicker/img/tab_right_inactive.gif";s:4:"653c";s:22:"mod1/css/mainstyle.css";s:4:"705c";s:16:"mod1/img/0_1.gif";s:4:"0589";s:16:"mod1/img/0_2.gif";s:4:"0589";s:16:"mod1/img/1_1.gif";s:4:"267e";s:16:"mod1/img/1_2.gif";s:4:"80c4";s:16:"mod1/img/2_1.gif";s:4:"95ef";s:16:"mod1/img/2_2.gif";s:4:"a989";s:16:"mod1/img/3_1.gif";s:4:"effc";s:16:"mod1/img/3_2.gif";s:4:"effc";s:14:"mod1/img/d.gif";s:4:"7813";s:20:"mod1/img/garbage.gif";s:4:"7b41";s:18:"mod1/img/minus.gif";s:4:"0f13";s:19:"mod1/img/pencil.gif";s:4:"e76c";s:17:"mod1/img/plus.gif";s:4:"b919";s:20:"mod1/img/savedok.gif";s:4:"933e";s:14:"mod1/img/u.gif";s:4:"6076";s:23:"mod1/js/draw_objects.js";s:4:"826e";s:20:"mod1/js/functions.js";s:4:"fb8f";s:15:"mod1/js/poly.js";s:4:"337d";s:24:"mod1/js/wz_jsgraphics.js";s:4:"b236";s:28:"mod1/js/wz_jsgraphics_new.js";s:4:"8a66";s:33:"mod1/templates/template_area.html";s:4:"0b6c";s:32:"mod1/templates/template_map.html";s:4:"e7ec";s:14:"pi1/canvas.gif";s:4:"8647";s:14:"pi1/canvas.png";s:4:"2a20";s:14:"pi1/ce_wiz.gif";s:4:"bd08";s:31:"pi1/class.tx_mwimagemap_pi1.php";s:4:"80f6";s:39:"pi1/class.tx_mwimagemap_pi1_wizicon.php";s:4:"dae9";s:17:"pi1/locallang.xml";s:4:"abbe";s:17:"pi1/template.html";s:4:"925e";s:22:"pi1/mwim/Changelog.txt";s:4:"55c6";s:28:"pi1/mwim/PostInstallHook.php";s:4:"d1dc";s:19:"pi1/mwim/README.txt";s:4:"9fa9";s:32:"pi1/mwim/class.tx_mwimagemap.php";s:4:"6624";s:38:"pi1/mwim/class.tx_mwimagemap_ufunc.php";s:4:"552b";s:35:"pi1/mwim/class.ux_tslib_content.php";s:4:"81a3";s:23:"pi1/mwim/config_inc.php";s:4:"51bb";s:22:"pi1/mwim/constants.php";s:4:"3bb6";s:16:"pi1/mwim/dam.txt";s:4:"b326";s:30:"pi1/mwim/ext_conf_template.txt";s:4:"5da5";s:23:"pi1/mwim/ext_emconf.php";s:4:"1b17";s:21:"pi1/mwim/ext_icon.gif";s:4:"2c77";s:26:"pi1/mwim/ext_localconf.php";s:4:"7213";s:23:"pi1/mwim/ext_tables.php";s:4:"ef4d";s:23:"pi1/mwim/ext_tables.sql";s:4:"234d";s:22:"pi1/mwim/locallang.xml";s:4:"b98f";s:25:"pi1/mwim/locallang_db.xml";s:4:"64a1";s:23:"pi1/mwim/doc/manual.sxw";s:4:"c056";s:28:"pi1/mwim/doc/wizard_form.dat";s:4:"b0f6";s:29:"pi1/mwim/doc/wizard_form.html";s:4:"9c1a";s:19:"pi1/mwim/mod1/cg.js";s:4:"372a";s:23:"pi1/mwim/mod1/clear.gif";s:4:"cc11";s:22:"pi1/mwim/mod1/conf.php";s:4:"677f";s:23:"pi1/mwim/mod1/index.php";s:4:"4aea";s:31:"pi1/mwim/mod1/locallang_mod.xml";s:4:"4528";s:28:"pi1/mwim/mod1/moduleicon.gif";s:4:"9eee";s:33:"pi1/mwim/mod1/tx_dam_navframe.php";s:4:"71df";s:42:"pi1/mwim/mod1/colpicker/color_functions.js";s:4:"d7ae";s:46:"pi1/mwim/mod1/colpicker/js_color_picker_v2.css";s:4:"5523";s:45:"pi1/mwim/mod1/colpicker/js_color_picker_v2.js";s:4:"714d";s:44:"pi1/mwim/mod1/colpicker/img/select_arrow.gif";s:4:"e3b6";s:49:"pi1/mwim/mod1/colpicker/img/select_arrow_down.gif";s:4:"ce4d";s:49:"pi1/mwim/mod1/colpicker/img/select_arrow_over.gif";s:4:"2b9f";s:45:"pi1/mwim/mod1/colpicker/img/slider_handle.gif";s:4:"fee1";s:49:"pi1/mwim/mod1/colpicker/img/tab_center_active.gif";s:4:"aacf";s:47:"pi1/mwim/mod1/colpicker/img/tab_left_active.gif";s:4:"aef1";s:49:"pi1/mwim/mod1/colpicker/img/tab_left_inactive.gif";s:4:"77f3";s:48:"pi1/mwim/mod1/colpicker/img/tab_right_active.gif";s:4:"0b16";s:50:"pi1/mwim/mod1/colpicker/img/tab_right_inactive.gif";s:4:"653c";s:31:"pi1/mwim/mod1/css/mainstyle.css";s:4:"705c";s:25:"pi1/mwim/mod1/img/0_1.gif";s:4:"0589";s:25:"pi1/mwim/mod1/img/0_2.gif";s:4:"0589";s:25:"pi1/mwim/mod1/img/1_1.gif";s:4:"267e";s:25:"pi1/mwim/mod1/img/1_2.gif";s:4:"80c4";s:25:"pi1/mwim/mod1/img/2_1.gif";s:4:"95ef";s:25:"pi1/mwim/mod1/img/2_2.gif";s:4:"a989";s:25:"pi1/mwim/mod1/img/3_1.gif";s:4:"effc";s:25:"pi1/mwim/mod1/img/3_2.gif";s:4:"effc";s:23:"pi1/mwim/mod1/img/d.gif";s:4:"7813";s:29:"pi1/mwim/mod1/img/garbage.gif";s:4:"7b41";s:27:"pi1/mwim/mod1/img/minus.gif";s:4:"0f13";s:28:"pi1/mwim/mod1/img/pencil.gif";s:4:"e76c";s:26:"pi1/mwim/mod1/img/plus.gif";s:4:"b919";s:29:"pi1/mwim/mod1/img/savedok.gif";s:4:"933e";s:23:"pi1/mwim/mod1/img/u.gif";s:4:"6076";s:32:"pi1/mwim/mod1/js/draw_objects.js";s:4:"826e";s:29:"pi1/mwim/mod1/js/functions.js";s:4:"fb8f";s:24:"pi1/mwim/mod1/js/poly.js";s:4:"337d";s:33:"pi1/mwim/mod1/js/wz_jsgraphics.js";s:4:"b236";s:37:"pi1/mwim/mod1/js/wz_jsgraphics_new.js";s:4:"8a66";s:42:"pi1/mwim/mod1/templates/template_area.html";s:4:"0b6c";s:41:"pi1/mwim/mod1/templates/template_map.html";s:4:"e7ec";s:23:"pi1/mwim/pi1/canvas.gif";s:4:"8647";s:23:"pi1/mwim/pi1/canvas.png";s:4:"2a20";s:23:"pi1/mwim/pi1/ce_wiz.gif";s:4:"bd08";s:40:"pi1/mwim/pi1/class.tx_mwimagemap_pi1.php";s:4:"a637";s:48:"pi1/mwim/pi1/class.tx_mwimagemap_pi1_wizicon.php";s:4:"dae9";s:26:"pi1/mwim/pi1/locallang.xml";s:4:"abbe";s:26:"pi1/mwim/pi1/template.html";s:4:"54b9";s:33:"pi1/mwim/pi1/static/editorcfg.txt";s:4:"f6d4";s:33:"pi1/mwim/static/pi1/constants.txt";s:4:"5a85";s:29:"pi1/mwim/static/pi1/setup.txt";s:4:"cd17";s:24:"pi1/static/editorcfg.txt";s:4:"f6d4";s:20:"res/js/mwimagemap.js";s:4:"3fe5";s:24:"static/pi1/constants.txt";s:4:"1f3f";s:20:"static/pi1/setup.txt";s:4:"a2b4";}',
	'suggests' => array(
	),
);

?>