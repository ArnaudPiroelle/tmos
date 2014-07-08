CREATE TABLE tmos_servers (
  serverid integer NOT NULL,
  server character varying(128) NOT NULL,
  serverc character varying(128) NOT NULL,
  ip character varying(128) NOT NULL,
  game character varying(16) NOT NULL,
  login character varying(128) NOT NULL,
  password character varying(128) NOT NULL,
  trackdirs text NOT NULL,
  logfiles text NOT NULL,
  envirs character varying(16) NOT NULL,  
  lastupdate character varying(19) NOT NULL,
  PRIMARY KEY  (serverid)
);

CREATE TABLE tmos_players (
  serverid integer NOT NULL,
  playerid character varying(11) NOT NULL,
  account character varying(128) NOT NULL,
  player character varying(128) NOT NULL,
  playerc character varying(128) NOT NULL,
  links text NOT NULL,
  aliases text NOT NULL,
  lastonline character varying(19) NOT NULL,
  PRIMARY KEY  (serverid,playerid)
);

CREATE TABLE tmos_tracks (
  serverid integer NOT NULL,
  trackid character varying(11) NOT NULL,
  uid character varying(30) NOT NULL,
  track character varying(128) NOT NULL,
  trackc character varying(128) NOT NULL,
  author character varying(128) NOT NULL,
  envirid character(1) NOT NULL,
  mood character varying(10) NOT NULL,
  type character varying(10) NOT NULL,
  nblaps integer NOT NULL,
  price integer NOT NULL,
  bronze character varying(11) NOT NULL,
  silver character varying(11) NOT NULL,
  gold character varying(11) NOT NULL,
  authortime character varying(11) NOT NULL,
  authorscore integer NOT NULL,
  rc integer NOT NULL,
  pc integer NOT NULL,
  filename character varying(128),
  PRIMARY KEY  (serverid,trackid)
);

CREATE TABLE tmos_clans (
  serverid integer NOT NULL,
  clanid character varying(11) NOT NULL,
  clanc character varying(128) NOT NULL,
  description text NOT NULL,
  members text NOT NULL,
  mc integer NOT NULL,
  PRIMARY KEY  (serverid,clanid)
);

CREATE TABLE tmos_scores (
  serverid integer NOT NULL,
  ownerid character varying(11) NOT NULL,
  envirid character(1) NOT NULL,
  am integer NOT NULL,
  gm integer NOT NULL,
  sm integer NOT NULL,
  bm integer NOT NULL,
  fc integer NOT NULL,
  score double precision NOT NULL,
  rank integer NOT NULL,
  PRIMARY KEY  (serverid,ownerid,envirid)
);

CREATE TABLE tmos_results (
  serverid integer NOT NULL,
  trackid character varying(11) NOT NULL,
  playerid character varying(11) NOT NULL,
  result character varying(11) NOT NULL,
  ts character varying(19) NOT NULL,
  fp integer NOT NULL,
  medal character(1) NOT NULL,
  PRIMARY KEY  (serverid,trackid,playerid)
);