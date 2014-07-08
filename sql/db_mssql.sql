CREATE TABLE [tmos_servers] (
  [serverid] [int] NOT NULL,
  [server] [nvarchar] (128) NOT NULL,
  [serverc] [nvarchar] (128) NOT NULL,
  [ip] [varchar] (128) NOT NULL,
  [game] [varchar] (16) NOT NULL,
  [login] [nvarchar] (128) NOT NULL,
  [password] [nvarchar] (128) NOT NULL,
  [trackdirs] [nvarchar] (1024) NOT NULL,
  [logfiles] [nvarchar] (1024) NOT NULL,
  [envirs] [varchar] (16) NOT NULL,
  [lastupdate] [varchar] (19) NOT NULL,
  PRIMARY KEY  ([serverid])
);

CREATE TABLE [tmos_players] (
  [serverid] [int] NOT NULL,
  [playerid] [varchar] (11) NOT NULL,
  [account] [nvarchar] (128) NOT NULL,
  [player] [nvarchar] (128) NOT NULL,
  [playerc] [nvarchar] (128) NOT NULL,
  [links] [nvarchar] (1024) NOT NULL,
  [aliases] [nvarchar] (1024) NOT NULL,
  [lastonline] [varchar] (19) NOT NULL,
  PRIMARY KEY  ([serverid],[playerid])
);

CREATE TABLE [tmos_tracks] (
  [serverid] [int] NOT NULL,
  [trackid] [varchar] (11) NOT NULL,
  [uid] [varchar] (30) NOT NULL,
  [track] [nvarchar] (128) NOT NULL,
  [trackc] [nvarchar] (128) NOT NULL,
  [author] [nvarchar] (128) NOT NULL,
  [envirid] [char] (1) NOT NULL,
  [mood] [varchar] (10) NOT NULL,
  [type] [varchar] (10) NOT NULL,
  [nblaps] [int] NOT NULL,
  [price] [int] NOT NULL,
  [bronze] [varchar] (11) NOT NULL,
  [silver] [varchar] (11) NOT NULL,
  [gold] [varchar] (11) NOT NULL,
  [authortime] [varchar] (11) NOT NULL,
  [authorscore] [int] NOT NULL,
  [rc] [int] NOT NULL,
  [pc] [int] NOT NULL,
  [filename] [nvarchar] (128),
  PRIMARY KEY  ([serverid],[trackid])
);

CREATE TABLE [tmos_clans] (
  [serverid] [int] NOT NULL,
  [clanid] [varchar] (11) NOT NULL,
  [clanc] [nvarchar] (128) NOT NULL,
  [description] [nvarchar] (1024) NOT NULL,
  [members] [varchar] (1024) NOT NULL,
  [mc] [int] NOT NULL,
  PRIMARY KEY  ([serverid],[clanid])
);

CREATE TABLE [tmos_scores] (
  [serverid] [int] NOT NULL,
  [ownerid] [varchar] (11) NOT NULL,
  [envirid] [char] (1) NOT NULL,
  [am] [int] NOT NULL,
  [gm] [int] NOT NULL,
  [sm] [int] NOT NULL,
  [bm] [int] NOT NULL,
  [fc] [int] NOT NULL,
  [score] [float] NOT NULL,
  [rank] [int] NOT NULL,
  PRIMARY KEY  ([serverid],[ownerid],[envirid])
);

CREATE TABLE [tmos_results] (
  [serverid] [int] NOT NULL,
  [trackid] [varchar] (11) NOT NULL,
  [playerid] [varchar] (11) NOT NULL,
  [result] [varchar] (11) NOT NULL,
  [ts] [varchar] (19) NOT NULL,
  [fp] [int] NOT NULL,
  [medal] [char] (1) NOT NULL,
  PRIMARY KEY  ([serverid],[trackid],[playerid])
);