TM Offline Stats (v1.0)

(c) 2006-2009 Alexander Domnin

   Warning: Bad english ! :)

========================================

TABLE OF CONTENTS
 [1] INTRODUCTION
 [2] ADDITIONAL INFORMATION
 [3] LICENSE
 [4] RECOMMENDED SPECIFICATION
 [5] UPDATE FROM THE PREVIOUS VERSIONS
 [6] INSTALLATION INSTRUCTIONS
 [7] FTP
 [8] DOWNLOADABLE TRACKS
 [9] AUTOMATIC UPDATING OF STATISTICS
[10] ADDITION OF SCREENSHOOTS
[11] ADDITION OF AVATARS
[12] USERBARS
[13] INTERFACE LANGUAGES
[14] COLOR SCHEME
[15] OTHER SETTINGS
[16] FAQ
[17] VERSION HISTORY


========================================

[1] INTRODUCTION

TM Offline Stats – is a statistics programme for the Trackmania games. It displays
a general ranking list of the server’s players and the records they have set. Every
player can see the best times set on each track, the medals that were awarded and
the place that was taken with that time. The built in monitoring allows users to
quickly see the current game mode, track and players on a server.

========================================

[2] ADDITIONAL INFORMATION

"TM Offline Stats" official site:
   http://www.tmos.pp.ru

========================================

[3] LICENSE

1. Программа "TM Offline Stats" (TMos) лицензирована по условиям Creative Commons
   Attribution-Noncommercial-No Derivative Works 3.0 Unported; ознакомиться с
   копией лицензии можно на странице http://creativecommons.org/licenses/by-nc-nd/3.0/

2. Автор предоставляет программу "TM Offline Stats" (TMos) "как есть" и не берет
   на себя обязательств предоставлять конечному пользователю поддержку

3. Конечный пользователь отвечает за любое использование программы "TM Offline
   Stats" (TMos). В наибольшей степени, допускаемой действующим законодательством,
   автор отказывается от предоставления любых гарантий, явных или подразумеваемых,
   в том числе относительно товарности, безвредности или применимости программы
   "TM Offline Stats" (TMos) для какой-либо конкретной цели

4. В наибольшей степени, допускаемой действующим законодательством, автор
   отказывается нести ответственность за какие-либо убытки (включая реальный ущерб и
   упущенную выгоду), возникшие из-за использования или невозможности использования
   программы "TM Offline Stats" (TMos), даже если автор был предупрежден о
   возможности возникновения такого ущерба

========================================

[4] RECOMMENDED SPECIFICATION

Recommended:
 - Windows/Linux any version
 - Log-files of Trackmania server '2006-04-25' and above
 - Apache 2.0.xx and above
 - PHP 4.4.4 and above
 - MySQL 4.1/PostgreSQL 8.0/Microsoft SQL 8.0 (2000) and above

========================================

[5] UPDATE FROM THE PREVIOUS VERSIONS

Variant 1 (recommended):
1. Completely remove the previous version of statistics, including tmos_xxx tables
   from the database
2. Install the new version [6]
3. Don't use the log-files in old format (server version less then 2006-04-25)

Variant 2 (with save results in DB):
1. Replace old files of statistics with new versions from this archive 
2. Go to administrator's panel (tmos_admin.php) 
3. Go to the menu item "General Settings". In the "Database" section specify
   database settings of the previous version of statistics. Save the changes
4. Go to the menu item "Database". Click button "Update" and follow the
   instructions

========================================

[6] INSTALLATION INSTRUCTIONS

1. Install server of Trackmania version 2006-04-25 or above. Information about
   server and links you can find on official forum:
   http://www.tm-forum.com

2. Install Apache + PHP + MySQL. PHP must be compiled with the support of mysql
   (pgsql/mssql) xml, gd (v2.0.8 or above).  Programs can be downloaded from (freeware):
   - http://www.apache.org
   - http://www.php.net
   - http://www.mysql.com
   Look for manuals and articles here "www.google.com" with query "apache php mysql"

3. Copy all files of statistics to any folder in DocumentRoot. For example, if
   DocumentRoot is c:\web, copy all files in the c:\web\tmos\. Make sure, that file
   tmos_config.php haven't option "Read Only" in Windows, or set rights 666 (Octal)
   to this file in Linux ("write by other"). In linux set rights 777 to folder
   "./cache" and to folder "./gfx/userbars"

4. Load the tmos_admin.php in browser (http://localhost/tmos/tmos_admin.php). 

   Attention: for first time admin's password is '1' (without quotes). If you forgot
   your password, open the file tmos_config.php in notepad

5. Go to the menu item "General Settings". Set your settings and click "save" button.

   Attention: blank database must already exist! You can create it through phpMyAdmin,
   MySql Admininstrator or any similar utility 

6. Go to "Database" and create tables with "create" button

7. Go to "Server registry" and registry one or more game servers

8. To bring player's results into the database, go to tmos_admin.php menu item
   "Your_server" and click button "parse", or use file tmos_parser.php. Like this:
   http://server_ip_adress/tmos/tmos_parser.php With this file will be updated results
   for all registered servers

9. Installation complete. Now, any player can see statistics through any browser. The
   file for viewing tmos_viewer.php or index.php 

========================================

[7] FTP

The statistics support placement log-files on ftp:// servers.

To use an FTP need:
 - pathes to log-files and folders with tracks must be set in the form
   ftp://ftplogin:ftppassword@ip_address/path/GameLog.xxx.txt
   ftp://ftplogin:ftppassword@ip_address/path/Tracks
 - if the anonymous access to ftp available, name and password can be deleted 
   ftp://ip_address/path/GameLog.xxx.txt
   ftp://ip_address/path/Tracks

Examples:
 * ftp://192.168.54.222/tmn/Logs/GameLog..txt
 * ftp://192.168.54.222/tmn/GameData/Tracks/
 * ftp://anonymous:ie@192.168.54.222/tmn/Logs/GameLog..txt
 * ftp://anonymous:ie@192.168.54.222/tmn/GameData/Tracks/

Attention:
   Files, located on FTP, downloads to a temporary folder of
   operating system, then opens and processes as local.
   Downloading files may require additional space on hard drive.

========================================

[8] DOWNLOADABLE TRACKS

If .gbx track file places in the folder ./files/ of statistics, then when
parsing log-files, information about him will be saved in the database and
the file will be available for download from the tab "Track" - a button "Download"
    
========================================

[9] AUTOMATIC UPDATING OF STATISTICS

Linux:
   Use the built-planner crontab (man crontab). Add to assignment line like this
   (set your own path to statistics):
   0 * * * * php /usr/home/myaccount/htdocs_tmos/tmos_parser.php
   and statistics will updating every hour

Windows:
   Use third-party tool crontab.exe for Windows (or any similar). To assignment
   file of the program "crontab" (without extension) add line like this
   (set your path to php and statistics):
   0 * * * * C:\web\php_505\cgi.exe c:\web\html\tmos\tmos_parser.php
   then run crontab.exe. Program will run this command one time in hour and
   update statistics 

Instead of asterisks can be substitute following values (sequentially):
   minute        0 - 59
   hour          0 - 23
   month day     1 - 31
   month         1 - 12
   week day      0 - 6  (0 - sunday)

========================================

[10] ADDITION OF SCREENSHOOTS

To add:
1. Lower screenshot to size 160x120 pixels and save them in jpg format
2. Rename the file in "track_UID.jpg." Track's UID can be found in matchsettings file
   of server or, for example, in tmos_admin.php->"Your_server"->"MSF"
3. Copy this file to folder. "./gfx/tracks"
4. Statistics automatically show needed image (F5)

Examples: 
 * StadiumC3, q0ljLrLGWogdntNr85I4UrwPsLf -> ./gfx/tracks/q0ljLrLGWogdntNr85I4UrwPsLf.jpg
 * DesertD4,  OyBGZZYhTTS2srBwVwR8xpB7g19 -> ./gfx/tracks/OyBGZZYhTTS2srBwVwR8xpB7g19.jpg

========================================

[11] ADDITION OF AVATARS

To add: 
1. Lower image with avatar to size 160x120 pixels
2. Save the image as jpg, png or gif named: 

   - for /lan servers - "player_nickname.jpg(png/gif)"

     player_nickname must be in lower case without color codes. If the nickname
     contain chars /\:*?<>"| they should be replaced with symbol "_" 

   - for /internet servers - "player_account.jpg(png/gif)"

3. Copy image file into "./gfx/avatars" folder of statistics

Examples:
 * /lan, $0f0Player$i$0ffNickName, jpg -> ./gfx/avatars/playernickname.jpg
 * /lan, $ffaOtHeR$zNiCk, gif          -> ./gfx/avatars/othernick.gif
 * /internet, playeraccount, png       -> ./gfx/avatars/playeraccount.png
 * /internet, _00faccount, jpg         -> ./gfx/avatars/_00faccount.jpg

========================================

[12] USERBARS

You can add any number of own userbars to statistics.
The configuration is done on the tab "Userbars" in admin's panel.

Attention:
1. If FreeType library is not installed with PHP, the text will writes
   with standard font of GD library, so properly will displayed only Latin
   characters and numbers
2. For useing TrueType fonts, you must to copy the font-files to folder
   "./gfx/fonts" of statistics. You can use any own unicode font or
   standard windows font "Arial Unicod MS" c:\windows\fonts

========================================

[13] INTERFACE LANGUAGES

To translate:
1. Copy file ./include/tmos_lang_rus.inc.php into the file containing the name
   of the language. For example, want translate to Italian, copy the file
   ./include/tmos_lang_rus.inc.php into ./include/tmos_lang_ita.inc.php
2. Open new file ./include/tmos_lang_ita.inc.php in any text editor that
   supports work with UTF-8 characters (windows notepad, for example)
3. All lines in file looks like:

   "PHP_code"=>"interface_string",

   Need translate all "interface_string", then save file in UTF-8
4. In administrator's panel choose new translation

========================================

[14] COLOR SCHEME

For changing statistics color scheme, edit one of css files in "./gfx" folder

========================================

[15] OTHER SETTINGS

In file "tmos_config_mp.php" you can specify:
   - set on/off autoparse team-tags
   - players that results will be united
   - players that will be deleted from statistics
   - team-tags
   - team-tags that will be deleted from statistics
   - UIDs for track that will be deleted from statistics

To edit "tmos_config_mp.php" needed:
   - open this file in notepad (or other text editor)
   - do changes
   - save file

For changes take effect needed:
   - start parsing log-files

Set on/off autoparse team-tags:
   $cfg_autoclans = true;

   false - switch off this function. If function off, statistics will find
           team-tags only by array $cfg_clans
   true  - switch on this function. If function on, statistics will find
           team-tags automatically. Array $cfg_clans will uses also

Attribution results of one player to another:

   $cfg_players = array(
   "SrcPlayerAccount"=>"DestPlayerAccount",
   "SrcPlayerAccount2"=>"DestPlayerAccount"
   );


   To reallocate the results of player to other nickname/account should be
   add string to the array:    

   - for /lan servers - "src_player_nickname"=>"dest_player_nickname",

     Results of player src_player_nickname will be convert to player
     dest_player_nickname. Both nicknames should be in lowercase with color
     codes. The best way to copy them from the log-file

     nickname: $000jago
     [2007/01/22 13:50:45] <time> [$000jago/213.85.135.45:2350 ($000Jago)] 0:51.07
     nickname: rock
     [2007/01/22 13:59:40] <time> [rock/172.16.12.52:2350 (RoCK)] 2:47.31

     $cfg_players = array(
        "$000jago"=>"rock",
     );

   - for /internet servers - "src_player_account"=>"dest_player_account",

     Results of player src_player_account will be convert to player
     src_player_account. The best way to copy accounts from the log-file

     account: wjp84
     [2006/06/14 14:04:19] <time> [wjp84 ($i$f4fWJP)] 0:32.18
     account: gunsteri
     [2006/06/14 14:04:38] <time> [gunsteri (gunster)] 0:43.50

     $cfg_players = array(
        "wjp84"=>"gunsteri",
     );

Removing players:

   $cfg_players_ignorelist = array(
   "FirstIgnorePlayer",
   "SecondIgnorePlayer"
   );

   To remove a player from the statistics, should be add string to the array:

   - for /lan servers - "player_nickname",

     When parsing logs, the results of player_nickname will be ignored.
     player_nickname must be in lowercase with color codes. The best way to
     copy them from the log-file

     nickname: $000jago
     [2007/01/22 13:50:45] <time> [$000jago/213.85.135.45:2350 ($000Jago)] 0:51.07
     nickname: rock
     [2007/01/22 13:59:40] <time> [rock/172.16.12.52:2350 (RoCK)] 2:47.31

     $cfg_players_ignorelist = array(
        "$000jago",
        "rock",
     );

   - for /internet servers - "player_account",

     When parsing logs, the results of player_account will be ignored.
     The best way to copy player_account from the log-file

     account: wjp84
     [2006/06/14 14:04:19] <time> [wjp84 ($i$f4fWJP)] 0:32.18
     account: gunsteri
     [2006/06/14 14:04:38] <time> [gunsteri (gunster)] 0:43.50

     $cfg_players_ignorelist = array(
        "wjp84",
        "gunsteri",
     );

Registration of teams/clans : 

   $cfg_clans = array(
   "ClanTag"=>array("description"=>"Description: full name, site, mirc channel, e.t.c.",
                    "autofindmembers"=>true,
                    "members"=>"member1,member2,member_e_t_c"),
   );

   To register clan, need add string to array: 

   "clan_tag"=>array("description"=>"description_text",
                     "autofindmembers"=>true,
                     "members"=>"member1;member2;member_e_t_c"),

   clan_tag         - team-tag. Perhaps, in any case, with or without color codes 
   description_text - description of the clan, the whole line will desplayed in the
                      statistics. Could include: full name of the clan, link to the
                      home page, mirc channel, e.t.c
   members          - list of clan members through ";". For /lan servers need type
                      nickname for /internet servers - account


   $cfg_clans = array(
      "BANANAS"=>array("description"=>" - BANANAS clan",
                       "autofindmembers"=>true),
       "UnItEd"=>array("description"=>" - Some players united to clan",
                       "autofindmembers"=>false,
                       "members"=>"$000jago;wjp84;gunsteri;rock"),
   );

Removing teams/clans:

   // case-insensitive
   $cfg_clans_ignorelist = array(
   "the_", "le_", "_guest_", "]max", "'s", "__", "_man", "-man",
   "_black", "_johnson", "st.", "mr.", "dr.", "mr_", "mc_", "c.",
   "d.", "g.", "m.", "r.", "s.", ".a", ".s", ".t", "-a", "-c",
   "-i", "-z", "_b", "_m", "_n", "_1", "_2", "_61", "_91", "_94"
   );

   To remove the clan, need add string to array : 

   "clan_tag",

    clan_tag may be in any case, with or without color codes

Removing track and all results on this track:

   $cfg_tracks_ignorelist = array(
      "track_uid",
   );

   To remove the track, need add string to array : 

   "track_uid",

   track_uid you may view in matchsettings file or in log-file of server

   [2007/01/19 18:20:13] Loading challenge desertC1.Challenge.Gbx (8SebSPNUFIajLWymNFZHZkW2Xnh)...
   track_uid: 8SebSPNUFIajLWymNFZHZkW2Xnh

   $cfg_tracks_ignorelist = array(
      "8SebSPNUFIajLWymNFZHZkW2Xnh",
   );


Attention:
 - Strings in all arrays dispart by ","

========================================

[16] FAQ

Q. Tracks in the statistics displayed as "trackname.gbx" and authortime/gold/silver/bronze
   time displayed as "00:00:00.00"
A. Files of this tracks didn't found in "Directories with tracks" or files don't have
   access to reading. Copy this files into "Directories with tracks" or in ./files/ directory
   of statistics and reparse statistics

   Attention: statistics don't support tracks in zip archives!
   
Q. Error: "Client does not support authentication protocol requested by
   server; consider upgrading MySQL client"
A. Error may arise at connection with the database on older versions of PHP. Need to
   execute query : 

   SET PASSWORD FOR 'your_login_in_db'@'ip_address_server_with_db' = OLD_PASSWORD('your_pass')

   (do it from phpMyAdmin, MySql QueryBrowser or from other tool)
   
Q. Error: "mysqlnd cannot connect to MySQL 4.1+ using old authentication"
A. Need to execute query:
   
   SET PASSWORD FOR 'your_login_in_db'@'ip_address_server_with_db' = PASSWORD('your_pass')

   (do it from phpMyAdmin, MySql QueryBrowser or from other tool)

Q. Monitoring don't work, write that "server offline"
A. 1. Make shure that "xmlrpc_allowremote" option in servers settings file (dedicated.cfg)
      set to "True". Should be "<xmlrpc_allowremote>True</xmlrpc_allowremote>"
   2. Make sure that correct set password for the user "SuperAdmin"

Q. How points calculates?
A. Points calculates with formula:

   P  = sum(pi)
   pi = (n-x)*k + m
   k  = (t - x + 1)/t

   where:
   P  - total player's points  (sum of points for each track)
   pi - points for one track
   n  - total count of players that finish current track
   x  - occupied by player place on current track
   m  - points for medal on current track
   k  - coefficient of "occupied place"
   t  - total count of players

   Players that finish with same time get same points

========================================

[17] VERSION HISTORY

v1.0

* A Lot of new

v0.62b
* Fixed error with names that contain "()"
* Added support for codes $h and $l in player's nicknames
* Player that come to server through LAN and Internet not form a clan
* Fixed error with wrong player's ranks
* Added new "bad" team-tags in tmos_config_mp.php
* Added old userbars 350x20
* Added "white-green" color scheme

v0.62a
* Fixed error: BLOB/TEXT column 'description' can't have a default value

v0.62
* Added DB converter from previous versions of statistics. Supports update
  from v0.50, v0.51, v0.60, v0.61
* Changed points calculated system
* Improve team-tags discern function. Now supports UTF-8 characters
* Fixed bug with tracks "mood", that give "track.gbx" lines in
  the statistics for standard Nadeo United tracks
* Rewritten tmos_config_mp work logic. No need "reset" database now, only
  reparse statistics
* Added clan's members registration in tmos_config_mp
* Added deleting tracks feature in tmos_config_mp

v0.61
* Added config file, that allow specify:
   - team-tags and team-descriptions
   - ignored team-tags
   - player's accounts for unite their results
   - ignored player's accounts
* Improve team-tags discern function
* Added gZip compression of html pages
* New format xx / yy for column "place" in personal players statistics. Where
  xx - finish place, yy - total count of results for this track
* Added "gray" color scheme

v0.60
* Added support for United
* Parser's engine rewritten. The parsing process going more quickly and
  consumes less RAM
* Added cache of html pages
* Each registered server can have several log-files and directories with tracks
* Players on /lan servers discern by nickname without color codes in lower case
* Tracks discern by UID
* Changed the scoring system
* Added second statistics for last few days
* Added team-stats
* May be added unbounded count of userbars
* Player names with UTF-8 characters correctly displayed on userbars
  (need unicod font)
* Added new field in table "Tracks" - better player at the track
* Added new options for the administrator:
  - color scheme
  - amount of points for medals and finish
  - the minimum number of team members to display in the statistics
  - the minimum number of player's points to display in the statistics
  - the time period for calculation "current" statistics
  - the font and font size for the userbars
  - caching pages
* Added "black" color scheme
* Added text "statistics update" while parsing

-