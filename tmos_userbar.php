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

class Ttmos_UB {

   function textwidth($font, $fontsize, $text) {
      $bbox = imagettfbbox($fontsize, 0, $font, $text);
      return abs($bbox[2] - $bbox[0]);
   }
   
   function textheight($font, $fontsize) {
      if ($fontsize <= 15) {
         $width = 16;
         $height = 32;
      }
      else if ($fontsize <= 30){
         $width = 64;
         $height = 64;
      }
      else {
         $width = 128;
         $height = 128;
      }
      $img = imagecreate($width, $height);
      $color = imagecolorallocate($img, 0, 0, 0);
      imagefill($img, 0, 0, $color);
      $color = imagecolorallocate($img, 255, 255, 255);
      imagettftext($img, $fontsize, 0, 0, $height, $color, $font, 'T');
      $dl = -1;
      for ($h = $height - 1; $h >= 0; $h--) {
         for ($w = 0; $w < $width; $w++)
            if (imagecolorat($img, $w, $h) != 0) {
               $dl = $h;
               break 2;
            }
      }
      $ul = -1;
      for ($h = 0; $h < $height; $h++) {
         for ($w = 0; $w < $width; $w++)
            if (imagecolorat($img, $w, $h) != 0) {
               $ul = $h;
               break 2;
            }
      }
      $result = ($dl - $ul + 1) + ($height - $dl - 1);
      imagedestroy($img);

      return $result;
   }

   function draw() {
      // cfg
      $cfg = config_load();
      require_once("includes/tmos_lang_".$cfg['defaultlanguage'].".inc.php");
      $it = $tmos_userbar_it;
      $error = '0';

      // gd
      if ($error == '0') {
         if (!function_exists('imagepng'))
            $error = 'gd';
      }
      // cfg
      if ($error == '0') {
         if (!$cfg['showuserbars'])
            $error = 'cfg';
      }
      // link
      if ($error == '0') {
         if (isset($_SERVER['QUERY_STRING']) &&  // '?'
             $_SERVER['QUERY_STRING'] != "")
            $qs = $_SERVER['QUERY_STRING'];
         else if (isset($_SERVER['PATH_INFO']) &&
                  $_SERVER['PATH_INFO'] != "")
            $qs = ltrim($_SERVER['PATH_INFO'], '\/');
         else if (isset($_SERVER['REQUEST_URI']) &&
                  $_SERVER['REQUEST_URI'] != "")
            $qs = basename($_SERVER['REQUEST_URI']);
         else
            $qs = "";
         preg_match("/^tmos_(.{1,4})_(\d+)_(.+)\.png$/",
                    $qs, $link);
         if (count($link) == 0)
            $error = 'link';
      }
      // file
      if ($error == '0') {
         $ub = userbars_load($link[1]);
         if ($ub !== -1) {
            $ub['file'] = DIR_USERBARS.$ub['file'];
            $buf = @getimagesize($ub['file']);
            if (!$buf || $buf[2] != 3)
               $error = 'file';
            else {
               $ub['width'] = $buf['0'];
               $ub['height'] = $buf['1'];
            }
         }
         else
            $error = 'file';
      }
      // view
      if ($error == '0') {
         $view = array("ubt"=>$ub['ubt'],
                       "sid"=>$link[2],
                       "pid"=>$link[3]);
      }
      // data
      if ($error == '0' && $view['pid'] == "preview") {
         $data = array("serverc"=>"Server Name",
                       "playerc"=>"Player Name",
                       "rank"=>rand(1, 99999),
                       "score"=>rand(1, 99999).".".rand(10, 99));
         foreach (envirs() as $eid) {
            $data[$eid] = rand(1, 99999);
         }
      }
      else if ($error == '0') {
         $db = new Ttmos_DB($cfg, true);
         $db->open();
         if ($db->last_error == "") {
            if ($view['ubt'] == 'o' || $view['ubt'] == 'ow')
               $data = $db->view_userbar_t1($view);
            else if ($view['ubt'] == 'et' || $view['ubt'] == 'eg')
               $data = $db->view_userbar_t2($view);
            else
               $data = array("count"=>0);
            $db->close();
         }
         else
            $error = 'db';
         if ($data['count'] == 0)
            $error = 'data';
         else
            $data = $data[0];
      }
      // fonts
      if ($error == '0') {
         $ub['font1'] = DIR_FONTS.$ub['font1'];
         $ub['font2'] = DIR_FONTS.$ub['font2'];
         if (!function_exists('imagettfbbox') ||
             !function_exists('imagettftext') ||
             !file_exists($ub['font1']) ||
             !file_exists($ub['font2']))
            $error = 'font';
      }
      // img
      if ($error == '0' || $error == 'font') {
         $img = imagecreatefrompng($ub['file']);
         $color1 = imagecolorallocate($img, hexdec($ub['color1'][0].$ub['color1'][1]),
                                            hexdec($ub['color1'][2].$ub['color1'][3]),
                                            hexdec($ub['color1'][4].$ub['color1'][5]));
         $color2 = imagecolorallocate($img, hexdec($ub['color2'][0].$ub['color2'][1]),
                                            hexdec($ub['color2'][2].$ub['color2'][3]),
                                            hexdec($ub['color2'][4].$ub['color2'][5]));
      }
      else if ($error != 'gd') {
         $img = imagecreate(350, 20);
         $color = imagecolorallocate($img, 0, 0, 0);
         imagefill($img, 0, 0, $color);
         $color = imagecolorallocate($img, 255, 255, 255);
      }
      // ttf text
      if ($error == '0' && $ub['ubt'] == 'o') { // overall
         $text = $data['serverc']. " / ".$data['playerc']." / ".
                 $data['rank']." / ".float_format($data['score']);
         $pos['x'] = $ub['width'] - 3 - 
                     $this->textwidth($ub['font1'], $ub['size1'], $text);
         $pos['y'] = $this->textheight($ub['font1'], $ub['size1']) + 2;
         imagettftext($img, $ub['size1'], 0, $pos['x'], $pos['y'],
                      $color1, $ub['font1'], $text);
      }
      else if ($error == '0' && $ub['ubt'] == 'ow') { // overall wide
         $tw = max($this->textwidth($ub['font1'], $ub['size1'], $it['ub_ttt_server']),
                   $this->textwidth($ub['font1'], $ub['size1'], $it['ub_ttt_player']),
                   $this->textwidth($ub['font1'], $ub['size1'], $it['ub_ttt_rank']),
                   $this->textwidth($ub['font1'], $ub['size1'], $it['ub_ttt_score']));
         $th = max($this->textheight($ub['font1'], $ub['size1']),
                   $this->textheight($ub['font2'], $ub['size2']));

         $pos['x1'] = 110;
         $pos['x2'] = $pos['x1'] + $tw;
         $pos['y1'] = $th + 4;
         $pos['y2'] = $th + 15;//$pos['y1'] + $th + 3;
         $pos['y3'] = $th + 26;//$pos['y2'] + $th + 3;
         $pos['y4'] = $th + 37;//$pos['y3'] + $th + 3;
         imagettftext($img, $ub['size1'], 0, $pos['x1'], $pos['y1'],
                      $color1, $ub['font1'], $it['ub_ttt_server']);
         imagettftext($img, $ub['size1'], 0, $pos['x1'], $pos['y2'],
                      $color1, $ub['font1'], $it['ub_ttt_player']);
         imagettftext($img, $ub['size1'], 0, $pos['x1'], $pos['y3'],
                      $color1, $ub['font1'], $it['ub_ttt_rank']);
         imagettftext($img, $ub['size1'], 0, $pos['x1'], $pos['y4'],
                      $color1, $ub['font1'], $it['ub_ttt_score']);
         imagettftext($img, $ub['size2'], 0, $pos['x2'], $pos['y1'],
                      $color2, $ub['font2'], $it['ub_ttt_separator'].$data['serverc']);
         imagettftext($img, $ub['size2'], 0, $pos['x2'], $pos['y2'],
                      $color2, $ub['font2'], $it['ub_ttt_separator'].$data['playerc']);
         imagettftext($img, $ub['size2'], 0, $pos['x2'], $pos['y3'],
                      $color2, $ub['font2'], $it['ub_ttt_separator'].$data['rank']);
         imagettftext($img, $ub['size2'], 0, $pos['x2'], $pos['y4'],
                      $color2, $ub['font2'], $it['ub_ttt_separator'].float_format($data['score']));
      }
      else if ($error == '0' && $ub['ubt'] == 'et') { // envirs text
         $text = str_replace(array("{0}", "{1}"),
                             array($data['serverc'], $data['playerc']),
                             $it['ub_ttt_oa_info']);
         $pos['x'] = 5;
         $pos['y'] = $this->textheight($ub['font1'], $ub['size1']) + 2;
         imagettftext($img, $ub['size1'], 0, $pos['x'], $pos['y'],
                      $color1, $ub['font1'], $text);

         $pos['x1'] = 25;
         $pos['x2'] = 120;
         $pos['x3'] = 210;
         $pos['y1'] = 24;
         $pos['y2'] = 35;
         $pos['y3'] = 46;
         imagettftext($img, $ub['size2'], 0,  $pos['x1'], $pos['y1'], $color2, $ub['font2'],
                      $it['ub_ttt_oa_overall'].$it['ub_ttt_oa_separator'].$data[envir_toid('Overall')]);
         imagettftext($img, $ub['size2'], 0,  $pos['x1'], $pos['y2'], $color2, $ub['font2'],
                      $it['ub_ttt_oa_stadium'].$it['ub_ttt_oa_separator'].$data[envir_toid('Stadium')]);
         imagettftext($img, $ub['size2'], 0,  $pos['x2'], $pos['y1'], $color2, $ub['font2'],
                      $it['ub_ttt_oa_island'].$it['ub_ttt_oa_separator'].$data[envir_toid('Island')]);
         imagettftext($img, $ub['size2'], 0,  $pos['x2'], $pos['y2'], $color2, $ub['font2'],
                      $it['ub_ttt_oa_bay'].$it['ub_ttt_oa_separator'].$data[envir_toid('Bay')]);
         imagettftext($img, $ub['size2'], 0,  $pos['x2'], $pos['y3'], $color2, $ub['font2'],
                      $it['ub_ttt_oa_coast'].$it['ub_ttt_oa_separator'].$data[envir_toid('Coast')]);
         imagettftext($img, $ub['size2'], 0,  $pos['x3'], $pos['y1'], $color2, $ub['font2'],
                      $it['ub_ttt_oa_alpine'].$it['ub_ttt_oa_separator'].$data[envir_toid('Alpine')]);
         imagettftext($img, $ub['size2'], 0,  $pos['x3'], $pos['y2'], $color2, $ub['font2'],
                      $it['ub_ttt_oa_rally'].$it['ub_ttt_oa_separator'].$data[envir_toid('Rally')]);
         imagettftext($img, $ub['size2'], 0,  $pos['x3'], $pos['y3'], $color2, $ub['font2'],
                      $it['ub_ttt_oa_speed'].$it['ub_ttt_oa_separator'].$data[envir_toid('Speed')]);
      }
      else if ($error == '0' && $ub['ubt'] == 'eg') { // envirs graphic
         $text = str_replace(array("{0}", "{1}"),
                             array($data['serverc'], $data['playerc']),
                             $it['ub_ttt_oa_info']);
         $pos['x'] = 5;
         $pos['y'] = $this->textheight($ub['font1'], $ub['size1']) + 3;
         imagettftext($img, $ub['size1'], 0, $pos['x'], $pos['y'],
                      $color1, $ub['font1'], $text);

         $pos['x1'] =  35 - $this->textwidth($ub['font2'], $ub['size2'], $data[envir_toid('Overall')])/2;
         $pos['x2'] =  75 - $this->textwidth($ub['font2'], $ub['size2'], $data[envir_toid('Stadium')])/2;
         $pos['x3'] = 115 - $this->textwidth($ub['font2'], $ub['size2'], $data[envir_toid('Island')])/2;
         $pos['x4'] = 155 - $this->textwidth($ub['font2'], $ub['size2'], $data[envir_toid('Bay')])/2;
         $pos['x5'] = 195 - $this->textwidth($ub['font2'], $ub['size2'], $data[envir_toid('Coast')])/2;
         $pos['x6'] = 235 - $this->textwidth($ub['font2'], $ub['size2'], $data[envir_toid('Alpine')])/2;
         $pos['x7'] = 275 - $this->textwidth($ub['font2'], $ub['size2'], $data[envir_toid('Rally')])/2;
         $pos['x8'] = 315 - $this->textwidth($ub['font2'], $ub['size2'], $data[envir_toid('Speed')])/2;
         $pos['yr'] = $this->textheight($ub['font2'], $ub['size2'])+ 40;
         imagettftext($img, $ub['size2'], 0, $pos['x1'], $pos['yr'], $color2, $ub['font2'],
                      $data[envir_toid('Overall')]);
         imagettftext($img, $ub['size2'], 0, $pos['x2'], $pos['yr'], $color2, $ub['font2'],
                      $data[envir_toid('Stadium')]);
         imagettftext($img, $ub['size2'], 0, $pos['x3'], $pos['yr'], $color2, $ub['font2'],
                      $data[envir_toid('Island')]);
         imagettftext($img, $ub['size2'], 0, $pos['x4'], $pos['yr'], $color2, $ub['font2'],
                      $data[envir_toid('Bay')]);
         imagettftext($img, $ub['size2'], 0, $pos['x5'], $pos['yr'], $color2, $ub['font2'],
                      $data[envir_toid('Coast')]);
         imagettftext($img, $ub['size2'], 0, $pos['x6'], $pos['yr'], $color2, $ub['font2'],
                      $data[envir_toid('Alpine')]);
         imagettftext($img, $ub['size2'], 0, $pos['x7'], $pos['yr'], $color2, $ub['font2'],
                      $data[envir_toid('Rally')]);
         imagettftext($img, $ub['size2'], 0, $pos['x8'], $pos['yr'], $color2, $ub['font2'],
                      $data[envir_toid('Speed')]);
      }
      // gdt text
      else if ($error == 'font' && $ub['ubt'] == 'o') {
         $text = $data['serverc']. " / ".$data['playerc']." / ".
                 $data['rank']." / ".float_format($data['score']);
         $pos['x'] = $ub['width'] - 5 * strlen($text) - 2;
         $pos['y'] = 1;
         imagestring($img, 1, $pos['x'], $pos['y'], $text, $color1);
      }
      else if ($error == 'font' && $ub['ubt'] == 'ow') {
         $pos['x1'] = 110;
         $pos['x2'] = $pos['x1'] + strlen($it['ub_gdt_server']) * 6;
         $pos['y1'] = 1;
         $pos['y2'] = $pos['y1'] + 11;
         $pos['y3'] = $pos['y2'] + 11;
         $pos['y4'] = $pos['y3'] + 11;
         imagestring($img, 2, $pos['x1'], $pos['y1'], $it['ub_gdt_server'], $color1);
         imagestring($img, 2, $pos['x1'], $pos['y2'], $it['ub_gdt_player'], $color1);
         imagestring($img, 2, $pos['x1'], $pos['y3'], $it['ub_gdt_rank'], $color1);
         imagestring($img, 2, $pos['x1'], $pos['y4'], $it['ub_gdt_score'], $color1);
         imagestring($img, 2, $pos['x2'], $pos['y1'], $data['serverc'], $color2);
         imagestring($img, 2, $pos['x2'], $pos['y2'], $data['playerc'], $color2);
         imagestring($img, 2, $pos['x2'], $pos['y3'], $data['rank'], $color2);
         imagestring($img, 2, $pos['x2'], $pos['y4'], float_format($data['score']), $color2);
      }
      else if ($error == 'font' && $ub['ubt'] == 'et') {
         $text = str_replace(array("{0}", "{1}"),
                             array($data['serverc'], $data['playerc']),
                             $it['ub_gdt_oa_info']);
         imagestring($img, 2,  5,  0, $text, $color1);

         $pos['x1'] = 25;
         $pos['x2'] = 120;
         $pos['x3'] = 210;
         $pos['y1'] = 13;
         $pos['y2'] = 24;
         $pos['y3'] = 35;
         imagestring($img, 2, $pos['x1'], $pos['y1'], $it['ub_gdt_oa_overall'].
                     $data[envir_toid('Overall')], $color2);
         imagestring($img, 2, $pos['x1'], $pos['y2'], $it['ub_gdt_oa_stadium'].
                     $data[envir_toid('Stadium')], $color2);
         imagestring($img, 2, $pos['x2'], $pos['y1'], $it['ub_gdt_oa_island'].
                     $data[envir_toid('Island')], $color2);
         imagestring($img, 2, $pos['x2'], $pos['y2'], $it['ub_gdt_oa_bay'].
                     $data[envir_toid('Bay')], $color2);
         imagestring($img, 2, $pos['x2'], $pos['y3'], $it['ub_gdt_oa_coast'].
                     $data[envir_toid('Coast')], $color2);
         imagestring($img, 2, $pos['x3'], $pos['y1'], $it['ub_gdt_oa_alpine'].
                     $data[envir_toid('Alpine')], $color2);
         imagestring($img, 2, $pos['x3'], $pos['y2'], $it['ub_gdt_oa_rally'].
                     $data[envir_toid('Rally')], $color2);
         imagestring($img, 2, $pos['x3'], $pos['y3'], $it['ub_gdt_oa_speed'].
                     $data[envir_toid('Speed')], $color2);
      }
      else if ($error == 'font' && $ub['ubt'] == 'eg') {
         $text = str_replace(array("{0}", "{1}"),
                             array($data['serverc'], $data['playerc']),
                             $it['ub_gdt_oa_info']);
         imagestring($img, 2,  5,  0, $text, $color1);

         $pos['x1'] =  35 - 6 * strlen($data[envir_toid('Overall')]) / 2;
         $pos['x2'] =  75 - 6 * strlen($data[envir_toid('Stadium')]) / 2;
         $pos['x3'] = 115 - 6 * strlen($data[envir_toid('Island')]) / 2;
         $pos['x4'] = 155 - 6 * strlen($data[envir_toid('Bay')]) / 2;
         $pos['x5'] = 195 - 6 * strlen($data[envir_toid('Coast')]) / 2;
         $pos['x6'] = 235 - 6 * strlen($data[envir_toid('Alpine')]) / 2;
         $pos['x7'] = 275 - 6 * strlen($data[envir_toid('Rally')]) / 2;
         $pos['x8'] = 315 - 6 * strlen($data[envir_toid('Speed')]) / 2;
         $pos['yr'] = 36;

         imagestring($img, 2, $pos['x1'], $pos['yr'], $data[envir_toid('Overall')], $color2);
         imagestring($img, 2, $pos['x2'], $pos['yr'], $data[envir_toid('Stadium')], $color2);
         imagestring($img, 2, $pos['x3'], $pos['yr'], $data[envir_toid('Island')], $color2);
         imagestring($img, 2, $pos['x4'], $pos['yr'], $data[envir_toid('Bay')], $color2);
         imagestring($img, 2, $pos['x5'], $pos['yr'], $data[envir_toid('Coast')], $color2);
         imagestring($img, 2, $pos['x6'], $pos['yr'], $data[envir_toid('Alpine')], $color2);
         imagestring($img, 2, $pos['x7'], $pos['yr'], $data[envir_toid('Rally')], $color2);
         imagestring($img, 2, $pos['x8'], $pos['yr'], $data[envir_toid('Speed')], $color2);
      }
      else if ($error == 'link') {
         imagestring($img, 1, 1, 0, $it['ub_gdt_link_err'], $color);
      }
      else if ($error == 'file') {
         imagestring($img, 1, 1, 0, $it['ub_gdt_file_err'], $color);
      }
      else if ($error == 'db') {
         imagestring($img, 1, 1, 0, $it['ub_gdt_offline_err'], $color);
      }
      else if ($error == 'data') {
         $text = str_replace(array("{0}", "{1}", "{2}"),
                             array($ub['ubid'], $view['sid'], $view['pid']),
                             $it['ub_gdt_data_err']);
         imagestring($img, 1, 1, 0, $text, $color);
      }
      else if ($error == 'cfg') {
         imagestring($img, 1, 1, 0, $it['ub_gdt_cfg_err'], $color);
      }
      // out
      if ($error != 'gd') {
         header("Content-Type: image/png");
         imagepng($img);
         imagedestroy($img);
      }
   }

} // class

$tmos_UB = new Ttmos_UB();
$tmos_UB->draw();

?>