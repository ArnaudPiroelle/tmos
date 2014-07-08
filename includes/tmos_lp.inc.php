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
require_once 'tmos_db.inc.php';
require_once 'tmos_ti.inc.php';

// *****************************************************************************
// Ttmos_LP
// *****************************************************************************
class Ttmos_LP {

   var $db;

   function logfiles_open(&$lfiles, &$fptrs) {
      $fptrs['count'] = $lfiles['count'];
      for ($i = 0; $i < $lfiles['count']; $i++)
         $fptrs[$i] = @fopen_ex($lfiles[$i]['filename'], "rb");
   }

   function logfiles_close(&$fptrs) {
      for ($i = 0; $i < $fptrs['count']; $i++)
         @fclose_ex($fptrs[$i]);
   }

   function tracks_refresh(&$tdirs, &$tracks, &$structs, $cfg_mp) {
      $flag = false;
      foreach ($structs as $tid=>$tinf) {
         if (!isset($tracks[$tid]) && !isset($cfg_mp['til'][$tid])) {
            $flag = true;
            break;
         }
      }
      foreach ($tracks as $tid=>$tinf) {
         if ($tinf['f'] == '!' || $tinf['r'] == '') {
            $flag = true;
            break;
         }
      }
      if ($flag == true) {
         $ti = new Ttmos_TI();
         $buf = $ti->get_tracks_info($tdirs);
         foreach ($buf as $tid=>$tinf) {
            if ($tinf == -1) {
            }
            else if (!isset($tracks[$tid])) {
               $tracks[$tid] = $tinf;
               $tracks[$tid]['rs'] = 'i';
               $tracks[$tid]['p'] = 0;
               $tracks[$tid]['q'] = 0;
               $tracks[$tid]['d'] = $tracks[$tid]['d'];
               if ($tinf['t'] == false)
                  $tracks[$tid]['r'] = '';
            }
            else if (($tracks[$tid]['f'] == '!') ||
                     ($tracks[$tid]['r'] == '' && $tinf['t'] == true)) {
               $tracks[$tid] = $tinf;
               $tracks[$tid]['rs'] = 'u';
               $tracks[$tid]['p'] = 0;
               $tracks[$tid]['q'] = 0;
               $tracks[$tid]['d'] = $tracks[$tid]['d'];
               if ($tinf['t'] == false)
                  $tracks[$tid]['r'] = '';
            }
         }
         foreach ($tracks as $tid=>$tinf) {
            if (!isset($buf[$tid]) && $tinf['r'] != '') {
               $tracks[$tid]['rs'] = 'u';
               $tracks[$tid]['r'] = '';
            }
         }
      }
      if ($flag == true) {
         foreach ($structs as $tid=>$tinf)
            if (!isset($tracks[$tid]) && !isset($cfg_mp['til'][$tid])) {
               $tracks[$tid]['rs'] = 'i';
               $tracks[$tid]['b'] = $tinf['uid'];
               $tracks[$tid]['c'] = $tinf['fn'];
               $buf = strpos(strtolower($tracks[$tid]['c']), '.challenge.gbx');
               if ($buf !== false) {
                  $tracks[$tid]['c'] = substr($tracks[$tid]['c'], 0, $buf);
               }
               $tracks[$tid]['d'] = name_clear($tinf['fn']);
               $tracks[$tid]['e'] = '';
               $tracks[$tid]['f'] = '!';
               $tracks[$tid]['g'] = '';
               $tracks[$tid]['h'] = '';
               $tracks[$tid]['i'] = 0;
               $tracks[$tid]['j'] = 0;
               $tracks[$tid]['k'] = '00:00:00.00';
               $tracks[$tid]['l'] = '00:00:00.00';
               $tracks[$tid]['m'] = '00:00:00.00';
               $tracks[$tid]['n'] = '00:00:00.00';
               $tracks[$tid]['o'] = 0;
               $tracks[$tid]['p'] = 0;
               $tracks[$tid]['q'] = 0;
               $tracks[$tid]['r'] = '';
            }
      }
   }

   function checksum_set(&$scores, &$clans) {
      foreach($scores as $pid=>$pinf) {
         foreach($pinf as $eid=>$einf) {
            $scores[$pid][$eid]['j'] = id_get("{$einf['c']}{$einf['d']}{$einf['e']}{$einf['f']}".
                                              "{$einf['g']}{$einf['h']}{$einf['i']}");
            $scores[$pid][$eid]['c'] = 0;
            $scores[$pid][$eid]['d'] = 0;
            $scores[$pid][$eid]['e'] = 0;
            $scores[$pid][$eid]['f'] = 0;
            $scores[$pid][$eid]['g'] = 0;
            $scores[$pid][$eid]['h'] = '';
            $scores[$pid][$eid]['i'] = 0;
         }
      }
      foreach($clans as $cid=>$cinf) {
         $clans[$cid]['g'] = id_get("{$cinf['b']}{$cinf['c']}{$cinf['d']}{$cinf['e']}");
         $clans[$cid]['c'] = '';
         $clans[$cid]['d'] = '';
         $clans[$cid]['e'] = 0;
      }
   }

   function logfiles_structs(&$lfiles, &$fptrs, &$structs) {
      for ($i = 0; $i < $lfiles['count']; $i ++) {
         if ((@fseek($fptrs[$i], $lfiles[$i]['pos']) == -1) ||
             (id_get(trim(fgets($fptrs[$i], 2046))) !== $lfiles[$i]['strmd5'])) {
            @fseek($fptrs[$i], 0);
            $offset = 0;
            $tid = 'unk';
         }
         else {
            $offset = $lfiles[$i]['pos'];
            $tid = $lfiles[$i]['tid'];
         }
         $structs[$tid]['count'] = 1;
         $structs[$tid]['fn'] = 'x';
         $structs[$tid]['uid'] = 'x';
         $structs[$tid][$i]['count'] = 1;
         $structs[$tid][$i]['a1'] = $offset;
         while (!feof($fptrs[$i])) {
            $offset = ftell($fptrs[$i]);
            $buffer = fgets($fptrs[$i], 2046);
            if (strlen($buffer) > 22 && $buffer[22] == 'L' &&
                preg_match("/^.{21} Loading challenge (.+) \((.{25,30})\).../", $buffer, $matches)) {
               $structs[$tid][$i]['b'.$structs[$tid][$i]['count']] = $offset;
               $tid = id_get($matches[2]);
               if (!isset($structs[$tid])) {
                  $structs[$tid]['count'] = 1;
                  $structs[$tid]['fn'] = $matches[1];
                  $structs[$tid]['uid'] = $matches[2];
                  $structs[$tid][$i]['count'] = 0;
               }
               if (!isset($structs[$tid][$i])) {
                  $structs[$tid]['count'] ++;
                  $structs[$tid][$i]['count'] = 1;
               }
               else
                  $structs[$tid][$i]['count']++;
               $structs[$tid][$i]['a'.$structs[$tid][$i]['count']] = $offset;
            }
            if (trim($buffer) != '') {
               $prev_offset = $offset;
               $prev_buffer = $buffer;
            }
         }
         $structs[$tid][$i]['b'.$structs[$tid][$i]['count']] = $offset;
         if (isset($prev_offset) &&
             isset($prev_buffer)) {
            $lfiles[$i]['pos'] = $prev_offset;
            $lfiles[$i]['strmd5'] = id_get(trim($prev_buffer));
            $lfiles[$i]['tid'] = $tid;
         }
      }
      unset($structs['unk']);      
   }
   
   function logfiles_results(&$fptrs, &$lstruct, &$players, &$results) {
      for ($i = 0; $i < $fptrs['count']; $i ++) {
         if (!isset($lstruct[$i])) continue;
         for ($j = 1; $j <= $lstruct[$i]['count']; $j ++) {
            fseek($fptrs[$i], $lstruct[$i]['a'.$j]);
            $offset = $lstruct[$i]['a'.$j];
            while ($offset < $lstruct[$i]['b'.$j]) {
               $buffer = fgets($fptrs[$i], 2046);
               $offset = ftell($fptrs[$i]);
               if ($buffer[23] = 't' and (
                   preg_match("/^\[(.{19})\] <time> \[(.+)\/\d+\.\d+\.\d+\.\d+:\d+ \((.+)\)\] (.+)/u", $buffer, $matches) ||
                   preg_match("/^\[(.{19})\] <time> \[([^ ]+) \((.+)\)\] (.+)/u", $buffer, $matches))) {

                  $result = time_full($matches[4]);
                  if ($result == '00:00:00.00') continue;
                  $account = name_clear($matches[2]);
                  $pid = id_get($account);

                  if (!isset($players[$pid])) {
                     $players[$pid]['rs'] = 'i';
                     $players[$pid]['b'] = $account;
                     $players[$pid]['c'] = $matches[3];
                     $players[$pid]['d'] = name_clear($matches[3]);
                     $players[$pid]['e'] = '';
                     name_links($players[$pid]['c'], $players[$pid]['e']);
                     $players[$pid]['f'] = $players[$pid]['c'];
                     $players[$pid]['g'] = $matches[1];
                  }
                  else if ($players[$pid]['g'] < $matches[1]) {
                     if ($players[$pid]['rs'] != 'i') $players[$pid]['rs'] = 'u';
                     $players[$pid]['c'] = $matches[3];
                     $players[$pid]['d'] = name_clear($matches[3]);
                     $players[$pid]['e'] = '';
                     name_links($players[$pid]['c'], $players[$pid]['e']);
                     $players[$pid]['f'] = params_add($players[$pid]['f'], $players[$pid]['c']);
                     $players[$pid]['g'] = $matches[1];
                  }
                  if (!isset($results[$pid])) {
                     $results[$pid]['rs'] = 'i';
                     $results[$pid]['b'] = $result;
                     $results[$pid]['c'] = $matches[1];
                     $results[$pid]['d'] = '!';
                     $results[$pid]['e'] = '!';
                  }
                  else if ($results[$pid]['b'] > $result) {
                     if ($results[$pid]['rs'] != 'i') $results[$pid]['rs'] = 'u';
                     $results[$pid]['b'] = $result;
                     $results[$pid]['c'] = $matches[1];
                     $results[$pid]['d'] = '!';
                     $results[$pid]['e'] = '!';
                  }                  
               }
            }
         }
      }
   }

   function results_refresh($tid, &$results, &$cfg_mp) {
      foreach ($cfg_mp['pul'] as $psrc=>$pdest) {
         if (isset($results[$psrc]) && !isset($results[$pdest])) {
            $results[$pdest]['rs'] = 'i';
            $results[$pdest]['b'] = $results[$psrc]['b'];
            $results[$pdest]['c'] = $results[$psrc]['c'];
            $results[$pdest]['d'] = $results[$psrc]['d'];
            $results[$pdest]['e'] = $results[$psrc]['e'];
         }
         else if (isset($results[$psrc]) && isset($results[$pdest]) &&
                 ($results[$psrc]['b'] < $results[$pdest]['b'])) {
            if ($results[$pdest]['rs'] != 'i') $results[$pdest]['rs'] = 'u';
            $results[$pdest]['b'] = $results[$psrc]['b'];
            $results[$pdest]['c'] = $results[$psrc]['c'];
            $results[$pdest]['d'] = $results[$psrc]['d'];
            $results[$pdest]['e'] = $results[$psrc]['e'];
         }
         if (isset($results[$psrc])) {
            if ($results[$psrc]['rs'] != 'i')
               $results[$psrc]['rs'] = 'd';
            else
               unset($results[$psrc]);
         }
      }
      foreach ($cfg_mp['pil'] as $pid=>$pinf) {
         if (isset($results[$pid])) {
            if ($results[$pid]['rs'] != 'i')
               $results[$pid]['rs'] = 'd';
            else
               unset($results[$pid]);
         }
      }
      if (isset($cfg_mp['til'][$tid])) {
         foreach ($results as $pid=>$pinf) {
            if ($pinf['rs'] != 'i')
               $results[$pid]['rs'] = 'd';
            else
               unset($results[$pid]);
         }
      }
   }

   function cmp($a, $b) {
      return strcasecmp($a['b'], $b['b']);
   }

   function scores_refresh(&$track, &$scores, &$results, &$cfg) {
      uasort($results, array("Ttmos_LP", "cmp"));
      $total_ranks = 0;
      $total_results = 0;
      $curr_result = "";
      foreach ($results as $pid=>$pinf) {
         if ($pinf['rs'] == 'd') continue;

         $total_results ++;
         if ($curr_result != $pinf['b']) {
            $total_ranks ++;
            $curr_result = $pinf['b'];
         }
         if (!isset($scores[$pid]['*'])) {
            $scores[$pid]['*']['rs'] = 'i';
            $scores[$pid]['*']['c'] = 0;
            $scores[$pid]['*']['d'] = 0;
            $scores[$pid]['*']['e'] = 0;
            $scores[$pid]['*']['f'] = 0;
            $scores[$pid]['*']['g'] = 0;
            $scores[$pid]['*']['h'] = '';
            $scores[$pid]['*']['i'] = 0;
            $scores[$pid]['*']['j'] = '';
         }
         if (!isset($scores[$pid][$track['f']])) {
            $scores[$pid][$track['f']]['rs'] = 'i';
            $scores[$pid][$track['f']]['c'] = 0;
            $scores[$pid][$track['f']]['d'] = 0;
            $scores[$pid][$track['f']]['e'] = 0;
            $scores[$pid][$track['f']]['f'] = 0;
            $scores[$pid][$track['f']]['g'] = 0;
            $scores[$pid][$track['f']]['h'] = '';
            $scores[$pid][$track['f']]['i'] = 0;
            $scores[$pid][$track['f']]['j'] = '';
         }
      }
      $curr_rank = 0;
      $curr_result = "";
      foreach ($results as $pid=>$pinf) {
         if ($pinf['rs'] == 'd') continue;

         $curr_medal = "";
         $curr_medal_field = "";
         $curr_medal_scores = 0;
      
         if ($track['i'] > 1) {
            $curr_medal = 'e';
            $curr_medal_field = "g";
            $curr_medal_scores = $cfg['finishscore'];
         }
         else if ($pinf['b'] <= $track['n']) {
            $curr_medal = 'a';
            $curr_medal_field = "c";
            $curr_medal_scores = $cfg['amscore'];
         }
         else if ($pinf['b'] <= $track['m']) {
            $curr_medal = 'b';
            $curr_medal_field = "d";
            $curr_medal_scores = $cfg['gmscore'];
         }
         else if ($pinf['b'] <= $track['l']) {
            $curr_medal = 'c';
            $curr_medal_field = "e";
            $curr_medal_scores = $cfg['smscore'];
         }
         else if ($pinf['b'] <= $track['k']) {
            $curr_medal = 'd';
            $curr_medal_field = "f";
            $curr_medal_scores = $cfg['bmscore'];
         }
         else {
            $curr_medal = 'e';
            $curr_medal_field = "g";
            $curr_medal_scores = $cfg['finishscore'];
         }

         if ($curr_result != $pinf['b']) {
            $curr_rank ++;
            $curr_result = $pinf['b'];
         }

         if ($pinf['e'] != $curr_medal || $pinf['d'] != $curr_rank) {
            if ($pinf['rs'] != 'i') $results[$pid]['rs'] = 'u';
            $results[$pid]['d'] = $curr_rank;
            $results[$pid]['e'] = $curr_medal;
         }
         
         $scores[$pid][$track['f']][$curr_medal_field] ++;
         $scores[$pid][$track['f']]['h'] .= "|$total_ranks|$curr_rank|$curr_medal_scores";
         $scores[$pid]['*'][$curr_medal_field] ++;
         $scores[$pid]['*']['h'] .= "|$total_ranks|$curr_rank|$curr_medal_scores";
      }
      if ($track['p'] != $total_results || $track['q'] != $total_ranks) {
         if ($track['rs'] != 'i')
            $track['rs'] = 'u';
         $track['p'] = $total_results;
         $track['q'] = $total_ranks;
      }

   }

   function players_refresh(&$players, &$clans, &$scores, &$cfg_mp) {
      // scores
      foreach ($scores as $pid=>$pinf) {
         foreach ($pinf as $eid=>$einf) {
            if ($einf['h'] == '' ||
                isset($cfg_mp['pil'][$pid]) ||
                isset($cfg_mp['pul'][$pid])) {
               if ($einf['rs'] != 'i')
                  $scores[$pid][$eid]['rs'] = 'd';
               else
                  unset($scores[$pid][$eid]);
            }
         }
      }

      // players
      foreach ($players as $pid=>$pinf) {
         if (isset($cfg_mp['pil'][$pid]) ||
             isset($cfg_mp['pul'][$pid]) ||
             !isset($scores[$pid]['*']) ||
             (isset($scores[$pid]['*']) && $scores[$pid]['*']['rs'] == 'd')) {
            if ($players[$pid]['rs'] != 'i')
               $players[$pid]['rs'] = 'd';
            else
               unset($players[$pid]);
         }
      }

      foreach ($cfg_mp['pul'] as $psrc=>$pdest) {
         if (isset($scores[$pdest]) &&
             !isset($players[$pdest])) {
            $players[$pdest]['rs'] = 'i';
            $players[$pdest]['b'] = $pdest;
            $players[$pdest]['c'] = 'Unknown_player_fom_config_mp ($$cfg_players)!';
            $players[$pdest]['d'] = 'Unknown_player';
            $players[$pdest]['e'] = '';
            $players[$pdest]['f'] = '';
            $players[$pdest]['g'] = '-';
         }
      }

      // points
      $total_players = array();
      foreach (envirs() as $eid)
         $total_players[$eid] = 0;
      foreach ($players as $pid=>$pinf) {
         if ($pinf['rs'] != 'd')
            foreach (envirs() as $eid)
               if (isset($scores[$pid][$eid]) && $scores[$pid][$eid]['rs'] != 'd')
                  $total_players[$eid] ++;
      }
      foreach ($scores as $pid=>$pinf) {
         foreach ($pinf as $eid=>$einf) {
            $score = explode('|', substr($einf['h'], 1));
            $scores[$pid][$eid]['h'] = 0;
            $i = sizeof($score)-1;
            while ($i > 0) {
               $scores[$pid][$eid]['h'] += ($score[$i-2] - $score[$i-1])*(($total_players[$eid]-$score[$i-1]+1)/$total_players[$eid]) + $score[$i];
               $i -= 3;
            }
         }
      }

      // rank - players
      foreach (envirs() as $eid) {
         $hash = array();
         foreach ($players as $pid=>$pinf) {
            if (isset($scores[$pid][$eid]))
               $hash[$pid] = $scores[$pid][$eid]['h'];
         }
         arsort($hash);
         $rank = 0;
         $curr_score = "";
         foreach ($hash as $pid=>$score) {
            if ($score != $curr_score) {
               $rank++;
               $curr_score = $score;
            }
            $scores[$pid][$eid]['i'] = $rank;
         }
      }

      // rank - clans
      foreach (envirs() as $eid) {
         $hash = array();
         foreach ($clans as $cid=>$cinf) {
            if ($cinf['rs'] != 'd' &&
                isset($scores[$cid][$eid]) &&
                $scores[$cid][$eid]['rs'] != 'd' &&
                $cinf['e'] > 0)
               $hash[$cid] = ($scores[$cid][$eid]['h']/$cinf['e']);
         }
         arsort($hash);
         $rank = 0;
         $curr_score = "";
         foreach ($hash as $cid=>$score) {
            if ($score != $curr_score) {
               $rank++;
               $curr_score = $score;
            }
            $scores[$cid][$eid]['h'] = $score;
            $scores[$cid][$eid]['i'] = $rank;
         }
      }

      // upd
      foreach ($scores as $pid=>$pinf) {
         foreach ($pinf as $eid=>$einf) {
            if ($einf['rs'] == 'c' and $einf['j'] !=
                id_get("{$einf['c']}{$einf['d']}{$einf['e']}{$einf['f']}{$einf['g']}{$einf['h']}{$einf['i']}"))
               $scores[$pid][$eid]['rs'] = 'u';
         }
      }

   }

   function clan_add(&$clans, $cid, $tag, $descr, $pid, $tag_pos, &$scores) {
      if (!isset($clans[$cid])) {
         $clans[$cid]['rs'] = 'i';
         $clans[$cid]['g'] = '';
         $clans[$cid]['e'] = 0;
      }
      if ($clans[$cid]['e'] == 0) {
         $clans[$cid]['c'] = $descr;
         $clans[$cid]['b'] = $tag;
         $clans[$cid]['d']['count'] = 1;
         $clans[$cid]['d'][0] = $pid;
         $clans[$cid]['e'] = 1;
         $clans[$cid]['f'] = $tag_pos;
         $clans[$cid]['h'] = $clans[$cid]['b'];
      }
      else if (!in_array($pid, $clans[$cid]['d'], true)) {
         $clans[$cid]['d'][$clans[$cid]['d']['count']] = $pid;
         $clans[$cid]['d']['count']++;
         $clans[$cid]['e']++;
      }

      foreach ($scores[$pid] as $eid=>$einf) {
         if (!isset($scores[$cid][$eid])) {
            $scores[$cid][$eid]['rs'] = 'i';
            $scores[$cid][$eid]['c'] = 0;
            $scores[$cid][$eid]['d'] = 0;
            $scores[$cid][$eid]['e'] = 0;
            $scores[$cid][$eid]['f'] = 0;
            $scores[$cid][$eid]['g'] = 0;
            $scores[$cid][$eid]['h'] = '';
            $scores[$cid][$eid]['i'] = 0;
            $scores[$cid][$eid]['j'] = '';
         }
         $scores[$cid][$eid]['c'] += $einf['c'];
         $scores[$cid][$eid]['d'] += $einf['d'];
         $scores[$cid][$eid]['e'] += $einf['e'];
         $scores[$cid][$eid]['f'] += $einf['f'];
         $scores[$cid][$eid]['g'] += $einf['g'];
         $scores[$cid][$eid]['h'] .= $einf['h'];
      }
   }

   function clans_refresh(&$players, &$scores, &$clans, &$cfg, &$cfg_mp) {
      foreach($clans as $cid=>$cinf) {
         $clans[$cid]['d'] = params_toarray($cinf['d'], false, 0, ',', true);
      }
      foreach ($players as $pid=>$pinf) {
         if ($pinf['rs'] == 'd' || isset($cfg_mp['pil'][$pid]) || isset($cfg_mp['pul'][$pid])) continue;

         $curr_clan_ml = "";
         $curr_clan_mr = "";
         $curr_clan_l = "";
         $curr_clan_r = "";
         $curr_clan_id = "";
         $curr_clan_descr = "";

         foreach ($cfg_mp['ctl'] as $cid=>$cinf) {
            if (isset($cinf['members'][$pinf['b']]) ||
               ($cinf['afm'] && name_clan_manual_left($pinf['d'], $cinf['tag']))) {
               $curr_clan_ml = $cinf['tag'];
               $curr_clan_descr = $cinf['descr'];
               break;
            }
            else if (isset($cinf['members'][$pinf['b']]) ||
               ($cinf['afm'] && name_clan_manual_right($pinf['d'], $cinf['tag']))) {
               $curr_clan_mr = $cinf['tag'];
               $curr_clan_descr = $cinf['descr'];
               break;
            }
         }
         if ($curr_clan_ml == "" && $curr_clan_mr == "" && $cfg_mp['afc']) {
            $curr_clan_l = name_clan_auto_left($pinf['d']);
            $curr_clan_r = name_clan_auto_right($pinf['d']);
         }
         if ($curr_clan_r == $curr_clan_l) $curr_clan_r = "";
         if ($curr_clan_ml != "") {
            $curr_clan_id = id_get(strtolower($curr_clan_ml));
            if (!isset($players[$curr_clan_id]))
               $this->clan_add($clans, $curr_clan_id, $curr_clan_ml, $curr_clan_descr, $pid, "l", $scores);
         }
         if ($curr_clan_mr != "") {
            $curr_clan_id = id_get(strtolower($curr_clan_mr));
            if (!isset($players[$curr_clan_id]))
               $this->clan_add($clans, $curr_clan_id, $curr_clan_mr, $curr_clan_descr, $pid, "r", $scores);
         }
         if ($curr_clan_l != "") {
            $curr_clan_id = id_get(strtolower($curr_clan_l));
            if (!isset($players[$curr_clan_id]))
               $this->clan_add($clans, $curr_clan_id, $curr_clan_l, $curr_clan_descr, $pid, "l", $scores);
         }
         if ($curr_clan_r != "") {
            $curr_clan_id = id_get(strtolower($curr_clan_r));
            if (!isset($players[$curr_clan_id]))
               $this->clan_add($clans, $curr_clan_id, $curr_clan_r, $curr_clan_descr, $pid, "r", $scores);
         }
      }

      foreach ($clans as $cid=>$cinf) {
         if (($cinf['d']['count'] < $cfg['minclansize']) ||
             ($cinf['d']['count'] == 2 && strcasecmp($players[$cinf['d'][0]]['d'], $players[$cinf['d'][1]]['d']) == 0) ||
              isset($cfg_mp['cil'][$cid])) {
            if ($clans[$cid]['rs'] != 'i') {
               $clans[$cid]['rs'] = 'd';
               foreach ($scores[$cid] as $eid=>$einf)
                  $scores[$cid][$eid]['rs'] = 'd';
            }
            else {
               unset($clans[$cid]);
               unset($scores[$cid]);
            }
         }
         else {
            $buf = preg_split('/([\p{P}\p{S}])/u', $players[$cinf['d'][0]]['d'], -1,
                              PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
            $ct = "";
            $ctt = "";
            foreach ($buf as $id=>$nnp) {
               $cinf['f'] == 'l' ? $ctt = $ctt.$nnp : $ctt = $nnp.$ctt;
               for ($i = 1; $i < $cinf['d']['count']; $i++) {
                  if (strpos(strtolower($players[$cinf['d'][$i]]['d']),
                             strtolower($ctt)) === false) {
                     break(2);
                  }
               }
               $ct = $ctt;
            }
            if ($ct != "")
               $clans[$cid]['b'] = $ct;

            $clans[$cid]['d'] = params_fromarray($clans[$cid]['d'], ',', true);
            if (($clans[$cid]['rs'] == 'c') && ($clans[$cid]['g'] !=
                id_get("{$clans[$cid]['b']}{$clans[$cid]['c']}{$clans[$cid]['d']}{$clans[$cid]['e']}"))) {
               $clans[$cid]['rs'] = 'u';
            }
         }
      }

   }

   function parse_server ($sid, &$server, $cfg, $cfg_mp) {
/*
   $cfg['afc'] = $cfg_autofindclans;
   $cfg['cil'] = array(); // clans, ignorelist
   $cfg['ctl'] = array(); // clans, tags
   $cfg['pil'] = array(); // players, ignoreslist
   $cfg['pul'] = array(); // players, unite
   $cfg['til'] = array(); // tracks, ignorelist
*/
      $players = array();
      $scores = array();
      $tracks = array();
      $fptrs = array();
      $structs = array();
      $this->logfiles_open($server['i'], $fptrs);
      $this->logfiles_structs($server['i'], $fptrs, $structs);
      $this->db->table_players("sel", $players, $sid);
      $this->db->table_scores("sel", $scores, $sid);
      $this->db->table_clans("sel", $clans, $sid);
      $this->db->table_tracks("sel", $tracks, $sid);
      $this->tracks_refresh($server['h'], $tracks, $structs, $cfg_mp);
      $this->checksum_set($scores, $clans);

      $server['j'] = '*';
      foreach ($tracks as $tid=>$tinf) {
         $results = array();
         $this->db->table_results("sel", $results, $sid, $tid);
         if (isset($structs[$tid]) && !isset($cfg_mp['til'][$tid]))
            $this->logfiles_results($fptrs, $structs[$tid], $players, $results);
         $this->results_refresh($tid, $results, $cfg_mp);
         $this->scores_refresh($tracks[$tid], $scores, $results, $cfg);
         $this->db->table_results("mod", $results, $sid, $tid);

         foreach ($results as $pid=>$pinf) {
            if ($pinf['rs'] != 'd') {
               if (strpos($server['j'], $tracks[$tid]['f']) === false)
                  $server['j'] .= $tracks[$tid]['f'];
               break;
            }
         }
      }
      $this->logfiles_close($fptrs);
      $this->clans_refresh($players, $scores, $clans, $cfg, $cfg_mp);
      $this->players_refresh($players, $clans, $scores, $cfg_mp);
      $this->db->table_players("mod", $players, $sid);
      $this->db->table_scores("mod", $scores, $sid);
      $this->db->table_tracks("mod", $tracks, $sid);
      $this->db->table_clans("mod", $clans, $sid);
   }

   function Go($sids, $cfsp = true) {

      if (isset($_SERVER['PATH_TRANSLATED']))
         chdir(dirname($_SERVER['PATH_TRANSLATED']));
      else if (isset($_SERVER['SCRIPT_FILENAME']))
         chdir(dirname($_SERVER['SCRIPT_FILENAME']));

      @set_time_limit(0);
      if (str_replace('M', '', ini_get('memory_limit')) < 32) {
         @ini_set('memory_limit', '32M');
      }

      $cfg = config_load();
      $cfg_mp = config_mp_load();
      $this->db = new Ttmos_db($cfg);
      $this->db->open();
      $servers = array();
      $this->db->table_servers("sel", $servers);
      $result = array();
      foreach($servers as $sid=>$sinf) {
         $result[$sid] = array("server"=>$sinf['b'], "skipped" => true, "parsed"=>false,
                               "logfiles"=>array(), "trackdirs"=>array());
         if ($sids == "!" || $sid == $sids) {
            $result[$sid]['skipped'] = false;

            if ($cfsp == false) {
               $sinf['i'] = logfiles_merge(logfiles_split($sinf['i'], true), true);
            }
            $sinf['i'] = logfiles_test($sinf['i'], true);
            $result[$sid]['logfiles'] = $sinf['i'];
            $sinf['h'] = trackdirs_test($sinf['h'], true);
            $result[$sid]['trackdirs'] = $sinf['h'];

            if ($result[$sid]['logfiles']['errors'] ||
                $result[$sid]['trackdirs']['errors']) {
               $result[$sid]['parsed'] = false;
            }
            else {
               $servers[$sid]['rs'] = 'u';
               $servers[$sid]['k'] = '...';
               $this->db->table_servers("mod", $servers);

               $this->parse_server($sid, $sinf, $cfg, $cfg_mp);

               $servers[$sid]['i'] = logfiles_merge($sinf['i'], false);
               $servers[$sid]['j'] = $sinf['j'];
               $servers[$sid]['k'] = @date("Y/m/d H:i:s");
               $this->db->table_servers("mod", $servers);
               $servers[$sid]['rs'] = 'c';

               $result[$sid]['parsed'] = true;
            }
         }
      }
      $this->db->close();

      return $result;
   }

} // class

?>