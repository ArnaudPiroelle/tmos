CREATE TABLE IF NOT EXISTS `tmos_servers` (
  `serverid` int(10) unsigned NOT NULL,
  `server` varchar(128) NOT NULL,
  `serverc` varchar(128) NOT NULL,
  `ip` varchar(128) NOT NULL,
  `game` varchar(16) NOT NULL,
  `login` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `trackdirs` text NOT NULL,
  `logfiles` text NOT NULL,
  `envirs` varchar(16) NOT NULL,  
  `lastupdate` varchar(19) NOT NULL,
  PRIMARY KEY  (`serverid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `tmos_players` (
  `serverid` int(10) unsigned NOT NULL,
  `playerid` varchar(11) NOT NULL,
  `account` varchar(128) NOT NULL,
  `player` varchar(128) NOT NULL,
  `playerc` varchar(128) NOT NULL,
  `links` text NOT NULL,
  `aliases` text NOT NULL,
  `lastonline` varchar(19) NOT NULL,
  PRIMARY KEY  (`serverid`,`playerid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `tmos_tracks` (
  `serverid` int(10) unsigned NOT NULL,
  `trackid` varchar(11) NOT NULL,
  `uid` varchar(30) NOT NULL,
  `track` varchar(128) NOT NULL,
  `trackc` varchar(128) NOT NULL,
  `author` varchar(128) NOT NULL,
  `envirid` char(1) NOT NULL,
  `mood` varchar(10) NOT NULL,
  `type` varchar(10) NOT NULL,
  `nblaps` int(10) unsigned NOT NULL,
  `price` int(10) unsigned NOT NULL,
  `bronze` varchar(11) NOT NULL,
  `silver` varchar(11) NOT NULL,
  `gold` varchar(11) NOT NULL,
  `authortime` varchar(11) NOT NULL,
  `authorscore` int(10) unsigned NOT NULL,
  `rc` int(10) unsigned NOT NULL,
  `pc` int(10) unsigned NOT NULL,
  `filename` varchar(128),
  PRIMARY KEY  (`serverid`,`trackid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `tmos_clans` (
  `serverid` int(10) unsigned NOT NULL,
  `clanid` varchar(11) NOT NULL,
  `clanc` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `members` text NOT NULL,
  `mc` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`serverid`,`clanid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `tmos_scores` (
  `serverid` int(10) unsigned NOT NULL,
  `ownerid` varchar(11) NOT NULL,
  `envirid` char(1) NOT NULL,
  `am` int(10) unsigned NOT NULL,
  `gm` int(10) unsigned NOT NULL,
  `sm` int(10) unsigned NOT NULL,
  `bm` int(10) unsigned NOT NULL,
  `fc` int(10) unsigned NOT NULL,
  `score` double NOT NULL,
  `rank` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`serverid`,`ownerid`,`envirid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `tmos_results` (
  `serverid` int(10) unsigned NOT NULL,
  `trackid` varchar(11) NOT NULL,
  `playerid` varchar(11) NOT NULL,
  `result` varchar(11) NOT NULL,
  `ts` varchar(19) NOT NULL,
  `fp` int(10) unsigned NOT NULL,
  `medal` char(1) NOT NULL,
  PRIMARY KEY  (`serverid`,`trackid`,`playerid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;