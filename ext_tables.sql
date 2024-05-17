#
# Table structure for table 'tx_hgonspecies_domain_model_species'
#
CREATE TABLE tx_hgonspecies_domain_model_species (

    record_type varchar(255) DEFAULT 'default' NOT NULL,
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	name_science varchar(255) DEFAULT '' NOT NULL,
	name_discoverer varchar(255) DEFAULT '' NOT NULL,
	year varchar(255) DEFAULT '' NOT NULL,
    remark text,
	characteristic text,
	habitat text,
	dissemination text,
	grid_frequency double(11,2) DEFAULT '0.00' NOT NULL,
	last_updated_date date DEFAULT NULL,
	red_list_hessia varchar(255) DEFAULT '' NOT NULL,
	red_list_germany varchar(255) DEFAULT '' NOT NULL,
	phenology text,
	mtb64 int(11) DEFAULT '0' NOT NULL,
	proof int(11) DEFAULT '0' NOT NULL,
	image int(11) unsigned DEFAULT '0' NOT NULL,
	dissemination_img int(11) unsigned NOT NULL default '0',
	sidebar_img int(11) unsigned NOT NULL default '0',
	files int(11) unsigned NOT NULL default '0',
	family int(11) unsigned DEFAULT '0',
	extended_family int(11) unsigned DEFAULT '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted smallint(5) unsigned DEFAULT '0' NOT NULL,
	hidden smallint(5) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state smallint(6) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,
	l10n_state text,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);
