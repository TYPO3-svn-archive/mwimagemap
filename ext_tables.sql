#
# Table structure for table 'tx_mwimagemap_map'
#
CREATE TABLE tx_mwimagemap_map (
	id int(11) NOT NULL auto_increment,
	name tinytext NOT NULL,
	file tinytext NOT NULL,
  alt_file varchar(255) NOT NULL DEFAULT '',
	folder tinytext NOT NULL,
	
	PRIMARY KEY (id)
);

#
# Table structure for table 'tx_mwimagemap_area'
#
CREATE TABLE tx_mwimagemap_area (
	id int(11) NOT NULL auto_increment,
	mid int(11) NOT NULL DEFAULT '0',
	type int(11) NOT NULL DEFAULT '0',
	link tinytext NOT NULL,
	description tinytext NOT NULL,
	color char(7) NOT NULL DEFAULT '',
	param tinytext NOT NULL,
	fe_bordercolor varchar(7) NOT NULL DEFAULT '',
  fe_visible tinyint(1) NOT NULL DEFAULT '0',
  fe_borderthickness tinyint(2) NOT NULL DEFAULT '0',
  fe_altfile varchar(255) NOT NULL DEFAULT '',
	
	PRIMARY KEY (id),
	KEY parent (mid)
);

#
# Table structure for table 'tx_mwimagemap_point'
#
CREATE TABLE tx_mwimagemap_point (
	id int(11) NOT NULL auto_increment,
	aid int(11) NOT NULL DEFAULT '0',
	num int(11) NOT NULL DEFAULT '0',
	x int(11) NOT NULL DEFAULT '0',
	y int(11) NOT NULL DEFAULT '0',
	
	PRIMARY KEY (id),
	KEY parent (aid)
);

#
# Table structure for table 'tx_mwimagemap_bcolors'
#
CREATE TABLE tx_mwimagemap_bcolors (
   id int(11) NOT NULL auto_increment,
   mid int(11) NOT NULL DEFAULT '0',
   colorname varchar(255) NOT NULL DEFAULT '',
   color varchar(7) NOT NULL DEFAULT '',
   PRIMARY KEY (id),
   KEY parent (mid)
);

#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content (
  	tx_mwimagemap varchar(255) NOT NULL DEFAULT ''
);

#
# Table structure for table 'tx_mwimagemap_contentpopup'
#
CREATE TABLE tx_mwimagemap_contentpopup (
	id int(11) NOT NULL auto_increment,
	aid int(11) NOT NULL DEFAULT '0',
  content_id int(11) NOT NULL DEFAULT '0',
  popup_width int(11) NOT NULL DEFAULT '0',
  popup_height int(11) NOT NULL DEFAULT '0',
  popup_x int(11) NOT NULL DEFAULT '0',
  popup_y int(11) NOT NULL DEFAULT '0',
  popup_bordercolor varchar(8) NOT NULL DEFAULT '',
  popup_backgroundcolor varchar(8) NOT NULL DEFAULT '',
  popup_borderwidth int(11) NOT NULL DEFAULT '0',
  active tinyint(1) NOT NULL DEFAULT '0',
	PRIMARY KEY (id),
	KEY parent (aid)
);
