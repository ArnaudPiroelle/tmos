<?php
/*
   <dscr>ENG (CavalierDeVache, Fleckman)</dscr>
   Translated by CavalierDeVache and Fleckman
*/

$tmos_admin_it = array(

// MENU
"mnu_header"=>"TM Offline Stats",
"mnu_gs"=>"General settings",
"mnu_db"=>"Database",
"mnu_dbupd"=>"Structure update",
"mnu_sl"=>"Server registry",
"mnu_sladd"=>"Add new server",
"mnu_slmod"=>"Edit server information",
"mnu_ubl"=>"Userbars",
"mnu_ubladd"=>"Add new userbar",
"mnu_ublmod"=>"Edit userbar properties",
"mnu_msf"=>"Matchsettings file",
"mnu_ts"=>"Track selection",
"mnu_chk"=>"Check config",
"mnu_cs"=>"Servers",
"mnu_csnull"=>"(not registered)",

// COMMON
"com_errorprefix"=>"Error: ",
"com_messageprefix"=>"> ",

// AUTORIZE
"az_authorize_header"=>"Authorization",
"az_login_btn"=>"LOGIN",
"az_status_1"=>"Incorrect password!",

// GENERAL SETTINGS
// - Headers
"gs_db_header"=>"Database",
"gs_interface_header"=>"Interface",
"gs_parsing_header"=>"Calculate statistics",
"gs_admin_header"=>"Administration",
"gs_action_header"=>"Actions",
// - DB
"gs_dbhost"=>"Database host",
"gs_dbtype"=>"Type of database",
"gs_dblogin"=>"Database login",
"gs_dbpassword"=>"Database password",
"gs_dbname"=>"Database name",
"gs_dbhost_desc"=>"IP address of server containing the database. Examples:<br>* 192.168.40.111:1433<br>* localhost",
"gs_dbtype_desc"=>"Type of database for storing statistics",
"gs_dblogin_desc"=>"Database user must have sufficient privileges to create and edit tables",
"gs_dbpassword_desc"=>"Database user password",
"gs_dbname_desc"=>"Database must be created beforehand",
// - Interface
"gs_defaultlanguage"=>"Default interface language",
"gs_defaultcolorscheme"=>"Default color scheme",
"gs_defaultrecperpage"=>"Default number of records per page",
"gs_javascript"=>"JavaScript",
"gs_servertimeout"=>"Server timeout",
"gs_showsingleserver"=>"Single server",
"gs_showmonitoring"=>"Monitoring tab",
"gs_showclans"=>"Team tab",
"gs_showuserbars"=>"Userbars",
"gs_showpreferences"=>"Preferences",
"gs_showlinks"=>"Links",
"gs_showdownloads"=>"Downloads",
"gs_htmlcache"=>"Cache HTML",
"gs_htmlcache_choice_1"=>"Main pages",
"gs_htmlcache_choice_2"=>"All pages",
"gs_htmlcache_choice_3"=>"Forbidden",
"gs_gzipcompression"=>"gZIP compression",
"gs_defaultlanguage_desc"=>"Language selection for statistics pages, administrator panel and userbars",
"gs_defaultcolorscheme_desc"=>"Stylesheets for statistics pages",
"gs_defaultrecperpage_desc"=>"The maximum quantity of records shown on one page. Remaining records are transferred to subsequent pages",
"gs_javascript_desc"=>"JavaScript is used for the highlighting of table rows under the mouse cursor for convenient browsing",
"gs_servertimeout_desc"=>"If there is no answer from the game server in this time interval (in secs.), the server is marked as offline",
"gs_showsingleserver_desc"=>"(Don't) show 'Servers' tab (e.g. if there is only one registered server)",
"gs_showmonitoring_desc"=>"(Don't) show 'Monitoring' tab",
"gs_showclans_desc"=>"(Don't) show 'Teams' tab",
"gs_showuserbars_desc"=>"(Don't) show 'Userbars' in the personal statistics of the player and by links",
"gs_showpreferences_desc"=>"(Don't) show button 'Preferences'",
"gs_showlinks_desc"=>"(Don't) show links in player's nicknames",
"gs_showdownloads_desc"=>"(Don't) show button 'Downloads'",
"gs_htmlcache_desc"=>"Accelerate HTML pages through the caching of PHP scripts",
"gs_gzipcompression_desc"=>"Compress HTML pages before sending to user (useful to decrease web traffic)",
// - Parsing
"gs_minclansize"=>"Team size",
"gs_minclansize_desc"=>"Minimum number of players that form a team",
"gs_medalsscore"=>"Points for medals",
"gs_medalsscore_desc"=>"Points awarded for obtaining author/gold/silver/bronze medal and completion of track",
// - Admin
"gs_adminpassword"=>"Administrator password",
"gs_adminpassword_desc"=>"TMOS administrator password",
// - Action
"gs_savecfg_btn"=>"SAVE",
"gs_savecfg_desc"=>"Save settings changes on this page",
// - Errors
"gs_doublequotes_err"=>"Do not use dual quotation marks",
"gs_defaultrecperpage_err"=>"The parameter 'Records per page' must be an integer >= 10",
"gs_servertimeout_err"=>"The parameter 'Server timeout' must be an integer > 0",
"gs_minclansize_err"=>"The parameter 'Team size' must be an integer >= 2",
"gs_medalsscore_err"=>"Parameters 'Points for medals' must all be an integer >= 0",
// - Operation results
"gs_status_1"=>"Settings saved",
"gs_status_2"=>"Settings could not be saved. Check that the file 'tmos_config.php' has write permissions",

// DATABASE
// - Headers
"db_status_header"=>"Database status",
"db_table_header"=>"Table",
"db_tablestate_header"=>"State",
"db_tablerecords_header"=>"Records",
"db_action_header"=>"Actions",
"db_updinfo_header"=>"Information",
// - DB
"db_dbstatus_1"=>"Ok",
"db_dbstatus_2"=>"Database not supported by PHP",
// - Tables
"db_tablestatus_1"=>"Ok",
"db_tablestatus_2"=>"Incorrect format",
"db_tablestatus_3"=>"Not found",
// - Update
"db_updinfo_text"=>"Database structure will be updated <b>{0} => {1}</b>. The sequence of actions:<br>* Renames old tables tmos_xxx to bk_tmos_xxx<br>* Creates new tables tmos_xxx in format {1}<br>* Transfers data from tables bk_tmos_xxx => tmos_xxx<br>* Parses the log-files for all servers",
"db_support_err"=>"Update from version {0} is not supported",
// - Action
"db_updatedb_btn"=>"UPDATE",
"db_createtables_btn"=>"CREATE",
"db_droptables_btn"=>"DROP",
"db_resetdata_btn"=>"RESET",
"db_cleardata_btn"=>"CLEAR",
"db_cancel_btn"=>"CANCEL",
"db_updatedb_desc"=>"Update the format of the TMOS database tables from earlier versions of TMOS (all data will be retained)",
"db_createtables_desc"=>"Create the TMOS tables in database",
"db_droptables_desc"=>"Remove the TMOS tables from database",
"db_resetdata_desc"=>"Remove all records except for the active servers",
"db_cleardata_desc"=>"Remove all records",
"db_cancel_desc"=>"Don't execute the update",
// - Operation results
"db_status_1"=>"Modification of the database completed successfully",
"db_status_2"=>"Operation cancelled",

// SERVERS
// - Headers
"sl_status_header"=>"Database status",
"sl_servers_header"=>"Servers",
"sl_action_header"=>"Actions",
"sl_add_header"=>"Set up new server",
"sl_mod_header"=>"Server ID:",
// - Servers
"sl_ip"=>"IP address",
"sl_server"=>"Server name",
"sl_id"=>"Server ID",
"sl_game"=>"Game",
"sl_login"=>"Server admin login",
"sl_password"=>"Server admin password",
"sl_logfiles"=>"Log-files",
"sl_trackdirs"=>"Tracks directories",
"sl_ip_desc"=>"The format of the address is 'ip:xmlrpcport'. Examples:<br>* 192.168.40.111:5000<br>* localhost:5001",
"sl_server_desc"=>"Shown in headings of tables and on userbars of statistics",
"sl_game_desc"=>"Pictures and userbars displayed in statistics according to this setting",
"sl_login_desc"=>"Must coincide with SuperAdmin in dedicated.cfg file",
"sl_password_desc"=>"",
"sl_logfiles_desc"=>"Trackmania server log files ('./Logs' server directory). Several logs can be specified by using ';' to separate them. Examples:<br>* c:\\tmn\Logs\GameLog..txt<br>* /usr/home/myaccount/tmn/Logs/GameLog..txt<br>* &lt;dir&gt;\GameLog.1.txt;&lt;dir&gt;\GameLog.2.txt;&lt;dir&gt;\GameLog.3.txt",
"sl_trackdirs_desc"=>"Directories with '.gbx' track files. Several directories can be specified by using ';' to separate them. Examples:<br>* c:\\tmn\GameData\Tracks<br>* /usr/home/myaccount/tmn/GameData/Tracks<br>* &lt;dir1&gt;/Tracks;&lt;dir2&gt;/Tracks;&lt;dir3&gt;/Tracks",
// - Action
"sl_addserver_btn"=>"ADD",
"sl_deleteservers_btn"=>"DELETE",
"sl_modifyservers_btn"=>"MODIFY",
"sl_cancel_btn"=>"CANCEL",
"sl_addserver_desc"=>"Register new server",
"sl_deleteservers_desc"=>"Delete selected servers",
"sl_modifyservers_desc"=>"Change data for selected servers",
"sl_cancel_desc"=>"Cancel changes",
// - Errors
"sl_doublequotes_err"=>"Do not use dual quotation marks",
// - Operation results
"sl_status_1"=>"Operation cancelled",
"sl_status_2"=>"Operation completed successfully",
"sl_status_3"=>"No servers selected",

// USERBARS             /////////////// new !!!!!!!!!!!!!!!!!!!!!
// - Headers
"ub_status_header"=>"GD Status",
"ub_userbars_header"=>"Userbars",
"ub_action_header"=>"Actions",
"ub_add_header"=>"Set up new userbar",
"ub_mod_header"=>"Userbar ID:",
// - Data
"ub_gdstatus_1"=>"Ok",
"ub_gdstatus_2"=>"GD lib is not supported",
"ub_gdstatus_3"=>"FreeType lib is not supported",
"ub_id"=>"Userbar ID",
"ub_game"=>"Game",
"ub_font1"=>"Font 1 / color / size",
"ub_font2"=>"Font 2 / color / size",
"ub_imgfile"=>"Image file (.png)",
"ub_type"=>"Type",
// - Action
"ub_adduserbar_btn"=>"ADD",
"ub_adduserbar_desc"=>"Add new userbar",
"ub_deleteuserbars_btn"=>"DELETE",
"ub_deleteuserbars_desc"=>"Delete selected userbars",
"ub_modifyuserbars_btn"=>"MODIFY",
"ub_modifyuserbars_desc"=>"Change properties for selected userbars",
"ub_cancel_btn"=>"CANCEL",
"ub_cancel_desc"=>"Cancel changes",
// - Errors
"ub_imgfile_err"=>"Image file must be in .png format, width <= 600, height <= 100, size <= 100Kb",
"ub_font1_err"=>"Font 1 not found",
"ub_size1_err"=>"Font size 1 must be an integer >= 1",
"ub_color1_err"=>"Font color 1 must be specified in XXXXXX format, where X is any hex value (0-9, a-f)",
"ub_font2_err"=>"Font 2 not found",
"ub_size2_err"=>"Font size 2 must be an integer >= 1",
"ub_color2_err"=>"Font color 2 must be specified in XXXXXX format, where X is any hex value (0-9, a-f)",
// - Operation results
"ub_status_1"=>"Operation cancelled",
"ub_status_2"=>"Ok",
"ub_status_3"=>"Unspecified error",
"ub_status_4"=>"No userbars selected",

// CHECK
// - Headers
"chk_php_header"=>"PHP",
"chk_db_header"=>"Database",
"chk_tables_header"=>"Tables",
"chk_servers_header"=>"Servers",
// - Inf
"chk_phpver"=>"Version",
"chk_phpxml"=>"XML",
"chk_phpgd"=>"GD",
"chk_phpft"=>"FreeType",
"chk_phpcache"=>"Cache",
"chk_phpzlib"=>"ZLib",
"chk_phpmetime"=>"max_execution_time",
"chk_phpallowurl"=>"allow_url_fopen",
"chk_phpmemlimit"=>"memory_limit",
"chk_phpver_desc"=>"PHP version must be 4.4.0 or above",
"chk_phpxml_desc"=>"XML support",
"chk_phpgd_desc"=>"GD libraries must be installed to use userbars",
"chk_phpft_desc"=>"Freetype libraries must be installed to use Truetype fonts with userbars",
"chk_phpcache_desc"=>"Test writing of cache file",
"chk_phpzlib_desc"=>"ZLib libraries must be installed to support compression of web pages",
"chk_phpmetime_desc"=>"Maximum PHP script execution time. If PHP safe mode is enabled (SM = On) scripts cannot alter this variable and it must be changed by hand",
"chk_phpallowurl_desc"=>"If this option is off, scripts cannot process files via file://",
"chk_phpmemlimit_desc"=>"Maximum amount of memory a script may consume. Minimum 32MB recommended",
"chk_dbtype"=>"Database type",
"chk_dbconnect"=>"Connection",
"chk_dbver"=>"Version",
"chk_logfiles"=>"Log-files",
"chk_trackdirs"=>"Tracks directories",
"chk_dbtype_desc"=>"",
"chk_dbconnect_desc"=>"Database accessibility",
"chk_dbver_desc"=>"Database version must be:<br>* 4.1.0 or above - MySQL<br>* 8.0 or above - PostgreSQL<br>* 8.0 (2000) or above - Microsoft SQL",
// - Check results
"chk_statusok"=>"Ok",
"chk_statusfailed"=>"Error",
"chk_srvonline"=>"Online",
"chk_srvoffline"=>"Offline",

// CURRENT SERVER
// - Headers
"cs_inf_header"=>"Information",
"cs_parsing_header"=>"Log-files parsing",
"cs_action_header"=>"Actions",
"cs_msf_header"=>"Matchsettings file / Tracks",
// - Inf
"cs_status"=>"Status",
"cs_totalplayers"=>"Players",
"cs_totaltracks"=>"Number of tracks",
"cs_currtrack"=>"Current track",
// - Parsing
"cs_parselast"=>"Last parse",
"cs_logfiles"=>"Log-files",
// - Tracks
"cs_trackdirs"=>"Tracks directories",
// - Action
"cs_refresh_btn"=>"REFRESH",
"cs_parse_btn"=>"PARSE",
"cs_createmsf_btn"=>"MSF",
"cs_restarttrack_btn"=>"RESTART",
"cs_nexttrack_btn"=>"NEXT",
"cs_choosetrack_btn"=>"CHOOSE",
"cs_refresh_desc"=>"Refresh server information",
"cs_restarttrack_desc"=>"Restart the current track",
"cs_nexttrack_desc"=>"Send server to the next track",
"cs_choosetrack_desc"=>"Choose and change to one of challenges in the playlist",
"cs_cfsp_desc"=>"Continue from saved position",
"cs_parse_desc"=>"Parse log-files and write results to database",
"cs_createmsf_desc"=>"Create new matchsettings file",
// - Errors
"cs_unknown_err"=>"Unknown error",
"cs_ip_err"=>"Incorrect IP address",
"cs_offline_err"=>"Server offline",
"cs_authenticate_err"=>"Incorrect username / password",
"cs_choosetrack_err"=>"No track selected",
"cs_servers_err"=>"Server(s) not found",
"cs_skipped_err"=>"Skipped",
"cs_trackdirs_err"=>"Tracks directory(s) not found or not readable",
"cs_logfiles_err"=>"Log-file(s) not found or not readable",
"cs_msfwrite_err"=>"Could not save matchsettings file. Possible causes:<br>* not enough rights<br>* directory doesn't exist<br>* filename contains illegal characters ('*', '?' ...)",
"cs_msftracks_err"=>"No tracks selected",
"cs_msfrestartserver_err"=>"Could not restart server",
// - Operation results
"cs_status_1"=>"Ok",
"cs_status_2"=>"Matchsettings file saved",
"cs_status_3"=>"Server restarted",
"cs_status_4"=>"Failure",

// MSF
// - Headers
"msf_parameter_header"=>"Parameter",
"msf_value_header"=>"Value",
"msf_checkbox_header"=>"?",
"msf_trackname_header"=>"Track name",
"msf_trackauthor_header"=>"Author",
"msf_trackuid_header"=>"UID",
"msf_ml_header"=>"ML",
"msf_envir_header"=>"Envir.",
"msf_version_header"=>"TM",
"msf_msfilename_header"=>"Matchsettings file",
"msf_action_header"=>"Actions",
// - Options
"msf_gamemode"=>"Game Mode",
"msf_chattime"=>"Chat time (msec)",
"msf_roundspointslimit"=>"Points limit for 'Rounds' mode",
"msf_roundsusenewrules"=>"Use new rules for 'Rounds' mode",
"msf_timeattacklimit"=>"Time limit for 'TimeAttack' mode (msec)",
"msf_teampointslimit"=>"Points limit for 'Team' mode",
"msf_teammaxpoints"=>"Maximum team points for 'Team' mode",
"msf_teamusenewrules"=>"Use new rules for 'Team' mode",
"msf_laps_nblaps"=>"Force number of laps for 'Laps' mode",
"msf_lapstimelimit"=>"Time limit for 'Laps' mode (msec)",
"msf_randommaporder"=>"Randomize the playlist",
// - Action
"msf_chkall"=>"Select all",
"msf_chkalpine"=>"Alpine",
"msf_chkbay"=>"Bay",
"msf_chkcoast"=>"Coast",
"msf_chkisland"=>"Island",
"msf_chkrally"=>"Rally",
"msf_chkspeed"=>"Speed",
"msf_chkstadium"=>"Stadium",
"msf_chknull"=>"Remove all",
"msf_savetofile_btn"=>"SAVE",
"msf_srvrestart_desc"=>"Restart server with new settings. Warning: all track files and matchsettingsfile.txt file must be in ...\GameData\Tracks\ dir or subdirs!",
"msf_savetofile_desc"=>"Save settings to file",

// CHOOSE TRACK
"ts_radio_header"=>"?",
"ts_track_header"=>"Track Name",
"ts_envir_header"=>"Envir.",
"ts_length_header"=>"Length",
"ts_choosetrack_btn"=>"CHOOSE",
"ts_action_header"=>"Actions",
);


$tmos_viewer_it = array(

// MENU
"mnu_servers"=>"Servers",
"mnu_monitoring"=>"Monitoring",
"mnu_players"=>"Player Ranking",
"mnu_tracks"=>"Tracks",
"mnu_clans"=>"Teams",
"mnu_pages"=>"Pages: ",
"mnu_envir_!"=>"???",
"mnu_envir_*"=>"OVERALL",
"mnu_envir_a"=>"STADIUM",
"mnu_envir_b"=>"ISLAND",
"mnu_envir_c"=>"BAY",
"mnu_envir_d"=>"COAST",
"mnu_envir_e"=>"ALPINE",
"mnu_envir_f"=>"RALLY",
"mnu_envir_g"=>"SPEED",

// SERVERLIST
"sl_header"=>"Servers",
"sl_online"=>"Online",
"sl_offline"=>"Offline",

// MONITORING
"mon_header"=>"Monitoring",
"mon_game"=>"Game",
"mon_gamemode"=>"Mode",
"mon_players"=>"Players",
"mon_spectators"=>"Spectators",
"mon_tracks"=>"Number of Tracks",
"mon_trackheader"=>"Track",
"mon_trackname"=>"Trackname",
"mon_trackenvir"=>"Environment",
"mon_trackauthor"=>"Author",
"mon_tracklaps"=>"Laps",
"mon_trackauthortime"=>"Author Time",
"mon_trackbesttime"=>"Best Time",
"mon_playernum"=>"#",
"mon_playername"=>"Player",
"mon_playerbesttime"=>"Best Time",
"mon_playerlaps"=>"Laps Finished",

// PLAYERLIST
"pl_header"=>"Player Ranking",
"pl_totalplayers"=>"Total Players",
"pl_totalawards"=>"Total Awards",
"pl_findplayer"=>"Find Player:",
"pl_findplayer_btn"=>"FIND",
"pl_num"=>"#",
"pl_player"=>"Player",
"pl_score"=>"Points",

// PLAYERINFO
"pi_header"=>"Player",
"pi_rank"=>"Rank",
"pi_afp"=>"Average Finish Position",
"pi_finishedtracks"=>"Finished Tracks",
"pi_firstplaces"=>"First Places",
"pi_lastonline"=>"Last Online",
"pi_aliases"=>"Aliases",
"pi_num"=>"#",
"pi_track"=>"Track",
"pi_besttime"=>"Best Time",
"pi_place"=>"Place",
"pi_award"=>"Award",
"pi_ts"=>"Date",

// TRACKLIST
"tl_header"=>"Tracks",
"tl_totaltracks"=>"Total Tracks",
"tl_totalauthors"=>"Total Authors",
"tl_findtrack"=>"Find Track:",
"tl_findtrack_btn"=>"FIND",
"tl_num"=>"#",
"tl_track"=>"Track",
"tl_author"=>"Author",
"tl_bestresult"=>"Time",
"tl_player"=>"Best Player",
"tl_severalplayers"=>"Players: {0}",

// TRACKINFO
"ti_header"=>"Track",
"ti_author"=>"Author",
"ti_timeauthor"=>"Author Time",
"ti_timegold"=>"Gold Time",
"ti_timesilver"=>"Silver Time",
"ti_timebronze"=>"Bronze Time",
"ti_envir"=>"Environment",
"ti_num"=>"#",
"ti_player"=>"Player",
"ti_bestresult"=>"Best Time",
"ti_award"=>"Award",
"ti_ts"=>"Date",

// CLANLIST
"cl_header"=>"Teams",
"cl_totalclans"=>"Total Teams",
"cl_findclan"=>"Find Team:",
"cl_findclan_btn"=>"FIND",
"cl_num"=>"#",
"cl_clan"=>"Team",
"cl_score"=>"Points",

// CLANINFO   // new !!!
"ci_header"=>"Team",
"ci_mc"=>"Total Members",
"ci_num"=>"#",
"ci_player"=>"Player",
"ci_score"=>"Points",

// USERBAR
"ub_header"=>"Userbar",
"ub_links"=>"BB code for forums and link for HTML:",
"ub_null_err"=>"> No userbar files found!",
"ub_gd_err"=>"> PHP GD library not supported!",

// PREFERENCES // new !!!
"pr_header"=>"Preferences",
"pr_colorscheme"=>"Color scheme",
"pr_language"=>"Interface language",
"pr_recperpage"=>"Records per page",
"pr_colortags"=>"Show color tags",
"pr_save_btn"=>"SAVE",
"pr_default_btn"=>"DEFAULT",

);


$tmos_userbar_it = array (

// GD TEXT (only latin)
"ub_gdt_server"=>"Server - ",
"ub_gdt_player"=>"Player - ",
"ub_gdt_rank"=>"Rank   - ",
"ub_gdt_score"=>"Score  - ",


"ub_gdt_oa_info"=>'{0} >> {1}',
"ub_gdt_oa_overall"=>"Overall: ",
"ub_gdt_oa_stadium"=>"Stadium: ",
"ub_gdt_oa_island"=>"Island: ",
"ub_gdt_oa_bay"=>"Bay: ",
"ub_gdt_oa_coast"=>"Coast: ",
"ub_gdt_oa_alpine"=>"Alpine: ",
"ub_gdt_oa_rally"=>"Rally: ",
"ub_gdt_oa_speed"=>"Speed: ",

"ub_gdt_link_err"=>"Error: bad userbar link",
"ub_gdt_offline_err"=>"Error: not connected",
"ub_gdt_data_err"=>"Error: data not found (UbID - {0}; SID - {1}; PID - {2})",
"ub_gdt_file_err"=>"Error: userbar file not found or not valid picture",
"ub_gdt_cfg_err"=>"Error: userbars disabled",


// TRUETYPE TEXT (utf8)
"ub_ttt_server"=>"Server",
"ub_ttt_player"=>"Player",
"ub_ttt_rank"=>"Rank",
"ub_ttt_score"=>"Score",
"ub_ttt_separator"=>"  -  ",

"ub_ttt_oa_info"=>'{0} >> {1}',
"ub_ttt_oa_overall"=>"Overall",
"ub_ttt_oa_stadium"=>"Stadium",
"ub_ttt_oa_island"=>"Island",
"ub_ttt_oa_bay"=>"Bay",
"ub_ttt_oa_coast"=>"Coast",
"ub_ttt_oa_alpine"=>"Alpine",
"ub_ttt_oa_rally"=>"Rally",
"ub_ttt_oa_speed"=>"Speed",
"ub_ttt_oa_separator"=>": ",

);

?>
