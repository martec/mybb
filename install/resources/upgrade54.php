<?php
/**
 * MyBB 1.9
 * Copyright 2014 MyBB Group, All Rights Reserved
 *
 * Website: http://www.mybb.com
 * License: http://www.mybb.com/about/license
 *
 */

/**
 * Upgrade Script: 1.9.0
 */

 $upgrade_detail = array(
     "revert_all_templates" => 0,
     "revert_all_themes" => 0,
     "revert_all_settings" => 0
);

@set_time_limit(0);

function upgrade54_dbchanges()
{
	global $output, $cache, $db, $mybb;

	$output->print_header("Performing Queries");

	echo "<p>Performing necessary upgrade queries..</p>";
	flush();

	$db->drop_table("templategroups");
	$db->write_query("CREATE TABLE ".TABLE_PREFIX."templategroups (
		gid int unsigned NOT NULL auto_increment,
		prefix varchar(50) NOT NULL default '',
		title varchar(100) NOT NULL default '',
		PRIMARY KEY (gid)
		) ENGINE=MyISAM{$collation};");

	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('1','announcements','<lang:group_announcements>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('2','calendar','<lang:group_calendar>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('3','contact','<lang:group_contact>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('4','editpost','<lang:group_editpost>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('5','error','<lang:group_error>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('6','forumbit','<lang:group_forumbit>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('7','forumdisplay','<lang:group_forumdisplay>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('8','header','<lang:group_header>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('9','index','<lang:group_index>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('10','layouts','<lang:group_layouts>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('11','managegroup','<lang:group_managegroup>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('12','member','<lang:group_member>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('13','memberlist','<lang:group_memberlist>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('14','messages','<lang:group_messages>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('15','misc','<lang:group_misc>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('16','modals','<lang:group_modals>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('17','modcp','<lang:group_modcp>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('18','moderation','<lang:group_moderation>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('19','newreply','<lang:group_newreply>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('20','newthread','<lang:group_newthread>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('21','online','<lang:group_online>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('22','parser','<lang:group_parser>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('23','partials','<lang:group_partials>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('24','polls','<lang:group_polls>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('25','portal','<lang:group_portal>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('26','postbit','<lang:group_postbit>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('27','printthread','<lang:group_printthread>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('28','private','<lang:group_private>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('29','referrals','<lang:group_referrals>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('30','report','<lang:group_report>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('31','reputation','<lang:group_reputation>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('32','search','<lang:group_search>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('33','sendthread','<lang:group_sendthread>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('34','showteam','<lang:group_showteam>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('35','showthread','<lang:group_showthread>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('36','smilieinsert','<lang:group_smilieinsert>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('37','stats','<lang:group_stats>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('38','usercp','<lang:group_usercp>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('39','warnings','<lang:group_warnings>');");
	$db->write_query("INSERT INTO ".TABLE_PREFIX."templategroups (gid,prefix,title) VALUES ('40','xmlhttp','<lang:group_xmlhttp>');");

	$output->print_contents("<p>Click next to continue with the upgrade process.</p>");
	$output->print_footer("54_done");
}