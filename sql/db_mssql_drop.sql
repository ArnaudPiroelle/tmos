if exists (select * from dbo.sysobjects where name = 'tmos_servers')
   drop table [tmos_servers];

if exists (select * from dbo.sysobjects where name = 'tmos_players')
   drop table [tmos_players];

if exists (select * from dbo.sysobjects where name = 'tmos_tracks')
   drop table [tmos_tracks];

if exists (select * from dbo.sysobjects where name = 'tmos_clans')
   drop table [tmos_clans];

if exists (select * from dbo.sysobjects where name = 'tmos_scores')
   drop table [tmos_scores];

if exists (select * from dbo.sysobjects where name = 'tmos_results')
   drop table [tmos_results];