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
require_once "includes/tmos_lp.inc.php";

class Ttmos_Admin {
   
   var $cfg;
   var $db;
   var $it;
   var $ct;
   var $view;
   var $data;
   var $status;

   function Ttmos_Admin() {
      unset($this->cfg);
      unset($this->db);
      unset($this->it);
      unset($this->ct);
      unset($this->view);
      unset($this->data);
      $this->status = array('connect'=>'0', 'schema'=>'0',
                            'ver'=>'?', 'error'=>'?',
                            'gd'=>'0', 'ft'=>'0');
   }

   function get_params() {
      // del magic quotes
      if (function_exists('set_magic_quotes_runtime')) {
         @set_magic_quotes_runtime(0);
      }
      if (get_magic_quotes_gpc() == 1) {
         foreach ($_POST as $key=>$value) {
            if (is_string($value))
               $_POST[$key] = stripslashes($value);
         }
         foreach ($_GET as $key=>$value)
            if (is_string($value))
               $_GET[$key] = stripslashes($value);
      }
      session_start();

      // cfg
      $this->cfg = config_load();
      // status
      if (isset($_SESSION['status_m'])) $this->view['status_m'] = $_SESSION['status_m'];
      else $this->view['status_m'] = "unknown";
      unset($_SESSION['status_m']);
      // actionbtn
      if (isset($_POST['actionbtn'])) $this->view['actionbtn'] = $_POST['actionbtn'];
      else $this->view['actionbtn'] = "unknown";
      // sid
      if (isset($_POST['sid'])) $this->view['sid'] = $_POST['sid'];
      else if (isset($_GET['sid'])) $this->view['sid'] = $_GET['sid'];
      else $this->view['sid'] = -1;
      // action
      if (isset($_POST['action'])) $this->view['action'] = $_POST['action'];
      else if (isset($_GET['action'])) $this->view['action'] = $_GET['action'];
      else {
         $this->view['action'] = "config";
         $this->view['actionbtn'] = "unknown";
         $this->view['status_m'] = "unknown";
      }
      // interface
      require_once "includes/tmos_lang_".$this->cfg['defaultlanguage'].".inc.php";
      $this->it = $tmos_admin_it;
      require_once "includes/tmos_content.inc.php";
      $this->ct = $tmos_admin_ct;
      $this->view['colorscheme'] = $this->cfg['defaultcolorscheme'];
   }

   function get_header() {
      $cd['data_1'] = $this->view['colorscheme'];
      if ($this->view['action'] == 'server_msf')
         $cd['data_2'] = $this->ct['script_1'];
      else
         $cd['data_2'] = '';
      $content = tmpl_replace($this->ct['header_1'], $cd);

      return $content;
   }

   function get_menu_header() {
      $cd = tmpl_null();
      $cd['data_1'] = $this->it['mnu_header'];
      $cd['data_2'] = $_SERVER['PHP_SELF']."?action=config";
      $cd['data_3'] = $this->it['mnu_gs'];
      $cd['data_4'] = $_SERVER['PHP_SELF']."?action=db";
      $cd['data_5'] = $this->it['mnu_db'];
      $cd['data_6'] = $_SERVER['PHP_SELF']."?action=servers";
      $cd['data_7'] = $this->it['mnu_sl'];
      $cd['data_8'] = $_SERVER['PHP_SELF']."?action=userbars";
      $cd['data_9'] = $this->it['mnu_ubl'];
      $cd['data_10'] = $_SERVER['PHP_SELF']."?action=check";
      $cd['data_11'] = $this->it['mnu_chk'];
      $cd['data_12'] = $this->it['mnu_cs'];
      $content = tmpl_replace($this->ct['menu_1'], $cd);

      $sl = array();
      if ($this->status['connect'] == "1" && $this->status['schema'] == "1")
         $this->db->table_servers("sel", $sl);
      if (count($sl) == 0) {
         $cd['data_1'] = $this->it['mnu_csnull'];
         $content .= tmpl_replace($this->ct['menu_2'], $cd);
      }
      else {
         foreach ($sl as $sid=>$sinf) {
            $cd['data_1'] = $_SERVER['PHP_SELF']."?action=server&sid=".$sid;
            $cd['data_2'] = name_html($sinf['b']);
            $content .= tmpl_replace($this->ct['menu_3'], $cd);
         }
      }
      $cd['data_1'] = $_SERVER['PHP_SELF'];
      $content .= tmpl_replace($this->ct['menu_4'], $cd);

      return $content;
   }

   function get_menu_footer() {
      return $this->ct['menu_5'];
   }

   function get_footer() {
      return $this->ct['footer_1'];
   }

   function get_options($assoc, $options, $currvalue) {
      $result= '';
      if ($assoc)
         foreach ($options as $value=>$text) {
            $currvalue == $value ? $selected = " selected" : $selected = "";
            $result .= '<option value="'.$value.'"'.$selected.'>'.$text.'</option>';
         }
      else
         for ($i = 0; $i < $options['count']; $i++) {
            $currvalue == $options[$i] ? $selected = " selected" : $selected = "";
            $result .= '<option value="'.$options[$i].'" '.$selected.'>'.$options[$i].'</option>';
         }
      return $result;
   }

   function get_checkbox($currvalue) {
      $currvalue ? $result = " checked" : $result = "";
      return $result;
   }

   function set_checkbox(&$values, $checkbox) {
      if (!isset($values[$checkbox]))
         $values[$checkbox] = false;
      return true;
   }

   function get_status_content() {
      if ($this->view['status_m'] != "unknown") {
         $cd['data_1'] = $this->view['status_m'];
         $content = tmpl_replace($this->ct['status_1'], $cd);
      }
      else
         $content = "";
      return $content;
   }

   function act_config_before() {
      $this->data = $this->cfg;
      $this->data['status_1'] = "";
      $this->data['status_2'] = "";
      $this->data['status_3'] = "";
   }

   function act_config_after() {
      if (isset($_POST['dbhost']) &&
          isset($_POST['dbtype']) &&
          isset($_POST['dbname']) &&
          isset($_POST['dblogin']) &&
          isset($_POST['dbpassword']) &&
          isset($_POST['defaultlanguage']) &&
          isset($_POST['defaultcolorscheme']) &&
          isset($_POST['defaultrecperpage']) &&
          $this->set_checkbox($_POST, 'javascript') &&
          isset($_POST['servertimeout'])  &&
          $this->set_checkbox($_POST, 'showsingleserver') &&
          $this->set_checkbox($_POST, 'showmonitoring') &&
          $this->set_checkbox($_POST, 'showclans') &&
          $this->set_checkbox($_POST, 'showuserbars') &&
          $this->set_checkbox($_POST, 'showpreferences') &&
          $this->set_checkbox($_POST, 'showlinks') &&
          $this->set_checkbox($_POST, 'showdownloads') &&
          isset($_POST['htmlcache']) &&
          $this->set_checkbox($_POST, 'gzipcompression') &&
          isset($_POST['minclansize']) &&
          isset($_POST['amscore']) &&
          isset($_POST['gmscore']) &&
          isset($_POST['smscore']) &&
          isset($_POST['bmscore']) &&
          isset($_POST['finishscore']) &&
          isset($_POST['adminpass'])) {

          $this->data['dbhost'] = $_POST['dbhost'];
          $this->data['dbtype'] = $_POST['dbtype'];
          $this->data['dbname'] = $_POST['dbname'];
          $this->data['dblogin'] = $_POST['dblogin'];
          $this->data['dbpassword'] = $_POST['dbpassword'];
          $this->data['defaultlanguage'] = $_POST['defaultlanguage'];
          $this->data['defaultcolorscheme'] = $_POST['defaultcolorscheme'];
          $this->data['defaultrecperpage'] = $_POST['defaultrecperpage'];
          $this->data['javascript'] = $_POST['javascript'];
          $this->data['servertimeout'] = $_POST['servertimeout'];
          $this->data['showsingleserver'] = $_POST['showsingleserver'];
          $this->data['showmonitoring'] = $_POST['showmonitoring'];
          $this->data['showclans'] = $_POST['showclans'];
          $this->data['showuserbars'] = $_POST['showuserbars'];
          $this->data['showpreferences'] = $_POST['showpreferences'];
          $this->data['showlinks'] = $_POST['showlinks'];
          $this->data['showdownloads'] = $_POST['showdownloads'];
          $this->data['htmlcache'] = $_POST['htmlcache'];
          $this->data['gzipcompression'] = $_POST['gzipcompression'];
          $this->data['minclansize'] = $_POST['minclansize'];
          $this->data['amscore'] = $_POST['amscore'];
          $this->data['gmscore'] = $_POST['gmscore'];
          $this->data['smscore'] = $_POST['smscore'];
          $this->data['bmscore'] = $_POST['bmscore'];
          $this->data['finishscore'] = $_POST['finishscore'];
          $this->data['adminpass'] = $_POST['adminpass'];

         if (strpos($this->data['dbhost'], '"') ||  strpos($this->data['dbname'], '"') ||
             strpos($this->data['dblogin'], '"') || strpos($this->data['dbpassword'], '"'))
            $this->data['status_1'] = $this->it['com_errorprefix'].
                                      $this->it['gs_doublequotes_err'];
         if (!preg_match("/^[1-9]\d*$/", $this->data['defaultrecperpage']) ||
             $this->data['defaultrecperpage'] < 10) 
            $this->data['status_2'] = $this->it['com_errorprefix'].
                                      $this->it['gs_defaultrecperpage_err']."<br>";
         if (!preg_match("/^[1-9]\d*$/", $this->data['servertimeout']))
            $this->data['status_2'] .= $this->it['com_errorprefix'].
                                       $this->it['gs_servertimeout_err']."<br>";
         if (!preg_match("/^\d+$/", $this->data['minclansize']) ||
             $this->data['minclansize'] < 2)
            $this->data['status_3'] .= $this->it['com_errorprefix'].
                                       $this->it['gs_minclansize_err']."<br>";
         if (!preg_match("/^\d+$/", $this->data['amscore']) || 
             !preg_match("/^\d+$/", $this->data['gmscore']) || 
             !preg_match("/^\d+$/", $this->data['smscore']) || 
             !preg_match("/^\d+$/", $this->data['bmscore']) || 
             !preg_match("/^\d+$/", $this->data['finishscore']))
            $this->data['status_3'] .= $this->it['com_errorprefix'].
                                       $this->it['gs_medalsscore_err']."<br>";

         if ($this->data['status_1'] == "" && $this->data['status_2'] == "" &&
             $this->data['status_3'] == "") {
            if (config_save($this->data))
               $_SESSION['status_m'] = $this->it['com_messageprefix'].$this->it['gs_status_1'];
            else
               $_SESSION['status_m'] = $this->it['com_errorprefix'].$this->it['gs_status_2'];
            header("Location: {$_SERVER['PHP_SELF']}?action=config"); exit;
         }
      }
   }

   function get_config_content() {
      $cd = tmpl_null('-');
      $cd['data_1']  = $this->it['mnu_gs'];
      $cd['data_2']  = $this->it['gs_db_header'];
      $cd['data_3']  = $this->it['gs_dbhost'];
      $cd['data_4']  = htmlspecialchars($this->data['dbhost']);
      $cd['data_5']  = $this->it['gs_dbhost_desc'];
      $cd['data_6']  = $this->it['gs_dbtype'];
      $cd['data_7']  = $this->get_options(true, array("mysql"=>"MySQL", "pg"=>"PostgreSQL",
                                                      "mssql"=>"Microsoft SQL"), $this->data['dbtype']);
      $cd['data_8']  = $this->it['gs_dbtype_desc'];
      $cd['data_9']  = $this->it['gs_dblogin'];
      $cd['data_10'] = htmlspecialchars($this->data['dblogin']);
      $cd['data_11'] = $this->it['gs_dblogin_desc'];
      $cd['data_12'] = $this->it['gs_dbpassword'];
      $cd['data_13'] = htmlspecialchars($this->data['dbpassword']);
      $cd['data_14'] = $this->it['gs_dbpassword_desc'];
      $cd['data_15'] = $this->it['gs_dbname'];
      $cd['data_16'] = htmlspecialchars($this->data['dbname']);
      $cd['data_17'] = $this->it['gs_dbname_desc'];
      $cd['data_18'] = $this->data['status_1'];
      $cd['data_19'] = $this->it['gs_interface_header'];
      $cd['data_20'] = $this->it['gs_defaultlanguage'];
      $cd['data_21'] = $this->get_options(false, languages_load(false), $this->data['defaultlanguage']);
      $cd['data_22'] = $this->it['gs_defaultlanguage_desc'];
      $cd['data_23'] = $this->it['gs_defaultcolorscheme'];
      $cd['data_24'] = $this->get_options(false, css_load(false), $this->data['defaultcolorscheme']);
      $cd['data_25'] = $this->it['gs_defaultcolorscheme_desc'];
      $cd['data_26'] = $this->it['gs_defaultrecperpage'];
      $cd['data_27'] = htmlspecialchars($this->data['defaultrecperpage']);
      $cd['data_28'] = $this->it['gs_defaultrecperpage_desc'];
      $cd['data_29'] = $this->it['gs_javascript'];
      $cd['data_30'] = $this->get_checkbox($this->data['javascript']);
      $cd['data_31'] = $this->it['gs_javascript_desc'];
      $cd['data_32'] = $this->it['gs_servertimeout'];
      $cd['data_33'] = htmlspecialchars($this->data['servertimeout']);
      $cd['data_34'] = $this->it['gs_servertimeout_desc'];
      $cd['data_35'] = $this->it['gs_showsingleserver'];
      $cd['data_36'] = $this->get_checkbox($this->data['showsingleserver']);
      $cd['data_37'] = $this->it['gs_showsingleserver_desc'];
      $cd['data_38'] = $this->it['gs_showmonitoring'];
      $cd['data_39'] = $this->get_checkbox($this->data['showmonitoring']);
      $cd['data_40'] = $this->it['gs_showmonitoring_desc'];
      $cd['data_41'] = $this->it['gs_showclans'];
      $cd['data_42'] = $this->get_checkbox($this->data['showclans']);
      $cd['data_43'] = $this->it['gs_showclans_desc'];
      $cd['data_44'] = $this->it['gs_showuserbars'];
      $cd['data_45'] = $this->get_checkbox($this->data['showuserbars']);
      $cd['data_46'] = $this->it['gs_showuserbars_desc'];
      $cd['data_47'] = $this->it['gs_showpreferences'];
      $cd['data_48'] = $this->get_checkbox($this->data['showpreferences']);
      $cd['data_49'] = $this->it['gs_showpreferences_desc'];
      $cd['data_50'] = $this->it['gs_showlinks'];
      $cd['data_51'] = $this->get_checkbox($this->data['showlinks']);
      $cd['data_52'] = $this->it['gs_showlinks_desc'];
      $cd['data_53'] = $this->it['gs_showdownloads'];
      $cd['data_54'] = $this->get_checkbox($this->data['showdownloads']);
      $cd['data_55'] = $this->it['gs_showdownloads_desc'];

      $cd['data_56'] = $this->it['gs_htmlcache'];
      $cd['data_57'] = $this->get_options(true, array("main"=>$this->it['gs_htmlcache_choice_1'],
                                                      "all"=>$this->it['gs_htmlcache_choice_2'],
                                                      "no"=>$this->it['gs_htmlcache_choice_3']), $this->data['htmlcache']);
      $cd['data_58'] = $this->it['gs_htmlcache_desc'];
      $cd['data_59'] = $this->it['gs_gzipcompression'];
      $cd['data_60'] = $this->get_checkbox($this->data['gzipcompression']);
      $cd['data_61'] = $this->it['gs_gzipcompression_desc'];
      $cd['data_62'] = $this->data['status_2'];
      $cd['data_63'] = $this->it['gs_parsing_header'];
      $cd['data_64'] = $this->it['gs_minclansize'];
      $cd['data_65'] = htmlspecialchars($this->data['minclansize']);
      $cd['data_66'] = $this->it['gs_minclansize_desc'];
      $cd['data_67'] = $this->it['gs_medalsscore'];
      $cd['data_68'] = htmlspecialchars($this->data['amscore']);
      $cd['data_69'] = htmlspecialchars($this->data['gmscore']);
      $cd['data_70'] = htmlspecialchars($this->data['smscore']);
      $cd['data_71'] = htmlspecialchars($this->data['bmscore']);
      $cd['data_72'] = htmlspecialchars($this->data['finishscore']);
      $cd['data_73'] = $this->it['gs_medalsscore_desc'];
      $cd['data_74'] = $this->data['status_3'];
      $cd['data_75'] = $this->it['gs_admin_header'];
      $cd['data_76'] = $this->it['gs_adminpassword'];
      $cd['data_77'] = htmlspecialchars($this->data['adminpass']);
      $cd['data_78'] = $this->it['gs_adminpassword_desc'];
      $cd['data_79'] = $this->it['gs_action_header'];
      $cd['data_80'] = $this->it['gs_savecfg_btn'];
      $cd['data_81'] = $this->it['gs_savecfg_desc'];

      $content = tmpl_replace($this->ct['config_1'], $cd);
       
      return $content;
   }

   function act_db_before() {
      if ($this->status['connect'] == "1")
         $this->data = $this->db->instance_schema_status();
   }

   function act_db_after() {
      if ($this->view['actionbtn'] == $this->it['db_updatedb_btn']) {
         $this->view['action'] = "db_upd";
      }
      else if ($this->view['actionbtn'] == $this->it['db_createtables_btn']) {
         $this->db->tables_create();
      }
      else if ($this->view['actionbtn'] == $this->it['db_droptables_btn']) {
         $this->db->tables_drop();
      }
      else if ($this->view['actionbtn'] == $this->it['db_resetdata_btn']) {
         $this->db->tables_clear(false);

         $data = array();
         $this->db->table_servers("sel", $data);
         foreach($data as $sid=>$sinf) {
            $data[$sid]['rs'] = 'u';
            $data[$sid]['i'] = logfiles_merge(logfiles_split($data[$sid]['i'], true), true);
            $data[$sid]['j'] = '';
            $data[$sid]['k'] = '-';
         }
         $this->db->table_servers("mod", $data);
      }
      else if ($this->view['actionbtn'] == $this->it['db_cleardata_btn']) {
         $this->db->tables_clear(true);
      }
      
      if ($this->view['actionbtn'] != $this->it['db_updatedb_btn']) {
         if ($this->db->last_error != '')
            $_SESSION['status_m'] = $this->it['com_errorprefix'].$this->db->last_error();
         else
            $_SESSION['status_m'] = $this->it['com_messageprefix'].$this->it['db_status_1'];
         header("Location: {$_SERVER['PHP_SELF']}?action=db"); exit;
      }
   }

   function get_db_content() {
      $cd['data_1'] = $this->it['mnu_db'];
      $cd['data_2'] = $this->it['db_status_header'];
      $content = tmpl_replace($this->ct['db_1'], $cd);

      if ($this->status['connect'] != "1") {
         $cd['data_1'] = $this->status['error'];
         $content .= tmpl_replace($this->ct['db_2'], $cd);
      }
      else {
         $cd['data_1'] = $this->data['ver'];
         $cd['data_2'] = $this->it['db_table_header'];
         $cd['data_3'] = $this->it['db_tablestate_header'];
         $cd['data_4'] = $this->it['db_tablerecords_header'];
         $content .= tmpl_replace($this->ct['db_3'], $cd);

         $state_text = array("-1" => $this->it['db_tablestatus_2'],
                              "1" => $this->it['db_tablestatus_1'],
                              "0" => $this->it['db_tablestatus_3']);
         for ($i = 0; $i < $this->data['count']; $i++) {
            $cd['data_1'] = $this->data[$i]['table'];
            $cd['data_2'] = $state_text[$this->data[$i]['status']];
            $cd['data_3'] = $this->data[$i]['record_count'];
            $content .= tmpl_replace($this->ct['db_4'], $cd);
         }

         $cd['data_1'] = $this->it['db_action_header'];
         $content .= tmpl_replace($this->ct['db_5'], $cd);

         if ($this->data['update'] == '1') {
            $cd['data_1'] = $this->it['db_updatedb_btn'];
            $cd['data_2'] = $this->it['db_updatedb_desc'];
            $content .= tmpl_replace($this->ct['db_6'], $cd);
         }
         if ($this->status['schema'] == "1") {
            $cd['data_1'] = $this->it['db_createtables_btn'];
            $cd['data_2'] = $this->it['db_createtables_desc'];
            $cd['data_3'] = $this->it['db_droptables_btn'];
            $cd['data_4'] = $this->it['db_droptables_desc'];
            $cd['data_5'] = $this->it['db_resetdata_btn'];
            $cd['data_6'] = $this->it['db_resetdata_desc'];
            $cd['data_7'] = $this->it['db_cleardata_btn'];
            $cd['data_8'] = $this->it['db_cleardata_desc'];
            $content .= tmpl_replace($this->ct['db_7'], $cd);
         }
         else {
            $cd['data_1'] = $this->it['db_createtables_btn'];
            $cd['data_2'] = $this->it['db_createtables_desc'];
            $cd['data_3'] = $this->it['db_droptables_btn'];
            $cd['data_4'] = $this->it['db_droptables_desc'];
            $content .= tmpl_replace($this->ct['db_8'], $cd);
         }
      }
      $content .= $this->ct['db_9'];
      return $content;
   }

   function act_db_upd_after() {
      if ($this->view['actionbtn'] == $this->it['db_updatedb_btn']) {
         $this->db->update($this->data['ver']);
         if ($this->db->last_error() == '') {
            $LP = new Ttmos_LP();
            $status = $LP->Go("!");
            $_SESSION['status_m'] = $this->it['com_messageprefix'].
                                    $this->it['db_status_1'];
         }
         else {
            $_SESSION['status_m'] = $this->it['com_errorprefix'].
                                    $this->db->last_error();
         }
      }
      else if ($this->view['actionbtn'] == $this->it['db_cancel_btn']) {
         $_SESSION['status_m'] = $this->it['com_messageprefix'].
                                 $this->it['db_status_2'];
      }
      header("Location: {$_SERVER['PHP_SELF']}?action=db"); exit;
   }

   function get_db_upd_content() {
      $cd['data_1'] = $this->it['mnu_db'];
      $cd['data_2'] = $this->it['mnu_dbupd'];
      $cd['data_3'] = $this->it['db_updinfo_header'];
      if ($this->data['support'] == '1') {
         $cd['data_4'] = str_replace("{0}", $this->data['ver'], $this->it['db_updinfo_text']);
         $cd['data_4'] = str_replace("{1}", $this->data['ver_last'], $cd['data_4']);
      }
      else {
         $cd['data_4'] = str_replace("{0}", $this->data['ver'], $this->it['db_support_err']);
      }
      $content = tmpl_replace($this->ct['db_10'], $cd);
      if ($this->data['support'] == '1') {
         $cd['data_1'] = $this->it['db_action_header'];
         $cd['data_2'] = $this->it['db_updatedb_btn'];
         $cd['data_3'] = $this->it['db_updatedb_desc'];
         $cd['data_4'] = $this->it['db_cancel_btn'];
         $cd['data_5'] = $this->it['db_cancel_desc'];
         $content .= tmpl_replace($this->ct['db_11'], $cd);
      }
      else {
         $cd['data_1'] = $this->it['db_action_header'];
         $cd['data_2'] = $this->it['db_cancel_btn'];
         $cd['data_3'] = $this->it['db_cancel_desc'];
         $content .= tmpl_replace($this->ct['db_12'], $cd);
      }
      return $content;
   }
   
   function act_servers_before() {
      if ($this->status['connect'] == "1" && $this->status['schema'] == "1") {
         $this->data = array();
         $this->db->table_servers("sel", $this->data);
      }
   }

   function act_servers_after() {
      if ($this->view['actionbtn'] == $this->it['sl_addserver_btn']) {
         $this->data = array(
            "b"=>"My New Server", "d"=>"localhost:5000",
            "e"=>"", "f"=>"SuperAdmin",
            "g"=>"SuperAdmin", "h"=>DIR_FILES,
            "i"=>"", "status_1"=>"");
         $this->view['action'] = "servers_add";
      }
      else if ($this->view['actionbtn'] == $this->it['sl_deleteservers_btn']) {
         foreach ($this->data as $sid=>$sinf) {
            if (isset($_POST['serverid_'.$sid]) && $sid == $_POST['serverid_'.$sid])
               $this->data[$sid]['rs'] = 'd';
            else
               unset($this->data[$sid]);
         }
         if (count($this->data) == 0) {
            $_SESSION['status_m'] = $this->it['com_errorprefix'].
                                    $this->it['sl_status_3'];
         }
         else {
            $this->db->table_servers("mod", $this->data, true);
            if ($this->db->last_error != '')
               $_SESSION['status_m'] = $this->it['com_errorprefix'].
                                       $this->db->last_error();
            else
               $_SESSION['status_m'] = $this->it['com_messageprefix'].
                                       $this->it['sl_status_2'];
         }
         header("Location: {$_SERVER['PHP_SELF']}?action=servers"); exit;
      }
      else if ($this->view['actionbtn'] == $this->it['sl_modifyservers_btn']) {
         foreach ($this->data as $sid=>$sinf) {
            if (isset($_POST['serverid_'.$sid]) && $sid == $_POST['serverid_'.$sid]) {
               $this->data[$sid]['h'] = trackdirs_tostr($sinf['h']);
               $this->data[$sid]['i'] = logfiles_tostr($sinf['i']);
            }
            else
               unset($this->data[$sid]);
         }
         if (count($this->data) == 0) {
            $_SESSION['status_m'] = $this->it['com_errorprefix'].
                                    $this->it['sl_status_3'];
            header("Location: {$_SERVER['PHP_SELF']}?action=servers"); exit;
         }
         $this->view['action'] = "servers_mod";
      }
   }

   function get_servers_content() {
      $cd['data_1'] = $this->it['mnu_sl'];
      $cd['data_2'] = $this->it['sl_status_header'];
      $content = tmpl_replace($this->ct['servers_1'], $cd);
      // ne connect
      if ($this->status['connect'] != "1" || $this->status['schema'] != "1") {
         if ($this->status['error'] != '?')
            $cd['data_1'] = $this->status['error'];
         else
            $cd['data_1'] = $this->status['ver'];
         $content .= tmpl_replace($this->ct['servers_2'], $cd);
      }
      //connect
      else {
         // net serverov
         if (sizeof($this->data) == 0) {
            $cd['data_1'] = $this->status['ver'];
            $cd['data_2'] = $this->it['sl_servers_header'];
            $cd['data_3'] = $this->it['sl_action_header'];
            $cd['data_4'] = $this->it['sl_addserver_btn'];
            $cd['data_5'] = $this->it['sl_addserver_desc'];
            $content .= tmpl_replace($this->ct['servers_3'], $cd);
         }
         else {
            // est' servera
            $cd['data_1'] = $this->status['ver'];
            $cd['data_2'] = $this->it['sl_servers_header'];
            $cd['data_3'] = sizeof($this->data);
            $content .= tmpl_replace($this->ct['servers_4'], $cd);
            foreach ($this->data as $sid=>$sinf) {
               $cd['data_1']  = $sinf['d'];
               $cd['data_2']  = name_html($sinf['b']);
               $cd['data_3']  = $this->it['sl_id'];
               $cd['data_4']  = $sid;
               $cd['data_5']  = $this->it['sl_game'];
               $cd['data_6']  = game_fromid($sinf['e']);
               $cd['data_7']  = $this->it['sl_login'];
               $cd['data_8']  = $sinf['f'];
               $cd['data_9']  = $this->it['sl_password'];
               $cd['data_10'] = $sinf['g'];
               $cd['data_11'] = $this->it['sl_trackdirs'];
               $cd['data_12'] = '';
               $tmp = trackdirs_split($sinf['h']);
               for ($i = 0; $i < $tmp['count']; $i++) {
                  $sd['data_1'] = $tmp[$i]['shortname'];
                  $cd['data_12'] .= tmpl_replace($this->ct['servers_12'], $sd);
               }
               $cd['data_13'] = $this->it['sl_logfiles'];
               $cd['data_14'] = '';
               $tmp = logfiles_split($sinf['i'], false);
               for ($i = 0; $i < $tmp['count']; $i++) {
                  $sd['data_1'] = $tmp[$i]['shortname'];
                  $cd['data_14'] .= tmpl_replace($this->ct['servers_12'], $sd);
               }
               $cd['data_15'] = "serverid_".$sid;
               $cd['data_16'] = $sid;
               $content .= tmpl_replace($this->ct['servers_5'], $cd);
            }
            $cd['data_1'] = $this->it['sl_action_header'];
            $cd['data_2'] = $this->it['sl_addserver_btn'];
            $cd['data_3'] = $this->it['sl_addserver_desc'];
            $cd['data_4'] = $this->it['sl_deleteservers_btn'];
            $cd['data_5'] = $this->it['sl_deleteservers_desc'];
            $cd['data_6'] = $this->it['sl_modifyservers_btn'];
            $cd['data_7'] = $this->it['sl_modifyservers_desc'];
            $content .= tmpl_replace($this->ct['servers_6'], $cd);
         }
      }
      $content .= $this->ct['servers_7'];

      return $content;
   }

   function act_servers_add_after() {
      if (($this->view['actionbtn'] == $this->it['sl_addserver_btn']) &&
          isset($_POST['ip']) &&
          isset($_POST['server']) &&
          isset($_POST['game']) &&
          isset($_POST['login']) &&
          isset($_POST['password']) &&
          isset($_POST['trackdirs']) &&
          isset($_POST['logfiles'])) {

         $this->data['rs'] = 'i';
         $this->data['b'] = $_POST['server'];
         $this->data['c'] = name_clear($_POST['server']);
         $this->data['d'] = $_POST['ip'];
         $this->data['e'] = $_POST['game'];
         $this->data['f'] = $_POST['login'];
         $this->data['g'] = $_POST['password'];
         if (strpos($_POST['trackdirs'], DIR_FILES) !== false)
            $this->data['h'] = trackdirs_fromstr($_POST['trackdirs']);
         else
            $this->data['h'] = trackdirs_fromstr($_POST['trackdirs'].";".DIR_FILES);
         $this->data['i'] = logfiles_fromstr($_POST['logfiles']);
         $this->data['j'] = '';
         $this->data['k'] = '-';

         if (strpos($this->data['b'], '"') !== false ||
             strpos($this->data['d'], '"') !== false ||
             strpos($this->data['f'], '"') !== false ||
             strpos($this->data['g'], '"') !== false ||
             strpos($this->data['i'], '"') !== false ||
             strpos($this->data['h'], '"') !== false)
            $this->data['status_1'] = $this->it['com_errorprefix'].
                                      $this->it['sl_doublequotes_err'];
         if ($this->data['status_1'] == "") {
            $this->data = array("?"=>$this->data);
            $this->db->table_servers("mod", $this->data);
            if ($this->db->last_error != '')
               $_SESSION['status_m'] = $this->it['com_errorprefix'].
                                       $this->db->last_error();
            else
               $_SESSION['status_m'] = $this->it['com_messageprefix'].
                                       $this->it['sl_status_2'];
            header("Location: {$_SERVER['PHP_SELF']}?action=servers"); exit;
         }
         else
            $this->data['i'] = logfiles_tostr($this->data['i']);
      }
      else if ($this->view['actionbtn'] == $this->it['sl_cancel_btn']) {
         $_SESSION['status_m'] = $this->it['com_messageprefix'].
                                 $this->it['sl_status_1'];
         header("Location: {$_SERVER['PHP_SELF']}?action=servers"); exit;
      }
   }

   function get_servers_add_content() {
      $cd['data_1']  = $this->it['mnu_sl'];
      $cd['data_2']  = $this->it['mnu_sladd'];
      $cd['data_3']  = $this->it['sl_add_header'];
      $cd['data_4']  = $this->it['sl_ip'];
      $cd['data_5']  = htmlspecialchars($this->data['d']);
      $cd['data_6']  = $this->it['sl_ip_desc'];
      $cd['data_7']  = $this->it['sl_server'];
      $cd['data_8']  = htmlspecialchars($this->data['b']);
      $cd['data_9']  = $this->it['sl_server_desc'];
      $cd['data_10']  = $this->it['sl_game'];
      $cd['data_11'] = $this->get_options(true, games(), $this->data['e']);
      $cd['data_12'] = $this->it['sl_game_desc'];
      $cd['data_13'] = $this->it['sl_login'];
      $cd['data_14'] = htmlspecialchars($this->data['f']);
      $cd['data_15'] = $this->it['sl_login_desc'];
      $cd['data_16'] = $this->it['sl_password'];
      $cd['data_17'] = htmlspecialchars($this->data['g']);
      $cd['data_18'] = $this->it['sl_password_desc'];
      $cd['data_19'] = $this->it['sl_logfiles'];
      $cd['data_20'] = htmlspecialchars($this->data['i']);
      $cd['data_21'] = $this->it['sl_logfiles_desc'];
      $cd['data_22'] = $this->it['sl_trackdirs'];
      $cd['data_23'] = htmlspecialchars($this->data['h']);
      $cd['data_24'] = $this->it['sl_trackdirs_desc'];
      $cd['data_25'] = $this->data['status_1'];
      $cd['data_26'] = $this->it['sl_action_header'];
      $cd['data_27'] = $this->it['sl_addserver_btn'];
      $cd['data_28'] = $this->it['sl_addserver_desc'];
      $cd['data_29'] = $this->it['sl_cancel_btn'];
      $cd['data_30'] = $this->it['sl_cancel_desc'];
      $content = tmpl_replace($this->ct['servers_8'], $cd);

      return $content;
   }

   function act_servers_mod_after() {
      if ($this->view['actionbtn'] == $this->it['sl_modifyservers_btn']) {
         foreach ($this->data as $sid=>$sinf) {
            if (isset($_POST["ip_$sid"]) &&
                isset($_POST["server_$sid"]) &&
                isset($_POST["game_$sid"]) &&
                isset($_POST["login_$sid"]) &&
                isset($_POST["logfiles_$sid"]) &&
                isset($_POST["trackdirs_$sid"])) {

               $this->data[$sid]['rs'] = 'u';
               $this->data[$sid]['b'] = $_POST['server_'.$sid];
               $this->data[$sid]['c'] = name_clear($_POST['server_'.$sid]);
               $this->data[$sid]['d'] = $_POST['ip_'.$sid];
               $this->data[$sid]['e'] = $_POST['game_'.$sid];
               $this->data[$sid]['f'] = $_POST['login_'.$sid];
               $this->data[$sid]['g'] = $_POST['password_'.$sid];
               if (strpos($_POST['trackdirs_'.$sid], DIR_FILES) !== false)
                  $this->data[$sid]['h'] = trackdirs_fromstr($_POST['trackdirs_'.$sid]);
               else
                  $this->data[$sid]['h'] = trackdirs_fromstr($_POST['trackdirs_'.$sid].";".DIR_FILES);
               $this->data[$sid]['i'] = logfiles_fromstr($_POST['logfiles_'.$sid]);
            }
         }

         $this->db->table_servers("mod", $this->data);
         if ($this->db->last_error != '')
            $_SESSION['status_m'] = $this->it['com_errorprefix'].
                                    $this->db->last_error();
         else
            $_SESSION['status_m'] = $this->it['com_messageprefix'].
                                    $this->it['sl_status_2'];
         header("Location: {$_SERVER['PHP_SELF']}?action=servers"); exit;
      }
      else if ($this->view['actionbtn'] == $this->it['sl_cancel_btn']) {
         $_SESSION['status_m'] = $this->it['com_messageprefix'].
                                 $this->it['sl_status_1'];
         header("Location: {$_SERVER['PHP_SELF']}?action=servers"); exit;
      }
   }

   function get_servers_mod_content() {
      $cd['data_1']  = $this->it['mnu_sl'];
      $cd['data_2']  = $this->it['mnu_slmod'];
      $content = tmpl_replace($this->ct['servers_9'], $cd);
      
      foreach ($this->data as $sid=>$sinf) {
         $cd['data_1']  = $sid;
         $cd['data_2']  = $sid;
         $cd['data_3']  = $this->it['sl_mod_header'];
         $cd['data_4']  = $sid;
         $cd['data_5']  = $this->it['sl_ip'];
         $cd['data_6']  = $sinf['d'];
         $cd['data_7']  = $this->it['sl_ip_desc'];
         $cd['data_8']  = $this->it['sl_server'];
         $cd['data_9']  = $sinf['b'];
         $cd['data_10'] = $this->it['sl_server_desc'];
         $cd['data_11'] = $this->it['sl_game'];
         $cd['data_12'] = $this->get_options(true, games(), $sinf['e']);
         $cd['data_13'] = $this->it['sl_game_desc'];
         $cd['data_14'] = $this->it['sl_login'];
         $cd['data_15'] = $sinf['f'];
         $cd['data_16'] = $this->it['sl_login_desc'];
         $cd['data_17'] = $this->it['sl_password'];
         $cd['data_18'] = $sinf['g'];
         $cd['data_19'] = $this->it['sl_password_desc'];
         $cd['data_20'] = $this->it['sl_logfiles'];
         $cd['data_21'] = $sinf['i'];
         $cd['data_22'] = $this->it['sl_logfiles_desc'];
         $cd['data_23'] = $this->it['sl_trackdirs'];
         $cd['data_24'] = $sinf['h'];
         $cd['data_25'] = $this->it['sl_trackdirs_desc'];
         $content .= tmpl_replace($this->ct['servers_10'], $cd);
      }
      $cd['data_1'] = $this->it['sl_action_header'];
      $cd['data_2'] = $this->it['sl_modifyservers_btn'];
      $cd['data_3'] = $this->it['sl_modifyservers_desc'];
      $cd['data_4'] = $this->it['sl_cancel_btn'];
      $cd['data_5'] = $this->it['sl_cancel_desc'];
      $content .= tmpl_replace($this->ct['servers_11'], $cd);
      
      return $content;
   }

   function act_userbars_before() {
      if (!function_exists('imagepng')) {
         $this->status['gd'] = "0";
         $this->status['ft'] = "0";
      }
      else {
         $this->data = userbars_load("");
         $this->status['gd'] = "1";
         if (!function_exists('imagettftext'))
            $this->status['ft'] = "0";
         else
            $this->status['ft'] = "1";
      }
   }

   function act_userbars_after() {
      if ($this->view['actionbtn'] == $this->it['ub_adduserbar_btn']) {
         $ubid = 1;
         while (isset($this->data[sprintf("%04d", $ubid)])) {
            $ubid++;
         }
         $this->data = array(
            "imgfile"=> "",
            "ubid"=>sprintf("%04d", $ubid),
            "game"=>"",
            "ubt"=>"",
            "font1"=>"arialuni.ttf",
            "size1"=>9,
            "color1"=>"000000",
            "font2"=>"arialuni.ttf",
            "size2"=>9,
            "color2"=>"000000",
            "status_1"=>"");
         $this->view['action'] = "userbars_add";
      }
      else if ($this->view['actionbtn'] == $this->it['ub_modifyuserbars_btn']) {
         foreach ($this->data as $ubid=>$ubinf) {
            if (!isset($_POST['userbarid_'.$ubid]) ||
                $ubid != $_POST['userbarid_'.$ubid])
               unset($this->data[$ubid]);
            else
               $this->data[$ubid]['status_1'] = "";
         }
         if (count($this->data) == 0) {
            $_SESSION['status_m'] = $this->it['com_errorprefix'].
                                    $this->it['ub_status_4'];
            header("Location: {$_SERVER['PHP_SELF']}?action=userbars"); exit;
         }
         $this->view['action'] = "userbars_mod";
      }
      else if ($this->view['actionbtn'] == $this->it['ub_deleteuserbars_btn']) {
         $flag = -2;
         foreach ($this->data as $ubid=>$ubinf) {
            if (!isset($_POST['userbarid_'.$ubid]) ||
                $ubid != $_POST['userbarid_'.$ubid])
               unset($this->data[$ubid]);
            else if (!@unlink(DIR_USERBARS.$ubinf['file'])) 
               $flag = -1;
            else if ($flag != -1)
               $flag = 0;
         }
         if ($flag == -2)
            $_SESSION['status_m'] = $this->it['com_errorprefix'].
                                    $this->it['ub_status_4'];
         else if ($flag == -1)
            $_SESSION['status_m'] = $this->it['com_errorprefix'].
                                    $this->it['ub_status_3'];
         else
            $_SESSION['status_m'] = $this->it['com_messageprefix'].
                                    $this->it['ub_status_2'];
         header("Location: {$_SERVER['PHP_SELF']}?action=userbars"); exit;
      }
   }

   function get_userbars_content() {
      $cd['data_1'] = $this->it['mnu_ubl'];
      $cd['data_2'] = $this->it['ub_status_header'];
      $content = tmpl_replace($this->ct['userbars_1'], $cd);
      if ($this->status['gd'] == "0") {
         $cd['data_1'] = $this->it['ub_gdstatus_2'];
         $content .= tmpl_replace($this->ct['userbars_2'], $cd);
      }
      else if (count($this->data) == 0) {
         $cd['data_1'] = $this->it['ub_gdstatus_1'];
         $cd['data_2'] = $this->it['ub_userbars_header'];
         $cd['data_3'] = $this->it['ub_action_header'];
         $cd['data_4'] = $this->it['ub_adduserbar_btn'];
         $cd['data_5'] = $this->it['ub_adduserbar_desc'];
         $content .= tmpl_replace($this->ct['userbars_3'], $cd);
      }
      else {
         if ($this->status['ft'] == "1")
            $cd['data_1'] = $this->it['ub_gdstatus_1'];
         else
            $cd['data_1'] = $this->it['ub_gdstatus_2'];
         $cd['data_2'] = $this->it['ub_userbars_header'];
         $cd['data_3'] = count($this->data);
         $content .= tmpl_replace($this->ct['userbars_4'], $cd);
         
         $host = $_SERVER['HTTP_HOST'];
         $uri = dirname(rtrim($_SERVER['PHP_SELF'], "\\/"));
         if($uri == '\\' || $uri == '/') $uri = '';
         $baselink = "http://$host$uri/tmos_userbar.php".UB_QUERY_DELIM;

         $state_class = array(true  => $this->ct['check_2'],
                              false => $this->ct['check_1']);
         foreach ($this->data as $ubid=>$ubinf) {
            $cd['data_1']  = $this->it['ub_id'];
            $cd['data_2']  = $ubid;
            $cd['data_3']  = $this->it['ub_game'];
            $cd['data_4']  = game_fromid($ubinf['game']);
            $cd['data_5']  = $this->it['ub_font1'];
            $cd['data_6'] = $state_class[file_exists(DIR_FONTS.$ubinf['font1'])];
            $cd['data_7']  = $ubinf['font1'];
            $cd['data_8']  = $ubinf['color1'];
            $cd['data_9']  = $ubinf['size1'];
            $cd['data_10']  = $this->it['ub_font2'];
            $cd['data_11'] = $state_class[file_exists(DIR_FONTS.$ubinf['font2'])];
            $cd['data_12'] = $ubinf['font2'];
            $cd['data_13'] = $ubinf['color2'];
            $cd['data_14'] = $ubinf['size2'];
            $cd['data_15'] = $baselink."tmos_{$ubid}_0_preview.png";
            $cd['data_16'] = "userbarid_$ubid";
            $cd['data_17'] = $ubid;
            $content .= tmpl_replace($this->ct['userbars_5'], $cd);
         }
         $cd['data_1'] = $this->it['ub_action_header'];
         $cd['data_2'] = $this->it['ub_adduserbar_btn'];
         $cd['data_3'] = $this->it['ub_adduserbar_desc'];
         $cd['data_4'] = $this->it['ub_deleteuserbars_btn'];
         $cd['data_5'] = $this->it['ub_deleteuserbars_desc'];
         $cd['data_6'] = $this->it['ub_modifyuserbars_btn'];
         $cd['data_7'] = $this->it['ub_modifyuserbars_desc'];
         $content .= tmpl_replace($this->ct['userbars_6'], $cd);
      }
      $content .= $this->ct['userbars_7'];
      return $content;
   }

   function act_userbars_add_after() {
      if (($this->view['actionbtn'] == $this->it['ub_adduserbar_btn']) &&
           isset($_FILES['imgfile']['tmp_name']) &&
           isset($_POST['game']) &&
           isset($_POST['ubt']) &&
           isset($_POST['font1']) &&
           isset($_POST['font2']) &&
           isset($_POST['color1']) &&
           isset($_POST['color2']) &&
           isset($_POST['size1']) &&
           isset($_POST['size2'])) {

         
         $this->data['imgfile'] = $_FILES['imgfile']['tmp_name'];
         $this->data['game'] = $_POST['game'];
         $this->data['ubt'] = $_POST['ubt'];
         $this->data['font1'] = $_POST['font1'];
         $this->data['size1'] = $_POST['size1'];
         $this->data['color1'] = $_POST['color1'];
         $this->data['font2'] = $_POST['font2'];
         $this->data['size2'] = $_POST['size2'];
         $this->data['color2'] = $_POST['color2'];

         $imgstatus = 'ok';
         if ($this->data['imgfile'] == "")
            $imgstatus = 'error';
         if ($imgstatus != 'error') {
            $buf = @filesize($this->data['imgfile']);
            if (!$buf || $buf > 102400)
               $imgstatus = 'error';
         }
         if ($imgstatus != 'error') {
            $buf = @getimagesize($this->data['imgfile']);
            if (!$buf || $buf[2] != 3 ||
                 $buf['0'] > 600 || $buf['1'] > 100)
               $imgstatus = 'error';
         }
         if ($imgstatus == 'error')
            $this->data['status_1'] .= $this->it['com_errorprefix'].
                                       $this->it['ub_imgfile_err']."<br>";
         if (!file_exists(DIR_FONTS.$this->data['font1']))
            $this->data['status_1'] .= $this->it['com_errorprefix'].
                                       $this->it['ub_font1_err']."<br>";
         if (!file_exists(DIR_FONTS.$this->data['font2']))
            $this->data['status_1'] .= $this->it['com_errorprefix'].
                                       $this->it['ub_font2_err']."<br>";
         if (!preg_match("/^[0-9A-Fa-f]{6}$/", $this->data['color1']))
            $this->data['status_1'] .= $this->it['com_errorprefix'].
                                       $this->it['ub_color1_err']."<br>";
         if (!preg_match("/^[0-9A-Fa-f]{6}$/", $this->data['color2']))
            $this->data['status_1'] .= $this->it['com_errorprefix'].
                                       $this->it['ub_color2_err']."<br>";
         if (!preg_match("/^[1-9]\d*$/", $this->data['size1']) ||
             $this->data['size1'] < 1)
            $this->data['status_1'] .= $this->it['com_errorprefix'].
                                       $this->it['ub_size1_err']."<br>";
         if (!preg_match("/^[1-9]\d*$/", $this->data['size2']) ||
             $this->data['size2'] < 1)
            $this->data['status_1'] .= $this->it['com_errorprefix'].
                                       $this->it['ub_size2_err']."<br>";
         if ($this->data['status_1'] == "") {
            if (move_uploaded_file($_FILES['imgfile']['tmp_name'],
                                   DIR_USERBARS."tmosub_".
                                   $this->data['ubid']."_".
                                   $this->data['game']."_".
                                   $this->data['ubt']."_".
                                   $this->data['font1']."_".
                                   $this->data['size1']."_".
                                   $this->data['color1']."_".
                                   $this->data['font2']."_".
                                   $this->data['size2']."_".
                                   $this->data['color2'].".png"))
               $_SESSION['status_m'] = $this->it['com_messageprefix'].$this->it['ub_status_2'];
            else
               $_SESSION['status_m'] = $this->it['com_errorprefix'].$this->it['ub_status_3'];
            header("Location: {$_SERVER['PHP_SELF']}?action=userbars"); exit;
         }
      }
      else if ($this->view['actionbtn'] == $this->it['ub_cancel_btn']) {
         $_SESSION['status_m'] = $this->it['com_messageprefix'].$this->it['ub_status_1'];
         header("Location: {$_SERVER['PHP_SELF']}?action=userbars"); exit;
      }
   }

   function get_userbars_add_content() {
      $cd['data_1']  = $this->it['mnu_ubl'];
      $cd['data_2']  = $this->it['mnu_ubladd'];
      $cd['data_3']  = $this->it['ub_add_header'];
      $cd['data_4']  = $this->it['ub_imgfile'];
      $cd['data_5']  = $this->data['imgfile'];
      $cd['data_6']  = $this->it['ub_game'];
      $cd['data_7']  = $this->get_options(true, games(), $this->data['game']);
      $cd['data_8']  = $this->it['ub_type'];
      $cd['data_9']  = $this->get_options(true, array("o"=>"Overall", "ow"=>"Overall wide",
         "et"=>"Envirs text", "eg"=>"Envirs graphics"), $this->data['ubt']);
      $cd['data_10'] = $this->it['ub_font1'];
      $cd['data_11'] = $this->data['font1'];
      $cd['data_12'] = $this->data['color1'];
      $cd['data_13'] = $this->data['size1'];
      $cd['data_14'] = $this->it['ub_font2'];
      $cd['data_15'] = $this->data['font2'];
      $cd['data_16'] = $this->data['color2'];
      $cd['data_17'] = $this->data['size2'];
      $cd['data_18'] = $this->data['status_1'];
      $cd['data_19'] = $this->it['ub_action_header'];
      $cd['data_20'] = $this->it['ub_adduserbar_btn'];
      $cd['data_21'] = $this->it['ub_adduserbar_desc'];
      $cd['data_22'] = $this->it['ub_cancel_btn'];
      $cd['data_23'] = $this->it['ub_cancel_desc'];

      $content = tmpl_replace($this->ct['userbars_8'], $cd);

      return $content;
   }

   function act_userbars_mod_after() {
      if ($this->view['actionbtn'] == $this->it['ub_modifyuserbars_btn']) {
         $flag = true;
         foreach ($this->data as $ubid=>$ubinf) {
            if (isset($_POST["userbarid_$ubid"]) &&
                isset($_POST["game_$ubid"]) &&
                isset($_POST["ubt_$ubid"]) &&
                isset($_POST["font1_$ubid"]) &&
                isset($_POST["color1_$ubid"]) &&
                isset($_POST["size1_$ubid"]) &&
                isset($_POST["font2_$ubid"]) &&
                isset($_POST["color2_$ubid"]) &&
                isset($_POST["size2_$ubid"])) {

               $this->data[$ubid]['game'] = $_POST['game_'.$ubid];
               $this->data[$ubid]['ubt'] = $_POST['ubt_'.$ubid];
               $this->data[$ubid]['font1'] = $_POST['font1_'.$ubid];
               $this->data[$ubid]['color1'] = $_POST['color1_'.$ubid];
               $this->data[$ubid]['size1'] = $_POST['size1_'.$ubid];
               $this->data[$ubid]['font2'] = $_POST['font2_'.$ubid];
               $this->data[$ubid]['color2'] = $_POST['color2_'.$ubid];
               $this->data[$ubid]['size2'] = $_POST['size2_'.$ubid];

               if (!file_exists(DIR_FONTS.$this->data[$ubid]['font1']))
                  $this->data[$ubid]['status_1'] .= $this->it['com_errorprefix'].
                                             $this->it['ub_font1_err']."<br>";
               if (!file_exists(DIR_FONTS.$this->data[$ubid]['font2']))
                  $this->data[$ubid]['status_1'] .= $this->it['com_errorprefix'].
                                             $this->it['ub_font2_err']."<br>";
               if (!preg_match("/^[0-9A-Fa-f]{6}$/", $this->data[$ubid]['color1']))
                  $this->data[$ubid]['status_1'] .= $this->it['com_errorprefix'].
                                             $this->it['ub_color1_err']."<br>";
               if (!preg_match("/^[0-9A-Fa-f]{6}$/", $this->data[$ubid]['color2']))
                  $this->data[$ubid]['status_1'] .= $this->it['com_errorprefix'].
                                             $this->it['ub_color2_err']."<br>";
               if (!preg_match("/^[1-9]\d*$/", $this->data[$ubid]['size1']) ||
                   $this->data[$ubid]['size1'] < 1)
                  $this->data[$ubid]['status_1'] .= $this->it['com_errorprefix'].
                                             $this->it['ub_size1_err']."<br>";
               if (!preg_match("/^[1-9]\d*$/", $this->data[$ubid]['size2']) ||
                  $this->data[$ubid]['size2'] < 1)
                  $this->data[$ubid]['status_1'] .= $this->it['com_errorprefix'].
                                             $this->it['ub_size2_err']."<br>";

               if ($this->data[$ubid]['status_1'] != "")
                  $flag = false;
            }
         }
         
         if ($flag == true) {
            foreach ($this->data as $ubid=>$ubinf) {
               if (!rename(DIR_USERBARS.$ubinf['file'],
                           DIR_USERBARS."tmosub_".
                           $this->data[$ubid]['ubid']."_".
                           $this->data[$ubid]['game']."_".
                           $this->data[$ubid]['ubt']."_".
                           $this->data[$ubid]['font1']."_".
                           $this->data[$ubid]['size1']."_".
                           $this->data[$ubid]['color1']."_".
                           $this->data[$ubid]['font2']."_".
                           $this->data[$ubid]['size2']."_".
                           $this->data[$ubid]['color2'].".png"))
                  $flag = false;
            }
            if ($flag == false)
               $_SESSION['status_m'] = $this->it['com_errorprefix'].
                                       $this->it['ub_status_3'];
            else
               $_SESSION['status_m'] = $this->it['com_messageprefix'].
                                       $this->it['ub_status_2'];
            header("Location: {$_SERVER['PHP_SELF']}?action=userbars"); exit;
         }
      }
      else if ($this->view['actionbtn'] == $this->it['ub_cancel_btn']) {
         $_SESSION['status_m'] = $this->it['com_messageprefix'].
                                 $this->it['ub_status_1'];
         header("Location: {$_SERVER['PHP_SELF']}?action=userbars"); exit;
      }
   }

   function get_userbars_mod_content() {
      $cd['data_1']  = $this->it['mnu_ubl'];
      $cd['data_2']  = $this->it['mnu_ublmod'];
      $content = tmpl_replace($this->ct['userbars_9'], $cd);

      foreach ($this->data as $ubid=>$ubinf) {
         $cd['data_1']  = $ubid;
         $cd['data_2']  = $ubid;
         $cd['data_3']  = $this->it['ub_mod_header'];
         $cd['data_4']  = $ubid;
         $cd['data_5']  = $this->it['ub_game'];
         $cd['data_6']  = $this->get_options(true, games(), $ubinf['game']);
         $cd['data_7']  = $this->it['ub_type'];
         $cd['data_8'] = $this->get_options(true, array("o"=>"Overall", "ow"=>"Overall wide",
         "et"=>"Envirs text", "eg"=>"Envirs graphics"), $ubinf['ubt']);
         $cd['data_9']  = $this->it['ub_font1'];
         $cd['data_10'] = $ubinf['font1'];
         $cd['data_11'] = $ubinf['color1'];
         $cd['data_12'] = $ubinf['size1'];
         $cd['data_13'] = $this->it['ub_font2'];
         $cd['data_14'] = $ubinf['font2'];
         $cd['data_15'] = $ubinf['color2'];
         $cd['data_16'] = $ubinf['size2'];
         $cd['data_17'] = $ubinf['status_1'];
         $content .= tmpl_replace($this->ct['userbars_10'], $cd);
      }
      $cd['data_1'] = $this->it['ub_action_header'];
      $cd['data_2'] = $this->it['ub_modifyuserbars_btn'];
      $cd['data_3'] = $this->it['ub_modifyuserbars_desc'];
      $cd['data_4'] = $this->it['ub_cancel_btn'];
      $cd['data_5'] = $this->it['ub_cancel_desc'];
      $content .= tmpl_replace($this->ct['userbars_11'], $cd);
      
      return $content;
   }


   function act_check_before() {
      $this->data = array();
      $this->data['php_vername'] = PHP_VERSION;
      $this->data['php_ver'] = ($this->data['php_vername'] >= '4.4.0');
      $this->data['php_xml'] = function_exists('xml_parser_create');
      $this->data['php_gd'] = function_exists('imagecreate');
      $this->data['php_ft'] = function_exists('imagettftext');
      $fp = @fopen(DIR_CACHE."cachetest", "wb+");
      if (!$fp) $this->data['php_cache'] = false;
      else {
         fclose($fp);
         if (!@unlink(DIR_CACHE."cachetest"))
            $this->data['php_cache'] = false;
         else
            $this->data['php_cache'] = true;
      }
      $this->data['php_zlib'] = extension_loaded('zlib');
      $this->data['php_metime'] = get_cfg_var("max_execution_time");
      if (get_cfg_var("safe_mode") == 1) $this->data['php_metime'] .= " (SM = On)";
      else $this->data['php_metime'] .= " (SM = Off)";
      if (get_cfg_var("allow_url_fopen") == 1) $this->data['php_allowurl'] = "On";
      else $this->data['php_allowurl'] = "Off";
      $this->data['php_memlimit'] = ini_get('memory_limit');
      $this->data['db_type']= $this->cfg['dbtype'];
      if ($this->status['connect'] == "1") {
         $this->data['db_version'] = $this->db->db_version();
         $this->data['db_tables'] = $this->db->instance_schema_status();
         if ($this->status['schema'] == '1') {
            $this->data['sl'] = array();
            $this->db->table_servers("sel", $this->data['sl']);
            @set_time_limit(120);
            foreach ($this->data['sl'] as $sid=>$sinf) {
               $this->data['sl'][$sid]['h'] = trackdirs_test($sinf['h']);
               $this->data['sl'][$sid]['i'] = logfiles_test($sinf['i']);
               $si = new Ttmos_SI();
               $this->data['sl'][$sid]['status'] = $si->connect($sinf['d'], $sinf['f'],
                                                        $sinf['g'], $this->cfg['servertimeout']);
               if ($this->data['sl'][$sid]['status'] == '1')
                  $si->disconnect();
            }
         }
         else {
            $this->data['sl'] = array();
         }
      }
   }
   
   function get_check_content() {
      $state_class = array("?"   => $this->ct['check_3'],
                           true  => $this->ct['check_2'],
                           false => $this->ct['check_1'],
                           "1" => $this->ct['check_2'],
                           "0" => $this->ct['check_1'],
                           "-1" => $this->ct['check_1'],
                           "-2" => $this->ct['check_1'],
                           "-3" => $this->ct['check_1']);
      $state_text = array(true  => $this->it['chk_statusok'],
                          false => $this->it['chk_statusfailed'],
                          "1" => $this->it['chk_statusok'],
                          "0" => $this->it['chk_statusfailed'],
                          "-1" => $this->it['chk_statusfailed']);
      // php
      $cd['data_1']  = $this->it['mnu_chk'];
      $cd['data_2']  = $this->it['chk_php_header'];
      $cd['data_3']  = $this->it['chk_phpver'];
      $cd['data_4']  = $state_class[$this->data['php_ver']];
      $cd['data_5']  = $this->data['php_vername'];
      $cd['data_6']  = $this->it['chk_phpver_desc'];
      $cd['data_7']  = $this->it['chk_phpxml'];
      $cd['data_8']  = $state_class[$this->data['php_xml']];
      $cd['data_9']  = $state_text[$this->data['php_xml']];
      $cd['data_10'] = $this->it['chk_phpxml_desc'];
      $cd['data_11'] = $this->it['chk_phpgd'];
      $cd['data_12'] = $state_class[$this->data['php_gd']];
      $cd['data_13'] = $state_text[$this->data['php_gd']];
      $cd['data_14'] = $this->it['chk_phpgd_desc'];
      $cd['data_15'] = $this->it['chk_phpft'];
      $cd['data_16'] = $state_class[$this->data['php_ft']];
      $cd['data_17'] = $state_text[$this->data['php_ft']];
      $cd['data_18'] = $this->it['chk_phpft_desc'];
      $cd['data_19'] = $this->it['chk_phpcache'];
      $cd['data_20'] = $state_class[$this->data['php_cache']];
      $cd['data_21'] = $state_text[$this->data['php_cache']];
      $cd['data_22'] = $this->it['chk_phpcache_desc'];
      $cd['data_23'] = $this->it['chk_phpzlib'];
      $cd['data_24'] = $state_class[$this->data['php_zlib']];
      $cd['data_25'] = $state_text[$this->data['php_zlib']];
      $cd['data_26'] = $this->it['chk_phpzlib_desc'];
      $cd['data_27'] = $this->it['chk_phpmetime'];
      $cd['data_28'] = $state_class["?"];
      $cd['data_29'] = $this->data['php_metime'];
      $cd['data_30'] = $this->it['chk_phpmetime_desc'];
      $cd['data_31'] = $this->it['chk_phpallowurl'];
      $cd['data_32'] = $state_class["?"];
      $cd['data_33'] = $this->data['php_allowurl'];
      $cd['data_34'] = $this->it['chk_phpallowurl_desc'];
      $cd['data_35'] = $this->it['chk_phpmemlimit'];
      $cd['data_36'] = $state_class["?"];
      $cd['data_37'] = $this->data['php_memlimit'];
      $cd['data_38'] = $this->it['chk_phpmemlimit_desc'];
      $cd['data_39'] = $this->it['chk_db_header'];
      $cd['data_40'] = $this->it['chk_dbtype'];
      $cd['data_41'] = $state_class["?"];
      $cd['data_42'] = $this->data['db_type'];
      $cd['data_43'] = $this->it['chk_dbtype_desc'];
      $cd['data_44'] = $this->it['chk_dbconnect'];
      $cd['data_45'] = $state_class[$this->status['connect']];
      $cd['data_46'] = ($this->status['connect'] == '1' ? $this->it['chk_statusok'] :
                                                            $this->status['error']);
      $cd['data_47'] = $this->it['chk_dbconnect_desc'];
      $content = tmpl_replace($this->ct['check_4'], $cd);

      if ($this->status['connect'] == '1') {
         // db
         $cd['data_1'] = $this->it['chk_dbver'];
         $cd['data_2'] = $state_class["?"];
         $cd['data_3'] = $this->data['db_version'];
         $cd['data_4'] = $this->it['chk_dbver_desc'];
         $cd['data_5'] = $this->it['chk_tables_header'];
         $cd['data_6'] = $this->data['db_tables']['ver'];
         $content .= tmpl_replace($this->ct['check_5'], $cd);

         for ($i = 0; $i < $this->data['db_tables']['count']; $i++) {
            $cd['data_1'] = $this->data['db_tables'][$i]['table'];
            $cd['data_2'] = $state_class[$this->data['db_tables'][$i]['status']];
            $cd['data_3'] = $state_text[$this->data['db_tables'][$i]['status']];
            $content .= tmpl_replace($this->ct['check_6'], $cd);
         }
         $cd['data_1'] = $this->it['chk_servers_header'];
         $content .= tmpl_replace($this->ct['check_7'], $cd);
         
         if ($this->status['schema'] != '1' ||
             count($this->data['sl']) == 0) {
            $content .= $this->ct['check_8'];
         }
         else {
            // servers
            foreach($this->data['sl'] as $sid=>$sinf) {
               $cd['data_1'] = name_html($sinf['b']);
               $cd['data_2'] = $sinf['d'];
               $cd['data_3'] = $state_class[$sinf['status']];
               switch ($sinf['status']) {
                  case  1: $cd['data_4'] = $this->it['chk_srvonline']; break;
                  case -1: $cd['data_4'] = $sinf['d']; break;
                  case -2: $cd['data_4'] = $this->it['chk_srvoffline']; break;
                  case -3: $cd['data_4'] = $sinf['f'].'<br>'.$sinf['g']; break;
               }
               $cd['data_5'] = $this->it['chk_trackdirs'];
               $cd['data_6'] = '';
               for ($i = 0; $i < $sinf['h']['count']; $i++) {
                  $sd['data_1'] = $state_class[$sinf['h'][$i]['status']];
                  $sd['data_2'] = $sinf['h'][$i]['shortname'];
                  $cd['data_6'] .= tmpl_replace($this->ct['check_12'], $sd);
               }
               $cd['data_7'] = $this->it['chk_logfiles'];
               $cd['data_8'] = '';
               for ($i = 0; $i < $sinf['i']['count']; $i++) {
                  $sd['data_1'] = $state_class[$sinf['i'][$i]['status']];
                  $sd['data_2'] = $sinf['i'][$i]['shortname'];
                  $cd['data_8'] .= tmpl_replace($this->ct['check_12'], $sd);
               }
               $content .= tmpl_replace($this->ct['check_10'], $cd);
            }
         }
      }
      $content .= $this->ct['check_11'];
      return $content;
   }

   function act_server_before() {
      $this->data = array("status"=>'0');
      $sl = array();
      $this->db->table_servers("sel", $sl);
      @set_time_limit(120);
      foreach ($sl as $sid=>$sinf) {
         if ($sid == $this->view['sid']) {
            $this->data = $sl[$sid];
            $this->data['a'] = $sid;
            $this->data['h'] = trackdirs_test($sinf['h']);
            $this->data['i'] = logfiles_test($sinf['i']);
            $SI = new Ttmos_SI();
            $this->data['status'] = $SI->connect($sinf['d'], $sinf['f'],
                                                 $sinf['g'], $this->cfg['servertimeout']);
            if ($this->data['status'] == '1') {
               $this->data['si'] = $SI->server_info();
               $this->data['ti'] = $SI->track_info();
               $SI->disconnect();
            }
            break;
         }
      }
   }

   function act_server_after() {
      if ($this->view['actionbtn'] == $this->it['cs_refresh_btn']) {
         header("Location: {$_SERVER['PHP_SELF']}?action=server&sid=".
                $this->view['sid']); exit;
      }
      else if ($this->view['actionbtn'] == $this->it['cs_parse_btn']) {
         $LP = new Ttmos_LP();
         $result = $LP->Go($this->view['sid'], isset($_POST['cfsp']));
         if (!isset($result[$this->view['sid']]))
            $_SESSION['status_m'] = $this->it['com_errorprefix'].
                                    $this->it['cs_servers_err'];
         if ($result[$this->view['sid']]['parsed'])
            $_SESSION['status_m'] = $this->it['com_messageprefix'].
                                    $this->it['cs_status_1'];
         else if ($result[$this->view['sid']]['skipped'])
            $_SESSION['status_m'] = $this->it['com_errorprefix'].
                                    $this->it['cs_skipped_err'];
         else if ($result[$this->view['sid']]['logfiles']['count'] == 0 ||
                  $result[$this->view['sid']]['logfiles']['errors'])
            $_SESSION['status_m'] = $this->it['com_errorprefix'].
                                    $this->it['cs_logfiles_err'];
         else if ($result[$this->view['sid']]['trackdirs']['count'] == 0 ||
                  $result[$this->view['sid']]['trackdirs']['errors'])
            $_SESSION['status_m'] = $this->it['com_errorprefix'].
                                    $this->it['cs_trackdirs_err'];
         else
            $_SESSION['status_m'] = $this->it['com_errorprefix'].
                                    $this->it['cs_unknown_err'];
         header("Location: {$_SERVER['PHP_SELF']}?action=server&sid=".
                $this->view['sid']); exit;
      }
      else if ($this->view['actionbtn'] == $this->it['cs_nexttrack_btn']) {
         $SI = new Ttmos_SI();
         $this->data['status'] = $SI->connect($this->data['d'], $this->data['f'],
                                              $this->data['g'], $this->cfg['servertimeout']);
         if ($this->data['status'] == '1') {
            $SI->track_next();
            $SI->disconnect();
            $_SESSION['status_m'] = $this->it['com_messageprefix'].
                                    $this->it['cs_status_1'];
         }
         else
            $_SESSION['status_m'] = $this->it['com_messageprefix'].
                                    $this->it['cs_offline_err'];
         header("Location: {$_SERVER['PHP_SELF']}?action=server&sid=".
                $this->view['sid']); exit;
      }
      else if ($this->view['actionbtn'] == $this->it['cs_restarttrack_btn']) {
         $SI = new Ttmos_SI();
         $this->data['status'] = $SI->connect($this->data['d'], $this->data['f'],
                                              $this->data['g'], $this->cfg['servertimeout']);
         if ($this->data['status'] == '1') {
            $SI->track_restart();
            $SI->disconnect();
            $_SESSION['status_m'] = $this->it['com_messageprefix'].
                                    $this->it['cs_status_1'];
         }
         else
            $_SESSION['status_m'] = $this->it['com_messageprefix'].
                                    $this->it['cs_offline_err'];
         header("Location: {$_SERVER['PHP_SELF']}?action=server&sid=".
                $this->view['sid']); exit;
      }
      else if ($this->view['actionbtn'] == $this->it['cs_choosetrack_btn']) {
         $SI = new Ttmos_SI();
         $this->data['status'] = $SI->connect($this->data['d'], $this->data['f'],
                                              $this->data['g'], $this->cfg['servertimeout']);
         if ($this->data['status'] == '1') {
            $this->data['tl'] = $SI->track_list();
            $SI->disconnect();
         }
         else
            $this->data['tl'] = array("count" => 0);
         $this->view['action'] = "server_ts";
      }
      else if ($this->view['actionbtn'] == $this->it['cs_createmsf_btn']) {
         if (isset($_POST['dir'])) {
            $TI = new Ttmos_TI();
            $this->data['tl'] = $TI->get_tracks_info(array("count"=>1,
                                                     0=>array("directory"=>$_POST['dir'])), true);
            $msf = $_POST['dir'];
            if (strpos($msf, "/") !== false)
               $slash = "/";
            else if (strpos($msf, "\\") !== false)
               $slash = "\\";
            else if (strstr(PHP_OS, 'WIN'))
               $slash = "\\";
            else
               $slash = "/";
            if (substr($msf, -1) == '\\' || substr($msf, -1) == '/')
               $msf = $msf."msf.txt";
            else
               $msf = $msf.$slash."msf.txt";
         }
         else {
            $this->data['tl'] = array("count"=>0);
            $msf = '?';
         }
         $this->data['msf'] = $msf;
         $this->view['action'] = "server_msf";
      }
   }

   function get_server_content() {
      $cd = tmpl_null('?');
      // inf
      if ($this->data['status'] != 0 ) {
         $cd['data_1'] = name_html($this->data['b']);
         $cd['data_2'] = $this->data['a'];
      }
      $cd['data_3']  = $this->it['cs_inf_header'];
      $cd['data_4']  = $this->it['cs_status'];
      $cd['data_6']  = $this->it['cs_totalplayers'];
      $cd['data_9']  = $this->it['cs_totaltracks'];
      $cd['data_11'] = $this->it['cs_currtrack'];
      if ($this->data['status'] == '1') {
         $cd['data_5']  = $this->data['si']['status'];
         $cd['data_7']  = $this->data['si']['totalplayers'];
         $cd['data_8']  = $this->data['si']['maxplayers'];
         $cd['data_10'] = $this->data['si']['totaltracks'];
         $cd['data_12'] = name_html($this->data['ti']['track']);
      }
      else {
         switch ($this->data['status']) {
            case  0: $cd['data_5'] = $this->it['com_errorprefix'].
                                     $this->it['cs_unknown_err']; break;
            case -1: $cd['data_5'] = $this->it['com_errorprefix'].
                                     $this->it['cs_ip_err']; break;
            case -2: $cd['data_5'] = $this->it['com_errorprefix'].
                                     $this->it['cs_offline_err']; break;
            case -3: $cd['data_5'] = $this->it['com_errorprefix'].
                                     $this->it['cs_authenticate_err']; break;
         }
      }
      // logfiles
      $cd['data_13'] = $this->it['cs_action_header'];
      $cd['data_14'] = $this->it['cs_refresh_btn'];
      $cd['data_15'] = $this->it['cs_refresh_desc'];
      $cd['data_16'] = $this->it['cs_parsing_header'];
      $cd['data_17'] = $this->it['cs_parselast'];
      $cd['data_19'] = $this->it['cs_logfiles'];
      if ($this->data['status'] != 0 ) {
         $cd['data_18'] = ts_format($this->data['k']);
         $cd['data_20'] = '';
         for ($i = 0; $i < $this->data['i']['count']; $i++) {
            $sd['data_1'] = $this->data['i'][$i]['filesize'];
            $sd['data_2'] = $this->data['i'][$i]['shortname'];
            $cd['data_20'] .= tmpl_replace($this->ct['server_2'], $sd);
         }
      }
      // trackdirs
      $cd['data_21'] = $this->it['cs_action_header'];
      $cd['data_22'] = $this->it['cs_parse_btn'];
      $cd['data_23'] = $this->it['cs_parse_desc'];
      $cd['data_24'] = '';
      $cd['data_25'] = $this->it['cs_msf_header'];
      $cd['data_26'] = $this->it['cs_trackdirs'];
      if ($this->data['status'] != 0 ) {
         $cd['data_27'] = '';
         for ($i = 0; $i < $this->data['h']['count']; $i++) {
            $sd['data_1'] = $this->data['h'][$i]['shortname'];
            $sd['data_2'] = $this->data['h'][$i]['directory'];
            $cd['data_27'] .= tmpl_replace($this->ct['server_3'], $sd);
         }
      }
      $cd['data_28'] = $this->it['cs_action_header'];
      $cd['data_29'] = $this->it['cs_createmsf_btn'];
      $cd['data_30'] = $this->it['cs_createmsf_desc'];
      $cd['data_31'] = $this->it['cs_restarttrack_btn'];
      $cd['data_32'] = $this->it['cs_restarttrack_desc'];
      $cd['data_33'] = $this->it['cs_nexttrack_btn'];
      $cd['data_34'] = $this->it['cs_nexttrack_desc'];
      $cd['data_35'] = $this->it['cs_choosetrack_btn'];
      $cd['data_36'] = $this->it['cs_choosetrack_desc'];
      $cd['data_37'] = $this->it['cs_cfsp_desc'];

      $content = tmpl_replace($this->ct['server_1'], $cd);
      return $content;
   }

   function act_server_ts_after() {
      if (isset($_POST['choosetrack'])) {
         $SI = new Ttmos_SI();
         $this->data['status'] = $SI->connect($this->data['d'], $this->data['f'],
                                              $this->data['g'], $this->cfg['servertimeout']);
         if ($this->data['status'] == '1') {
            $SI->track_set($_POST['choosetrack']);
            $SI->track_next();
            $SI->disconnect();
            $_SESSION['status_m'] = $this->it['com_messageprefix'].
                                    $this->it['cs_status_1'];
         }
         else
            $_SESSION['status_m'] = $this->it['com_messageprefix'].
                                    $this->it['cs_offline_err'];
      }
      else
         $_SESSION['status_m'] = $this->it['com_errorprefix'].
                                 $this->it['cs_choosetrack_err'];
      header("Location: {$_SERVER['PHP_SELF']}?action=server&sid=".
                         $this->view['sid']); exit;
   }
   
   function get_server_ts_content() {
     $cd['data_1'] = name_html($this->data['b']);
     $cd['data_2'] = $this->it['mnu_ts'];
     $cd['data_3'] = $this->data['a'];
     $cd['data_4'] = $this->it['ts_radio_header'];
     $cd['data_5'] = $this->it['ts_track_header'];
     $cd['data_6'] = $this->it['ts_envir_header'];
     $cd['data_7'] = $this->it['ts_length_header'];
     $content = tmpl_replace($this->ct['server_4'], $cd);

     if ($this->data['tl']['count'] == 0) {
        $content .= $this->ct['server_5'];
     }
     else {
        for ($i = 0; $i < $this->data['tl']['count']; $i++) {
           $cd['data_1'] = $this->data['tl'][$i]['filename'];
           $cd['data_2'] = name_html($this->data['tl'][$i]['track']);
           $cd['data_3'] = $this->data['tl'][$i]['envir'];
           $cd['data_4'] = time_msectocut($this->data['tl'][$i]['length']);
           $content .= tmpl_replace($this->ct['server_6'], $cd);
        }
     }

     $cd['data_1'] = $this->it['ts_action_header'];
     $cd['data_2'] = $this->it['ts_choosetrack_btn'];
     $content .= tmpl_replace($this->ct['server_7'], $cd);
     
     return $content;
   }

   function act_server_msf_after() {
      if (isset($_POST['msfilepath']) &&
         ($fp = @fopen($_POST['msfilepath'], "wb")) !== false) {
         $cd['data_1']  = $_POST['gi_gamemode'];
         $cd['data_2']  = $_POST['gi_chattime'];
         $cd['data_3']  = $_POST['gi_roundspointslimit'];
         $cd['data_4']  = $_POST['gi_roundsusenewrules'];
         $cd['data_5']  = $_POST['gi_timeattacklimit'];
         $cd['data_6']  = $_POST['gi_teampointslimit'];
         $cd['data_7']  = $_POST['gi_teammaxpoints'];
         $cd['data_8']  = $_POST['gi_teamusenewrules'];
         $cd['data_9']  = $_POST['gi_lapsnblaps'];
         $cd['data_10'] = $_POST['gi_lapstimelimit'];
         $cd['data_11'] = $_POST['gi_randommaporder'];
         $content = tmpl_replace($this->ct['server_12'], $cd);

         $flag = false;
         foreach ($_POST as $id=>$value) {
            if (preg_match("/t(al|ba|co|is|ra|sp|st)\d+/", $id)) {
               $flag = true;
               $cd['data_1'] = strtok($value, '*');
               $cd['data_2'] = strtok('');
               $content .= tmpl_replace($this->ct['server_13'], $cd);
            }
         }
         $content .= $this->ct['server_14'];

         fputs($fp, $content);
         fclose($fp);
         if ($flag)
            $_SESSION['status_m'] = $this->it['com_messageprefix'].
                                    $this->it['cs_status_2'];
         else
            $_SESSION['status_m'] = $this->it['com_errorprefix'].
                                    $this->it['cs_msftracks_err'];
         if ($flag && isset($_POST['restartserver'])) {
            $SI = new Ttmos_SI();
            $flag = $SI->connect($this->data['d'], $this->data['f'],
                                   $this->data['g'], $this->cfg['servertimeout']);
            if ($flag == '1') {
               $flag = $SI->matchsettings_load($_POST['msfilepath']);
               $SI->track_next();
               $SI->disconnect();
            }
            if ($flag == 1)
               $_SESSION['status_m'] .= "<br>".$this->it['com_messageprefix'].
                                               $this->it['cs_status_3'];
            else
               $_SESSION['status_m'] .= "<br>".$this->it['com_errorprefix'].
                                               $this->it['cs_msfrestartserver_err'];
         }
      }
      else
         $_SESSION['status_m'] = $this->it['com_errorprefix'].
                                 $this->it['cs_msfwrite_err'];

      header("Location: {$_SERVER['PHP_SELF']}?action=server&sid=".
                         $this->view['sid']); exit;
   }

   function get_server_msf_content() {
      $cd = tmpl_null('?');
      $cd['data_1']  = name_html($this->data['b']);
      $cd['data_2']  = $this->it['mnu_msf'];
      $cd['data_3']  = $this->data['a'];
      $cd['data_4']  = $this->it['msf_parameter_header'];
      $cd['data_5']  = $this->it['msf_value_header'];
      $cd['data_6']  = $this->it['msf_gamemode'];
      $cd['data_7']  = $this->get_options(true, array("1"=>"TimeAttack",
                                                      "0"=>"Rounds",
                                                      "2"=>"Team",
                                                      "3"=>"Laps",
                                                      "4"=>"Stunts"), "1");
      $cd['data_8']  = $this->it['msf_chattime'];
      $cd['data_9']  = $this->it['msf_roundspointslimit'];
      $cd['data_10'] = $this->it['msf_roundsusenewrules'];
      $cd['data_11'] = $this->get_options(true, array("0"=>"No", "1"=>"Yes"), "0");
      $cd['data_12'] = $this->it['msf_timeattacklimit'];
      $cd['data_13'] = $this->it['msf_teampointslimit'];
      $cd['data_14'] = $this->it['msf_teammaxpoints'];
      $cd['data_15'] = $this->it['msf_teamusenewrules'];
      $cd['data_16'] = $this->get_options(true, array("0"=>"No", "1"=>"Yes"), "0");
      $cd['data_17'] = $this->it['msf_laps_nblaps'];
      $cd['data_18'] = $this->it['msf_lapstimelimit'];
      $cd['data_19'] = $this->it['msf_randommaporder'];
      $cd['data_20'] = $this->get_options(true, array("0"=>"No", "1"=>"Yes"), "0");
      $cd['data_21'] = $this->it['msf_checkbox_header'];
      $cd['data_22'] = $this->it['msf_trackname_header'];
      $cd['data_23'] = $this->it['msf_trackauthor_header'];
      $cd['data_24'] = $this->it['msf_trackuid_header'];
      $cd['data_25'] = $this->it['msf_envir_header'];
      $cd['data_26'] = $this->it['msf_ml_header'];
      $cd['data_27'] = $this->it['msf_version_header'];

      $content = tmpl_replace($this->ct['server_8'], $cd);
      
      if (count($this->data['tl']) == 0) {
         $content .= $this->ct['server_9'];
      }
      else {
         $i = 0;
         foreach ($this->data['tl'] as $tid=>$tinf) {
            $cd['data_1'] = strtolower(substr(envir_fromid($tinf['f']), 0, 2)).$i;
            $cd['data_2'] = $tinf['r']."*".$tinf['b'];
            $cd['data_3'] = name_html($tinf['c']);
            $cd['data_4'] = name_html($tinf['e']);
            $cd['data_5'] = $tinf['b'];
            $cd['data_6'] = envir_fromid($tinf['f']);
            $cd['data_7'] = ($tinf['i'] > 1 ? "+" : "&nbsp;");
            $cd['data_8'] = strtoupper($tinf['s']);

            $content .= tmpl_replace($this->ct['server_10'], $cd);
            $i++;
         }
      }
      $cd['data_1']  = $this->it['msf_chkall'];
      $cd['data_2']  = $this->it['msf_chkalpine'];
      $cd['data_3']  = $this->it['msf_chkbay'];
      $cd['data_4']  = $this->it['msf_chkcoast'];
      $cd['data_5']  = $this->it['msf_chkisland'];
      $cd['data_6']  = $this->it['msf_chkrally'];
      $cd['data_7']  = $this->it['msf_chkspeed'];
      $cd['data_8']  = $this->it['msf_chkstadium'];
      $cd['data_9']  = $this->it['msf_chknull'];
      $cd['data_10'] = $this->it['msf_msfilename_header'];
      $cd['data_11'] = $this->data['msf'];
      $cd['data_12'] = $this->it['msf_action_header'];
      $cd['data_13'] = $this->it['msf_srvrestart_desc'];
      $cd['data_14'] = $this->it['msf_savetofile_btn'];
      $cd['data_15'] = $this->it['msf_savetofile_desc'];
      
      $content .= tmpl_replace($this->ct['server_11'], $cd);

      return $content;
   }

   function act_authorize() {
      if (!isset($_SESSION['adminpass']) ||
          $_SESSION['adminpass'] != $this->cfg['adminpass']) {
         if (isset($_POST['adminpass'])) {
            if ($_POST['adminpass'] == $this->cfg['adminpass']) {
               $_SESSION['adminpass'] = $_POST['adminpass'];
               header("Location: {$_SERVER['PHP_SELF']}?action=config"); exit;
            }
            else {
               $this->view['status_m'] = $this->it['az_status_1'];
               $this->view['action'] = "authorize";
            }
         }
         else {
            $this->view['status_m'] = "";
            $this->view['action'] = "authorize";
         }
      }
   }

   function get_authorize_content() {
      $cd['data_1'] = $_SERVER['PHP_SELF'];
      $cd['data_2'] = $this->it['az_authorize_header'];
      $cd['data_3'] = $this->it['az_login_btn'];
      $cd['data_4'] = $this->view['status_m'];
      $content = tmpl_replace($this->ct['authorize_1'], $cd);
      return $content;
   }
   
   function process() {
      $this->get_params();
      
      header('Content-Type: text/html; charset=UTF-8');

      // check authorize
      $this->act_authorize();
      if ($this->view['action'] == "authorize") {
         $content = $this->get_header();
         $content .= $this->get_authorize_content();
         $content .= $this->get_footer();
         echo $content;
         return;
      }

      $this->db = new Ttmos_DB($this->cfg, true);
      $this->db->open();
      if ($this->db->last_error != '')
         $this->status['error'] = $this->db->last_error;
      else {
         $this->status['connect'] = '1';
         $this->status['schema'] = $this->db->instance_schema_status();
         $this->status['ver'] = $this->status['schema']['ver'];
         if ($this->status['ver'] == 'v1.00')
            $this->status['schema'] = '1';
         else
            $this->status['schema'] = '0';
      }

      // del cache
      if ((strpos($this->view['action'], '_act') !== false ||
           strpos($this->view['action'], '_mod') !== false) &&
           ($this->cfg['htmlcache'] != "no")) {
         @fclose(fopen(DIR_CACHE.'!clear!', 'w'));
      }

      switch ($this->view['action']) {
         case "config":        $this->act_config_before();
                               break;
         case "config_act":    $this->act_config_before();
                               $this->act_config_after();
                               break;
         case "db":            $this->act_db_before();
                               break;
         case "db_act":        $this->act_db_before();
                               $this->act_db_after();
                               break;
         case "db_upd":        $this->act_db_before();
                               $this->act_db_upd_after();
                               break;
         case "servers":       $this->act_servers_before();
                               break;
         case "servers_act":   $this->act_servers_before();
                               $this->act_servers_after();
                               break;
         case "servers_add":   $this->act_servers_before();
                               $this->act_servers_after(); 
                               $this->act_servers_add_after();
                               break;
         case "servers_mod":   $this->act_servers_before();
                               $this->act_servers_after(); 
                               $this->act_servers_mod_after();
                               break;
         case "check":         $this->act_check_before();
                               break;
         case "userbars":      $this->act_userbars_before();
                               break;
         case "userbars_act":  $this->act_userbars_before();
                               $this->act_userbars_after();
                               break;
         case "userbars_add":  $this->act_userbars_before();
                               $this->act_userbars_after();
                               $this->act_userbars_add_after();
                               break;
         case "userbars_mod":  $this->act_userbars_before();
                               $this->act_userbars_after(); 
                               $this->act_userbars_mod_after();
                               break;
         case "server":        $this->act_server_before();
                               break;
         case "server_act":    $this->act_server_before();
                               $this->act_server_after();
                               break;
         case "server_ts":     $this->act_server_before();
                               $this->act_server_after();
                               $this->act_server_ts_after();
                               break;
         case "server_msf":    $this->act_server_before();
                               $this->act_server_msf_after();
                               break;
      }

      $content = $this->get_header();
      $content .= $this->get_menu_header();
      switch ($this->view['action']) {
         case 'config': 
         case 'config_act':   $content .= $this->get_config_content();
                              break;
         case 'db':           $content .= $this->get_db_content();
                              break;
         case 'db_upd':       $content .= $this->get_db_upd_content();
                              break;
         case 'servers':      $content .= $this->get_servers_content();
                              break;
         case 'servers_add':  $content .= $this->get_servers_add_content();
                              break;
         case 'servers_mod':  $content .= $this->get_servers_mod_content();
                              break;
         case 'check':        $content .= $this->get_check_content();
                              break;
         case 'userbars':     $content .= $this->get_userbars_content();
                              break;
         case 'userbars_add': $content .= $this->get_userbars_add_content();
                              break;
         case 'userbars_mod': $content .= $this->get_userbars_mod_content();
                              break;
         case "server":       $content .= $this->get_server_content();
                              break;
         case "server_ts":    $content .= $this->get_server_ts_content();
                              break;
         case "server_msf":   $content .= $this->get_server_msf_content();
                              break;
      }
      $content .= $this->get_status_content();
      $content .= $this->get_menu_footer();
      $content .= $this->get_footer();

      if ($this->status['connect'] == '1')
         $this->db->close();

      echo $content;
   }

}

$tmos_Admin = new Ttmos_Admin();
$tmos_Admin->process();
?>
