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

require_once "GbxRemote.inc.php";
require_once "tmos_funcs.inc.php";

// *****************************************************************************
// Ttmos_SI
// *****************************************************************************

class Ttmos_SI {

   var $tm_client;

   function connect($ip, $login, $password, $timeout) {
      $address = preg_split("/(.+):(\d+)/u", $ip, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
      if (!isset($address[0]) || !isset($address[1]))
         $result = -1;
      else {
         $this->tm_client = new IXR_Client_Gbx;
         if(!$this->tm_client->InitWithIp($address[0], $address[1], $timeout))
            $result = -2;
         else if(!$this->tm_client->query('Authenticate', $login, $password)) {
            $result = -3;
            $this->tm_client->Terminate();
         }
         else
            $result = 1;
      }
      return $result;
   }
   
   function disconnect() {
      $this->tm_client->Terminate();
      $this->tm_client = null;
   }

   function cmd($command, $param_1 = -1, $param_2 = -1) {
      if ($param_1 != -1 && $param_2 != -1)
         $result = $this->tm_client->query($command, $param_1, $param_2);
      else if ($param_1 != -1)
         $result = $this->tm_client->query($command, $param_1);
      else
         $result = $this->tm_client->query($command);
      if ($result) $result = $this->tm_client->getResponse();
      else $result = -1;
      return $result;
   }

   function track_next() {
      return $this->cmd('NextChallenge');
   }

   function track_restart() {
      return $this->cmd('ChallengeRestart');
   }

   function track_set($trackname) {
      return $this->cmd('ChooseNextChallenge', $trackname);
   }

   function matchsettings_load($msfile) {
      $result = $this->cmd('LoadMatchSettings', $msfile);
      if ($result > 0) $result = 1;
      return $result;
   }

   function cmp_tracks($a, $b) {
      return strcasecmp($a['trackc'], $b['trackc']);
   }

   function track_list() {
      $buf = $this->cmd('GetChallengeList', 300, 0);
      if ($buf === -1)
         $result = array("count" => 0);
      else {
         $result = array("count" => 0);
         foreach ($buf as $tid=>$tinf) {
            $result[$result['count']]['track'] = $tinf['Name'];
            $result[$result['count']]['trackc'] = name_clear($tinf['Name']);
            $result[$result['count']]['envir'] = $tinf['Environnement'];
            $result[$result['count']]['length'] = $tinf['GoldTime'];
            $result[$result['count']]['filename'] = $tinf['FileName'];
            $result['count'] += 1;
         }
      }

      return $result;
   }

   function track_info() {
      $buf = $this->cmd('GetCurrentChallengeInfo');
      if ($buf === -1) {
         $result = array("uid" => "x", "track" => "?",
                         "envir" => "?", "author" => "?",
                         "authortime" => "?", "laps" => "0");
      }
      else {
         $result = array("uid" =>$buf['UId'],
                         "track" => $buf['Name'],
                         "envir" => $buf['Environnement'],
                         "author" => $buf['Author'],
                         "authortime" => $buf['AuthorTime'],
                         "laps" => $buf['LapRace']);
      }
      $buf = $this->cmd('GetNbLaps');
      if ($buf === -1) 
         $result['laps_s'] = 0;
      else
         $result['laps_s'] = $buf['CurrentValue'];
      return $result;
   }

   function server_info() {
      $buf = $this->cmd('GetStatus');
      $result = array();
      if ($buf === -1)
         $result['status'] = "?";
      else
         $result['status'] = $buf['Name'];
      $buf = $this->cmd('GetVersion');
      if ($buf === -1)
         $result['version'] = "?";
      else
         $result['version'] = $buf['Version'];
      $buf = $this->cmd('GetServerName');
      if ($buf === -1)
         $result['name'] = "?";
      else
         $result['name'] = $buf;
      $buf = $this->cmd('GetServerComment');
      if ($buf === -1)
         $result['comment'] = "?";
      else
         $result['comment'] = $buf;
      $buf = $this->cmd('GetGameMode');
      if ($buf === -1)
         $result['gamemode'] = "?";
      else {
         switch ($buf) {
            case 0: $result['gamemode'] = 'Rounds'; break;
            case 1: $result['gamemode'] = 'TimeAttack'; break;
            case 2: $result['gamemode'] = 'Team'; break;
            case 3: $result['gamemode'] = 'Laps'; break;
            case 4: $result['gamemode'] = 'Stunts'; break;
         }
      }
      $buf = $this->cmd('GetMaxPlayers');
      if ($buf === -1) 
         $result['maxplayers'] = "?";
      else
         $result['maxplayers'] = $buf['CurrentValue'];
      $buf = $this->cmd('GetMaxSpectators');
      if ($buf === -1) 
         $result['maxspectators'] = "?";
      else
         $result['maxspectators'] = $buf['CurrentValue'];
      $buf = $this->cmd('GetServerPassword');
      if ($buf === -1) 
         $result['password'] = "?";
      else if ($buf == '' || $buf == false)
         $result['password'] = '0';
      else
         $result['password'] = '1';
      $buf = $this->cmd('GetPlayerList', 300, 0);
      if ($buf === -1)
         $result['totalplayers'] = "?";
      else if (count($buf) >= 300)
         $result['totalplayers'] = "300+";
      else
         $result['totalplayers'] = count($buf);
      if ($buf === -1)
        $result['totalspectators'] = "?";
      else {
         $result['totalspectators'] = 0;
         foreach ($buf as $pid=>$pinf)
            if ((isset($pinf['IsSpectator']) && $pinf['IsSpectator'] == true) ||
                (isset($pinf['SpectatorStatus']) && $pinf['SpectatorStatus'] > 0))
               $result['totalspectators']++;
      }
      $buf = $this->cmd('GetChallengeList', 300, 0);
      if ($buf === -1)
         $result['totaltracks'] = "?";
      else if (count($buf) >= 300)
         $result['totaltracks'] = "300+";
      else
         $result['totaltracks'] = count($buf);
      return $result;
   }
   /*
   function cmp_players($a, $b) {
      $result = 0;
      if ((!isset($a['besttime']) || !isset($b['besttime'])) ||
         ($a['besttime'] == -1 && $b['besttime'] == -1)) {
         $result = 0;
      }
      else {
         if ($a['besttime'] == -1)
            $result = 1;
         else if ($b['besttime'] == -1)
             $result = -1;
         else if ($a['besttime'] < $b['besttime'])
            $result = -1;
         else if ($a['besttime'] > $b['besttime'])
            $result = 1;
         else
            $result = 0;
      }
      return $result;
   }
   */
   function player_list() {
      $buf = $this->cmd('GetCurrentRanking', 300, 0);
      if ($buf === -1) {
         $result = array("count" => 0);
      }
      else {
         $result = array("count" => 0);

         foreach ($buf as $pid=>$pinf) {
            if ($pinf['BestTime'] != -1) 
               $result[$result['count']]['besttime'] = $pinf['BestTime'];
            else
               $result[$result['count']]['besttime'] = 600000;
            $ippos = strrpos($pinf['Login'], '/');
            if ($ippos !== false)
               $result[$result['count']]['account'] = name_clear(substr($pinf['Login'], 0, $ippos));
            else
               $result[$result['count']]['account'] = name_clear($pinf['Login']);
            $result[$result['count']]['player'] = $pinf['NickName'];
            if (isset($pinf['NbrLapsFinished']))
               $result[$result['count']]['lapsfinished'] = $pinf['NbrLapsFinished'];
            else
               $result[$result['count']]['lapsfinished'] = 0;
            $pinf = $this->cmd('GetPlayerInfo', $pinf['Login']);
            if ($pinf === -1)
               $result[$result['count']]['spectator'] = false;
            else if (isset($pinf['IsSpectator']))
               $result[$result['count']]['spectator'] = $pinf['IsSpectator'];
            else if (isset($pinf['SpectatorStatus']) && $pinf['SpectatorStatus'] > 0)
               $result[$result['count']]['spectator'] = true;
            else
               $result[$result['count']]['spectator'] = false;
            $result['count'] += 1;
         }
         array_multisort($result);
      }
      return $result;
   }
   
   // GetCurrentRanking
   // 2006-03-10 Login, NickName, Rank, BestTime, Score, NbrLapsFinished, LadderScore
   // 2006-04-25 Login, NickName, PlayerId, Rank, BestTime, Score, NbrLapsFinished, LadderScore, array BestCheckpoints
   // 2006-05-30 ...
   // 2007-01-09 ...
   // 2007-02-23 ...
   // 2008-10-07 ...
   // 2008-12-05 ...
   // GetPlayerInfo
   // 2006-03-10 Login, NickName, IPAddress, ConnectionType, PlayerId, IsSpectator, IsInOfficialMode, e.t.c
   // 2006-04-25 ...
   // 2006-05-30 ...
   // 2007-01-09 Login, NickName, PlayerId, TeamId, IsSpectator, IsInOfficialMode, LadderRanking
   // 2007-02-23 ...
   // 2007-04-18 Login, NickName, PlayerId, TeamId, SpectatorStatus, LadderRanking, and Flags
   //            SpectatorStatus = Spectator + TemporarySpectator * 10 + PureSpectator * 100 + AutoTarget * 1000 + CurrentTargetId * 10000
   // 2008-10-07 ...
   // 2008-12-05 ...

} // class
?>