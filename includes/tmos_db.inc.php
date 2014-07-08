<?php
/*
   TM Offline Stats v1.0
   Copyright (c) 2006-2009 Alexander Domnin

   This program is licenced under the
   Creative Commons Attribution-Noncommercial-No Derivative Works 3.0 Unported.
   To view a copy of this licence, visit http://creativecommons.org/licenses/by-nc-nd/3.0/

   This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
   without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

require_once "tmos_funcs.inc.php";

// *****************************************************************************
// Ttmos_DB
// *****************************************************************************

class Ttmos_DB {
   var $cfg;
   var $funcs;
   var $db_link;
   var $safe;
   var $last_error;

   function Ttmos_DB($config, $safefl = false) {
      $this->cfg = $config;
      if ($this->cfg['dbtype'] != "mysql" &&
          $this->cfg['dbtype'] != "mssql" &&
          $this->cfg['dbtype'] != "pg")
         $this->cfg['dbtype'] = "mysql";
      $this->funcs['open'] = "open_".$this->cfg['dbtype'];
      $this->funcs['close'] = "close_".$this->cfg['dbtype'];
      $this->funcs['select'] = "query_select_".$this->cfg['dbtype'];
      $this->funcs['selectpage'] = "query_selectpage_".$this->cfg['dbtype'];
      $this->funcs['exec'] = "query_exec_".$this->cfg['dbtype'];
      $this->funcs['schema'] = "instance_schema_".$this->cfg['dbtype'];
      $this->funcs['tables_drop'] = "tables_drop_".$this->cfg['dbtype'];
      $this->funcs['tables_create'] = "tables_create_".$this->cfg['dbtype'];
      $this->funcs['version'] = "db_version_".$this->cfg['dbtype'];
      $this->db_link = NULL;
      $this->safe = $safefl;
      $this->last_error = '';
   }
   
   function last_error() {
      return $this->last_error;
   }
   
// MySQL (sm +) ////////////////////////////////////////////////////////////////

   function open_mysql() {
      $this->db_link = @mysql_connect($this->cfg['dbhost'], $this->cfg['dblogin'],
                                         $this->cfg['dbpassword']);
      if (!$this->db_link ||
          !@mysql_select_db($this->cfg['dbname'], $this->db_link) ||
          !@mysql_query("/*!40101 SET NAMES 'utf8' */", $this->db_link)) {
         if ($this->safe) $this->last_error = mysql_error();
         else die("Ttmos_DB: ".mysql_error());
         if ($this->db_link !== false)
            @mysql_close($this->db_link);
         if ($this->last_error == '') $this->last_error = '?';
      }
      else
         $this->last_error = '';
   }

   function close_mysql() {
      if ($this->db_link != null && $this->db_link !== false) {
         if (!@mysql_close($this->db_link)) {
            if ($this->safe) $this->last_error = mysql_error();
            else die("Ttmos_DB: ".mysql_error());
         }
         else
            $this->last_error = '';
         $this->db_link = null;
      }
   }

   function query_select_mysql($sql, $key1, $key2, $defval = null) {
      $query_result = @mysql_unbuffered_query($sql, $this->db_link);
      if ($query_result === false) {
         if ($this->safe) $this->last_error = mysql_error($this->db_link);
         else die("Ttmos_DB: ".mysql_error($this->db_link)." (".$sql.")");
         if ($key1 != -1 || $key2 != -1)
            $result = array();
         else
            $result = array("count"=>0);
      }
      else {
         $this->last_error = '';
         
         $result = array();
         if ($key2 != -1) {
            while ($curr_str = mysql_fetch_array($query_result, MYSQL_ASSOC)) {
               $result[$curr_str[$key1]][$curr_str[$key2]] = $curr_str;
               unset($result[$curr_str[$key1]][$curr_str[$key2]][$key2]);
               unset($result[$curr_str[$key1]][$curr_str[$key2]][$key1]);
            }
         }
         else if ($key1 != -1) {
            while ($curr_str = mysql_fetch_array($query_result, MYSQL_ASSOC)) {
               $result[$curr_str[$key1]] = $curr_str;
               unset($result[$curr_str[$key1]][$key1]);
            }
         }
         else {
            $result['count'] = 0;
            while ($curr_str = mysql_fetch_array($query_result, MYSQL_ASSOC)) {
               if ($defval !== null) {
                  foreach ($curr_str as $key=>$value)
                     if ($value == null) $curr_str[$key] = $defval;
               }
               $result[$result['count']] = $curr_str;
               $result['count'] += 1;
            }
         }
         mysql_free_result($query_result);
      }
      return $result;
   }

   function query_exec_mysql($sql) {
      $result = @mysql_query($sql, $this->db_link);
      if ($result === false) {
         if ($this->safe) $this->last_error = mysql_error($this->db_link);
         else die("Ttmos_DB: ".mysql_error($this->db_link)." (".$sql.")");
      }
      else
         $this->last_error = '';
   }

   function query_selectpage_mysql($sql, $pagenum, $recperpage) {
      $sql .= " LIMIT ".($pagenum-1)*$recperpage.", $recperpage";
      return $this->query_select_mysql($sql, -1, -1);
   }

   function db_version_mysql() {
      $result = @mysql_get_server_info($this->db_link);
      if ($result === false) {
         if ($this->safe) $this->last_error = mysql_error($this->db_link);
         else die("Ttmos_DB: ".mysql_error($this->db_link));
         $result = '?';
      }
      else {
         $this->last_error = '';
         preg_match('/[1-9]{1,3}\.[0-9]{1,3}.[0-9]{0,4}/', $result, $buf);
         isset($buf[0]) ? $result = $buf[0] : $result = '?';
      }
      return $result;
   }

   // sm -
/*
   // old version
   function instance_schema_mysql() {
      $result = array();
      $tbls = mysql_list_tables($this->cfg['dbname'], $this->db_link);
      while ($curr_tbl = mysql_fetch_row($tbls)) {
         if (strpos($curr_tbl[0], 'tmos_') !== false) {
            $flds = mysql_list_fields($this->cfg['dbname'], $curr_tbl[0], $this->db_link);
            $flds_count = mysql_num_fields($flds);
            for ($i = 0; $i < $flds_count; $i++) {
               $result[$curr_tbl[0]][mysql_field_name($flds, $i)] = "1";
            }
            mysql_free_result($flds);
         }
      }
      mysql_free_result($tbls);

      return $result;
   }
*/
   // update for PHP 5.3+
   function instance_schema_mysql() {
      $result = array();
      $tbls = $this->query_select_mysql(
         "show tables from {$this->cfg['dbname']} like 'tmos_%'", -1, -1);
      for ($i = 0; $i < $tbls['count']; $i++) {
         foreach ($tbls[$i] as $tablename) {
            $flds = $this->query_select_mysql(
               "show columns from {$tablename}", -1, -1);
            for ($j = 0; $j < $flds['count']; $j++)
               $result[$tablename][$flds[$j]['Field']] = "1";
         }
      }

      return $result;
   }

/*
   // update for PHP 5.3+, MySQL 6(5?) only
   function instance_schema_mysql() {
      $result = array();
      $tbls = $this->query_select_mysql(
         "select table_name from information_schema.tables ".
         "where table_schema = '{$this->cfg['dbname']}' ".
           "and table_name like 'tmos_%'", -1, -1);
      for ($i = 0; $i < $tbls['count']; $i++) {
         $flds = $this->query_select_mysql(
            "select column_name from information_schema.columns ".
            "where table_schema = '{$this->cfg['dbname']}' ".
              "and table_name = '{$tbls[$i]['table_name']}'", -1, -1);
         for ($j = 0; $j < $flds['count']; $j++)
            $result[$tbls[$i]['table_name']][$flds[$j]['column_name']] = "1";
      }
      return $result;
   }
*/
// MsSQL (sm +) ////////////////////////////////////////////////////////////////

   function open_mssql() {
      if (preg_match("/(.+):(\d{3,7})$/i", $this->cfg['dbhost'], $buf))
         $this->cfg['dbhost'] = $buf[1].",".$buf[2];
      $this->db_link = @mssql_connect($this->cfg['dbhost'], $this->cfg['dblogin'],
                                      $this->cfg['dbpassword']);
      if (!$this->db_link ||
          !@mssql_select_db($this->cfg['dbname'], $this->db_link)) {
         if ($this->safe) $this->last_error =
            "Connection failed ({$this->cfg['dbhost']}, {$this->cfg['dblogin']})";
         else die("Ttmos_DB: Connection failed");
         if ($this->db_link !== false)
            @mssql_close($this->db_link);
      }
      else
         $this->last_error = '';
   }

   function close_mssql() {
      if ($this->db_link != null && $this->db_link !== false) {
         if (!@mssql_close($this->db_link)) {
            if ($this->safe) $this->last_error = mssql_get_last_message();
            else die("Ttmos_DB: ".mssql_get_last_message());
         }
         else
            $this->last_error = '';
         $this->db_link = null;
      }
   }

   function query_select_mssql($sql, $key1, $key2, $defval = null) {
      // prepare qry (instr -> charindex)
      //$sql = preg_replace("/instr[ ]*\(([^,]+),([^\)]+)\)/i", 'charindex(\\2,\\1)', $sql);

      $query_result = @mssql_query($sql, $this->db_link);
      if ($query_result === false) {
         if ($this->safe) $this->last_error = mssql_get_last_message();
         else die("Ttmos_DB: ".mssql_get_last_message()." (".$sql.")");
         if ($key1 != -1 || $key2 != -1)
            $result = array();
         else
            $result = array("count"=>0);
      }
      else {
         $this->last_error = '';
         
         $result = array();
         if ($key2 != -1) {
            while ($curr_str = mssql_fetch_array($query_result, MSSQL_ASSOC)) {
               $result[$curr_str[$key1]][$curr_str[$key2]] = $curr_str;
               unset($result[$curr_str[$key1]][$curr_str[$key2]][$key2]);
               unset($result[$curr_str[$key1]][$curr_str[$key2]][$key1]);
            }
         }
         else if ($key1 != -1) {
            while ($curr_str = mssql_fetch_array($query_result, MSSQL_ASSOC)) {
               $result[$curr_str[$key1]] = $curr_str;
               unset($result[$curr_str[$key1]][$key1]);
            }
         }
         else {
            $result['count'] = 0;
            while ($curr_str = mssql_fetch_array($query_result, MSSQL_ASSOC)) {
               if ($defval !== null) {
                  foreach ($curr_str as $key=>$value)
                     if ($value == null) $curr_str[$key] = $defval;
               }
               $result[$result['count']] = $curr_str;
               $result['count'] += 1;
            }
         }
         mssql_free_result($query_result);
      }

      return $result;
   }

   function query_exec_mssql($sql) {
      $result = @mssql_query($sql, $this->db_link);
      if ($result === false) {
         if ($this->safe) $this->last_error = mssql_get_last_message();
         else die("Ttmos_DB: ".mssql_get_last_message()." (".$sql.")");
      }
      else
         $this->last_error = '';
   }

   function query_selectpage_mssql($sql, $pagenum, $recperpage) {
      // предполагается, что всегда есть order by,
      // запрос начинается с select и ещё много чего,
      // не в общем виде, вобщем, конкретно под tmos ... голяк
      $buf = "select count(*) as tr from (".substr($sql, 0, strpos($sql, 'order by')-1).") t";
      $buf = $this->query_select_mssql($buf, -1, -1);
      if ($recperpage >= $buf[0]['tr'])
         $buf = 0;
      else if ($pagenum*$recperpage > $buf[0]['tr'])
         $buf = $buf[0]['tr'] - ($pagenum-1)*$recperpage;
      else
         $buf = $recperpage;
      if ($buf != 0) {
         $orderbyf = preg_replace("/ .{1}\./i", " ", substr($sql, strpos($sql, 'order by')));
         $orderbyb = str_replace(array(" asc", " desc", " !desc"),
                                 array(" !desc", " asc", " desc"), $orderbyf);
         $sql = "select * from (".
                   "select top $buf * from (".
                      preg_replace("/^select (.+)/i", "select top ".
                                    ($pagenum*$recperpage)." \\1", $sql).") t1 ".
                   "$orderbyb) t2 ".
                "$orderbyf";
      }
      return $this->query_select_mssql($sql, -1, -1);
   }

   function db_version_mssql() {
      $result = $this->query_select_mssql('select @@version as ver', -1, -1);
      if ($result['count'] > 0) {
         preg_match('/[1-9]{1,3}\.[0-9]{1,3}.[0-9]{0,4}/', $result[0]['ver'], $buf);
         isset($buf[0]) ? $result = trim($buf[0]) : $result = '?';
      }
      else
         $result = '?';
      return $result;
   }

   function instance_schema_mssql() {
      $result = array();
      $tbls = $this->query_select_mssql(
         "select name, id from dbo.sysobjects where name like 'tmos_%'", -1, -1);
      for ($i = 0; $i < $tbls['count']; $i++) {
         $flds = $this->query_select_mssql(
            "select name from dbo.syscolumns where id = {$tbls[$i]['id']}", -1, -1);
         for ($j = 0; $j < $flds['count']; $j++)
            $result[$tbls[$i]['name']][$flds[$j]['name']] = "1";
      }
      return $result;
   }

// PostgreSQL (sm +) ///////////////////////////////////////////////////////////

   function open_pg() {
      $cs = "dbname='{$this->cfg['dbname']}' ".
            "user='{$this->cfg['dblogin']}' ".
            "password='{$this->cfg['dbpassword']}' ".
            "connect_timeout=5";
      if (preg_match("/(.+):(\d{3,7})$/i", $this->cfg['dbhost'], $buf))
         $cs = "host='{$buf[1]}' port={$buf[2]} ".$cs;
      else
         $cs = "host='{$this->cfg['dbhost']}' port=5432 ".$cs;
      $this->db_link = @pg_connect($cs);
      if (!$this->db_link || 
          @pg_set_client_encoding($this->db_link, 'UTF8') == -1) {
         if ($this->safe) $this->last_error = "Connection failed ($cs)";
         else die("Ttmos_DB: Connection failed");
         if ($this->db_link !== false)
            @pg_close($this->db_link);
      }
      else
         $this->last_error = '';
   }

   function close_pg() {
      if ($this->db_link != null && $this->db_link !== false) {
         if (!@pg_close($this->db_link)) {
            if ($this->safe) $this->last_error = pg_last_error();
            else die("Ttmos_DB: ".pg_last_error());
         }
         else
            $this->last_error = '';
         $this->db_link = null;
      }
   }

   function query_select_pg($sql, $key1, $key2, $defval = null) {
      //$sql = preg_replace("/instr[ ]*\(([^,]+),([^\)]+)\)/i", 'position(\\2 in \\1)', $sql);

      $query_result = @pg_query($this->db_link, $sql);
      if ($query_result === false) {
         if ($this->safe) $this->last_error = pg_last_error($this->db_link);
         else die("Ttmos_DB: ".pg_last_error($this->db_link)." (".$sql.")");
         if ($key1 != -1 || $key2 != -1)
            $result = array();
         else
            $result = array("count"=>0);
      }
      else {
         $this->last_error = '';
         
         $result = array();
         if ($key2 != -1) {
            while ($curr_str = pg_fetch_assoc($query_result)) {
               $result[$curr_str[$key1]][$curr_str[$key2]] = $curr_str;
               unset($result[$curr_str[$key1]][$curr_str[$key2]][$key2]);
               unset($result[$curr_str[$key1]][$curr_str[$key2]][$key1]);
            }
         }
         else if ($key1 != -1) {
            while ($curr_str = pg_fetch_assoc($query_result)) {
               $result[$curr_str[$key1]] = $curr_str;
               unset($result[$curr_str[$key1]][$key1]);
            }
         }
         else {
            $result['count'] = 0;
            while ($curr_str = pg_fetch_assoc($query_result)) {
               if ($defval !== null) {
                  foreach ($curr_str as $key=>$value)
                     if ($value == null) $curr_str[$key] = $defval;
               }
               $result[$result['count']] = $curr_str;
               $result['count'] += 1;
            }
         }
         pg_free_result($query_result);
      }
      return $result;
   }

   function query_exec_pg($sql) {
      $result = @pg_query($this->db_link, $sql);
      if ($result === false) {
         if ($this->safe) $this->last_error = pg_last_error($this->db_link);
         else die("Ttmos_DB: ".pg_last_error($this->db_link)." (".$sql.")");
      }
      else
         $this->last_error = '';
   }

   function query_selectpage_pg($sql, $pagenum, $recperpage) {
      $sql .= " LIMIT $recperpage OFFSET ".($pagenum-1)*$recperpage;
      return $this->query_select_pg($sql, -1, -1);
   }

   function db_version_pg() {
      $result = $this->query_select_pg('select version() as ver', -1, -1);
      if ($result['count'] > 0) {
         preg_match('/[1-9]{1,3}\.[0-9]{1,3}.[0-9]{0,4}/', $result[0]['ver'], $buf);
         isset($buf[0]) ? $result = trim($buf[0]) : $result = '?';
      }
      else
         $result = '?';
      return $result;
   }

   function instance_schema_pg() {
      $result = array();
      $tbls = $this->query_select_pg(
         "select table_name from information_schema.tables ".
         "where table_name like 'tmos_%'", -1, -1);
      for ($i = 0; $i < $tbls['count']; $i++) {
         $flds = $this->query_select_pg(
            "select column_name from information_schema.columns ".
            "where table_name = '{$tbls[$i]['table_name']}'", -1, -1);
         for ($j = 0; $j < $flds['count']; $j++)
            $result[$tbls[$i]['table_name']][$flds[$j]['column_name']] = "1";
      }
      return $result;
   }

// Overall (sm -) //////////////////////////////////////////////////////////////

   function script_exec($filename) {
      $sql = @file_get_contents($filename);
      if ($sql !== false) {
         $sql = preg_split('/;/', $sql, -1, PREG_SPLIT_NO_EMPTY);
         for ($i = 0; $i < count($sql); $i++) {
            $this->{$this->funcs['exec']}($sql[$i]);
            if ($this->last_error != '') break;
         }
      }
      else
         $this->last_error = "No such file or directory: $filename";
      if (($this->last_error != '') && (!$this->safe))
         die("Ttmos_DB: ".$this->last_error);
   }

   function es($str) {
      switch ($this->cfg['dbtype']) {
      case 'mysql':
         $result = mysql_real_escape_string($str, $this->db_link);
         break;
      case 'mssql':
         $result = str_replace("'", "''", $str);
         break;
      case 'pg':
         $result = pg_escape_string($str); //pg_escape_string($this->db_link, $str); // >= 5.2.0
         break;
      default: $result = addslashes($str);
      }
      return $result;
   }

   function instance_schemas($ver = '') {
      $result = array();
      $result['v1.00'] = array(
         "tmos_servers" => array("serverid"=>1, "server"=>1, "serverc"=>1, "ip"=>1, "game"=>1,
                                 "login"=>1, "password"=>1, "trackdirs"=>1, "logfiles"=>1,
                                 "envirs"=>1, "lastupdate"=>1),
         "tmos_players" => array("serverid"=>1, "playerid"=>1, "account"=>1, "player"=>1,
                                 "playerc"=>1, "links"=>"1", "aliases"=>1, "lastonline"=>1),
         "tmos_tracks"  => array("serverid"=>1, "trackid"=>1, "uid"=>1, "track"=>1, "trackc"=>1,
                                 "author"=>1, "envirid"=>1, "mood"=>1, "type"=>1, "nblaps"=>1,
                                 "price"=>1, "bronze"=>1, "silver"=>1, "gold"=>1, "authortime"=>1,
                                 "authorscore"=>1, "rc"=>1, "pc"=>1, "filename"=>1),
         "tmos_results" => array("serverid"=>1, "trackid"=>1, "playerid"=>1, "result"=>1, "ts"=>1,
                                 "fp"=>"1", "medal"=>"1"),
         "tmos_clans"   => array("serverid"=>1, "clanid"=>1, "clanc"=>1, "description"=>1,
                                 "members"=>1, "mc"=>1),
         "tmos_scores"  => array("serverid"=>1, "ownerid"=>1, "envirid"=>1, "am"=>1, "gm"=>1,
                                 "sm"=>1, "bm"=>1, "fc"=>1, "score"=>1, "rank"=>1)
      );
      $result['v0.62'] = array(
         "tmos_servers" => array("serverid"=>1, "server"=>1, "serverc"=>1, "ip"=>1, "game"=>1,
                                 "login"=>1, "password"=>1, "tracks"=>"1", "logfiles"=>"1",
                                 "last_update"=>"1"),
         "tmos_players" => array("serverid"=>1, "playerid"=>1, "account"=>1, "player"=>1,
                                 "playerc"=>1, "aliases"=>1, "lastonline"=>1, "am"=>1, "gm"=>1,
                                 "sm"=>1, "bm"=>1, "score"=>1, "am_c"=>1, "gm_c"=>1, "sm_c"=>1,
                                 "bm_c"=>1, "score_c"=>1),
         "tmos_tracks"  => array("serverid"=>1, "trackid"=>1, "uid"=>1, "track"=>1, "trackc"=>1,
                                 "author"=>1, "envir"=>1, "mood"=>1, "type"=>1, "nblaps"=>1,
                                 "price"=>1, "bronze"=>1, "silver"=>1, "gold"=>1, "authortime"=>1,
                                 "authorscore"=>1, "relpath"=>1),
         "tmos_results" => array("serverid"=>1, "resultid"=>1, "trackid"=>1, "playerid"=>1,
                                 "result"=>1, "ts"=>1),
         "tmos_clans"   => array("serverid"=>1, "clanid"=>1, "clanc"=>1, "description"=>1,
                                 "members"=>1, "score"=>1, "score_c"=>1, "tm"=>1),
         "tmos_view"    => array("serverid"=>1, "stats"=>1, "trackid"=>1, "playerid"=>1,
                                 "bestresult"=>1, "ts"=>1, "award"=>1, "rank"=>1, "totalresults"=>1)
      );
      $result['v0.61'] = array(
         "tmos_servers" => array("serverid"=>1, "server"=>1, "serverc"=>1, "ip"=>1, "game"=>1,
                                 "login"=>1, "password"=>1, "tracks"=>1, "logfiles"=>1,
                                 "last_update"=>1),
         "tmos_players" => array("serverid"=>1, "playerid"=>1, "account"=>1, "player"=>1,
                                 "playerc"=>1, "aliases"=>1, "lastonline"=>1, "am"=>1, "gm"=>1,
                                 "sm"=>1, "bm"=>1, "score"=>1, "am_c"=>1, "gm_c"=>1, "sm_c"=>1,
                                 "bm_c"=>1, "score_c"=>1),
         "tmos_tracks"  => array("serverid"=>1, "trackid"=>1, "uid"=>1, "track"=>1, "trackc"=>1,
                                 "author"=>1, "envir"=>1, "mood"=>1, "type"=>1, "nblaps"=>1,
                                 "price"=>1, "bronze"=>1, "silver"=>1, "gold"=>1, "authortime"=>1,
                                 "authorscore"=>1, "relpath"=>1),
         "tmos_results" => array("serverid"=>1, "resultid"=>1, "trackid"=>1, "playerid"=>1,
                                 "result"=>1, "ts"=>1),
         "tmos_clans"   => array("serverid"=>1, "clanid"=>1, "clanc"=>1, "members"=>1, "score"=>1,
                                 "score_c"=>1, "tm"=>1),
         "tmos_view"    => array("serverid"=>1, "stats"=>1, "trackid"=>1, "playerid"=>1,
                                 "bestresult"=>1, "ts"=>1, "award"=>1, "rank"=>1, "totalresults"=>1)
      );
      $result['v0.60'] = array(
         "tmos_servers" => array("serverid"=>1, "server"=>1, "serverc"=>1, "ip"=>1, "game"=>1,
                                 "login"=>1, "password"=>1, "tracks"=>1, "logfiles"=>1,
                                 "last_update"=>1),
         "tmos_players" => array("serverid"=>1, "playerid"=>1, "account"=>1, "player"=>1,
                                 "playerc"=>1, "aliases"=>1, "lastonline"=>1, "am"=>1, "gm"=>1,
                                 "sm"=>1, "bm"=>1, "score"=>1, "am_c"=>1, "gm_c"=>1, "sm_c"=>1,
                                 "bm_c"=>1, "score_c"=>1),
         "tmos_tracks"  => array("serverid"=>1, "trackid"=>1, "uid"=>1, "track"=>1, "trackc"=>1,
                                 "author"=>1, "envir"=>1, "mood"=>1, "type"=>1, "nblaps"=>1,
                                 "price"=>1, "bronze"=>1, "silver"=>1, "gold"=>1, "authortime"=>1,
                                 "authorscore"=>1, "relpath"=>1),
         "tmos_results" => array("serverid"=>1, "resultid"=>1, "trackid"=>1, "playerid"=>1,
                                 "result"=>1, "ts"=>1),
         "tmos_clans"   => array("serverid"=>1, "clanid"=>1, "clanc"=>1, "members"=>1, "score"=>1,
                                 "score_c"=>1, "tm"=>1),
         "tmos_view"    => array("serverid"=>1, "stats"=>1, "trackid"=>1, "playerid"=>1,
                                 "bestresult"=>1, "ts"=>1, "award"=>1, "rank"=>1)
      );
      $result['v0.51'] = array(
         "tmos_servers" => array("serverid"=>1, "server"=>1, "serverc"=>1, "ip"=>1, "game"=>1,
                                 "login"=>1, "password"=>1, "tracksdir"=>1, "logfile"=>1,
                                 "parse_position"=>1, "parse_track"=>1, "parse_str"=>1,
                                 "parse_last"=>1),
         "tmos_players" => array("serverid"=>1, "playerid"=>1, "account"=>1, "ip"=>1, "player"=>1,
                                 "playerc"=>1, "nation"=>"1", "aliases"=>1, "lastonline"=>1,
                                 "am"=>1, "gm"=>1, "sm"=>1, "bm"=>1, "score"=>1, "rank"=>1),
         "tmos_tracks"  => array("serverid"=>1, "trackid"=>1, "uid"=>1, "track"=>1, "trackc"=>1,
                                 "author"=>1, "envir"=>1, "mood"=>1, "type"=>1, "nblaps"=>1,
                                 "price"=>1, "bronze"=>1, "silver"=>1, "gold"=>1, "authortime"=>1,
                                 "authorscore"=>1, "filename"=>1),
         "tmos_results" => array("serverid"=>1, "trackid"=>1, "playerid"=>1, "besttime"=>1,
                                 "ts"=>1, "award"=>1),
      );
      $result['v0.50'] = array(
         "tmos_servers" => array("serverid"=>1, "server"=>1, "serverc"=>1, "ip"=>1, "game"=>1,
                                 "login"=>1, "password"=>1, "tracksdir"=>1, "logfile"=>1,
                                 "parse_position"=>1, "parse_track"=>1, "parse_str"=>1,
                                 "parse_last"=>1),
         "tmos_players" => array("serverid"=>1, "playerid"=>1, "player"=>1, "playerc"=>1,
                                 "account"=>1, "ip"=>1, "nation"=>"1", "am"=>1, "gm"=>1, "sm"=>1,
                                 "bm"=>1, "score"=>1, "rank"=>1),
         "tmos_tracks"  => array("serverid"=>1, "trackid"=>1, "uid"=>1, "track"=>1, "trackc"=>1,
                                 "author"=>1, "envir"=>1, "mood"=>1, "type"=>1, "nblaps"=>1,
                                 "price"=>1, "bronze"=>1, "silver"=>1, "gold"=>1, "authortime"=>1,
                                 "authorscore"=>1, "filename"=>1),
         "tmos_results" => array("serverid"=>1, "trackid"=>1, "playerid"=>1, "besttime"=>1,
                                 "ts"=>1, "award"=>1),
      );
      $result['v0.30/v0.40/v0.41/v0.42/v0.43/v0.44'] = array(
         "tmos_players" => array("id"=>1, "player"=>1, "ip"=>1, "am"=>1, "gm"=>1, "sm"=>1,
                                 "bm"=>1, "score"=>1),
         "tmos_tracks"  => array("id"=>1, "uid"=>1, "name"=>1, "author"=>1, "envir"=>1,
                                 "mood"=>1, "type"=>1, "nblaps"=>1, "price"=>1, "bronze"=>1,
                                 "silver"=>1, "gold"=>1, "authortime"=>1, "authorscore"=>1,
                                 "filename"=>1),
         "tmos_results" => array("trackid"=>1, "playerid"=>1, "besttime"=>1, "ts"=>1,
                                 "prize"=>1),
      );
      if ($ver != '' && isset($result[$ver]))
         return $result[$ver];
      else
         return $result;
   }
   
   function instance_schema_status() {
      $schemas = $this->instance_schemas();
      $schema_inst = $this->{$this->funcs['schema']}();

      // test v1.00
      $result['count'] = 0;
      foreach ($schemas['v1.00'] as $curr_tbl=>$flds) {
         $result[$result['count']]['table'] = $curr_tbl;
         $result[$result['count']]['status'] = "1";
         $result[$result['count']]['record_count'] = "?";
         if (!isset($schema_inst[$curr_tbl]))
            $result[$result['count']]['status'] = "0";
         else {
            foreach ($flds as $curr_fld=>$tmp) {
               if (!isset($schema_inst[$curr_tbl][$curr_fld])) {
                  $result[$result['count']]['status'] = "-1";
                  break;
               }
            }
         }
         if ($result[$result['count']]['status'] == "1") {
            $buf = $this->{$this->funcs['select']}("select count(*) as rc from ".$curr_tbl, -1, -1);
            $result[$result['count']]['record_count'] = $buf[0]['rc'];
         }
         $result['count'] += 1;
      }
      $result['ver'] = "v1.00";
      $result['update'] = '0';
      $result['support'] = '0';
      for ($i = 0; $i < $result['count']; $i++) {
         if ($result[$i]['status'] != "1") {
            $result['ver'] = "?";
            break;
         }
      }
      // test v0.30-v0.62
      if ($result['ver'] == "?") {
         foreach ($schemas as $curr_ver=>$tbls) {
            $result['ver'] = $curr_ver;
            foreach ($tbls as $curr_tbl=>$flds) {
               if (!isset($schema_inst[$curr_tbl])) {
                  $result['ver'] = "?";
                  break;
               }
               else
                  foreach ($flds as $curr_fld=>$tmp)
                     if (!isset($schema_inst[$curr_tbl][$curr_fld])) {
                        $result['ver'] = "?";
                        break;
                     }
            }
            if ($result['ver'] == $curr_ver)
               break;
         }
         if ($result['ver'] == "?") {
            $result['update'] = '0';
            $result['support'] = '0';
         }
         else {
            $result['update'] = '1';
            if ($result['ver'] == 'v0.30/v0.40/v0.41/v0.42/v0.43/v0.44' ||
                $result['ver'] == 'v0.50' ||
                $result['ver'] == 'v0.51')
               $result['support'] = '0';
            else
               $result['support'] = '1';
         }
      }
      // last version
      $result['ver_last'] = "v1.00";

      return $result;
   }

   function db_version() {
      return $this->{$this->funcs['version']}();
   }

   function open() {
      switch ($this->cfg['dbtype']) {
      case 'mysql':
         if (!function_exists('mysql_connect'))
            $this->last_error = 'MySQL not supported by PHP';
         break;
      case 'mssql':
         if (!function_exists('mssql_connect'))
            $this->last_error = 'MsSQL not supported by PHP';
         break;
      case 'oracle':
         if (!function_exists('oci_connect'))
            $this->last_error = 'Oracle not supported by PHP';
         break;
      case 'pg':
         if (!function_exists('pg_connect'))
            $this->last_error = 'PostgreSQL not supported by PHP';
         break;
      }
      if ($this->last_error == '') {
         $this->{$this->funcs['open']}();
      }
   }

   function close() {
      $this->{$this->funcs['close']}();
   }
   
   function update($ver) {
      if ($ver == 'v0.60' ||
          $ver == 'v0.61' ||
          $ver == 'v0.62') {
         // backup old tables
         $this->{$this->funcs['exec']}('alter table tmos_servers rename to bk_tmos_servers');
         $this->{$this->funcs['exec']}('alter table tmos_tracks rename to bk_tmos_tracks');
         $this->{$this->funcs['exec']}('alter table tmos_clans rename to bk_tmos_clans');
         $this->{$this->funcs['exec']}('alter table tmos_players rename to bk_tmos_players');
         $this->{$this->funcs['exec']}('alter table tmos_results rename to bk_tmos_results');
         $this->{$this->funcs['exec']}('alter table tmos_view rename to bk_tmos_view');
         if ($this->last_error != '') return;
         // create new tables
         $this->script_exec(DIR_SQL."db_{$this->cfg['dbtype']}.sql");
         if ($this->last_error != '') return;
         // data -> servers
         $sql = "select serverid as a, server as b, serverc as c, ip as d, ".
                "game as e, login as f, password as g, tracks as h, logfiles as i ".
                "from bk_tmos_servers";
         $data = $this->{$this->funcs['select']}($sql, "a", -1);
         foreach ($data as $sid=>$sinf) {
            $data[$sid]['rs'] = 'i';
            $data[$sid]['e'] = game_toid($data[$sid]['e']);
            $data[$sid]['h'] = params_add(params_fromarray(params_toarray($sinf['h'], false, 0, ';')), DIR_FILES);
            $data[$sid]['i'] = logfiles_merge(logfiles_split(params_fromarray(
                                  params_toarray($sinf['i'], false, 0, ';')), true), true);
            $data[$sid]['j'] = '';
            $data[$sid]['k'] = '-';
         }
         $this->table_servers("mod", $data);
         // data
         $sql = "select serverid from bk_tmos_servers";
         $sl = $this->{$this->funcs['select']}($sql, "serverid", -1);
         foreach ($sl as $sid=>$sinf) {
            // data -> tracks
            $sql = "select trackid as a, uid as b, track as c, trackc as d, ".
                   "author as e, envir as f, mood as g, type as h, nblaps as i, price as j, ".
                   "bronze as k, silver as l, gold as m, authortime as n, authorscore as o ".
                   "from bk_tmos_tracks where serverid = $sid";
            $data = $this->{$this->funcs['select']}($sql, "a", -1);
            foreach ($data as $tid=>$tinf) {
               $data[$tid]['rs'] = 'i';
               $data[$tid]['f'] = envir_toid($data[$tid]['f']);
               $data[$tid]['p'] = 0;
               $data[$tid]['q'] = 0;
               $data[$tid]['r'] = '';
            }
            $this->table_tracks("mod", $data, $sid);
            // data -> players
            $sql = "select playerid as a, account as b, player as c, playerc as d, ".
                   "aliases as f, lastonline as g from bk_tmos_players ".
                   "where serverid = $sid";
            $data = $this->{$this->funcs['select']}($sql, "a", -1);
            foreach ($data as $pid=>$pinf) {
               $data[$pid]['rs'] = 'i';
               $data[$pid]['e'] = '';
               name_links($data[$pid]['c'], $data[$pid]['e']);
               $data[$pid]['d'] = name_clear($pinf['d']);
               $data[$pid]['f'] = params_fromarray(params_toarray($pinf['f'], false, 0, ','));
            }
            $this->table_players("mod", $data, $sid);
         }
         // data -> results
         $sql = "insert into tmos_results (serverid, trackid, playerid, result, ts, fp, medal) ".
                "select t1.serverid, t1.trackid, t1.playerid, t1.result, min(t2.ts), 0, '?' ".
                "from (".
                   "select serverid, trackid, playerid, min(result) as result ".
                   "from bk_tmos_results ".
                   "group by trackid, playerid ".
                ") t1, bk_tmos_results t2 ".
                "where t1.serverid = t2.serverid ".
                  "and t1.trackid = t2.trackid ".
                  "and t1.playerid = t2.playerid ".
                  "and t1.result = t2.result ".
                "group by t1.serverid, t1.trackid, t1.playerid, t1.result";
         $this->{$this->funcs['exec']}($sql);
         // data -> players
         $sql = "delete from tmos_players where not exists ".
                "(select 1 from tmos_results r where r.serverid = tmos_players.serverid ".
                 "and r.playerid = tmos_players.playerid)";
         $this->{$this->funcs['exec']}($sql);
      }
   }
   
   function tables_drop() {
      $this->script_exec(DIR_SQL."db_{$this->cfg['dbtype']}_drop.sql");
   }
   
   function tables_create() {
      $this->script_exec(DIR_SQL."db_{$this->cfg['dbtype']}.sql");
   }
   
   function tables_clear($del_servers) {
      $sql = "delete from tmos_players";
      $this->{$this->funcs['exec']}($sql);
      $sql = "delete from tmos_tracks";
      $this->{$this->funcs['exec']}($sql);
      $sql = "delete from tmos_results";
      $this->{$this->funcs['exec']}($sql);
      $sql = "delete from tmos_clans";
      $this->{$this->funcs['exec']}($sql);
      $sql = "delete from tmos_scores";
      $this->{$this->funcs['exec']}($sql);
      if ($del_servers) {
         $sql = "delete from tmos_servers";
         $this->{$this->funcs['exec']}($sql);
      }
   }

   function table_servers($operation, &$data, $cascade = false) {
      if ($operation == "sel") {
         $sql = "select 'c' as rs, serverid as a, server as b, serverc as c, ip as d, ".
                "game as e, login as f, password as g, trackdirs as h, logfiles as i, ".
                "envirs as j, lastupdate as k ".
                "from tmos_servers";
         $data = $this->{$this->funcs['select']}($sql, "a", -1);
      }
      else {
         foreach ($data as $sid=>$sinf) {
            if ($sinf['rs'] == 'i') {
               if (!is_numeric($sid)) {
                  $sql = "select max(serverid) as id from tmos_servers";
                  $buf = $this->{$this->funcs['select']}($sql, -1, -1);
                  if ($buf['count'] == 0 || $buf[0]['id'] == null)
                     $serverid = 1;
                  else
                     $serverid = $buf[0]['id'] + 1;
               }
               else
                  $serverid = $sid;
               $sql = "insert into tmos_servers (serverid, server, serverc, ip, game, ".
                      "login, password, trackdirs, logfiles, envirs, lastupdate) ".
                      "values ($serverid, '".$this->es($sinf['b'])."', '".$this->es($sinf['c']).
                      "', '".$this->es($sinf['d'])."', '".$this->es($sinf['e'])."', '".
                      $this->es($sinf['f'])."', '".$this->es($sinf['g'])."', '".
                      $this->es($sinf['h'])."', '".$this->es($sinf['i']).
                      "', '{$sinf['j']}', '{$sinf['k']}')";
            }
            else if ($sinf['rs'] == 'u')
               $sql = "update tmos_servers set server = '".$this->es($sinf['b'])."', serverc = '".
                      $this->es($sinf['c'])."', ip = '".$this->es($sinf['d'])."', game = '".
                      $this->es($sinf['e'])."', login = '".$this->es($sinf['f']).
                      "', password = '".$this->es($sinf['g'])."', trackdirs = '".
                      $this->es($sinf['h'])."', logfiles = '".$this->es($sinf['i']).
                      "', envirs = '{$sinf['j']}', "."lastupdate = '{$sinf['k']}' ".
                      "where serverid = $sid";
            else if ($sinf['rs'] == 'd')
               $sql = "delete from tmos_servers where serverid = $sid";
            if ($sinf['rs'] != 'c')
               $this->{$this->funcs['exec']}($sql);
            if ($sinf['rs'] == 'd' && $cascade) {
               $sql = "delete from tmos_players where serverid = $sid";
               $this->{$this->funcs['exec']}($sql);
               $sql = "delete from tmos_tracks where serverid = $sid";
               $this->{$this->funcs['exec']}($sql);
               $sql = "delete from tmos_results where serverid = $sid";
               $this->{$this->funcs['exec']}($sql);
               $sql = "delete from tmos_clans where serverid = $sid";
               $this->{$this->funcs['exec']}($sql);
               $sql = "delete from tmos_scores where serverid = $sid";
               $this->{$this->funcs['exec']}($sql);
            }
         }
      }
   }

   function table_players($operation, &$data, $sid, $cascade = false) {
      if ($operation == "sel") {
         $sql = "select 'c' as rs, playerid as a, account as b, player as c, playerc as d, ".
                "links as e, aliases as f, lastonline as g from tmos_players ".
                "where serverid = $sid";
         $data = $this->{$this->funcs['select']}($sql, "a", -1);
      }
      else {
         foreach ($data as $pid=>$pinf) {
            if ($pinf['rs'] == 'i')
               $sql = "insert into tmos_players (serverid, playerid, account, player, playerc, ".
                      "links, aliases, lastonline) ".
                      "values ($sid, '$pid', '".$this->es($pinf['b'])."', '".
                      $this->es($pinf['c'])."', '".$this->es($pinf['d'])."', '".
                      $this->es($pinf['e'])."', '".$this->es($pinf['f'])."', '{$pinf['g']}')";
            else if ($pinf['rs'] == 'u')
               $sql = "update tmos_players set player = '".$this->es($pinf['c'])."', playerc = '".
                      $this->es($pinf['d'])."', links = '".$this->es($pinf['e'])."', aliases = '".
                      $this->es($pinf['f'])."', lastonline = '{$pinf['g']}' ".
                      "where serverid = $sid and playerid = '$pid'";
            else if ($pinf['rs'] == 'd')
               $sql = "delete from tmos_players where serverid = $sid and playerid = '$pid'";
            if ($pinf['rs'] != 'c')
               $this->{$this->funcs['exec']}($sql);
            if ($pinf['rs'] == 'd' && $cascade) {
               $sql = "delete from tmos_scores where serverid = $sid and playerid = '$pid'";
               $this->{$this->funcs['exec']}($sql);
               $sql = "delete from tmos_results where serverid = $sid and playerid = '$pid'";
               $this->{$this->funcs['exec']}($sql);
            }
         }
      }
   }

   function table_scores($operation, &$data, $sid) {
      if ($operation == "sel") {
         $sql = "select 'c' as rs, ownerid as a, envirid as b, am as c, gm as d, sm as e, ".
                "bm as f, fc as g, score as h, rank as i ".
                "from tmos_scores where serverid = $sid";
         $data = $this->{$this->funcs['select']}($sql, "a", "b");
      }
      else {
         foreach ($data as $oid=>$oinf) {
            foreach ($oinf as $eid=>$einf) {
               if ($einf['rs'] == 'i')
                  $sql = "insert into tmos_scores ".
                         "(serverid, ownerid, envirid, am, gm, sm, bm, fc, score, rank) ".
                         "values ($sid, '$oid', '$eid', {$einf['c']}, {$einf['d']}, ".
                         "{$einf['e']}, {$einf['f']}, {$einf['g']}, {$einf['h']}, {$einf['i']})";
               else if ($einf['rs'] == 'u')
                  $sql = "update tmos_scores set am = {$einf['c']}, gm = {$einf['d']}, ".
                         "sm = {$einf['e']}, bm = {$einf['f']}, fc = {$einf['g']}, ".
                         "score = {$einf['h']}, rank = {$einf['i']} ".
                         "where serverid = $sid and ownerid = '$oid' and envirid = '$eid'";
               else if ($einf['rs'] == 'd')
                  $sql = "delete from tmos_scores ".
                         "where serverid = $sid and ownerid = '$oid' and envirid = '$eid'";
               if ($einf['rs'] != 'c')
                  $this->{$this->funcs['exec']}($sql);
            }
         }
      }
   }
   
   function table_tracks($operation, &$data, $sid, $cascade = false) {
      if ($operation == "sel") {
         $sql = "select 'c' as rs, trackid as a, uid as b, track as c, trackc as d, ".
                "author as e, envirid as f, mood as g, type as h, nblaps as i, price as j, ".
                "bronze as k, silver as l, gold as m, authortime as n, authorscore as o, ".
                "rc as p, pc as q, filename as r from tmos_tracks where serverid = $sid";
         $data = $this->{$this->funcs['select']}($sql, "a", -1);
      }
      else {
         foreach ($data as $tid=>$tinf) {
            if ($tinf['rs'] == 'i')
               $sql = "insert into tmos_tracks (serverid, trackid, uid, track, trackc, author, ".
                      "envirid, mood, type, nblaps, price, bronze, silver, gold, authortime, ".
                      "authorscore, rc, pc, filename) values ($sid, '$tid', '{$tinf['b']}', '".
                      $this->es($tinf['c'])."', '".$this->es($tinf['d'])."', '".
                      $this->es($tinf['e'])."', '{$tinf['f']}', '{$tinf['g']}', ".
                      "'{$tinf['h']}', {$tinf['i']}, {$tinf['j']}, '{$tinf['k']}', ".
                      "'{$tinf['l']}', '{$tinf['m']}', '{$tinf['n']}', {$tinf['o']}, ".
                      "{$tinf['p']}, {$tinf['q']}, '".$this->es($tinf['r'])."')";
            else if ($tinf['rs'] == 'u')
               $sql = "update tmos_tracks set track = '".$this->es($tinf['c'])."', trackc = '".
                       $this->es($tinf['d'])."', author = '".$this->es($tinf['e']).
                       "', envirid = '{$tinf['f']}', mood = '{$tinf['g']}', ".
                       "type = '{$tinf['h']}', nblaps = {$tinf['i']}, price = {$tinf['j']}, ".
                       "bronze = '{$tinf['k']}', silver = '{$tinf['l']}', gold = '{$tinf['m']}', ".
                       "authortime = '{$tinf['n']}', authorscore = {$tinf['o']}, ".
                       "rc = {$tinf['p']}, pc = {$tinf['q']}, filename = '".$this->es($tinf['r'])."' ".
                       "where serverid = $sid and trackid = '$tid'";
            else if ($tinf['rs'] == 'd')
               $sql = "delete from tmos_tracks where serverid = $sid and trackid = '$tid'";
            if ($tinf['rs'] != 'c')
               $this->{$this->funcs['exec']}($sql);
            if ($tinf['rs'] == 'd' && $cascade) {
               $sql = "delete from tmos_results where serverid = $sid and trackid = '$tid'";
               $this->{$this->funcs['exec']}($sql);
            }
         }
      }
   }

   function table_results($operation, &$data, $sid, $tid) {
      if ($operation == "sel") {
         $sql = "select 'c' as rs, playerid as a, result as b, ts as c, fp as d, medal as e ".
                "from tmos_results where serverid = $sid and trackid = '$tid'";
         $data = $this->{$this->funcs['select']}($sql, "a", -1);
      }
      else {
         foreach ($data as $pid=>$pinf) {
            if ($pinf['rs'] == 'i')
               $sql = "insert into tmos_results (serverid, trackid, playerid, result, ts, ".
                      "fp, medal) values ($sid, '$tid', '$pid', '{$pinf['b']}', '{$pinf['c']}', ".
                      "{$pinf['d']}, '{$pinf['e']}')";
            else if ($pinf['rs'] == 'u')
               $sql = "update tmos_results set result = '{$pinf['b']}', ts = '{$pinf['c']}', ".
                      "fp = {$pinf['d']}, medal = '{$pinf['e']}' ".
                      "where serverid = $sid and trackid = '$tid' and playerid = '$pid'";
            else if ($pinf['rs'] == 'd')
               $sql = "delete from tmos_results ".
                      "where serverid = $sid and trackid = '$tid' and playerid = '$pid'";
            if ($pinf['rs'] != 'c')
               $this->{$this->funcs['exec']}($sql);
         }
      }
   }

   function table_clans($operation, &$data, $sid) {
      if ($operation == "sel") {
         $sql = "select 'c' as rs, clanid as a, clanc as b, description as c, members as d, ".
                "mc as e from tmos_clans where serverid = $sid";
         $data = $this->{$this->funcs['select']}($sql, "a", -1);
      }
      else {
         foreach ($data as $cid=>$cinf) {
            if ($cinf['rs'] == 'i')
               $sql = "insert into tmos_clans (serverid, clanid, clanc, description, members, mc) ".
                       "values ($sid, '$cid', '".$this->es($cinf['b'])."', '".
                       $this->es($cinf['c'])."', '".$this->es($cinf['d'])."', {$cinf['e']})";
            else if ($cinf['rs'] == 'u')
               $sql = "update tmos_clans set clanc = '".$this->es($cinf['b'])."', description = '".
                      $this->es($cinf['c'])."', members = '".$this->es($cinf['d'])."', ".
                      "mc = {$cinf['e']} where serverid = $sid and clanid = '$cid'";
            else if ($cinf['rs'] == 'd')
               $sql = "delete from tmos_clans where serverid = $sid and clanid = '$cid'";
            if ($cinf['rs'] != 'c')
               $this->{$this->funcs['exec']}($sql);
         }
      }
   }

   function view_work($view) {
      $result = array();
      foreach ($view as $key=>$value) {
         $result[$key] = $this->es($value);
      }
      if (isset($result['sid']) && !is_numeric($result['sid']))
         $result['sid'] = -111;
      if (isset($result['pagenum']) && !is_numeric($result['pagenum']))
         $result['pagenum'] = 1;
      if (isset($result['query']) && $result['query'] != "*") {
         if (preg_match("/^[^\*]*[^\*]$/u", $result['query']))
            $result['query'] = "*".$result['query']."*";
         $result['query'] = str_replace("*", "%", $result['query']);
         $result['query'] = str_replace("?", "_", $result['query']);
      }
      return $result;
   }

   function view_menu(&$aview) {
      $view = $this->view_work($aview);

      $sql = "select s.serverid, s.envirs, s.lastupdate from tmos_servers s ".
             "where s.serverid = {$view['sid']} or -1 = {$view['sid']}";
      $data = $this->{$this->funcs['select']}($sql, -1, -1);
      if ($data['count'] > 0) {
         // sort
         $buf = $data[0]['envirs'];
         $data[0]['envirs'] = '';
         foreach (envirs() as $eid) {
           if (strpos($buf, $eid) !== false)
              $data[0]['envirs'] .= $eid;
         }
         // links
         if ($view['action'] == 'player') {
            $sql = "select distinct s.envirid from tmos_scores s ".
                   "where s.ownerid = '{$view['pid']}'";
            $buf = $this->{$this->funcs['select']}($sql, -1, -1);
            $data[0]['envirlinks'] = '*';
            for ($i = 0; $i < $buf['count']; $i++)
               $data[0]['envirlinks'] .= $buf[$i]['envirid'];
         }
         else if ($view['action'] == 'track') {
            $sql = "select envirid from tmos_tracks where trackid = '{$view['tid']}'";
            $buf = $this->{$this->funcs['select']}($sql, -1, -1);
            if ($buf['count'] > 0)
               $data[0]['envirlinks'] = '*'.$buf[0]['envirid'];
            else
               $data[0]['envirlinks'] = '';
         }
         else if ($view['action'] == 'clan') {
            $sql = "select distinct s.envirid from tmos_scores s ".
                   "where s.ownerid = '{$view['cid']}'";
            $buf = $this->{$this->funcs['select']}($sql, -1, -1);
            $data[0]['envirlinks'] = '*';
            for ($i = 0; $i < $buf['count']; $i++)
               $data[0]['envirlinks'] .= $buf[$i]['envirid'];
         }
         else {
            $data[0]['envirlinks'] = $data[0]['envirs'];
         }
      }
      $sql = "select count(*) as ts from tmos_servers";
      $data['count_total'] = $this->{$this->funcs['select']}($sql, -1, -1);
      $data['count_total'] = $data['count_total'][0]['ts']; // vsegda

      return $data;
   }

   function view_servers(&$aview) {
      $view = $this->view_work($aview);

      $sql = "select s.serverid, s.server, s.game, s.ip, s.login, s.password ".
             "from tmos_servers s order by s.serverc asc";
      $data = $this->{$this->funcs['select']}($sql, -1, -1);

      return $data;
   }

   function view_monitoring(&$aview, $data) {
      $view = $this->view_work($aview);

      if ($data == null) {
         $sql = "select s.serverid, s.server, s.game, s.ip, s.login, s.password ".
                "from tmos_servers s where s.serverid = {$view['sid']}";
         $data = $this->{$this->funcs['select']}($sql, -1, -1);
      }
      else {
         $sql = "select t.trackid, t.nblaps, p.playerid, p.player, r.result ".
                "from tmos_tracks t, tmos_results r, tmos_players p ".
                "where t.serverid = {$view['sid']} and t.uid = '{$data['ti']['uid']}' ".
                  "and r.serverid = t.serverid and r.trackid = t.trackid ".
                  "and p.serverid = r.serverid and p.playerid = r.playerid ".
                  "and r.fp = 1";
         $buf = $this->{$this->funcs['select']}($sql, -1, -1);
         if ($buf['count'] > 0) {
            $data['ti']['trackid'] = $buf[0]['trackid'];
            $data['ti']['laps_t'] = $buf[0]['nblaps'];
            $data['ti']['playerid'] = $buf[0]['playerid'];
            $data['ti']['player'] = $buf[0]['player'];
            $data['ti']['result'] = $buf[0]['result'];
         }
         else {
            $data['ti']['trackid'] = -1;
            $data['ti']['laps_t'] = -1;
            $data['ti']['playerid'] = -1;
         }
         
         $pr = 0;
         $sql = '';
         for ($i = 0; $i < $data['pl']['count']; $i++) {
            $data['pl'][$i]['playerid'] = -1;
            $sql .= "'".$data['pl'][$i]['account']."',";
            $pr++;
            if ($pr >= 50 || $i == $data['pl']['count']-1) {
               $sql ="select playerid, account from tmos_players where account in (".substr($sql, 0, -1).")";
               $buf = $this->{$this->funcs['select']}($sql, -1, -1);
               for ($j = 0; $j < $buf['count']; $j++) {
                  for ($k = 0; $k < $data['pl']['count']; $k++)
                     if ($data['pl'][$k]['account'] == $buf[$j]['account']) {
                        $data['pl'][$k]['playerid'] = $buf[$j]['playerid'];
                        break;
                     }
               }
               $sql = '';
               $pr = 0;
            }
         }
      }

      return $data;
   }

   function view_players(&$aview) {
      $view = $this->view_work($aview);
   
      $sort_fields = array("player"=>"p.playerc",
                           "am"=>"s.am",
                           "gm"=>"s.gm",
                           "sm"=>"s.sm",
                           "bm"=>"s.bm",
                           "fc"=>"s.fc",
                           "score"=>"s.score",
                           "default"=>"s.score");
      $sort_dirs = array("desc"=>"desc",
                         "asc"=>"asc",
                         "default"=>"desc");
      if (isset($sort_dirs[$view['sortdir']]))
         $sd = $sort_dirs[$view['sortdir']];
      else
         $sd = $sort_dirs['default'];
      if (isset($sort_fields[$view['sortfield']]))
         $sf = $sort_fields[$view['sortfield']];
      else {
         $sf = $sort_fields['default'];
         $sd = $sort_dirs['default'];
      }
      if ($view['query'] == "*")
         $query = '';
      else if ($view['query'] == "%!links%")
         $query = " and p.links is not null and p.links <> ''";
      else if ($view['query'] == "%!aliases%")
         $query = " and p.aliases like '%\x01%'";
      else
         $query = " and p.playerc like '{$view['query']}'";
      $sql = "select p.playerid, p.player, p.playerc, p.links, s.am, s.gm, s.sm, s.bm, s.fc, s.score ".
             "from tmos_players p, tmos_scores s ".
             "where p.serverid = {$view['sid']} and s.envirid = '{$view['eid']}' ".
               "and p.serverid = s.serverid and p.playerid = s.ownerid{$query} ".
             "order by $sf $sd";
      $data = $this->{$this->funcs['selectpage']}($sql, $view['pagenum'], $view['recperpage']);
      $sql = "select s.server, s.game from tmos_servers s where s.serverid = {$view['sid']}";
      $data['srv'] = $this->{$this->funcs['select']}($sql, -1, -1);
      $sql = "select count(p.playerid) as tp, coalesce(sum(s.am+s.gm+s.sm+s.bm), 0) as tm ".
             "from tmos_players p, tmos_scores s ".
             "where p.serverid = {$view['sid']} and s.envirid = '{$view['eid']}' ".
               "and p.serverid = s.serverid and p.playerid = s.ownerid{$query}";
      $data['dscr'] = $this->{$this->funcs['select']}($sql, -1, -1, 0);
      $data['count_total'] = $data['dscr'][0]['tp']; // vsegda

      return $data;
   }
   
   function view_player(&$aview) {
      $view = $this->view_work($aview);

      $sort_fields = array("track"=>"t.trackc",
                           "result"=>"r.result",
                           "fp"=>"r.fp",
                           "medal"=>"r.medal",
                           "pc"=>"t.pc",
                           "rc"=>"t.rc",
                           "ts"=>"r.ts",
                           "default"=>"t.trackc");
      $sort_dirs = array("desc"=>"desc",
                         "asc"=>"asc",
                         "default"=>"asc");
      if (isset($sort_dirs[$view['sortdir']]))
         $sd = $sort_dirs[$view['sortdir']];
      else
         $sd = $sort_dirs['default'];
      if (isset($sort_fields[$view['sortfield']]))
         $sf = $sort_fields[$view['sortfield']];
      else {
         $sf = $sort_fields['default'];
         $sd = $sort_dirs['default'];
      }
      if ($view['eid'] == '*')
         $envir = '';
      else
         $envir =" and t.envirid = '{$view['eid']}'";
      $sql = "select t.trackid, t.track, t.trackc, r.result, r.fp, t.pc, t.rc, r.medal, r.ts ".
             "from tmos_results r, tmos_tracks t ".
             "where r.serverid = {$view['sid']} and r.playerid = '{$view['pid']}'{$envir} ".
               "and r.serverid = t.serverid and r.trackid = t.trackid order by $sf $sd";
      $data = $this->{$this->funcs['selectpage']}($sql, $view['pagenum'], $view['recperpage']);
      $sql = "select s.server, s.game from tmos_servers s ".
             "where s.serverid = {$view['sid']}";
      $data['srv'] = $this->{$this->funcs['select']}($sql, -1, -1);
      $sql = "select p.account, p.player, p.links, p.aliases, p.lastonline, s.am, ".
                    "s.gm, s.sm, s.bm, s.fc, s.score, s.rank ".
             "from tmos_players p, tmos_scores s ".
             "where p.serverid = {$view['sid']} and p.playerid = '{$view['pid']}' ".
               "and s.envirid = '{$view['eid']}' and p.serverid = s.serverid ".
               "and p.playerid = s.ownerid";
      $data['dscr'] = $this->{$this->funcs['select']}($sql, -1, -1);
      if ($data['dscr']['count'] > 0) {
         $data['dscr'][0]['ft'] = $data['dscr'][0]['am'] + $data['dscr'][0]['gm'] +
                                  $data['dscr'][0]['sm'] + $data['dscr'][0]['bm'] +
                                  $data['dscr'][0]['fc'];
         $sql = "select count(r.trackid) as fp from tmos_results r, tmos_tracks t ".
                "where r.serverid = {$view['sid']} and r.playerid = '{$view['pid']}'{$envir} ".
                  "and r.serverid = t.serverid and r.trackid = t.trackid and r.fp = 1";
         $data['dscr'][0]['fp'] = $this->{$this->funcs['select']}($sql, -1, -1);
         $data['dscr'][0]['fp'] = $data['dscr'][0]['fp'][0]['fp'];
         /////////////////////
         if ($data['dscr'][0]['ft'] == 0) die('ERROROROROROR!!!!!!');
         /////////////////////
         $sql = "select sum(r.fp) as afp from tmos_results r, tmos_tracks t ".
                "where r.serverid = {$view['sid']} and r.playerid = '{$view['pid']}'{$envir} ".
                  "and r.serverid = t.serverid and r.trackid = t.trackid";
         $data['dscr'][0]['afp'] = $this->{$this->funcs['select']}($sql, -1, -1, 0);
         $data['dscr'][0]['afp'] = $data['dscr'][0]['afp'][0]['afp']/$data['dscr'][0]['ft'];
         $data['count_total'] = $data['dscr'][0]['ft'];
      }
      else
         $data['count_total'] = 0;

      return $data;
   }

   function view_tracks(&$aview) {
      $view = $this->view_work($aview);

      $sort_fields = array("track"=>"t.trackc",
                           "result"=>"t.result",
                           "author"=>"t.author",
                           "player"=>"p.playerc",
                           "rc"=>"t.rc",
                           "default"=>"t.trackc");
      $sort_dirs = array("desc"=>"desc",
                         "asc"=>"asc",
                         "default"=>"asc");
      if (isset($sort_dirs[$view['sortdir']]))
         $sd = $sort_dirs[$view['sortdir']];
      else
         $sd = $sort_dirs['default'];
      if (isset($sort_fields[$view['sortfield']]))
         $sf = $sort_fields[$view['sortfield']];
      else {
         $sf = $sort_fields['default'];
         $sd = $sort_dirs['default'];
      }
      if ($view['eid'] == '*')
         $envir = '';
      else
         $envir =" and t.envirid = '{$view['eid']}'";
      if ($view['query'] == "*")
         $query = "";
      else if ($view['query'] == "%!ml%")
         $query = " and t.nblaps > 1";
      else
         $query = " and t.trackc like '{$view['query']}'";
      $sql = "select t.*, p.player, p.playerc from (".
               "select t.trackid, t.track, t.trackc, t.author, t.rc, r.result, ".
                      "min(p.playerid) as playerid, count(*) as tr ".
               "from tmos_tracks t, tmos_results r, tmos_players p ".
               "where t.serverid = {$view['sid']}{$envir} and r.fp = 1{$query} ".
                 "and t.serverid = r.serverid and t.trackid = r.trackid ".
                 "and p.serverid = r.serverid and p.playerid = r.playerid ".
               "group by t.trackid, t.track, t.trackc, t.author, t.rc, r.result".
             ") t, tmos_players p ".
             "where p.serverid = {$view['sid']} and p.playerid = t.playerid ".
             "order by $sf $sd";
      $data = $this->{$this->funcs['selectpage']}($sql, $view['pagenum'], $view['recperpage']);
      $sql = "select s.server, s.game from tmos_servers s where s.serverid = {$view['sid']}";
      $data['srv'] = $this->{$this->funcs['select']}($sql, -1, -1);
      $sql = "select count(distinct t.trackid) as tt, count(distinct t.author) as ta ".
             "from tmos_tracks t, tmos_results r ".
             "where t.serverid = {$view['sid']}{$envir} and t.serverid = r.serverid ".
               "and t.trackid = r.trackid{$query}";
      $data['dscr'] = $this->{$this->funcs['select']}($sql, -1, -1);
      $data['count_total'] = $data['dscr'][0]['tt']; // vsegda

      return $data;
   }
   
   function view_track(&$aview) {
      $view = $this->view_work($aview);

      $sort_fields = array("player"=>"p.playerc",
                           "result"=>"r.result",
                           "medal"=>"r.medal",
                           "ts"=>"r.ts",
                           "default"=>"r.result");
      $sort_dirs = array("desc"=>"desc",
                         "asc"=>"asc",
                         "default"=>"asc");
      if (isset($sort_dirs[$view['sortdir']]))
         $sd = $sort_dirs[$view['sortdir']];
      else
         $sd = $sort_dirs['default'];
      if (isset($sort_fields[$view['sortfield']]))
         $sf = $sort_fields[$view['sortfield']];
      else {
         $sf = $sort_fields['default'];
         $sd = $sort_dirs['default'];
      }
      if ($view['eid'] == '*')
         $envir = '';
      else
         $envir =" and t.envirid = '{$view['eid']}'";
      $sql = "select p.playerid, p.player, p.playerc, p.links, r.result, r.medal, r.ts ".
             "from tmos_results r, tmos_players p, tmos_tracks t ".
             "where r.serverid = {$view['sid']}{$envir} and t.trackid = '{$view['tid']}' ".
               "and r.serverid = p.serverid and r.playerid = p.playerid ".
               "and r.serverid = t.serverid and r.trackid = t.trackid ".
               "order by $sf $sd";
      $data = $this->{$this->funcs['selectpage']}($sql, $view['pagenum'], $view['recperpage']);
      $sql = "select s.server, s.game from tmos_servers s where s.serverid = {$view['sid']}";
      $data['srv'] = $this->{$this->funcs['select']}($sql, -1, -1);
      $sql = "select t.track, t.author, t.authortime, t.gold, t.silver, t.bronze, t.envirid, ".
             "t.nblaps, t.filename, t.uid from tmos_tracks t ".
             "where t.serverid = {$view['sid']} and t.trackid = '{$view['tid']}'{$envir}";
      $data['dscr'] = $this->{$this->funcs['select']}($sql, -1, -1);
      if ($data['dscr']['count'] > 0) {
         $sql = "select coalesce(min(r.result), '00:00:00.00') as br from tmos_results r ".
                "where r.serverid = {$view['sid']} and r.trackid = '{$view['tid']}'";
         $data['dscr'][0]['br'] = $this->{$this->funcs['select']}($sql, -1, -1, 0);
         $data['dscr'][0]['br'] = $data['dscr'][0]['br'][0]['br'];
      }
      $sql = "select count(*) as tr from tmos_results r, tmos_tracks t ".
             "where r.serverid = {$view['sid']} and r.trackid = '{$view['tid']}'{$envir} ".
               "and r.serverid = t.serverid and r.trackid = t.trackid";
      $data['count_total'] = $this->{$this->funcs['select']}($sql, -1, -1);
      $data['count_total'] = $data['count_total'][0]['tr'];

      return $data;
   }

   function view_clans(&$aview) {
      $view = $this->view_work($aview);

      $sort_fields = array("clan"=>"c.clanc",
                           "score"=>"s.score",
                           "mc" => "c.mc",
                           "am"=>"s.am",
                           "gm"=>"s.gm",
                           "sm"=>"s.sm",
                           "bm"=>"s.bm",
                           "fc"=>"s.fc",
                           "default"=>"score");
      $sort_dirs = array("desc"=>"desc",
                         "asc"=>"asc",
                         "default"=>"desc");
      if (isset($sort_dirs[$view['sortdir']]))
         $sd = $sort_dirs[$view['sortdir']];
      else
         $sd = $sort_dirs['default'];
      if (isset($sort_fields[$view['sortfield']]))
         $sf = $sort_fields[$view['sortfield']];
      else {
         $sf = $sort_fields['default'];
         $sd = $sort_dirs['default'];
      }
      if ($view['query'] == "*")
         $query = '';
      else
         $query = " and c.clanc like '{$view['query']}'";
      $sql = "select c.clanid, c.clanc, c.description, c.members, c.mc, s.am, ".
                    "s.gm, s.sm, s.bm, s.fc, s.score ".
             "from tmos_clans c, tmos_scores s ".
             "where c.serverid = {$view['sid']} and s.envirid = '{$view['eid']}' ".
               "and c.serverid = s.serverid and c.clanid = s.ownerid{$query} order by $sf $sd";
      $data = $this->{$this->funcs['selectpage']}($sql, $view['pagenum'], $view['recperpage']);
      $sql = "select s.server, s.game from tmos_servers s where s.serverid = {$view['sid']}";
      $data['srv'] = $this->{$this->funcs['select']}($sql, -1, -1);
      $sql = "select count(*) as tc from tmos_clans c, tmos_scores s ".
             "where c.serverid = {$view['sid']} and s.envirid = '{$view['eid']}' ".
               "and c.serverid = s.serverid and c.clanid = s.ownerid{$query}";
      $data['dscr'] = $this->{$this->funcs['select']}($sql, -1, -1);
      $data['count_total'] = $data['dscr'][0]['tc'];  // vsegda

      return $data;
   }
   
   function view_clan(&$aview) {
      $view = $this->view_work($aview);

      $sort_fields = array("player"=>"p.playerc",
                           "am"=>"s.am",
                           "gm"=>"s.gm",
                           "sm"=>"s.sm",
                           "bm"=>"s.bm",
                           "fc"=>"s.fc",
                           "score"=>"s.score",
                           "default"=>"s.score");
      $sort_dirs = array("desc"=>"desc",
                         "asc"=>"asc",
                         "default"=>"desc");
      if (isset($sort_dirs[$view['sortdir']]))
         $sd = $sort_dirs[$view['sortdir']];
      else
         $sd = $sort_dirs['default'];
      if (isset($sort_fields[$view['sortfield']]))
         $sf = $sort_fields[$view['sortfield']];
      else {
         $sf = $sort_fields['default'];
         $sd = $sort_dirs['default'];
      }
      $sql = "select c.clanc, c.description, c.members, c.mc ".
             "from tmos_clans c ".
             "where c.serverid = {$view['sid']} and c.clanid = '{$view['cid']}'";
      $buf = $this->{$this->funcs['select']}($sql, -1, -1);
      if ($buf['count'] > 0) $members = $buf[0]['members'];
      else $members = "''";
      $sql = "select p.playerid, p.player, p.playerc, p.links, s.am, s.gm, s.sm, s.bm, s.fc, s.score ".
             "from tmos_players p, tmos_scores s, tmos_clans c ".
             "where c.serverid = {$view['sid']} and c.clanid = '{$view['cid']}' ".
               "and s.envirid = '{$view['eid']}' ".
               "and p.playerid in ($members) and c.serverid = p.serverid ".
               "and p.serverid = s.serverid and p.playerid = s.ownerid order by $sf $sd";
      $data = $this->{$this->funcs['selectpage']}($sql, $view['pagenum'], $view['recperpage']);
      $sql = "select s.server, s.game from tmos_servers s where s.serverid = {$view['sid']}";
      $data['srv'] = $this->{$this->funcs['select']}($sql, -1, -1);
      $data['dscr'] = $buf;
      if ($data['dscr']['count'] > 0)
         $data['count_total'] = $data['dscr'][0]['mc'];
      else
         $data['count_total'] = 0;

      return $data;
   }

   function view_userbars(&$aview) {
      $view = $this->view_work($aview);

      $sql = "select s.server, s.game from tmos_servers s where s.serverid = {$view['sid']}";
      $data = $this->{$this->funcs['select']}($sql, -1, -1);

      return $data;
   }
   
   function view_userbar_t1(&$aview) {
      $view = $this->view_work($aview);

      $sql = "select srv.serverc, srv.lastupdate, p.playerc, s.score, s.rank ".
             "from tmos_servers srv, tmos_players p, tmos_scores s ".
             "where srv.serverid = {$view['sid']} and p.playerid = '{$view['pid']}' ".
               "and s.envirid = '*' and srv.serverid = p.serverid ".
               "and p.serverid = s.serverid and p.playerid = s.ownerid";
      $data = $this->{$this->funcs['select']}($sql, -1, -1);

      return $data;
   }

   function view_userbar_t2(&$aview) {
      $view = $this->view_work($aview);

      $sql = "select s.serverc, s.lastupdate, p.playerc ".
             "from tmos_servers s, tmos_players p ".
             "where s.serverid = {$view['sid']} and p.playerid = '{$view['pid']}' ".
               "and p.serverid = s.serverid";
      $data = $this->{$this->funcs['select']}($sql, -1, -1);
      if ($data['count'] > 0) {
         $sql = "select s.envirid, s.rank from tmos_scores s ".
                "where s.serverid = {$view['sid']} and s.ownerid = '{$view['pid']}'";
         $buf = $this->{$this->funcs['select']}($sql, "envirid", -1);
         foreach(envirs() as $eid) {
            if (!isset($buf[$eid]))
               $data[0][$eid] = '-';
            else
               $data[0][$eid] = $buf[$eid]['rank'];
         }
      }

      return $data;
   }

   function view_userbar_t3(&$aview) {
      $view = $this->view_work($aview);
      
      // like http://www.gametracker.com ???
      
      return -1;
   }
   
   function plug_lu(&$view) {
      $sql = "select lastupdate from tmos_servers where serverid = {$view['sid']}";
      $data = $this->{$this->funcs['select']}($sql, -1, -1);

      return $data;
   }
   
   function plug_top10(&$view) {
      $sql = "select s.rank, s.score, p.player from tmos_players p, tmos_scores s ".
             "where s.serverid = {$view['sid']} and s.envirid = '{$view['eid']}' ".
               "and p.serverid = s.serverid and p.playerid = s.ownerid ".
             "order by s.score desc";
      $data = $this->{$this->funcs['selectpage']}($sql, $view['pagenum'], $view['recperpage']);
      $sql = "select s.rank, s.score, p.player from tmos_players p, tmos_scores s ".
             "where s.serverid = {$view['sid']} and s.ownerid = '{$view['pid']}' ".
               "and s.envirid = '{$view['eid']}' ".
               "and p.serverid = s.serverid and p.playerid = s.ownerid";
      $data['player'] = $this->{$this->funcs['select']}($sql, -1, -1);

      return $data;
   }

   function plug_recs(&$view) {
      $sql = "select r.fp, r.result, p.player from tmos_results r, tmos_players p ".
             "where r.serverid = {$view['sid']} and r.trackid = '{$view['tid']}' ".
               "and p.serverid = r.serverid and p.playerid = r.playerid ".
             "order by result";
      $data = $this->{$this->funcs['selectpage']}($sql, $view['pagenum'], $view['recperpage']);
      $sql = "select r.fp, r.result, p.player from tmos_results r, tmos_players p ".
             "where r.serverid = {$view['sid']} and r.trackid = '{$view['tid']}' ".
               "and r.playerid = '{$view['pid']}' ".
               "and p.serverid = r.serverid and p.playerid = r.playerid";
      $data['player'] = $this->{$this->funcs['select']}($sql, -1, -1);

      return $data;
   }

   function plug_tt(&$view) {
      $sql = "select t.track, t.bronze, t.silver, t.gold, t.authortime ".
             "from tmos_tracks t ".
             "where t.serverid = {$view['sid']} and t.trackid = '{$view['tid']}'";
      $data = $this->{$this->funcs['select']}($sql, -1, -1);
      $sql = "select r.result, p.player from tmos_results r, tmos_players p ".
             "where r.serverid = {$view['sid']} and r.trackid = '{$view['tid']}' ".
               "and r.playerid = '{$view['pid']}' ".
               "and p.serverid = r.serverid and p.playerid = r.playerid";
      $data['player'] = $this->{$this->funcs['select']}($sql, -1, -1);

      return $data;
   }

   function plug_teams(&$view) {
      $sql = "select s.rank, s.score, c.mc, c.clanc ".
             "from tmos_scores s, tmos_clans c ".
             "where s.serverid = {$view['sid']} and s.envirid = '{$view['eid']}' ".
               "and c.serverid = s.serverid and c.clanid = s.ownerid ".
             "order by score desc";
      $data = $this->{$this->funcs['selectpage']}($sql, $view['pagenum'], $view['recperpage']);

      return $data;
   }

   function plug_stats(&$view) {
      $sql = "select p.player, s.am, s.gm, s.sm, s.bm, s.fc, s.score, s.rank ".
             "from tmos_scores s, tmos_players p ".
             "where s.serverid = {$view['sid']} and s.ownerid = '{$view['pid']}' ".
               "and s.envirid = '{$view['eid']}' and p.serverid = s.serverid ".
               "and p.playerid = s.ownerid";
      $data = $this->{$this->funcs['select']}($sql, -1, -1);
      if ($data['count'] > 0) {
         $data[0]['ft'] = $data[0]['am'] + $data[0]['gm'] +
                          $data[0]['sm'] + $data[0]['bm'] +
                          $data[0]['fc'];
         $sql = "select count(r.trackid) as fp from tmos_results r, tmos_tracks t ".
                "where r.serverid = {$view['sid']} and r.playerid = '{$view['pid']}' ".
                  ($view['eid'] == '*' ? "" : " and t.envirid = '{$view['eid']}' ").
                  "and r.serverid = t.serverid and r.trackid = t.trackid and r.fp = 1";
         $data[0]['fp'] = $this->{$this->funcs['select']}($sql, -1, -1);
         $data[0]['fp'] = $data[0]['fp'][0]['fp'];
         $sql = "select sum(r.fp) as afp from tmos_results r, tmos_tracks t ".
                "where r.serverid = {$view['sid']} and r.playerid = '{$view['pid']}' ".
                  ($view['eid'] == '*' ? "" : " and t.envirid = '{$view['eid']}'").
                  "and r.serverid = t.serverid and r.trackid = t.trackid";
         $data[0]['afp'] = $this->{$this->funcs['select']}($sql, -1, -1, 0);
         $data[0]['afp'] = $data[0]['afp'][0]['afp']/$data[0]['ft'];
      }
      
      return $data;
   }

   function plug_srv(&$view) {
      $sql = "select server from tmos_servers where serverid = {$view['sid']}";
      $data = $this->{$this->funcs['select']}($sql, -1, -1);
      $sql = "select count(p.playerid) as tp, coalesce(sum(s.am+s.gm+s.sm+s.bm), 0) as tm ".
             "from tmos_players p, tmos_scores s ".
             "where p.serverid = {$view['sid']} and s.envirid = '{$view['eid']}' ".
               "and p.serverid = s.serverid and p.playerid = s.ownerid";
      $buf = $this->{$this->funcs['select']}($sql, -1, -1);
      $data[0]['tp'] = $buf[0]['tp'];
      $data[0]['tm'] = $buf[0]['tm'];
      $sql = "select count(distinct t.trackid) as tt ".
             "from tmos_tracks t, tmos_results r ".
             "where t.serverid = {$view['sid']} and t.serverid = r.serverid ".
               "and t.trackid = r.trackid".
               ($view['eid'] == '*' ? "" : " and t.envirid = '{$view['eid']}'");
      $buf = $this->{$this->funcs['select']}($sql, -1, -1);
      $data[0]['tt'] = $buf[0]['tt'];
      $sql = "select count(c.clanid) as tc from tmos_clans c, tmos_scores s ".
             "where c.serverid = '{$view['sid']}' and c.serverid = s.serverid ".
               "and c.clanid = s.ownerid and s.envirid = '{$view['eid']}'";
      $buf = $this->{$this->funcs['select']}($sql, -1, -1);
      $data[0]['tc'] = $buf[0]['tc'];
      
      return $data;
   }

} // class