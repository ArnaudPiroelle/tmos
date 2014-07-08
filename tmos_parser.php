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

require_once "includes/tmos_lp.inc.php";

// parse
$time = getmicrotime();
$LP = new Ttmos_LP();
$status = $LP->Go("!");
$time = getmicrotime() - $time;

// delcache
@fclose(fopen(DIR_CACHE.'!clear!', 'w'));

// info
header("Content-type: text/plain");
if (count($status) == 0) {
   echo "Registered servers not found!";
}
else {
   foreach ($status as $sid=>$sinf) {
      if ($sinf['skipped']) {
         echo "(".$sid.")".$sinf['server']." - Skipped\n";
      }
      else {
         if ($sinf['parsed'])
            echo "(".$sid.")".$sinf['server']." - Processed\n";
         else {
            echo "(".$sid.")".$sinf['server']." - Errors\n";
            for ($i = 0; $i < $sinf['logfiles']['count']; $i++) {
               if (!$sinf['logfiles'][$i]['status'])
                  echo " => '".$sinf['logfiles'][$i]['filename']."' - File not found or not readable!\n";
            }
            for ($i = 0; $i < $sinf['trackdirs']['count']; $i++) {
               if (!$sinf['trackdirs'][$i]['status'])
                  echo " => '".$sinf['trackdirs'][$i]['directory']."' - Directory not found!\n";
            }
         }
      }
   }
   printf("\nProcessed in %f s", $time);
}

?>