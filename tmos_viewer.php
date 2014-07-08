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

require_once "includes/tmos_funcs.inc.php";
require_once "includes/tmos_db.inc.php";
require_once "includes/tmos_si.inc.php";

class Ttmos_Viewer {
   var $cfg;
   var $view;
   var $it;
   var $ct;
   var $content;
   var $db;

   function Ttmos_Viewer() {
      $this->cfg = null;
      $this->view = null;
      $this->it = null;
      $this->ct = null;
      $this->content = null;
      $this->db = null;
   }

   function clear() {
      unset($this->cfg);
      unset($this->view);
      unset($this->ct);
      unset($this->it);
      unset($this->content);
      unset($this->db);
   }


   function get_params() {
      // del magic quotes
      if (function_exists('set_magic_quotes_runtime'))
         @set_magic_quotes_runtime(0);
      if (get_magic_quotes_gpc() == 1) {
         foreach($_POST as $key=>$value)
            $_POST[$key] = stripslashes($value);
         foreach($_GET as $key=>$value)
            $_GET[$key] = stripslashes($value);
         foreach($_COOKIE as $key=>$value)
            $_COOKIE[$key] = stripslashes($value);
      }
      // for IIS ???
      if (!isset($_SERVER['REQUEST_URI'])) {
         $arr = explode("/", $_SERVER['PHP_SELF']);
         $_SERVER['REQUEST_URI'] = "/" . $arr[count($arr)-1];
         if ($_SERVER['argv'][0]!="")
         $_SERVER['REQUEST_URI'] .= "?" . $_SERVER['argv'][0];
      }

      // cfg
      //$this->cfg = config_load(); // process!
      // action
      if(isset($_GET['action'])) $this->view['action'] = $_GET['action'];
      else if(isset($_POST['action'])) $this->view['action'] = $_POST['action'];
      else $this->view['action'] = "servers";
      // sid
      if(isset($_GET['sid'])) $this->view['sid'] = $_GET['sid'];
      else if(isset($_POST['sid'])) $this->view['sid'] = $_POST['sid'];
      else $this->view['sid'] = -1;
      // pid
      if(isset($_GET['pid'])) $this->view['pid'] = $_GET['pid'];
      else if(isset($_POST['pid'])) $this->view['pid'] = $_POST['pid'];
      else $this->view['pid'] = -1;
      // tid
      if(isset($_GET['tid'])) $this->view['tid'] = $_GET['tid'];
      else if(isset($_POST['tid'])) $this->view['tid'] = $_POST['tid'];
      else $this->view['tid'] = -1;
      // eid
      if(isset($_GET['eid'])) $this->view['eid'] = $_GET['eid'];
      else if(isset($_POST['eid'])) $this->view['eid'] = $_POST['eid'];
      else $this->view['eid'] = '*';
      // cid
      if(isset($_GET['cid'])) $this->view['cid'] = $_GET['cid'];
      else if(isset($_POST['cid'])) $this->view['cid'] = $_POST['cid'];
      else $this->view['cid'] = -1;
      // page
      if(isset($_GET['pagenum'])) $this->view['pagenum'] = $_GET['pagenum'];
      else if(isset($_POST['pagenum'])) $this->view['pagenum'] = $_POST['pagenum'];
      else $this->view['pagenum'] = 1;
      if (!is_numeric($this->view['pagenum'])) $this->view['pagenum'] = 1;
      // sort
      if(isset($_GET['sortfield'])) $this->view['sortfield'] = $_GET['sortfield'];
      else if(isset($_POST['sortfield'])) $this->view['sortfield'] = $_POST['sortfield'];
      else $this->view['sortfield'] = "default";
      // dir
      if(isset($_GET['sortdir'])) $this->view['sortdir'] = $_GET['sortdir'];
      else if(isset($_POST['sortdir'])) $this->view['sortdir'] = $_POST['sortdir'];
      else $this->view['sortdir'] = "default";
      // find
      if(isset($_GET['query'])) $this->view['query'] = $_GET['query'];
      else if(isset($_POST['query'])) $this->view['query'] = $_POST['query'];
      else $this->view['query'] = "*";
      if ($this->view['query'] == "") $this->view['query'] = "*";
      // colorscheme
      if (isset($_GET['colorscheme'])) $this->view['colorscheme'] = $_GET['colorscheme'];
      else if (isset($_POST['colorscheme'])) $this->view['colorscheme'] = $_POST['colorscheme'];
      else if (isset($_COOKIE['tmos_colorscheme'])) $this->view['colorscheme'] = $_COOKIE['tmos_colorscheme'];
      else $this->view['colorscheme'] = $this->cfg['defaultcolorscheme'];
      // recperpage
      if (isset($_GET['recperpage'])) $this->view['recperpage'] = $_GET['recperpage'];
      else if (isset($_POST['recperpage'])) $this->view['recperpage'] = $_POST['recperpage'];
      else if (isset($_COOKIE['tmos_recperpage'])) $this->view['recperpage'] = $_COOKIE['tmos_recperpage'];
      else $this->view['recperpage'] = $this->cfg['defaultrecperpage'];
      // language
      if (isset($_POST['oldlanguage'])) $this->view['language'] = $_POST['oldlanguage'];
      else if (isset($_GET['language'])) $this->view['language'] = $_GET['language'];
      else if (isset($_POST['language'])) $this->view['language'] = $_POST['language'];
      else if (isset($_COOKIE['tmos_language'])) $this->view['language'] = $_COOKIE['tmos_language'];
      else $this->view['language'] = $this->cfg['defaultlanguage'];
      // colortags
      if (isset($_COOKIE['tmos_colortags'])) $this->view['colortags'] = $_COOKIE['tmos_colortags'];
      else $this->view['colortags'] = '1';
      // interface
      require_once("includes/tmos_lang_".$this->view['language'].".inc.php");
      $this->it = $tmos_viewer_it;
      require_once("includes/tmos_content.inc.php");
      $this->ct = $tmos_viewer_ct;
      // dl
      if (isset($_GET['dl'])) $this->view['dl'] = $_GET['dl'];
      else $this->view['dl'] = '';
   }

   function get_link($action, $sid, $eid, $pid, $tid, $cid, $query ="*",
                     $sortfield = "", $sortdir = "", $pagenum = 1) {
      $link = "{$_SERVER['PHP_SELF']}?";
      $link .= "action=$action";
      if ($sid != -1)
         $link .= "&sid=$sid";
      if ($eid != '*')
         $link .= "&eid=$eid";
      if ($pid != -1)
         $link .= "&pid=$pid";
      if ($tid != -1)
         $link .= "&tid=$tid";
      if ($cid != -1)
         $link .= "&cid=$cid";
      if ($query != "*")
         $link .= "&query=$query";
      if ($sortfield != "" && $sortfield != "default")
         $link .= "&sortfield=$sortfield";
      if ($sortdir != "" && $sortdir != "default")
         $link .= "&sortdir=$sortdir";
      if ($pagenum != 1)
         $link .= "&pagenum=$pagenum";
      return $link;
   }

   function get_link_page($pagenum = -1) {
      if ($pagenum == -1)
         $pagenum = $view['pagenum'];
      return $this->get_link($this->view['action'], $this->view['sid'], $this->view['eid'],
                             $this->view['pid'], $this->view['tid'], $this->view['cid'],
                             $this->view['query'], $this->view['sortfield'],
                             $this->view['sortdir'], $pagenum);
   }

   function get_link_sort($sortfield, $sortdir) {
      return $this->get_link($this->view['action'], $this->view['sid'], $this->view['eid'],
                             $this->view['pid'], $this->view['tid'], $this->view['cid'],
                             $this->view['query'], $sortfield, $sortdir, 1);
   }

   function get_pict_sort($sortfield, $deffield = false) {
      if ($this->view['sortfield'] == $sortfield or
          ($this->view['sortfield'] == "default" and $deffield))
         $result = "gfx/bsa.gif";
      else
         $result = "gfx/bs.gif";
      return $result;
   }

   function get_pict_info($game, $folder = "", $file = "") {
      if ($folder == "" && $file == "" &&
          file_exists("gfx/{$this->view['action']}_$game.jpg"))
         $result = "gfx/{$this->view['action']}_$game.jpg";
      else if (file_exists("gfx/$folder/$file.jpg"))
         $result = "gfx/$folder/$file.jpg";
      else if (file_exists("gfx/$folder/$file.gif"))
         $result = "gfx/$folder/$file.gif";
      else if (file_exists("gfx/$folder/$file.png"))
         $result = "gfx/$folder/$file.png";
      else if (file_exists("gfx/{$this->view['action']}_$game.jpg"))
         $result = "gfx/{$this->view['action']}_$game.jpg";
      else
         $result = "gfx/null.jpg";
      return $result;
   }

   function get_pict_medal($mid) {
      switch ($mid) {
      case "a": $result = "gfx/ma.gif"; break;
      case "b": $result = "gfx/mg.gif"; break;
      case "c": $result = "gfx/ms.gif"; break;
      case "d": $result = "gfx/mb.gif"; break;
      default:  $result = "gfx/mf.gif"; break;
      }
      return $result;
   }

   function get_pagesstr($totalpages) {
      $pages = $this->it['mnu_pages'];
      $this->view['pagenum'] > $totalpages-7 ? $first = $totalpages-10 : $first = $this->view['pagenum']-5;
      $this->view['pagenum'] <= 7 ? $last = 11 : $last = $this->view['pagenum']+5;
      if ($first <= 2) $first = 1;
      if ($last >= $totalpages-1) $last = $totalpages;
      $result = '';
      for ($i = $first; $i <= $last; $i++) {
         if ($i == $this->view['pagenum'])
            $result .=  " |<b>$i</b>|";
         else
            $result .= ' <a href="'.$this->get_link_page($i).'"> '.$i.' </a>';
      }
      if ($first > 2)
         $result = '<a href="'.$this->get_link_page(1).'"> 1 </a> ... '.$result;
      if ($last < $totalpages-1)
         $result .= '... <a href="'.$this->get_link_page($totalpages).'"> '.$totalpages.' </a>';
      return $result;
   }
   
   function colors($str) {
      if ($this->view['colortags'] == '1')
         $result = name_html($str);
      else
         $result = name_clear($str);
      return $result;
   }

   function get_header() {
      $data = $this->db->view_menu($this->view);
      // redirect
      if ($data['count'] == 0) {
         $this->view['action'] = 'servers';
      }
      if ($data['count_total'] == 1 &&
          $data['count'] > 0 &&
          $this->cfg['showsingleserver'] == false &&
          $this->view['action'] == 'servers') {
         $this->view['action'] = 'monitoring';
         $this->view['sid'] = $data[0]['serverid'];
      }
      if ($this->cfg['showmonitoring'] == false &&
         $this->view['action'] == 'monitoring') {
         $this->view['action'] = 'players';
      }
      // flags
      $flag = (($data['count'] > 0) && ($this->view['action'] != "servers") &&
               ($this->view['action'] != 'preferences'));
      $this->view['showmenuservers'] = (($this->view['action'] != 'preferences') &&
                                        ($data['count_total'] > 1 ||
                                         $this->cfg['showsingleserver']));
      $this->view['showmenuclans'] = ($flag && $this->cfg['showclans']);
      $this->view['showmenuplayers'] = $flag;
      $this->view['showmenutracks'] = $flag;
      $this->view['showmenumonitoring'] = ($flag && $this->cfg['showmonitoring']);
      $this->view['showmenuother'] = $flag;
      $this->view['showparsedate'] = $flag;
      $this->view['showmenuenvir'] = (($flag == true) &&
                                      ($this->view['action'] != "monitoring") &&
                                      ($this->view['action'] != "userbar") &&
                                      ((strlen($data[0]['envirs']) > 2) ||
                                       (strlen($data[0]['envirs']) == 2 &&
                                        strpos($data[0]['envirs'], envir_toid('Stadium')) === false)));
      $this->view['showparsedate'] = $flag;
      $this->view['showpreferences'] = $this->cfg['showpreferences'];

      $cd['data_1'] = $this->view['colorscheme'];
      if ($this->cfg['javascript'])
         $cd['data_2'] = $this->ct['script_1'];
      else
         $cd['data_2'] = '';
      $content = tmpl_replace($this->ct['header_1'], $cd);
      // menu
      $flag = false;
      foreach (array("servers", "monitoring", "players",
                     "tracks", "clans") as $action) {
         if ($this->view['showmenu'.$action]) {
            if ($this->view['action'] == $action) {
               $cd['data_1'] = $this->ct['header_2'];
               $flag = true;
            }
            else
               $cd['data_1'] = $this->ct['header_3'];
            // link
            $sd['data_1'] = $this->get_link($action, $this->view['sid'],
                                            $this->view['eid'], -1, -1, -1);
            $sd['data_2'] = $cd['data_1'];
            $sd['data_3'] = $this->it['mnu_'.$action];
            $cd['data_2'] = tmpl_replace($this->ct['common_4'], $sd);
            //
            $content .= tmpl_replace($this->ct['header_4'], $cd);
         }
      }
      if ($this->view['showmenuother']) {
         if ($flag)
            $cd['data_1'] = $this->ct['header_3'];
         else
            $cd['data_1'] = $this->ct['header_2'];
         $content .= tmpl_replace($this->ct['header_5'], $cd);
      }
      $content .= $this->ct['header_6'];
      // envirs
      if ($this->view['showmenuenvir']) {
         for ($i = 0; $i < strlen($data[0]['envirs']); $i++) {
            $eid = $data[0]['envirs'][$i];
            if ($this->view['eid'] == $eid)
               $cd['data_1'] = $this->ct['header_7'];
            else
               $cd['data_1'] = $this->ct['header_8'];
            if (strpos($data[0]['envirlinks'], $eid) !== false) {
               // link
               $sd['data_1'] = $this->get_link($this->view['action'], $this->view['sid'],
                                               $eid, $this->view['pid'], $this->view['tid'],
                                               $this->view['cid'], $this->view['query'],
                                               $this->view['sortfield'], $this->view['sortdir']);
               $sd['data_2'] = $cd['data_1'];
               $sd['data_3'] = $this->it['mnu_envir_'.$eid];
               $cd['data_2'] = tmpl_replace($this->ct['common_4'], $sd);
               //
            }
            else
               $cd['data_2'] = $this->it['mnu_envir_'.$eid];
            $content .= tmpl_replace($this->ct['header_9'], $cd);
         }
      }
      // parsedate
      if ($this->view['showparsedate']) {
         if ($data[0]['lastupdate'] == '...')
            $cd['data_1'] = $this->ct['header_10'];
         else
            $cd['data_1'] = ts_format($data[0]['lastupdate']);
      }
      else
         $cd['data_1'] = '';
      $content .= tmpl_replace($this->ct['header_11'], $cd);
      // prefs
      if ($this->view['showpreferences']) {
         $sd['data_1'] = $this->get_link("preferences", -1, '*', -1, -1, -1);
         $cd['data_1'] = tmpl_replace($this->ct['header_12'], $sd);
      }
      else
         $cd['data_1'] = '';
      $content .= tmpl_replace($this->ct['header_13'], $cd);

      return $content;
   }

   function get_footer() {
      return $this->ct['footer_1'];
   }

   function get_preferences_content() {
      $cd['data_1'] = $_SERVER['PHP_SELF'];;
      $cd['data_2'] = $this->view['language'];
      $cd['data_3'] = $this->it['pr_header'];
      $cd['data_4'] = $this->it['pr_colorscheme'];
      $data = css_load(true);
      $cd['data_5'] = '';
      for ($i = 0; $i < $data['count']; $i++) {
         $data[$i]['css'] == $this->view['colorscheme'] ? $selected = " selected" : $selected = "";
         $cd['data_5'] .= '<option value="'.$data[$i]['css'].'"'.$selected.'>'.$data[$i]['dscr'].'</option>';
      }
      $cd['data_6'] = $this->it['pr_language'];
      $data = languages_load(true);
      $cd['data_7'] = '';
      for ($i = 0; $i < $data['count']; $i++) {
         $data[$i]['lng'] == $this->view['language'] ? $selected = " selected" : $selected = "";
         $cd['data_7'] .= '<option value="'.$data[$i]['lng'].'"'.$selected.'>'.$data[$i]['dscr'].'</option>';
      }
      $cd['data_8'] = $this->it['pr_recperpage'];
      $cd['data_9'] = $this->view['recperpage'];
      $cd['data_10'] = $this->it['pr_colortags'];
      if ($this->view['colortags'] == "1")
         $cd['data_11'] = ' checked';
      else
         $cd['data_11'] = '';
      $cd['data_12'] = $this->it['pr_save_btn'];
      $cd['data_13'] = $this->it['pr_default_btn'];
      return  tmpl_replace($this->ct['preferences_1'], $cd);
   }

   function act_preferences_save() {
      if (isset($_POST['actionbtn']) &&
          ($_POST['actionbtn'] == $this->it['pr_save_btn']) &&
          isset($_POST['colorscheme']) &&
          isset($_POST['language']) &&
          isset($_POST['recperpage'])) {
         $expire = time() + 2592000;
         setcookie('tmos_colorscheme', $_POST['colorscheme'], $expire);
         if  (!is_numeric($_POST['recperpage']) ||
              strpos($_POST['recperpage'], '.') !== false ||
              strpos($_POST['recperpage'], ',') !== false)
            $_POST['recperpage'] = $this->cfg['defaultrecperpage'];
         if ($_POST['recperpage'] < 10)
            $_POST['recperpage'] = 10;
         if ($_POST['recperpage'] > 1000)
            $_POST['recperpage'] = 1000;
         setcookie('tmos_recperpage', $_POST['recperpage'], $expire);
         setcookie('tmos_language', $_POST['language'], $expire);
         if (isset($_POST['colortags']))
            setcookie('tmos_colortags', '1', $expire);
         else
            setcookie('tmos_colortags', '0', $expire);
      }
      else if ($_POST['actionbtn'] == $this->it['pr_default_btn']) {
         setcookie('tmos_colorscheme', "");
         setcookie('tmos_recperpage', "");
         setcookie('tmos_language', "");
         setcookie('tmos_colortags', "");
      }
      header("Location: {$_SERVER['PHP_SELF']}?action=servers"); exit;
   }

   function get_servers_content() {
      $data = $this->db->view_servers($this->view);
      // table header
      $cd['data_1'] = $this->it['sl_header'];
      $content = tmpl_replace($this->ct['servers_1'], $cd);
      // data
      if ($data['count'] == 0) {
         $content .= $this->ct['servers_2'];
      }
      else {
         for ($i = 0; $i < $data['count']; $i++) {
            $cd = tmpl_null('-');
            if ($this->cfg['javascript'])
               $cd['data_1'] = $this->ct['script_2'];
            else
               $cd['data_1'] = "";
            $cd['data_3'] = $this->colors($data[$i]['server']);
            $cd['data_4'] = game_fromid($data[$i]['game']);
            $SI = new Ttmos_SI();
            $data[$i]['status'] = $SI->connect($data[$i]['ip'], $data[$i]['login'],
                                               $data[$i]['password'], $this->cfg['servertimeout']);
            if ($data[$i]['status'] == '1') {
               $data[$i]['si'] = $SI->server_info();
               $data[$i]['ti'] = $SI->track_info();
               $SI->disconnect();
               $cd['data_2'] = $this->get_link("monitoring", $data[$i]['serverid'], '*', -1, -1, -1);
               $cd['data_5'] = $this->colors($data[$i]['ti']['track']);
               $cd['data_6'] = $data[$i]['si']['totalplayers'];
               $cd['data_7'] = $data[$i]['si']['maxplayers'];
               $cd['data_8'] = $this->it['sl_online'];
               if ($data[$i]['si']['password'] == '1')
                  $cd['data_9'] = $this->ct['common_3'];
               else
                  $cd['data_9'] = '';
            }
            else {
               $cd['data_2'] = $this->get_link("players", $data[$i]['serverid'], '*', -1, -1, -1);
               $cd['data_8'] = $this->it['sl_offline'];
               $cd['data_9'] = '';
            }
            $content .= tmpl_replace($this->ct['servers_3'], $cd);
         }
      }
      $content .= $this->ct['servers_4'];
      return $content;
   }
   
   function get_monitoring_content() {
      $data = $this->db->view_monitoring($this->view, null);
      if ($data['count'] > 0) {
         $SI = new Ttmos_SI();
         $data['status'] = $SI->connect($data[0]['ip'], $data[0]['login'],
                                        $data[0]['password'], $this->cfg['servertimeout']);
         if ($data['status'] == '1') {
            $data['si'] = $SI->server_info();
            $data['ti'] = $SI->track_info();
            $data['pl'] = $SI->player_list();
            $SI->disconnect();
            $data = $this->db->view_monitoring($this->view, $data);
         }
      }
      else
         $data['status'] = '0';

      // info
      $cd = tmpl_null('-');
      if ($data['count'] > 0) {
         $cd['data_1'] = game_tocut($data[0]['game'])." &raquo; ".
                         $this->colors($data[0]['server'])." &raquo; ".
                         $this->it['mon_header'];
         $cd['data_4'] = game_fromid($data[0]['game']);
         if (isset($data['ti']['uid']))
            $cd['data_18'] = $this->get_pict_info($data[0]['game'],
                                                  "tracks", $data['ti']['uid']);
         else
            $cd['data_18'] = $this->get_pict_info($data[0]['game']);
         $cd['data_31'] = game_tocut($data[0]['game']);
      }
      else {
         $cd['data_18'] = $this->get_pict_info("?");
      }
      if ($data['status'] == '1' && $data['si']['password'] == '1')
         $cd['data_1'] .= " ".$this->ct['common_3'];
      $cd['data_3'] = $this->it['mon_game'];
      $cd['data_5'] = $this->it['mon_gamemode'];
      $cd['data_7'] = $this->it['mon_players'];
      $cd['data_10'] = $this->it['mon_spectators'];
      $cd['data_13'] = $this->it['mon_tracks'];
      $cd['data_15'] = $this->it['mon_trackheader'];
      $cd['data_16'] = $this->it['mon_trackname'];
      $cd['data_19'] = $this->it['mon_trackenvir'];
      $cd['data_21'] = $this->it['mon_trackauthor'];
      $cd['data_23'] = $this->it['mon_tracklaps'];
      $cd['data_25'] = $this->it['mon_trackauthortime'];
      $cd['data_27'] = $this->it['mon_trackbesttime'];
      $cd['data_30'] = '';
      if ($data['status'] == '1') {
         $cd['data_6'] = $data['si']['gamemode'];
         $cd['data_8'] = $data['si']['totalplayers'];
         $cd['data_9'] = $data['si']['maxplayers'];
         $cd['data_11'] = $data['si']['totalspectators'];
         $cd['data_12'] = $data['si']['maxspectators'];
         $cd['data_14'] = $data['si']['totaltracks'];
         if ($data['ti']['trackid'] != -1) {
            $sd['data_1'] = $this->get_link("track", $this->view['sid'],
                                            $this->view['eid'], -1,
                                            $data['ti']['trackid'], -1);
            $sd['data_2'] = $this->colors($data['ti']['track']);
            $cd['data_17'] = tmpl_replace($this->ct['common_2'], $sd);
         }
         else {
            $cd['data_17'] = $this->colors($data['ti']['track']);
         }
         $cd['data_20'] = $data['ti']['envir'];
         $cd['data_22'] = $this->colors($data['ti']['author']);
         if ($data['si']['gamemode'] == "Rounds" &&
             $data['ti']['laps'] &&
             $data['ti']['trackid'] != -1)
            $cd['data_24'] = $data['ti']['laps_t'];
         else if ($data['si']['gamemode'] == "Rounds" &&
                  $data['ti']['laps'])
            $cd['data_24'] = '+';
         else if ($data['ti']['laps'])
            $cd['data_24'] = $data['ti']['laps_s'];
         $cd['data_26'] = time_msectofull($data['ti']['authortime']);
         if ($data['ti']['playerid'] != -1) {
            $cd['data_28'] = $data['ti']['result'];
            $sd['data_1'] = $this->get_link("player", $this->view['sid'],
                                            $this->view['eid'],
                                            $data['ti']['playerid'], -1, -1);
            $sd['data_2'] = $this->colors($data['ti']['player']);
            $cd['data_29'] = tmpl_replace($this->ct['common_2'], $sd);
         }
      }
      $content = tmpl_replace($this->ct['monitoring_1'], $cd);

      // table header
      $cd['data_1'] = $this->it['mon_playernum'];
      $cd['data_2'] = $this->it['mon_playername'];
      if ($data['status'] == 1 && $data['si']['gamemode'] == "Laps")
         $cd['data_3'] = $this->it['mon_playerlaps'];
      else
         $cd['data_3'] = $this->it['mon_playerbesttime'];
      $content .= tmpl_replace($this->ct['monitoring_2'], $cd);

      // data
      if ($data['status'] != 1 || $data['pl']['count'] == 0) {
         $content .= $this->ct['monitoring_3'];
      }
      else {
         if ($this->cfg['javascript'])
            $cd['data_1'] = $this->ct['script_2'];
         else
            $cd['data_1'] = "";
         for ($i = 0; $i < $data['pl']['count']; $i++) {
            $cd['data_2'] = $i+1;
            if ($data['pl'][$i]['playerid'] != -1) {
               $sd['data_1'] = $this->get_link("player", $this->view['sid'], $this->view['eid'],
                                               $data['pl'][$i]['playerid'], -1, -1);
               $sd['data_2'] = $this->colors($data['pl'][$i]['player']);
               $cd['data_3'] = tmpl_replace($this->ct['common_2'], $sd);
            }
            else {
               $cd['data_3'] = $this->colors($data['pl'][$i]['player']);
            }
            if ($data['pl'][$i]['besttime'] != 600000)
               $cd['data_4'] = time_msectocut($data['pl'][$i]['besttime']);
            else
               $cd['data_4'] = '-';
            if ($data['si']['gamemode'] == "Laps")
               $cd['data_4'] = $data['pl'][$i]['lapsfinished']." / ".
                               time_full($cd['data_4']);
            if ($data['pl'][$i]['spectator'])
               $cd['data_5'] = '+';
            else
               $cd['data_5'] = '';
            $content .= tmpl_replace($this->ct['monitoring_4'], $cd);
         }
      }
      $content .= tmpl_replace($this->ct['monitoring_5'], $cd);
      $content .= tmpl_replace($this->ct['monitoring_6'], $cd);

      return $content;
   }

   function get_players_content() {
      $data = $this->db->view_players($this->view);

      // info
      if ($data['srv']['count'] != 0 && $data['dscr']['count'] != 0) {
         $cd = tmpl_null();
         $cd['data_1'] = game_tocut($data['srv'][0]['game'])." &raquo; ".
                         $this->colors($data['srv'][0]['server'])." &raquo; ".
                         $this->it['pl_header'];
         // pict
         $cd['data_2'] = $this->get_pict_info($data['srv'][0]['game']);
         // link action find
         $cd['data_5'] = $_SERVER['PHP_SELF'];
         // save info
         $cd['data_6'] = $this->view['action'];
         $cd['data_7'] = $this->view['sid'];
         $cd['data_8'] = $this->view['sortfield'];
         $cd['data_9'] = $this->view['sortdir'];
         // caption find
         $cd['data_10'] = $this->it['pl_findplayer'];
         // qry find
         $cd['data_11'] = htmlspecialchars($this->view['query']);
         // btn
         $cd['data_12'] = $this->it['pl_findplayer_btn'];
         // inf
         $cd['data_3'] = $this->it['pl_totalplayers'];
         $cd['data_4'] = $data['dscr'][0]['tp'];
         $cd['data_13'] = $this->it['pl_totalawards'];
         $cd['data_14'] = $data['dscr'][0]['tm'];
      }
      else
         $cd = tmpl_null('-');
      $content = tmpl_replace($this->ct['dscr_1'], $cd);

      // table header
      $cd['data_1'] = $this->it['pl_num'];
      $cd['data_2'] = $this->it['pl_player'];
      $cd['data_3'] = $this->get_link_sort("player", "asc");
      $cd['data_4'] = $this->get_pict_sort("player");
      $cd['data_5'] = $this->get_link_sort("am", "desc");
      $cd['data_6'] = $this->get_pict_sort("am");
      $cd['data_7'] = $this->get_link_sort("gm", "desc");
      $cd['data_8'] = $this->get_pict_sort("gm");
      $cd['data_9'] = $this->get_link_sort("sm", "desc");
      $cd['data_10'] = $this->get_pict_sort("sm");
      $cd['data_11'] = $this->get_link_sort("bm", "desc");
      $cd['data_12'] = $this->get_pict_sort("bm");
      $cd['data_13'] = $this->it['pl_score'];
      $cd['data_14'] = $this->get_link_sort("score", "desc");
      $cd['data_15'] = $this->get_pict_sort("score", true);
      $content .= tmpl_replace($this->ct['players_1'], $cd);

      // data
      if ($data['count'] == 0) {
         $content .= $this->ct['players_2'];
      }
      else {
         if ($this->cfg['javascript'])
            $cd['data_1'] = $this->ct['script_2'];
         else
            $cd['data_1'] = "";
         for ($i = 0; $i < $data['count']; $i++) {
            $cd['data_2'] = ($this->view['pagenum']-1)*$this->view['recperpage'] + $i + 1;
            $cd['data_3'] = $this->get_link("player", $this->view['sid'], $this->view['eid'],
                                                      $data[$i]['playerid'], -1, -1);
            $cd['data_4'] = $this->colors($data[$i]['player']);
            $cd['data_5'] = '';
            if ($this->cfg['showlinks']) {
               $links = params_toarray($data[$i]['links'], false, 3);
               for ($j = 0; $j < $links['count']; $j++) {
                  $sd['data_1'] = $links[$j];
                  $cd['data_5'] .= tmpl_replace($this->ct['common_1'], $sd);
               }
            }
            $cd['data_6'] = $data[$i]['am'];
            $cd['data_7'] = $data[$i]['gm'];
            $cd['data_8'] = $data[$i]['sm'];
            $cd['data_9'] = $data[$i]['bm'];
            $cd['data_10'] = float_format($data[$i]['score']);
            $content .= tmpl_replace($this->ct['players_3'], $cd);
         }
         $cd['data_1'] = $this->get_pagesstr(ceil($data['count_total']/$this->view['recperpage']));
         $content .= tmpl_replace($this->ct['players_4'], $cd);
      }
      $content .= $this->ct['players_5'];
      return $content;
   }

   function get_player_content() {
      $data = $this->db->view_player($this->view);

      // info
      if ($data['srv']['count'] != 0 && $data['dscr']['count'] != 0) {
         $cd = tmpl_null();
         $cd['data_1'] = game_tocut($data['srv'][0]['game'])." &raquo; ".
                         $this->colors($data['srv'][0]['server'])." &raquo; ".
                         $this->it['pi_header']." &raquo; ".
                         $this->colors($data['dscr'][0]['player']);
         if ($this->cfg['showlinks']) {
            $links = params_toarray($data['dscr'][0]['links'], false, 3);
            for ($j = 0; $j < $links['count']; $j++) {
               $sd['data_1'] = $links[$j];
               $cd['data_1'] .= tmpl_replace($this->ct['common_1'], $sd);
            }
         }
         if ($this->cfg['showuserbars']) {
            $sd['data_1'] = $this->get_link("userbar", $this->view['sid'], $this->view['eid'],
                                                       $this->view['pid'], -1, -1);
            $cd['data_2'] = tmpl_replace($this->ct['dscr_2'], $sd);
         }
         else
            $cd['data_2'] = "&nbsp;";
         $account = str_replace(array("/","\\",":","*","?","<",">",'"',"|"), "_", $data['dscr'][0]['account']);
         $cd['data_3'] = $this->get_pict_info($data['srv'][0]['game'], "avatars", $account);
         $cd['data_4'] = $this->it['pi_rank'];
         $cd['data_5'] = $data['dscr'][0]['rank'];
         $cd['data_26'] = $data['dscr'][0]['score'];

         $cd['data_8'] = $this->it['pi_afp'];
         $cd['data_9'] = float_format($data['dscr'][0]['afp']);
         $cd['data_10'] = $data['dscr'][0]['am'];
         $cd['data_11'] = $data['dscr'][0]['gm'];
         $cd['data_12'] = $data['dscr'][0]['sm'];
         $cd['data_13'] = $data['dscr'][0]['bm'];
         $cd['data_14'] = $data['dscr'][0]['fc'];
         $cd['data_15'] = $this->it['pi_finishedtracks'];
         $cd['data_16'] = $data['dscr'][0]['ft'];
         $cd['data_17'] = $this->it['pi_firstplaces'];
         $cd['data_18'] = $data['dscr'][0]['fp'];
         
         $cd['data_19'] = $this->it['pi_lastonline'];
         $cd['data_20'] = ts_format($data['dscr'][0]['lastonline']);
         $cd['data_6'] = $this->it['pi_aliases'];
         $aliases = params_toarray($data['dscr'][0]['aliases'], true, 5, "\x01", false);
         $cd['data_7'] = $aliases['count_total'];
         for ($i = 0; $i < $aliases['count']; $i++) {
            $cd['data_'.(21+$i)] = $this->colors($aliases[$i]);
         }
      }
      else
         $cd = tmpl_null('-');
      $content = tmpl_replace($this->ct['dscr_3'], $cd);

      // table header
      $cd['data_1'] = $this->it['pi_num'];
      $cd['data_2'] = $this->it['pi_track'];
      $cd['data_3'] = $this->get_link_sort("track", "asc");
      $cd['data_4'] = $this->get_pict_sort("track", true);
      $cd['data_5'] = $this->it['pi_besttime'];
      $cd['data_6'] = $this->it['pi_place'];
      $cd['data_7'] = $this->get_link_sort("fp", "asc");
      $cd['data_8'] = $this->get_pict_sort("fp");
      $cd['data_9'] = $this->get_link_sort("rc", "asc");
      $cd['data_10'] = $this->get_pict_sort("rc");
      //$cd['data_11'] = $this->it['pi_award'];
      $cd['data_12'] = $this->get_link_sort("medal", "asc");
      $cd['data_13'] = $this->get_pict_sort("medal");
      $cd['data_14'] = $this->it['pi_ts'];
      $cd['data_15'] = $this->get_link_sort("ts", "asc");
      $cd['data_16'] = $this->get_pict_sort("ts");
      $content .= tmpl_replace($this->ct['player_1'], $cd);

      // data
      if ($data['count'] == 0) {
         $content .= $this->ct['player_2'];
      }
      else {
         if ($this->cfg['javascript'])
            $cd['data_1'] = $this->ct['script_2'];
         else
            $cd['data_1'] = "";
         for ($i = 0; $i < $data['count']; $i++) {
            $cd['data_2'] = ($this->view['pagenum']-1)*$this->view['recperpage'] + $i + 1;
            $cd['data_3'] = $this->get_link("track", $this->view['sid'], $this->view['eid'], -1,
                                                     $data[$i]['trackid'], -1);
            $cd['data_4'] = $this->colors($data[$i]['track']);
            $cd['data_5'] = time_cut($data[$i]['result']);
            $cd['data_6'] = $data[$i]['fp']." / ".$data[$i]['pc']." (".$data[$i]['rc'].")";
            $cd['data_7'] = $this->get_pict_medal($data[$i]['medal']);
            $cd['data_8'] = $data[$i]['ts'];
            $content .= tmpl_replace($this->ct['player_3'], $cd);
         }
         $cd['data_1'] = $this->get_pagesstr(ceil($data['count_total']/$this->view['recperpage']));
         $content .= tmpl_replace($this->ct['player_4'], $cd);
      }
      $content .= $this->ct['player_5'];
      return $content;
   }

   function get_tracks_content() {
      $data = $this->db->view_tracks($this->view);

      // info
      if ($data['srv']['count'] != 0 && $data['dscr']['count'] != 0) {
         $cd = tmpl_null();
         $cd['data_1'] = game_tocut($data['srv'][0]['game'])." &raquo; ".
                         $this->colors($data['srv'][0]['server'])." &raquo; ".
                         $this->it['tl_header'];
         // pict
         $cd['data_2'] = $this->get_pict_info($data['srv'][0]['game']);
         // link action find
         $cd['data_5'] = $_SERVER['PHP_SELF'];
         // save info
         $cd['data_6'] = $this->view['action'];
         $cd['data_7'] = $this->view['sid'];
         $cd['data_8'] = $this->view['sortfield'];
         $cd['data_9'] = $this->view['sortdir'];
         // caption find
         $cd['data_10'] = $this->it['tl_findtrack'];
         // qry find
         $cd['data_11'] = htmlspecialchars($this->view['query']);
         // btn
         $cd['data_12'] = $this->it['tl_findtrack_btn'];
         // inf
         $cd['data_3'] = $this->it['tl_totaltracks'];
         $cd['data_4'] = $data['dscr'][0]['tt'];
         $cd['data_13'] = $this->it['tl_totalauthors'];
         $cd['data_14'] = $data['dscr'][0]['ta'];
      }
      else
         $cd = tmpl_null('-');
      $content = tmpl_replace($this->ct['dscr_1'], $cd);

      // table header
      $cd['data_1'] = $this->it['tl_num'];
      $cd['data_2'] = $this->it['tl_track'];
      $cd['data_3'] = $this->get_link_sort("track", "asc");
      $cd['data_4'] = $this->get_pict_sort("track", true);
      $cd['data_5'] = $this->it['tl_author'];
      $cd['data_6'] = $this->get_link_sort("author", "asc");
      $cd['data_7'] = $this->get_pict_sort("author");
      $cd['data_8'] = $this->it['tl_bestresult'];
      $cd['data_9'] = $this->get_link_sort("result", "asc");
      $cd['data_10'] = $this->get_pict_sort("result");
      $cd['data_11'] = $this->it['tl_player'];
      $cd['data_12'] = $this->get_link_sort("player", "asc");
      $cd['data_13'] = $this->get_pict_sort("player");
      $cd['data_14'] = $this->get_link_sort("rc", "desc");
      $cd['data_15'] = $this->get_pict_sort("rc");
      $content .= tmpl_replace($this->ct['tracks_1'], $cd);

      // data
      if ($data['count'] == 0) {
         $content .= $this->ct['tracks_2'];
      }
      else {
         if ($this->cfg['javascript'])
            $cd['data_1'] = $this->ct['script_2'];
         else
            $cd['data_1'] = "";
         for ($i = 0; $i < $data['count']; $i++) {
            $cd['data_2'] = ($this->view['pagenum']-1)*$this->view['recperpage'] + $i + 1;
            $cd['data_3'] = $this->get_link("track", $this->view['sid'], $this->view['eid'], -1,
                                                     $data[$i]['trackid'], -1);
            $cd['data_4'] = $this->colors($data[$i]['track']);
            $cd['data_5'] = $this->colors($data[$i]['author']);
            $cd['data_6'] = time_cut($data[$i]['result']);
            if ($data[$i]['tr'] > 1) {
              $cd['data_7'] = str_replace("{0}", $data[$i]['tr'], $this->it['tl_severalplayers']);
            }
            else {
              $sd['data_1'] = $this->get_link("player", $this->view['sid'], $this->view['eid'],
                                                        $data[$i]['playerid'], -1, -1);
              $sd['data_2'] = $this->colors($data[$i]['player']);
              $cd['data_7'] = tmpl_replace($this->ct['common_2'], $sd);
            }
            $cd['data_8'] = $data[$i]['rc'];
            $content .= tmpl_replace($this->ct['tracks_3'], $cd);
         }
         $cd['data_1'] = $this->get_pagesstr(ceil($data['count_total']/$this->view['recperpage']));
         $content .= tmpl_replace($this->ct['tracks_4'], $cd);
      }
      $content .= $this->ct['tracks_5'];

      return $content;
   }
   
   function get_track_content() {
      $data = $this->db->view_track($this->view);

      // info
      if ($data['srv']['count'] != 0 && $data['dscr']['count'] != 0) {
         $cd = tmpl_null();
         $cd['data_1'] = game_tocut($data['srv'][0]['game'])." &raquo; ".
                         $this->colors($data['srv'][0]['server'])." &raquo; ".
                         $this->it['ti_header']." &raquo; ".
                         $this->colors($data['dscr'][0]['track']);
         // pict
         $cd['data_2'] = $this->get_pict_info($data['srv'][0]['game'],
                                              "tracks", $data['dscr'][0]['uid']);
         // inf
         $cd['data_3'] = $this->it['ti_author'];
         $cd['data_4'] = $this->colors($data['dscr'][0]['author']);
         if ($data['dscr'][0]['nblaps'] > 1)
            $laps = ' / '.$data['dscr'][0]['nblaps'];
         else
            $laps = '';
         $cd['data_5'] = $this->it['ti_timeauthor'];
         $cd['data_6'] = $data['dscr'][0]['authortime'].$laps;
         $cd['data_7'] = $this->it['ti_timegold'];
         $cd['data_8'] = $data['dscr'][0]['gold'].$laps;
         $cd['data_9'] = $this->it['ti_timesilver'];
         $cd['data_10'] = $data['dscr'][0]['silver'].$laps;
         $cd['data_11'] = $this->it['ti_timebronze'];
         $cd['data_12'] = $data['dscr'][0]['bronze'].$laps;
         $cd['data_13'] = $this->it['ti_envir'];
         $cd['data_14'] = envir_fromid($data['dscr'][0]['envirid']);
         if ($this->cfg['showdownloads'] && $data['dscr'][0]['filename'] != '') {
            $sd['data_1'] = $_SERVER['REQUEST_URI']."&dl=".$data['dscr'][0]['filename'];
            $cd['data_15'] = tmpl_replace($this->ct['dscr_4'], $sd);
         }
         else
            $cd['data_15'] = "&nbsp;";
      }
      else
         $cd = tmpl_null('-');
      $content = tmpl_replace($this->ct['dscr_5'], $cd);

      // table header
      $cd['data_1'] = $this->it['ti_num'];
      $cd['data_2'] = $this->it['ti_player'];
      $cd['data_3'] = $this->get_link_sort("player", "asc");
      $cd['data_4'] = $this->get_pict_sort("player");
      $cd['data_5'] = $this->it['ti_bestresult'];
      $cd['data_6'] = $this->get_link_sort("result", "asc");
      $cd['data_7'] = $this->get_pict_sort("result", true);
      //$cd['data_8'] = $this->it['ti_award'];
      $cd['data_9'] = $this->get_link_sort("medal", "asc");
      $cd['data_10'] = $this->get_pict_sort("medal");
      $cd['data_11'] = $this->it['ti_ts'];
      $cd['data_12'] = $this->get_link_sort("ts", "asc");
      $cd['data_13'] = $this->get_pict_sort("ts");
      $content .= tmpl_replace($this->ct['track_1'], $cd);

      // data
      if ($data['count'] == 0) {
         $content .= $this->ct['track_2'];
      }
      else {
         if ($this->cfg['javascript'])
            $cd['data_1'] = $this->ct['script_2'];
         else
            $cd['data_1'] = "";
         for ($i = 0; $i < $data['count']; $i++) {
            $cd['data_2'] = ($this->view['pagenum']-1)*$this->view['recperpage'] + $i + 1;
            $cd['data_3'] = $this->get_link("player", $this->view['sid'], $this->view['eid'],
                                                      $data[$i]['playerid'], -1, -1);
            $cd['data_4'] = $this->colors($data[$i]['player']);
            $cd['data_5'] = '';
            if ($this->cfg['showlinks']) {
               $links = params_toarray($data[$i]['links'], false, 3);
               for ($j = 0; $j < $links['count']; $j++) {
                  $sd['data_1'] = $links[$j];
                  $cd['data_5'] .= tmpl_replace($this->ct['common_1'], $sd);
               }
            }
            $cd['data_6'] = time_cut($data[$i]['result']);
            $cd['data_7'] = "+".time_deltacut($data[$i]['result'], $data['dscr'][0]['br']);
            $cd['data_8'] = $this->get_pict_medal($data[$i]['medal']);
            $cd['data_9'] = $data[$i]['ts'];
            $content .= tmpl_replace($this->ct['track_3'], $cd);
         }
         $cd['data_1'] = $this->get_pagesstr(ceil($data['count_total']/$this->view['recperpage']));
         $content .= tmpl_replace($this->ct['track_4'], $cd);
      }
      $content .= $this->ct['track_5'];

      return $content;
   }
   
   function act_track_download() {
      if ($this->view['dl'] != '') {
         $filename = DIR_FILES.$this->view['dl'];
         if (file_exists($filename)) {
            $filesize = filesize($filename);
         }
         else {
            $filename = 'File_not_found!';
            $filesize = 0;
         }
         header("Pragma: public");
         header("Expires: 0");
         header("Content-Description: File Transfer");
         header("Content-Type: application/force-download");
         header("Content-Type: application/octet-stream");
         header("Content-Type: application/download");
         header("Content-Disposition: attachment; filename=\"".basename($filename)."\"");
         header("Content-Transfer-Encoding: binary");
         header("Content-Length: $filesize");
         if ($filesize > 0)
            readfile($filename);
         exit(0);
      }
   }

   function get_clans_content() {
      $data = $this->db->view_clans($this->view);

      // info
      if ($data['srv']['count'] != 0 && $data['dscr']['count'] != 0) {
         $cd = tmpl_null();
         $cd['data_1'] = game_tocut($data['srv'][0]['game'])." &raquo; ".
                         $this->colors($data['srv'][0]['server'])." &raquo; ".
                         $this->it['cl_header'];
         // pict
         $cd['data_2'] = $this->get_pict_info($data['srv'][0]['game']);
         // link action find
         $cd['data_5'] = $_SERVER['PHP_SELF'];
         // save info
         $cd['data_6'] = $this->view['action'];
         $cd['data_7'] = $this->view['sid'];
         $cd['data_8'] = $this->view['sortfield'];
         $cd['data_9'] = $this->view['sortdir'];
         // caption find
         $cd['data_10'] = $this->it['cl_findclan'];
         // qry find
         $cd['data_11'] = htmlspecialchars($this->view['query']);
         // btn
         $cd['data_12'] = $this->it['cl_findclan_btn'];
         // inf
         $cd['data_3'] = $this->it['cl_totalclans'];
         $cd['data_4'] = $data['dscr'][0]['tc'];
      }
      else
         $cd = tmpl_null('-');
      $content = tmpl_replace($this->ct['dscr_1'], $cd);

      // table header
      $cd['data_1'] = $this->it['cl_num'];
      $cd['data_2'] = $this->it['cl_clan'];
      $cd['data_3'] = $this->get_link_sort("clan", "asc");
      $cd['data_4'] = $this->get_pict_sort("clan");
      $cd['data_5'] = $this->get_link_sort("am", "desc");
      $cd['data_6'] = $this->get_pict_sort("am");
      $cd['data_7'] = $this->get_link_sort("gm", "desc");
      $cd['data_8'] = $this->get_pict_sort("gm");
      $cd['data_9'] = $this->get_link_sort("sm", "desc");
      $cd['data_10'] = $this->get_pict_sort("sm");
      $cd['data_11'] = $this->get_link_sort("bm", "desc");
      $cd['data_12'] = $this->get_pict_sort("bm");
      $cd['data_13'] = $this->it['cl_score'];
      $cd['data_14'] = $this->get_link_sort("score", "desc");
      $cd['data_15'] = $this->get_pict_sort("score", true);
      $cd['data_16'] = $this->get_link_sort("mc", "desc");
      $cd['data_17'] = $this->get_pict_sort("mc");
      $content .= tmpl_replace($this->ct['clans_1'], $cd);

      // data
      if ($data['count'] == 0) {
         $content .= $this->ct['clans_2'];
      }
      else {
         if ($this->cfg['javascript'])
            $cd['data_1'] = $this->ct['script_2'];
         else
            $cd['data_1'] = "";
         for ($i = 0; $i < $data['count']; $i++) {
            $cd['data_2'] = ($this->view['pagenum']-1)*$this->view['recperpage'] + $i + 1;
            $cd['data_3'] = $this->get_link("clan", $this->view['sid'], $this->view['eid'], -1, -1,
                                                    $data[$i]['clanid']);
            $cd['data_4'] = $data[$i]['clanc'];
            $cd['data_5'] = $data[$i]['description'];
            $cd['data_6'] = $data[$i]['am'];
            $cd['data_7'] = $data[$i]['gm'];
            $cd['data_8'] = $data[$i]['sm'];
            $cd['data_9'] = $data[$i]['bm'];
            $cd['data_10'] = float_format($data[$i]['score']);
            $cd['data_11'] = $data[$i]['mc'];
            $content .= tmpl_replace($this->ct['clans_3'], $cd);
         }
         $cd['data_1'] = $this->get_pagesstr(ceil($data['count_total']/$this->view['recperpage']));
         $content .= tmpl_replace($this->ct['clans_4'], $cd);
      }
      $content .= $this->ct['clans_5'];

      return $content;
   }

   function get_clan_content() {
      $data = $this->db->view_clan($this->view);

      // info
      if ($data['srv']['count'] != 0 && $data['dscr']['count'] != 0) {
         $cd = tmpl_null();
         $cd['data_1'] = game_tocut($data['srv'][0]['game'])." &raquo; ".
                         $this->colors($data['srv'][0]['server'])." &raquo; ".
                         $this->it['ci_header']." &raquo; ".
                         $data['dscr'][0]['clanc'].$data['dscr'][0]['description'];
         // pict
         $cd['data_2'] = $this->get_pict_info($data['srv'][0]['game']);
         // inf
         $cd['data_3'] = $this->it['ci_mc'];
         $cd['data_4'] = $data['dscr'][0]['mc'];
      }
      else
         $cd = tmpl_null('-');
      $content = tmpl_replace($this->ct['dscr_5'], $cd);

      // table header
      $cd['data_1'] = $this->it['ci_num'];
      $cd['data_2'] = $this->it['ci_player'];
      $cd['data_3'] = $this->get_link_sort("player", "asc");
      $cd['data_4'] = $this->get_pict_sort("player");
      $cd['data_5'] = $this->get_link_sort("am", "desc");
      $cd['data_6'] = $this->get_pict_sort("am");
      $cd['data_7'] = $this->get_link_sort("gm", "desc");
      $cd['data_8'] = $this->get_pict_sort("gm");
      $cd['data_9'] = $this->get_link_sort("sm", "desc");
      $cd['data_10'] = $this->get_pict_sort("sm");
      $cd['data_11'] = $this->get_link_sort("bm", "desc");
      $cd['data_12'] = $this->get_pict_sort("bm");
      $cd['data_13'] = $this->it['ci_score'];
      $cd['data_14'] = $this->get_link_sort("score", "desc");
      $cd['data_15'] = $this->get_pict_sort("score", true);
      $content .= tmpl_replace($this->ct['clan_1'], $cd);

      // data
      if ($data['count'] == 0) {
         $content .= $this->ct['clan_2'];
      }
      else {
         if ($this->cfg['javascript'])
            $cd['data_1'] = $this->ct['script_2'];
         else
            $cd['data_1'] = "";
         for ($i = 0; $i < $data['count']; $i++) {
            $cd['data_2'] = ($this->view['pagenum']-1)*$this->view['recperpage'] + $i + 1;
            $cd['data_3'] = $this->get_link("player", $this->view['sid'], $this->view['eid'],
                                                      $data[$i]['playerid'], -1, -1);
            $cd['data_4'] = $this->colors($data[$i]['player']);
            $cd['data_5'] = $data[$i]['am'];
            $cd['data_6'] = $data[$i]['gm'];
            $cd['data_7'] = $data[$i]['sm'];
            $cd['data_8'] = $data[$i]['bm'];
            $cd['data_9'] = float_format($data[$i]['score']);
            $content .= tmpl_replace($this->ct['clan_3'], $cd);
         }
         $cd['data_1'] = $this->get_pagesstr(ceil($data['count_total']/$this->view['recperpage']));
         $content .= tmpl_replace($this->ct['clan_4'], $cd);
      }
      $content .= $this->ct['clan_5'];
      return $content;
   }

   function get_userbar_content() {
      $data = $this->db->view_userbars($this->view);
      // inf
      if ($data['count'] > 0)
         $cd['data_1'] = game_tocut($data[0]['game'])." &raquo; ".
                         $this->colors($data[0]['server'])." &raquo; ".
                         $this->it['ub_header'];
      else
         $cd = tmpl_null();
      $content = tmpl_replace($this->ct['userbars_1'], $cd);
      // data
      $files = userbars_load("");
      if ($data['count'] > 0) {
         foreach ($files as $ubid=>$ubinf)
            if ($ubinf['game'] != $data[0]['game'])
               unset($files[$ubid]);
      }
      if (!function_exists('imagepng')) {
         $content .= $this->it['ub_gd_err'];
      }
      else if ($data['count'] == 0 || count($files) == 0) {
         $content .= $this->it['ub_null_err'];
      }
      else {
         $host = $_SERVER['HTTP_HOST'];
         $uri = dirname(rtrim($_SERVER['PHP_SELF'], "\\/"));
         if($uri == '\\' || $uri == '/') $uri = '';
         $baselink = "http://$host$uri/tmos_userbar.php".UB_QUERY_DELIM;

         foreach ($files as $ubid=>$ubinf) {
            $link = $baselink."tmos_{$ubid}_{$this->view['sid']}_{$this->view['pid']}.png";
            $cd['data_1'] = $link;
            $cd['data_2'] = $this->it['ub_links'];
            $cd['data_3'] = $link;
            $cd['data_4'] = $link;
            $content .= tmpl_replace($this->ct['userbars_2'], $cd);
         }
      }
      $content .= $this->ct['userbars_3'];

      return $content;
   }
      
   function get_content() {
      // db
      $this->db = new Ttmos_DB($this->cfg);
      $this->db->open();
      if ($this->db->last_error != '') exit;
      // dl
      $this->act_track_download();
      // content
      $this->content = $this->get_header();
      switch ($this->view['action']) {
      case 'servers': $this->content .= $this->get_servers_content(); break;
      case 'monitoring': $this->content .= $this->get_monitoring_content(); break;
      case 'players': $this->content .= $this->get_players_content(); break;
      case 'player': $this->content .= $this->get_player_content(); break;
      case 'tracks': $this->content .= $this->get_tracks_content(); break;
      case 'track': $this->content .= $this->get_track_content(); break;
      case 'clans': $this->content .= $this->get_clans_content(); break;
      case 'clan': $this->content .= $this->get_clan_content(); break;
      case 'preferences': $this->content .= $this->get_preferences_content(); break;
      case 'preferences_save': $this->content .= $this->act_preferences_save(); break;
      case 'userbar': $this->content .= $this->get_userbar_content(); break;
      case 'download': 
      }
      $this->content .= $this->get_footer();
      // db
      $this->db->close();
   }

   /*
   function gzip($data = "", $level = 6, $filename = "", $comments = "") {
    $flags = (empty($comment)? 0 : 16) + (empty($filename)? 0 : 8);
    $mtime = time();
   
    return (pack("C1C1C1C1VC1C1", 0x1f, 0x8b, 8, $flags, $mtime, 2, 0xFF) .
                (empty($filename) ? "" : $filename . "\0") .
                (empty($comment) ? "" : $comment . "\0") .
                gzdeflate($data, $level) .
                pack("VV", crc32($data), strlen($data)));
   }
   */

   function get_compress() {
      $encoding = "";
      if (extension_loaded('zlib') &&
          isset($_SERVER['HTTP_ACCEPT_ENCODING']) &&
          strlen($this->content) > 1024) {
         if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false)
            $encoding = "x-gzip";
         if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false)
            $encoding = "gzip";
         if ($encoding != "")
            $this->content = "\x1f\x8b\x08\x00\x00\x00\x00\x00".
                             substr(gzcompress($this->content, 6), 0, -4).
                             pack("VV", crc32($this->content), strlen($this->content));
      }
      return $encoding;
   }

   function show_content() {
      header('Content-Type: text/html; charset=UTF-8');
      if ($this->cfg['gzipcompression']) {
         $encoding = $this->get_compress();
         if ($encoding != "") {
            header("Content-Encoding: $encoding");
            header("Vary: Accept-Encoding");
         }
      }
      //header('Content-Length: '.strlen($this->content));
      echo $this->content;
   }

   function cache_clear() {
      if (!file_exists(DIR_CACHE.'!clear!')) {
         $result = false;
      }
      else {
         if (($curr_dir = @opendir(DIR_CACHE)) !== false) {
            while(($curr_rec = readdir($curr_dir)) !== false) {
               if ($curr_rec != '.' &&
                   $curr_rec != '..' &&
                   is_file(DIR_CACHE.$curr_rec)) {
                  unlink(DIR_CACHE.$curr_rec);
               }
            }
            closedir($curr_dir);
         }
         $result = true;
      }
      return $result;
   }

   function cache_write() {
      if ((($this->cfg['htmlcache'] == "all") &&
           ($this->view['action'] != "servers") &&
           ($this->view['action'] != "monitoring") &&
           ($this->view['action'] != "userbar") &&
           ($this->view['query'] == "*") &&
           ($this->view['pagenum'] <= 10)) ||
          (($this->cfg['htmlcache'] == "main") &&
           ($this->view['action'] != "servers") &&
           ($this->view['action'] != "monitoring") &&
           ($this->view['action'] != "player") &&
           ($this->view['action'] != "track") &&
           ($this->view['action'] != "clan") &&
           ($this->view['action'] != "userbar") &&
           ($this->view['query'] == "*") &&
           ($this->view['pagenum'] <= 10))) {

         $filename = md5($_SERVER['REQUEST_URI']);
         if (!file_exists(DIR_CACHE.$filename)) {
            $fp = @fopen(DIR_CACHE.$filename, "wb+");
            if (!$fp) {
            }
            else {
               @fwrite($fp, $this->content, strlen($this->content));
               @fclose($fp);
            }
         }
         $result = true;
      }
      else
         $result = false;
   }

   function cache_read() {
      $filename = md5($_SERVER['REQUEST_URI']);
      if (file_exists(DIR_CACHE.$filename)) {
         $this->content = file_get_contents(DIR_CACHE.$filename);
         $result = true;
      }
      else {
         $this->content = "";
         $result = false;
      }
      return $result;
   }

   function process() {
      $this->cfg = config_load();

      if ($this->cfg['htmlcache'] != "no") {
         $this->cache_clear();
         $this->cache_read();
      }
      if ($this->content == "") {
         $this->get_params();
         $this->get_content();
      }
      if ($this->cfg['htmlcache'] != "no") {
         $this->cache_write();
      }
      $this->show_content();
   }

} // class

$tmos_Viewer = new Ttmos_Viewer();
$tmos_Viewer->process();
$tmos_Viewer->clear();
?>