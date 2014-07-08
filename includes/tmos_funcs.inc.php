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

define("DIR_FILES", "./files/");
define("DIR_CSS", "./css/");
define("DIR_CACHE", "./cache/");
define("DIR_SQL", "./sql/");
define("DIR_FONTS", "./gfx/fonts/");
define("DIR_USERBARS", "./gfx/userbars/");
define("FN_CFG", "./tmos_config.php");
define("FN_CFGMP", "./tmos_config_mp.php");
define("UB_QUERY_DELIM", "/");  // set to "?" if don't work

function id_get($str) {
   return substr(md5($str), 0, 11);
}

function envir_toid($envir) {
   switch (strtolower($envir)) {
      case 'overall': $result = '*'; break;
      case 'stadium': $result = 'a'; break;
      case 'island' : $result = 'b'; break;
      case 'bay'    : $result = 'c'; break;
      case 'coast'  : $result = 'd'; break;
      case 'alpine' : $result = 'e'; break;
      case 'rally'  : $result = 'f'; break;
      case 'speed'  : $result = 'g'; break;
      default : $result = '!'; break;
   }
   return $result;
}

function envir_fromid($envirid) {
   switch ($envirid) {
      case '*' : $result = 'Overall'; break;
      case 'a' : $result = 'Stadium'; break;
      case 'b' : $result = 'Island'; break;
      case 'c' : $result = 'Bay'; break;
      case 'd' : $result = 'Coast'; break;
      case 'e' : $result = 'Alpine'; break;
      case 'f' : $result = 'Rally'; break;
      case 'g' : $result = 'Speed'; break;
      default : $result = '???'; break;
   }
   return $result;
}

function envirs() {
   return array('*', 'a', 'b', 'c', 'd', 'e', 'f', 'g', '!');
}

function game_fromenvir($ver, $envir) {
   $ver = strtolower($ver);
   $envir = strtolower($envir);
   if ($ver == "tmc.6")
      $result = 'u';
   else if ($envir == 'stadium')
      $result = 'n';
   else if ($envir == 'island' || 
            $envir == 'bay' || 
            $envir == 'coast')
      $result = 's';
   else if ($envir == 'alpine' || 
            $envir == 'rally' || 
            $envir == 'speed')
      $result = 'o';
   else
      $result = '?';
   return $result;
}

function game_tocut($game) {
   switch ($game) {
      case 'Original':
      case 'o':  $result = 'TMO'; break;
      case 'Sunrise':
      case 's':  $result = 'TMS'; break;
      case 'Nations':
      case 'n':  $result = 'TMN'; break;
      case 'United':
      case 'u':  $result = 'TMU'; break;
      case 'United Forever':
      case 'uf': $result = 'TMUF'; break;
      case 'Nations Forever':
      case 'nf': $result = 'TMNF'; break;
      default : $result = '?'; break;
   }
   return $result;
}

function game_toid($game) {
   switch ($game) {
      case 'Original': $result = 'o'; break;
      case 'Sunrise': $result = 's'; break;
      case 'Nations': $result = 'n'; break;
      case 'United': $result = 'u'; break;
      case 'United Forever': $result = 'uf'; break;
      case 'Nations Forever': $result = 'nf'; break;
      default: $result = '?'; break;
   }
   return $result;
}

function game_fromid($gameid) {
   switch ($gameid) {
      case 'o':  $result = 'Original'; break;
      case 's':  $result = 'Sunrise'; break;
      case 'n':  $result = 'Nations'; break;
      case 'u':  $result = 'United'; break;
      case 'uf': $result = 'United Forever'; break;
      case 'nf': $result = 'Nations Forever'; break;
      default :  $result = '???'; break;
   }
   return $result;
}

function games() {
   return array("o"=>"Original",
                "s"=>"Sunrise",
                "n"=>"Nations",
                "u"=>"United",
                "nf"=>"Nations Forever",
                "uf"=>"United Forever");
}

function config_mp_load() {
   require(FN_CFGMP);
   // protect from dummies ?
   if (!isset($cfg_autofindclans) ||
       !isset($cfg_players) ||
       !isset($cfg_players_ignorelist) ||
       !isset($cfg_autofindclans) ||
       !isset($cfg_clans) ||
       !isset($cfg_clans_ignorelist) ||
       !isset($cfg_tracks_ignorelist))
      die ("File \"tmos_config_mp.php\" is corrupted, replace him with entire version");

   $cfg['afc'] = $cfg_autofindclans;
   $cfg['cil'] = array(); // clans, ignorelist
   $cfg['ctl'] = array(); // clans, tags
   $cfg['pil'] = array(); // players, ignoreslist
   $cfg['pul'] = array(); // players, unite
   $cfg['til'] = array(); // tracks, ignorelist

   foreach ($cfg_clans_ignorelist as $value) {
      $cfg['cil'][id_get(strtolower(name_clear($value)))] = true;
   }
   foreach ($cfg_clans as $key=>$value) {
      $clan_id = id_get(strtolower(name_clear($key)));
      $cfg['ctl'][$clan_id]['tag'] = $key;
      if (isset($value['description']))
         $cfg['ctl'][$clan_id]['descr'] = $value['description'];
      else
         $cfg['ctl'][$clan_id]['descr'] = "";
      if (isset($value['autofindmembers']))
          $cfg['ctl'][$clan_id]['afm'] = $value['autofindmembers'];
      else
          $cfg['ctl'][$clan_id]['afm'] = true;
      $cfg['ctl'][$clan_id]['members'] = array();
      if (isset($value['members'])) {
         $tmp = preg_split('/;/u', $value['members'], -1, PREG_SPLIT_NO_EMPTY);
         for ($i = 0; $i < sizeof($tmp); $i++)
            $cfg['ctl'][$clan_id]['members'][name_clear($tmp[$i])] = true;
      }
   }
   foreach ($cfg_players as $key=>$value) {
      $cfg['pul'][id_get(name_clear($key))] = id_get(name_clear($value));
   }
   foreach ($cfg_players_ignorelist as $value) {
      $cfg['pil'][id_get(name_clear($value))] = true;
   }
   foreach ($cfg_tracks_ignorelist as $value) {
      $cfg['til'][id_get(trim($value))] = true;
   }

   return $cfg;
}

function params_add($params, $param_new, $delim = "\x01") {
   $param_tmp = trim($param_new);
   if ($param_tmp == '')
      $result = $params;
   else if ($params == '')
      $result = $param_tmp;
   else if (strpos($delim.$params.$delim, $delim.$param_tmp.$delim) === false)
      $result = $params.$delim.$param_tmp;
   else
      $result = $params;
   return $result;
}

// считаем что пустых и не оттримленых алиасов нет
function params_sum($params, $params_new, $delim = "\x01") {
   $result = $params;
   $params_new = explode($delim, $params_new);
   foreach ($params_new as $param_new) {
      if (strpos($delim.$result.$delim, $delim.$param_new.$delim) === false)
         $result = $result.$delim.$param_new;
   }
   return $result;
}

function params_toarray($params, $shuffle = false, $maxcount = 0, $delim = "\x01", $quote = false) {
   $result = preg_split("/$delim/u", trim($params), -1, PREG_SPLIT_NO_EMPTY);
   if ($shuffle)
      shuffle($result);
   $result['count_total'] = count($result);
   $result['count'] = $result['count_total'];
   if ($maxcount != 0 && $maxcount <= $result['count']) {
      for ($i = $maxcount; $i < $result['count']; $i++)
         unset($result[$i]);
      $result['count'] = $maxcount;
   }
   if ($quote)
      for ($i = 0; $i < $result['count']; $i++)
         $result[$i] = trim($result[$i], '\'');
   return $result;
}

function params_fromarray($params, $delim = "\x01", $quote = false) {
   $result = "";
   $quote ? $quote_chr = "'" : $quote_chr = '';
   for ($i = 0; $i < $params['count']-1; $i++) {
      $result .= $quote_chr.$params[$i].$quote_chr.$delim;
   }
   if ($params['count'] > 0)
      $result = $result.$quote_chr.$params[$params['count']-1].$quote_chr;
   return $result;
}

function name_clan_auto_left($name) {
   $matches = array();
   if (preg_match("/^([\p{P}\p{S}]{0,2}[\{\(\<\[\|]{1,1}.{1,10}[\}\)\>\]\|]{1,1}[\p{P}\p{S}]{0,2})/u", $name, $matches)) {}
   else if (preg_match("/^([\p{P}\p{S}]{1,3}[\p{L}\p{N}]{1,10}[\p{P}\p{S}]{1,3})/u", $name, $matches)) {}
   else if (preg_match("/^([\p{L}\p{N}]{1,10}[\p{P}\p{S}]{1,3})/u", $name, $matches)) {}
   if (sizeof($matches) && $matches[1] != $name) {
      return trim($matches[1]);
   }
   return '';
}

function name_clan_auto_right($name) {
   $matches = array();
   if (preg_match("/([\p{P}\p{S}]{0,2}[\{\(\<\[\|]{1,1}.{1,10}[\}\)\>\]\|]{1,1}[\p{P}\p{S}]{0,2})$/u", $name, $matches)) {}
   else if (preg_match("/([\p{P}\p{S}]{1,3}[\p{L}\p{N}]{1,10}[\p{P}\p{S}]{1,3})$/u", $name, $matches)) {}
   else if (preg_match("/([\p{P}\p{S}]{1,3}[\p{L}\p{N}]{1,10})$/u", $name, $matches)) {}
   if (sizeof($matches) && $matches[1] != $name) {
      return trim($matches[1]);
   }
   return '';
}

function name_clan_manual_left($name, $mask) {
   if ($name == "" || $mask == "")
      $result = false;
   else if (strpos(strtolower($name), strtolower($mask)) === 0)
      $result = true;
   else
      $result = false;
   return $result;
}

function name_clan_manual_right($name, $mask) {
   if ($name == "" || $mask == "")
      $result = false;
   else if (strpos(strtolower($name), strtolower($mask)) === strlen($name) - strlen($mask))
      $result = true;
   else
      $result = false;
   return $result;
}

function name_links(&$name, &$links, $delim = "\x01") {
   $buf = preg_replace('/(\$\$)/u', "\x01", $name);
   $buf = preg_split('/(\$[hlpz])/iu', $buf, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
   $name = '';
   $links = '';
   $link = false;
   foreach ($buf as $tok) {
      if ($tok == '$h' || $tok == '$H' ||
          $tok == '$l' || $tok == '$L' ||
          $tok == '$p' || $tok == '$P')
         $link ? $link = false : $link = true;
      else if ($tok == '$z' || $tok == '$Z')
         $link = false;
      else if ($link) {
         $hlbp = strpos($tok, '[');
         $hlep = strrpos($tok, ']');
         $link = "";
         if ($hlbp !== false && $hlep !== false) {
            $link = substr($tok, $hlbp+1, $hlep-$hlbp-1);
            $name .= substr($tok, 0, $hlbp).substr($tok, $hlep+1);
         }
         else if ($hlbp !== false && $hlep === false) {
            $link = substr($tok, $hlbp+1);
            $name .= substr($tok, 0, $hlbp);
         }
         else if ($hlbp === false && $hlep !== false) {
            $links = substr($tok, 0, $hlep);
            $name .= substr($tok, $hlep+1);
         }
         else
            $name .= $tok;
         if ($link != "") {
            if (substr($link, 0, 5) != "http:" &&
                substr($link, 0, 5) != "tmtp:")
               $link = "http://".$link;
            $links = params_add($links, $link, $delim);
         }
      }
      else
         $name .= $tok;
   }
}

function name_clear($name) {
   $buf = preg_replace('/(\$\$)/u', "\x01", $name);
   $buf = preg_replace('/\$[iswnmgto]|\$([0-9a-f]..)/iu', '', $buf);
   $buf = preg_split('/(\$[hlpz])/iu', $buf, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
   $result = '';
   $link = false;
   foreach($buf as $tok) {
      if ($tok == '$h' || $tok == '$H' ||
          $tok == '$l' || $tok == '$L' ||
          $tok == '$p' || $tok == '$P')
         $link ? $link = false : $link = true;
      else if ($tok == '$z' || $tok == '$Z')
         $link = false;
      else if ($link) {
         $hlbp = strpos($tok, '[');
         $hlep = strrpos($tok, ']');
         if ($hlbp !== false && $hlep !== false)
            $result .= substr($tok, 0, $hlbp).substr($tok, $hlep+1);
         else if ($hlbp !== false && $hlep === false)
            $result .= substr($tok, 0, $hlbp);
         else if ($hlbp === false && $hlep !== false)
            $result .= substr($tok, $hlep+1);
         else
            $result .= $tok;
      }
      else
         $result .= $tok;
   }
   return trim(preg_replace("/\x01/u", '$', $result));
}

function name_html($name) {
   $buf = preg_replace(array('/(\$\$)/u', '/(\$[sot])/iu'), array("\x01", ""), $name);
   $buf = preg_split('/(\$[inwgzm])|(\$...)/iu', $buf, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
   $res = '';
   $st_color = '';
   $st_italic = '';
   $st_spacing = '';
   foreach($buf as $tnum=>$tok) {
      if (strcasecmp($buf[$tnum], '$z') == 0) {
         $st_color = '';
         $st_italic = '';
         $st_spacing = '';
      }
      else if (strcasecmp($buf[$tnum], '$g') == 0)
         $st_color = '';
      else if (strcasecmp($buf[$tnum], '$m') == 0)
         $st_spacing = '';
      else if (strcasecmp($buf[$tnum], '$i') == 0) {
         if ($st_italic !== '') $st_italic = '';
         else $st_italic = "font-style:italic;";
      }
      else if (strcasecmp($buf[$tnum], '$w') == 0)
         $st_spacing = "letter-spacing:2;";
      else if (strcasecmp($buf[$tnum], '$n') == 0)
         $st_spacing = "letter-spacing:-1;";
      else if($buf[$tnum][0] == "$") {
         $patterns = array ('/(\$)/', '/([0-9a-f])/iu', '/([^0-9a-f])/iu');
         $replace = array ("", "\${1}0", "00");
         $st_color = "color:#".preg_replace($patterns, $replace, $buf[$tnum]).";";
      }
      else if ("$st_color$st_italic$st_spacing" != "") {
         $res .= "<span style=\"$st_color$st_italic$st_spacing\">";
         $res .= htmlspecialchars($buf[$tnum]);
         $res .= "</span>";
      }
      else {
         $res .= htmlspecialchars($buf[$tnum]);
      }
   }
   return preg_replace("/\x01/u", "$", $res);
}

// xx:xx:xx.xx (1:2.3 -> 00:01:02.30)
function time_full($timestr) {
   preg_match("/(\d{0,2}):{0,1}(\d{0,2}):{0,1}(\d{1,2})\.(\d{1,2})/", '00:'.$timestr, $matches);
   return sprintf("%02d:%02d:%02d.%02d", $matches[1], $matches[2], $matches[3], substr($matches[4].'0', 0, 2));
}

// xx:xx:xx.xx (62300 -> 00:01:02.30)
function time_msectofull($timemsec) {
   if ($timemsec <= 0)
      return "00:00:00.00";
   else {
      $hours =  floor($timemsec/3600000);
      $timemsec -= $hours*3600000;
      $minutes = floor($timemsec/60000);
      $timemsec -= $minutes*60000;
      $seconds = floor($timemsec/1000);
      $msecs = ($timemsec - $seconds*1000)/10;
      return sprintf("%02d:%02d:%02d.%02d", $hours, $minutes, $seconds, $msecs);
   }
}

// xx:xx:xx.xx (62300 -> 1:02.30)
function time_msectocut($timemsec) {
   return time_cut(time_msectofull($timemsec));
}

// xx:xx:xx.xx (00:01:02.30 -> 1:02.30)
function time_cut($timestr) {
   $patterns = array ("/(00:)/", "/^0(\d)(:|\.)/");
   $replace = array ("", "\${1}\${2}");
   return preg_replace($patterns, $replace, $timestr);
}

// msec (00:01:02.30 -> 62300)
function time_fulltomsec($timestr) {
   list($hours, $minutes, $seconds, $msec) = sscanf($timestr, "%2s:%2s:%2s.%2s");
   return ((int)$hours)*3600000 + ((int)$minutes)*60000 + ((int)$seconds)*1000 + ((int)($msec))*10;
}

// $time1 - $time2 (00:01:02.30 - 00:00:32.00 = 30.30)
function time_deltacut($time1, $time2) {
   return time_msectocut(time_fulltomsec($time1) - time_fulltomsec($time2));
}

function ts_format($ts) {
   if ($ts == '-' || $ts == '...') {
      $result = $ts;
   }
   else if (is_numeric($ts)) {
      $result = @date("j-m-Y H:i", $ts);
   }
   else {
      list($year, $month, $day, $hour, $minute, $second) =
         sscanf($ts, "%4s/%2s/%2s %2s:%2s:%s");
      $result = @date("j-m-Y H:i", @mktime($hour, $minute, $second, $month, $day, $year));
   }
   return $result;
}

function float_format($float) {
   return sprintf("%.2f", $float);
}

function file_exists_ex($filename) {
   if (substr($filename, 0, 6) == 'ftp://') {
      $buf = parse_url($filename);
      if (!isset($buf['pass'])) $buf['pass'] = 'ie@';
      if (!isset($buf['user'])) $buf['user'] = 'anonymous';
      if (!isset($buf['port'])) $buf['port'] = 21;
      $buf['file'] = basename($buf['path']);
      $buf['path'] = dirname($buf['path']);
      $ftp = ftp_connect($buf['host'], $buf['port'], 5);
      if (!$ftp) {
         $result = false;
      }
      else {
         if (!ftp_login($ftp, $buf['user'], $buf['pass']) ||
             !ftp_pasv($ftp, true) ||
             !ftp_chdir($ftp, $buf['path']))
            $result = false;
         else {
            if (in_array($buf['file'], ftp_nlist($ftp, '.')))
               $result = true;
            else
               $result = false;
         }
         ftp_close($ftp);
      }
   }
   else
      $result = file_exists($filename);
   return $result;
}

function filesize_ex($filename) {
   if (substr($filename, 0, 6) == 'ftp://') {
      $buf = parse_url($filename);
      if (!isset($buf['pass'])) $buf['pass'] = 'ie@';
      if (!isset($buf['user'])) $buf['user'] = 'anonymous';
      if (!isset($buf['port'])) $buf['port'] = 21;
      $ftp = ftp_connect($buf['host'], $buf['port'], 5);
      if (!$ftp) {
         $result = false;
      }
      else {
         if (!ftp_login($ftp, $buf['user'], $buf['pass']) ||
             !ftp_pasv($ftp, true))
            $result = false;
         else {
            $result = ftp_size($ftp, $buf['path']);
            if ($result == -1) $result = false;
         }
         ftp_close($ftp);
      }
   }
   else
      $result = filesize($filename);
   return $result;
}

function fopen_ex($filename, $mode) { //rb only ?
   if (substr($filename, 0, 6) == 'ftp://') {
      $buf = parse_url($filename);
      if (!isset($buf['pass'])) $buf['pass'] = 'ie@';
      if (!isset($buf['user'])) $buf['user'] = 'anonymous';
      if (!isset($buf['port'])) $buf['port'] = 21;
      $ftp = ftp_connect($buf['host'], $buf['port'], 5);
      if (!$ftp) {
         $result = false;
      }
      else {
         if (!ftp_login($ftp, $buf['user'], $buf['pass']) ||
             !ftp_pasv($ftp, true))
            $result = false;
         else {
            $result = tmpfile();
            $buf = ftp_fget($ftp, $result, $buf['path'], FTP_BINARY);
            if (!$buf) {
               fclose($result);
               $result = false;
            }
            fseek($result, 0);
         }
         ftp_close($ftp);
      }
   }
   else
      $result = fopen($filename, $mode);
   return $result;
}

function fclose_ex($handle) {
   return fclose($handle);
}

function filelist_ftp($ftp, $curr_path, &$files) {
   ftp_chdir($ftp, $curr_path);
   $list = ftp_nlist($ftp, ".");
   foreach ($list as $curr_rec) {
      if ($curr_rec != '.' && $curr_rec != '..') {
         $curr_rec = $curr_path.'/'.$curr_rec;
         $files[] = $curr_rec;
         if (ftp_size($ftp, $curr_rec) == -1)
            filelist_ftp($ftp, $curr_rec, $files);
      }
   }
}

function filelist_hdd($curr_path, $slash, &$files) {
   if (($curr_dir = opendir($curr_path)) !== false) {
      while(($curr_rec = readdir($curr_dir)) !== false) {
         if ($curr_rec != '.' && $curr_rec != '..') {
            $curr_rec = $curr_path.$slash.$curr_rec;
            $files[] = $curr_rec;
            if (is_dir($curr_rec))
               filelist_hdd($curr_rec, $slash, $files);
         }
      }
      closedir($curr_dir);
   }
}
   
function filelist_ex($path, $mask) {
   // prepare data
   $path = rtrim($path, " \\/");
   if ($path == "") $path = ".";
   if (strpos($path, "/") !== false) $slash = "/";
   else if (strpos($path, "\\") !== false) $slash = "\\";
   else if (strstr(PHP_OS, "WIN")) $slash = "\\";
   else $slash = "/";

   // search
   $result = array();
   if (substr($path, 0, 6) == 'ftp://') {
      $buf = parse_url($path);
      if (!isset($buf['pass'])) $buf['pass'] = 'ie@';
      if (!isset($buf['user'])) $buf['user'] = 'anonymous';
      if (!isset($buf['port'])) $buf['port'] = 21;
      $ftp = ftp_connect($buf['host'], $buf['port'], 5);
      if ($ftp) {
         if (ftp_login($ftp, $buf['user'], $buf['pass']) &&
             ftp_pasv($ftp, true))
            filelist_ftp($ftp, $buf['path'], $result);
         ftp_close($ftp);
      }
      foreach ($result as $id=>$filename)
         $result[$id] = $buf['scheme'].'://'.$buf['user'].':'.
                        $buf['pass'].'@'.$buf['host'].$filename;
   }
   else {
      filelist_hdd($path, $slash, $result);
   }

   // filter
   foreach ($result as $id=>$filename) {
      if (!preg_match("/^$mask$/i", $filename))
         unset($result[$id]);
   }
   return $result;
}

function filedscr_ex($filename, $opentag, $closetag, $striptags = true) {
   if (($fp = fopen_ex($filename, 'rb')) !== false) {
      $buf = fread($fp, 4096);
      fclose_ex($fp);
      $begpos = strpos($buf, $opentag);
      $endpos = strpos($buf, $closetag);
      if($begpos !== false && $endpos !== false)
         $result = substr($buf, $begpos,
                          $endpos - $begpos + strlen($closetag));
      else 
         $result = -1;
   }
   else
      $result = -1;
   if ($result != -1 && $striptags == true)
      $result = substr($result, strlen($opentag),
                       -strlen($closetag));
   return $result;
}

function logfiles_split($logfiles, $setnull) {
   $result = params_toarray($logfiles);
   for ($i = 0; $i < $result['count']; $i++) {
      $tmp = explode("*", $result[$i]);
      $result[$i] = array("filename" => $tmp[0]);
      if (strlen($result[$i]['filename']) > 40)
         $result[$i]['shortname'] = "...".substr($result[$i]['filename'], -40);
      else
         $result[$i]['shortname'] = $result[$i]['filename'];
      if (count($tmp) < 4 || $setnull) {
         $result[$i]['pos'] = 0;
         $result[$i]['strmd5'] = "x";
         $result[$i]['tid'] = "x";
      }
      else {
         $result[$i]['pos'] = $tmp[1];
         $result[$i]['strmd5'] = $tmp[2];
         $result[$i]['tid'] = $tmp[3];
      }
   }
   return $result;
}

function logfiles_merge($logfiles, $setnull) {
   $result['count'] = $logfiles['count'];
   for ($i = 0; $i < $logfiles['count']; $i++) {
      if ($setnull)
         $result[$i] = $logfiles[$i]['filename']."*0*x*x";
      else
         $result[$i] = $logfiles[$i]['filename']."*".
                       $logfiles[$i]['pos']."*".
                       $logfiles[$i]['strmd5']."*".
                       $logfiles[$i]['tid'];
   }
   return params_fromarray($result);
}

function logfiles_fromstr($logfiles) {
   $result = '';
   $tmp = preg_split('/;/', $logfiles, -1, PREG_SPLIT_NO_EMPTY);
   for ($i = 0; $i < count($tmp); $i++)
      $result = params_add($result, $tmp[$i]."*0*x*x");
   return $result;
}

function logfiles_tostr($logfiles) {
   $result = '';
   $tmp = params_toarray($logfiles);
   for ($i = 0; $i < $tmp['count']; $i++) {
      $tmp[$i] = explode("*", $tmp[$i]);
      $result .= $tmp[$i][0].';';
   }
   return substr($result, 0, -1);
}

function logfiles_test($logfiles, $split = true) {
   clearstatcache();
   if ($split)
      $result = logfiles_split($logfiles, false);
   else
      $result = $logfiles;
   $result['errors'] = false;
   for ($i = 0; $i < $result['count']; $i++) {
      $result[$i]['status'] = (@file_exists_ex($result[$i]['filename']));
      $result[$i]['filesize'] = @filesize_ex($result[$i]['filename']);
      if ($result[$i]['filesize'] === false) $result[$i]['filesize'] = "?";
      if (!$result[$i]['status'])
         $result['errors'] = true;
   }
   return $result;
}

function trackdirs_split($trackdirs) {
   $result = params_toarray($trackdirs);
   for ($i = 0; $i < $result['count']; $i++) {
      $result[$i] = array("directory" => $result[$i]);
      if (strlen($result[$i]['directory']) > 40)
         $result[$i]['shortname'] = "...".substr($result[$i]['directory'], -40);
      else
         $result[$i]['shortname'] = $result[$i]['directory'];
   }
   return $result;
}

function trackdirs_tostr($trackdirs) {
   $result = '';
   $tmp = params_toarray($trackdirs);
   for ($i = 0; $i < $tmp['count']; $i++) {
      $result .= $tmp[$i].';';
   }
   return substr($result, 0, -1);
}

function trackdirs_fromstr($trackdirs) {
   $result = '';
   $tmp = preg_split('/;/', $trackdirs, -1, PREG_SPLIT_NO_EMPTY);
   for ($i = 0; $i < count($tmp); $i++)
      $result = params_add($result, $tmp[$i]);
   return $result;
}

function trackdirs_test($trackdirs, $split = true) {
   clearstatcache();
   if ($split)
      $result = trackdirs_split($trackdirs);
   else
      $result = $trackdirs;
   $result['errors'] = false;
   for ($i = 0; $i < $result['count']; $i++) {
      $result[$i]['status'] = @file_exists_ex($result[$i]['directory']);
      if (!$result[$i]['status'])
         $result['errors'] = true;
   }
   return $result;
}

function userbars_load($ubid) {
   $list = @filelist_ex(DIR_USERBARS, ".*tmosub_.*\.png");
   $result = array();
   foreach ($list as $filename) {
      if (preg_match('/tmosub_(\d{4})_(.{1,2})_(.{1,2})_(.+)_(\d+)_'.
                     '([0-9a-z]{6})_(.+)_(\d+)_([0-9a-z]{6})\.png/i',
                    basename($filename), $buf))
         $result[$buf[1]] = array(
            "file"=>$buf[0], "ubid"=>$buf[1], "game"=>$buf[2],
            "ubt"=>$buf[3], "font1"=>$buf[4], "size1"=>$buf[5],
            "color1"=>$buf[6], "font2"=>$buf[7], "size2"=>$buf[8],
            "color2"=>$buf[9]);
   }
   if ($ubid != "" && isset($result[$ubid]))
      $result = $result[$ubid];
   else if ($ubid != "")
      $result = -1;
   else
      asort($result);
   return $result;
}

function languages_load($dscr) {
   $list = @filelist_ex("./includes/", ".*tmos_lang_.*\.inc\.php");
   $result = array("count"=>0);
   foreach ($list as $filename) {
      if (preg_match('/tmos_lang_([0-9a-z]{1,10})\.inc\.php/i',
                    basename($filename), $buf)) {
         if ($dscr == true) {
            $result[$result['count']] = array("lng"=>$buf[1],
                                              "dscr"=>@filedscr_ex($filename, "<dscr>", "</dscr>"));
         }
         else
            $result[$result['count']] = $buf[1];
         $result['count']++;
      }
   }
   return $result;
}

function css_load($dscr) {
   $list = @filelist_ex(DIR_CSS, ".*tmos_.*\.css");
   $result = array("count"=>0);
   foreach ($list as $filename) {
      if (preg_match('/tmos_.+\.css/i',
                    basename($filename), $buf)) {
         if ($dscr == true) {
            $result[$result['count']] = array("css"=>$buf[0],
                                              "dscr"=>@filedscr_ex($filename, "<dscr>", "</dscr>"));
         }
         else
            $result[$result['count']] = $buf[0];
         $result['count']++;
      }
   }
   return $result;
}

function tmpl_replace($content, $data) {
   $result = $content;
   krsort($data);
   foreach ($data as $key=>$value) {
      $result = str_replace('#'.$key, $value, $result);
   }
   return $result;
}

function tmpl_null($cd_null = '&nbsp;', $cd_count = 100) {
   $result = array();
   for ($i = 1; $i < $cd_count; $i++)
      $result['data_'.$i] = $cd_null;
   return $result;
}

function config_load() {
   $cfg = array();

   require(FN_CFG);

   if (!isset($cfg['dbhost'])             || !is_string($cfg['dbhost']))             $cfg['dbhost'] = "localhost";
   if (!isset($cfg['dbtype'])             || !is_string($cfg['dbtype']))             $cfg['dbtype'] = "mysql";
   if (!isset($cfg['dbname'])             || !is_string($cfg['dbname']))             $cfg['dbname'] = "tmostats";
   if (!isset($cfg['dblogin'])            || !is_string($cfg['dblogin']))            $cfg['dblogin'] = "root";
   if (!isset($cfg['dbpassword'])         || !is_string($cfg['dbpassword']))         $cfg['dbpassword'] = "";
   if (!isset($cfg['defaultlanguage'])    || !is_string($cfg['defaultlanguage']))    $cfg['defaultlanguage'] = "eng";
   if (!isset($cfg['defaultcolorscheme']) || !is_string($cfg['defaultcolorscheme'])) $cfg['defaultcolorscheme'] = "tmos_default.css";
   if (!isset($cfg['defaultrecperpage'])  || !is_numeric($cfg['defaultrecperpage'])
                                          || $cfg['defaultrecperpage'] < 10)         $cfg['defaultrecperpage'] = 100;
   if (!isset($cfg['javascript'])         || !is_bool($cfg['javascript']))           $cfg['javascript'] = true;
   if (!isset($cfg['servertimeout'])      || !is_numeric($cfg['servertimeout'])
                                          || $cfg['servertimeout'] < 1)              $cfg['servertimeout'] = 2;
   if (!isset($cfg['showsingleserver'])   || !is_bool($cfg['showsingleserver']))     $cfg['showsingleserver'] = false;
   if (!isset($cfg['showmonitoring'])     || !is_bool($cfg['showmonitoring']))       $cfg['showmonitoring'] = true;
   if (!isset($cfg['showclans'])          || !is_bool($cfg['showclans']))            $cfg['showclans'] = true;
   if (!isset($cfg['showuserbars'])       || !is_bool($cfg['showuserbars']))         $cfg['showuserbars'] = true;
   if (!isset($cfg['showpreferences'])    || !is_bool($cfg['showpreferences']))      $cfg['showpreferences'] = true;
   if (!isset($cfg['showlinks'])          || !is_bool($cfg['showlinks']))            $cfg['showlinks'] = true;
   if (!isset($cfg['showdownloads'])      || !is_bool($cfg['showdownloads']))        $cfg['showdownloads'] = true;
   if (!isset($cfg['htmlcache'])          || !is_string($cfg['htmlcache']))          $cfg['htmlcache'] = "no";
   if (!isset($cfg['gzipcompression'])    || !is_bool($cfg['gzipcompression']))      $cfg['gzipcompression'] = false;
   if (!isset($cfg['minclansize'])        || !is_numeric($cfg['minclansize'])
                                          || $cfg['minclansize'] < 2)                $cfg['minclansize'] = 2;
   if (!isset($cfg['amscore'])            || !is_numeric($cfg['amscore'])
                                          || $cfg['amscore'] < 0)                    $cfg['amscore'] = 1;
   if (!isset($cfg['gmscore'])            || !is_numeric($cfg['gmscore']) 
                                          || $cfg['gmscore'] < 0)                    $cfg['gmscore'] = 0;
   if (!isset($cfg['smscore'])            || !is_numeric($cfg['smscore'])
                                          || $cfg['smscore'] < 0)                    $cfg['smscore'] = 0;
   if (!isset($cfg['bmscore'])            || !is_numeric($cfg['bmscore']) 
                                          || $cfg['bmscore'] < 0)                    $cfg['bmscore'] = 0;
   if (!isset($cfg['finishscore'])        || !is_numeric($cfg['finishscore'])
                                          || $cfg['finishscore'] < 0)                $cfg['finishscore'] = 0;
   if (!isset($cfg['adminpass'])          || !is_string($cfg['adminpass']))          $cfg['adminpass'] = "1";

   return $cfg;
}

function config_save($cfg) {
   if (($fp = @fopen(FN_CFG, "wb")) !== false) {
      // preformat
      $cfg['javascript'] ? $cfg['javascript'] = "true" : $cfg['javascript'] = "false";
      $cfg['showsingleserver'] ? $cfg['showingleserver'] = "true" : $cfg['showsingleserver'] = "false";
      $cfg['showmonitoring'] ? $cfg['showmonitoring'] = "true" : $cfg['showmonitoring'] = "false";
      $cfg['showclans'] ? $cfg['showclans'] = "true" : $cfg['showclans'] = "false";
      $cfg['showuserbars'] ? $cfg['showuserbars'] = "true" : $cfg['showuserbars'] = "false";
      $cfg['showpreferences'] ? $cfg['showpreferences'] = "true" : $cfg['showpreferences'] = "false";
      $cfg['showlinks'] ? $cfg['showlinks'] = "true" : $cfg['showlinks'] = "false";
      $cfg['showdownloads'] ? $cfg['showdownloads'] = "true" : $cfg['showdownloads'] = "false";
      $cfg['gzipcompression'] ? $cfg['gzipcompression'] = "true" : $cfg['gzipcompression'] = "false";

$tmos_config = <<<EOD
<?php
// TM Offline Stats v1.0

// db settings
\$cfg['dbhost'] = '{$cfg['dbhost']}';
\$cfg['dbtype'] = '{$cfg['dbtype']}';
\$cfg['dbname'] = '{$cfg['dbname']}';
\$cfg['dblogin'] = '{$cfg['dblogin']}';
\$cfg['dbpassword'] = '{$cfg['dbpassword']}';

// interface settings
\$cfg['defaultlanguage'] = '{$cfg['defaultlanguage']}';
\$cfg['defaultcolorscheme'] = '{$cfg['defaultcolorscheme']}';
\$cfg['defaultrecperpage'] = {$cfg['defaultrecperpage']};
\$cfg['javascript'] = {$cfg['javascript']};
\$cfg['servertimeout'] = {$cfg['servertimeout']};
\$cfg['showsingleserver'] = {$cfg['showsingleserver']};
\$cfg['showmonitoring'] = {$cfg['showmonitoring']};
\$cfg['showclans'] = {$cfg['showclans']};
\$cfg['showuserbars'] = {$cfg['showuserbars']};
\$cfg['showpreferences'] = {$cfg['showpreferences']};
\$cfg['showlinks'] = {$cfg['showlinks']};
\$cfg['showdownloads'] = {$cfg['showdownloads']};
\$cfg['htmlcache'] = '{$cfg['htmlcache']}';
\$cfg['gzipcompression'] = {$cfg['gzipcompression']};

// parse settings
\$cfg['minclansize'] = {$cfg['minclansize']};
\$cfg['amscore'] = {$cfg['amscore']};
\$cfg['gmscore'] = {$cfg['gmscore']};
\$cfg['smscore'] = {$cfg['smscore']};
\$cfg['bmscore'] = {$cfg['bmscore']};
\$cfg['finishscore'] = {$cfg['finishscore']};

// admin password
\$cfg['adminpass'] = '{$cfg['adminpass']}';
?>
EOD;
      // save
      if (@fwrite($fp, $tmos_config) !== false) $result = true;
      else $result = false;
      fclose ($fp);
   }
   else
      $result = false;
   return $result;
}

function getmicrotime() {
    list($usec, $sec) = explode(" ", microtime()); 
    return ((float)$usec + (float)$sec);
}

?>