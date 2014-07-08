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

require_once 'tmos_funcs.inc.php';

// *****************************************************************************
// Ttmos_TI
// *****************************************************************************

class Ttmos_TI {

   function parse_xmlheader(&$xmlheader) {
      $vals = array();
      $tags = array();

      // ????
      $xmlheader = str_replace('»', '?', $xmlheader);

      $xml_parser = xml_parser_create('UTF-8');
      xml_parser_set_option($xml_parser, XML_OPTION_SKIP_WHITE, 0);
      xml_parse_into_struct($xml_parser, $xmlheader, $vals, $tags);
      xml_parser_free($xml_parser);

      if (isset($tags['HEADER'][0]) &&
          isset($tags['IDENT'][0]) &&
          isset($tags['IDENT'][0]) &&
          isset($tags['TIMES'][0]) &&
          isset($vals[$tags['HEADER'][0]]['attributes']['TYPE']) &&
          ($vals[$tags['HEADER'][0]]['attributes']['TYPE'] == "challenge") &&
          isset($vals[$tags['HEADER'][0]]['attributes']['VERSION']) &&
          isset($vals[$tags['IDENT'][0]]['attributes']['UID']) &&
          isset($vals[$tags['IDENT'][0]]['attributes']['NAME']) &&
          isset($vals[$tags['IDENT'][0]]['attributes']['AUTHOR']) &&
          isset($vals[$tags['DESC'][0]]['attributes']['ENVIR']) &&
          isset($vals[$tags['DESC'][0]]['attributes']['MOOD']) &&
          isset($vals[$tags['DESC'][0]]['attributes']['TYPE']) &&
          isset($vals[$tags['DESC'][0]]['attributes']['NBLAPS']) &&
          isset($vals[$tags['DESC'][0]]['attributes']['PRICE']) &&
          isset($vals[$tags['TIMES'][0]]['attributes']['BRONZE']) &&
          isset($vals[$tags['TIMES'][0]]['attributes']['SILVER']) &&
          isset($vals[$tags['TIMES'][0]]['attributes']['GOLD']) &&
          isset($vals[$tags['TIMES'][0]]['attributes']['AUTHORTIME']) &&
          isset($vals[$tags['TIMES'][0]]['attributes']['AUTHORSCORE']) &&
          ($vals[$tags['DESC'][0]]['attributes']['TYPE'] == "Race")) {

         $result = array();
         $result['b'] = $vals[$tags['IDENT'][0]]['attributes']['UID'];
         $result['c'] = urldecode($vals[$tags['IDENT'][0]]['attributes']['NAME']);
         $result['d'] = name_clear($result['c']);
         $result['e'] = urldecode($vals[$tags['IDENT'][0]]['attributes']['AUTHOR']);
         $result['f'] = envir_toid($vals[$tags['DESC'][0]]['attributes']['ENVIR']);
         $result['g'] = trim($vals[$tags['DESC'][0]]['attributes']['MOOD']);
         if (preg_match("/^\d{2}x\d{2}(\w+)/i", $result['g'], $matches))
            $result['g'] = ucfirst($matches[1]);
         $result['h'] = $vals[$tags['DESC'][0]]['attributes']['TYPE'];
         $result['i'] = $vals[$tags['DESC'][0]]['attributes']['NBLAPS'];
         $result['j'] = $vals[$tags['DESC'][0]]['attributes']['PRICE'];
         $result['k'] = time_msectofull($vals[$tags['TIMES'][0]]['attributes']['BRONZE']);
         $result['l'] = time_msectofull($vals[$tags['TIMES'][0]]['attributes']['SILVER']);
         $result['m'] = time_msectofull($vals[$tags['TIMES'][0]]['attributes']['GOLD']);
         $result['n'] = time_msectofull($vals[$tags['TIMES'][0]]['attributes']['AUTHORTIME']);
         $result['o'] = $vals[$tags['TIMES'][0]]['attributes']['AUTHORSCORE'];
         if ($result['o'] < 0) $result['o'] = 0;
         $result['r'] = ''; // filename
         $result['s'] = game_fromenvir($vals[$tags['HEADER'][0]]['attributes']['VERSION'],
                                       $vals[$tags['DESC'][0]]['attributes']['ENVIR']);
      }
      else 
         $result = -1;

      return $result;
   }

   function cmp($a, $b) {
      return strcasecmp($a['d'], $b['d']);
   }

   function get_tracks_info($dirs, $sort = false) {
      $result = array();

      for ($i = 0; $i < $dirs['count']; $i++) {
         $list = @filelist_ex($dirs[$i]['directory'], '.*\.gbx');
         foreach ($list as $filename) {
            $buf = @filedscr_ex($filename, '<header', '/header>', false);
            if ($buf == -1) {
               // very long header ...
               $buf = @filedscr_ex($filename, '<header', '<deps', false);
               if ($buf != -1)
                  $buf = substr($buf, 0, -5).'</header>';
            }
            if ($buf !== -1) {
               $buf = $this->parse_xmlheader($buf);
               if ($buf !== -1) {
                  $buf['r'] = ltrim(str_replace($dirs[$i]['directory'], '', $filename), '/\\ ');
                  $buf['t'] = ($dirs[$i]['directory'] == DIR_FILES);
                  $result[id_get($buf['b'])] = $buf;
               }
            }
         }
      }

      if ($sort) uasort($result, array("Ttmos_TI", "cmp"));

      return $result;
   }

} // class

?>