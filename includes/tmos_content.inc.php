<?php

$tmos_admin_ct = array(

"authorize_1" => '
   <div class="splitter">&nbsp;</div>
   <center>
   <table cols="1" class="authorize">
      <form action="#data_1" method="post" name="mainform">
      <tr><th class="tlr">#data_2</th></tr>
      <tr><td class="l" ><input type="password" name="adminpass">&nbsp;<input type="submit" name="actionbtn" value="#data_3" class="btn"></td></tr>
      <tr><td class="blr" colspan="3"><span class="err">#data_4</span>&nbsp;</td></tr>
      </form>
   </table>
   </center>
'."\r\n",

"script_1" => '
   <script type="text/javascript" language="JavaScript">
   <!--
   function check(check_flag) {
      var currform = document.forms.mainform;
      var elcount = currform.elements.length;
      var elname = "";
      var cbtype = "";
      for (var i = 0; i < elcount; i++) {
         elname = currform.elements[i].name;
         if (elname.substr(0, 1) == "t") {
            cbtype = elname.substr(1, 2);
            switch (check_flag) {
               case "achk" : currform.elements[i].checked = true; break;
               case "al" : if (cbtype == "al") currform.elements[i].checked = true; break;
               case "ba" : if (cbtype == "ba") currform.elements[i].checked = true; break;
               case "co" : if (cbtype == "co") currform.elements[i].checked = true; break;
               case "is" : if (cbtype == "is") currform.elements[i].checked = true; break;
               case "ra" : if (cbtype == "ra") currform.elements[i].checked = true; break;
               case "sp" : if (cbtype == "sp") currform.elements[i].checked = true; break;
               case "st" : if (cbtype == "st") currform.elements[i].checked = true; break;
               case "uchk" : currform.elements[i].checked = false; break;
            }
         }
      }
      return false;
   }
   //-->
   </script>'."\r\n",

"header_1" => '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
   <title>TM Offline Stats 1.0 [admin]</title>
   <link rel="stylesheet" type="text/css" href="css/#data_1">
   #data_2
</head>
<body>'."\r\n",

"menu_1" => '
   <table class="adminmenu" cols="2">
      <tr><td class="n" width="150">
      <b>#data_1</b><br>
      <a href="#data_2">#data_3</a><br>
      <a href="#data_4">#data_5</a><br>
      <a href="#data_6">#data_7</a><br>
      <a href="#data_8">#data_9</a><br>
      <a href="#data_10">#data_11</a>
      <p><b>#data_12</b><br>'."\r\n",
"menu_2" => '#data_1'."\r\n",
"menu_3" => '
      <a href="#data_1">#data_2</a><br>'."\r\n",
"menu_4" => '
      </td>
      <td class="n">
      <form enctype="multipart/form-data" action="#data_1" method="post" name="mainform">'."\r\n",
"menu_5" => '
      </form>
      </td>
      </tr>
   </table>'."\r\n",

"footer_1" => '
   <div class="splitter">&nbsp;</div>
   <table class="links">
      <tr><td class="links">&copy; 2006-2009 Alexander Domnin</td></tr>
      <tr><td class="links"><a href=http://tmos.pp.ru>www.tmos.pp.ru</a></td></tr>
   </table>
</body>
</html>',

'config_1' => '
      <span class="hdr">&raquo; #data_1</span>
      <div class="splitter">&nbsp;</div>
      <input type="hidden" name="action" value="config_act">
      <table cols="3" class="admindata">
         <tr><th class="tlr" colspan="3">#data_2</th></tr>
         <tr><td class="l" width="200">#data_3</td><td width="150"><input type="text" name="dbhost" value="#data_4"></td><td class="r">#data_5</td></tr>
         <tr><td class="l">#data_6</td><td><select name="dbtype">#data_7</select></td><td class="r">#data_8</td></tr>
         <tr><td class="l">#data_9</td><td><input type="text" name="dblogin" value="#data_10"></td><td class="r">#data_11</td></tr>
         <tr><td class="l">#data_12</td><td><input type="text" name="dbpassword" value="#data_13"></td><td class="r">#data_14</td></tr>
         <tr><td class="l">#data_15</td><td><input type="text" name="dbname" value="#data_16"></td><td class="r">#data_17</td></tr>
         <tr><td class="lr" colspan="3"><span class="err">#data_18</span>&nbsp;</td></tr>
         <tr><th class="lr" colspan="3">#data_19</th></tr>
         <tr><td class="l">#data_20</td><td><select name="defaultlanguage">#data_21</select></td><td class="r">#data_22</td></tr>
         <tr><td class="l">#data_23</td><td><select name="defaultcolorscheme">#data_24</select></td><td class="r">#data_25</td></tr>
         <tr><td class="l">#data_26</td><td><input type="text" name="defaultrecperpage" value="#data_27"></td><td class="r">#data_28</td></tr>
         <tr><td class="l">#data_29</td><td><input type="checkbox" name="javascript" value="true"#data_30></td><td class="r">#data_31</td></tr>
         <tr><td class="l">#data_32</td><td><input type="text" name="servertimeout" value="#data_33"></td><td class="r">#data_34</td></tr>
         <tr><td class="l">#data_35</td><td><input type="checkbox" name="showsingleserver" value="true"#data_36></td><td class="r">#data_37</td></tr>
         <tr><td class="l">#data_38</td><td><input type="checkbox" name="showmonitoring" value="true"#data_39></td><td class="r">#data_40</td></tr>
         <tr><td class="l">#data_41</td><td><input type="checkbox" name="showclans" value="true"#data_42></td><td class="r">#data_43</td></tr>
         <tr><td class="l">#data_44</td><td><input type="checkbox" name="showuserbars" value="true"#data_45></td><td class="r">#data_46</td></tr>
         <tr><td class="l">#data_47</td><td><input type="checkbox" name="showpreferences" value="true"#data_48></td><td class="r">#data_49</td></tr>
         <tr><td class="l">#data_50</td><td><input type="checkbox" name="showlinks" value="true"#data_51></td><td class="r">#data_52</td></tr>
         <tr><td class="l">#data_53</td><td><input type="checkbox" name="showdownloads" value="true"#data_54></td><td class="r">#data_55</td></tr>
         <tr><td class="l">#data_56</td><td><select name="htmlcache">#data_57</select></td><td class="r">#data_58</td></tr>
         <tr><td class="l">#data_59</td><td><input type="checkbox" name="gzipcompression" value="true"#data_60></td><td class="r">#data_61</td></tr>
         <tr><td class="lr" colspan="3"><span class="err">#data_62</span>&nbsp;</td></tr>
         <tr><th class="lr" colspan="3">#data_63</th></tr>
         <tr><td class="l">#data_64</td><td><input type="text" name="minclansize" value="#data_65"></td><td class="r">#data_66</td></tr>
         <tr><td class="l">#data_67</td><td>
            <input type="text" name="amscore" value="#data_68" class="txtshort">
            <input type="text" name="gmscore" value="#data_69" class="txtshort">
            <input type="text" name="smscore" value="#data_70" class="txtshort">
            <input type="text" name="bmscore" value="#data_71" class="txtshort">
            <input type="text" name="finishscore" value="#data_72" class="txtshort">
         </td><td class="r">#data_73</td></tr>
         <tr><td class="lr" colspan="3"><span class="err">#data_74</span>&nbsp;</td></tr>
         <tr><th class="lr" colspan="3">#data_75</th></tr>
         <tr><td class="l">#data_76</td><td><input type="text" name="adminpass" value="#data_77"></td><td class="r">#data_78</td></tr>
         <tr><td class="lr" colspan="3">&nbsp;</td></tr>
         <tr><th class="lr" colspan="3">#data_79</th></tr>
         <tr><td class="bl"><input type="submit" name="actionbtn" value="#data_80" class="btn"></td><td colspan="2" class="br">#data_81</td></tr>
      </table>'."\r\n",

'status_1' => '
      <div class="splitter">&nbsp;</div>
      <span class="status">#data_1</span>'."\r\n",

'servers_1' => '
      <span class="hdr">&raquo; #data_1</span>
      <div class="splitter">&nbsp;</div>
      <input type="hidden" name="action" value="servers_act">
      <table cols="3" class="admindata">
         <tr><th class="tlr" colspan="3">#data_2</th></tr>'."\r\n",
'servers_2' => '
         <tr><td class="blr" colspan="3">#data_1</td></tr>'."\r\n",
'servers_3' => '
         <tr><td class="lr" colspan="3">#data_1</td></tr>
         <tr><th class="lr" colspan="3">#data_2 (0)</th></tr>
         <tr><td class="l" width="200">-</td><td>-</td><td class="r" width="30">-</td></tr>
         <tr><td class="lr" colspan="3">&nbsp;</td></tr>
         <tr><th class="lr" colspan="3">#data_3</th></tr>
         <tr><td class="bl"><input type="submit" name="actionbtn" value="#data_4" class="btn"></td><td class="br" colspan="2">#data_5</td></tr>'."\r\n",
'servers_4' => '
         <tr><td class="lr" colspan="3">#data_1</td></tr>
         <tr><th class="lr" colspan="3">#data_2 (#data_3)</th></tr>'."\r\n",
'servers_5' => '
         <tr><td class="l" width="200">#data_2<br>(#data_1)</td>
             <td nowrap>#data_3: #data_4<br>#data_5: "#data_6"<br>#data_7: "#data_8"<br>#data_9: "#data_10"<br>#data_11:#data_12<br>#data_13:#data_14</td>
             <td class="r" width="30"><input type="checkbox" name="#data_15" value="#data_16"></td>
         </tr>'."\r\n",
'servers_6' => '
         <tr><td class="lr" colspan="3">&nbsp;</td></tr>
         <tr><th class="lr" colspan="3">#data_1</th></tr>
         <tr><td class="l"><input type="submit" name="actionbtn" value="#data_2" class="btn"></td><td class="r" colspan="2">#data_3</td></tr>
         <tr><td class="l"><input type="submit" name="actionbtn" value="#data_4" class="btn"></td><td class="r" colspan="2">#data_5</td></tr>
         <tr><td class="bl"><input type="submit" name="actionbtn" value="#data_6" class="btn"></td><td class="br" colspan="2">#data_7</td></tr>'."\r\n",
'servers_7' => '
      </table>'."\r\n",
'servers_8' => '
      <span class="hdr">&raquo; #data_1 &raquo; #data_2</span>
      <div class="splitter">&nbsp;</div>
      <input type="hidden" name="action" value="servers_add">
      <table cols="3" class="admindata">
         <tr><th colspan="3">#data_3</th></tr>
         <tr><td class="l" width="200">#data_4</td><td width="150"><input type="text" name="ip" value="#data_5"></td><td class="r">#data_6</td></tr>
         <tr><td class="l">#data_7</td><td><input type="text" name="server" value="#data_8"></td><td class="r">#data_9</td></tr>
         <tr><td class="l">#data_10</td><td><select name="game">#data_11</select></td><td class="r">#data_12</td></tr>
         <tr><td class="l">#data_13</td><td><input type="text" name="login" value="#data_14"></td><td class="r">#data_15</td></tr>
         <tr><td class="l">#data_16</td><td><input type="text" name="password" value="#data_17"></td><td class="r">#data_18</td></tr>
         <tr><td class="l">#data_19</td><td><input type="text" name="logfiles" value="#data_20"></td><td class="r">#data_21</td></tr>
         <tr><td class="l">#data_22</td><td><input type="text" name="trackdirs" value="#data_23"></td><td class="r">#data_24</td></tr>
         <tr><td class="lr" colspan="3"><span class="err">#data_25&nbsp;</span></td></tr>
         <tr><th class="lr" colspan="3">#data_26</th></tr>
         <tr><td class="l"><input type="submit" name="actionbtn" value="#data_27" class="btn"></td><td class="r" colspan="2">#data_28</td></tr>
         <tr><td class="bl"><input type="submit" name="actionbtn" value="#data_29" class="btn"></td><td colspan="2" class="br">#data_30</td></tr>
      </table>'."\r\n",
'servers_9' => '
      <span class="hdr">&raquo; #data_1 &raquo; #data_2</span>
      <div class="splitter">&nbsp;</div>
      <input type="hidden" name="action" value="servers_mod">
      <table cols="3" class="admindata">'."\r\n",
'servers_10' => '
         <input type="hidden" name="serverid_#data_1" value="#data_2">
         <tr><th class="lr" colspan="3">#data_3 #data_4</th></tr>
         <tr><td class="l" width="200">#data_5</td><td width="150"><input type="text" name="ip_#data_1" value="#data_6"></td><td class="r">#data_7</td></tr>
         <tr><td class="l">#data_8</td><td><input type="text" name="server_#data_1" value="#data_9"></td><td class="r">#data_10</td></tr>
         <tr><td class="l">#data_11</td><td><select name="game_#data_1">#data_12</select></td><td class="r">#data_13</td></tr>
         <tr><td class="l">#data_14</td><td><input type="text" name="login_#data_1" value="#data_15"></td><td class="r">#data_16</td></tr>
         <tr><td class="l">#data_17</td><td><input type="text" name="password_#data_1" value="#data_18"></td><td class="r">#data_19</td></tr>
         <tr><td class="l">#data_20</td><td><input type="text" name="logfiles_#data_1" value="#data_21"></td><td class="r">#data_22</td></tr>
         <tr><td class="l">#data_23</td><td><input type="text" name="trackdirs_#data_1" value="#data_24"></td><td class="r">#data_25</td></tr>
         <tr><td colspan="3" class="lr"><span class="err">&nbsp;</span></td></tr>'."\r\n",
'servers_11' => '
         <tr><th class="lr" colspan="3">#data_1</th></tr>
         <tr><td class="l"><input type="submit" name="actionbtn" value="#data_2" class="btn"></td><td colspan="2" class="r">#data_3</td></tr>
         <tr><td class="bl"><input type="submit" name="actionbtn" value="#data_4" class="btn"></td><td colspan="2" class="br">#data_5</td></tr>
      </table>'."\r\n",
'servers_12' => '<br>- #data_1',

'db_1' => '
      <span class="hdr">&raquo; #data_1</span>
      <div class="splitter">&nbsp;</div>
      <input type="hidden" name="action" value="db_act">
      <table cols="3" class="admindata">
         <tr><th class="tlr" colspan="3">#data_2</th></tr>'."\r\n",
'db_2' => ' 
         <tr><td class="blr" colspan="3">#data_1</td></tr>'."\r\n",
'db_3' => '
         <tr><td class="lr" colspan="3">#data_1</td></tr>
         <tr><th class="l" width="200">#data_2</th><th>#data_3</th><th class="r">#data_4</th></tr>'."\r\n",
'db_4' => '
         <tr><td class="l">#data_1</td><td>#data_2</td><td class="r">#data_3</td></tr>'."\r\n",
'db_5' => '
         <tr><td class="lr" colspan="3">&nbsp;</td></tr>
         <tr><th class="lr" colspan="3">#data_1</th></tr>'."\r\n",
'db_6' => '
         <tr><td class="l"><input type="submit" name="actionbtn" value="#data_1" class="btn"></td><td colspan="2" class="r">#data_2</td></tr>'."\r\n",
'db_7' => '
         <tr><td class="l"><input type="submit" name="actionbtn" value="#data_1" class="btn"></td><td colspan="2" class="r">#data_2</td></tr>
         <tr><td class="l"><input type="submit" name="actionbtn" value="#data_3" class="btn"></td><td colspan="2" class="r">#data_4</td></tr>
         <tr><td class="l"><input type="submit" name="actionbtn" value="#data_5" class="btn"></td><td colspan="2" class="r">#data_6</td></tr>
         <tr><td class="bl"><input type="submit" name="actionbtn" value="#data_7" class="btn"></td><td colspan="2" class="br">#data_8</td></tr>'."\r\n",
'db_8' => '
         <tr><td class="l"><input type="submit" name="actionbtn" value="#data_1" class="btn"></td><td colspan="2" class="r">#data_2</td></tr>
         <tr><td class="bl"><input type="submit" name="actionbtn" value="#data_3" class="btn"></td><td colspan="2" class="br">#data_4</td></tr>'."\r\n",
'db_9' => '
      </table>'."\r\n",
'db_10'=>'
      <span class="hdr">&raquo; #data_1 &raquo; #data_2</span>
      <div class="splitter">&nbsp;</div>
      <input type="hidden" name="action" value="db_upd">
      <table cols="2" class="admindata">
         <tr><th colspan="2">#data_3</th></tr>
         <tr><td class="lr" colspan="2">#data_4</td></tr>'."\r\n",
'db_11'=>'
         <tr><th class="lr" colspan="2">#data_1</th></tr>
         <tr><td class="l" width="200"><input type="submit" name="actionbtn" value="#data_2" class="btn"></td><td class="r">#data_3</td></tr>
         <tr><td class="bl"><input type="submit" name="actionbtn" value="#data_4" class="btn"></td><td class="br">#data_5</td></tr>
      </table>'."\r\n",
'db_12'=>'
         <tr><th class="lr" colspan="2">#data_1</th></tr>
         <tr><td class="bl" width="200"><input type="submit" name="actionbtn" value="#data_2" class="btn"></td><td class="br">#data_3</td></tr>
      </table>'."\r\n",
      
'check_1' => 'err',
'check_2' => 'ok',
'check_3' => 'unknown',
'check_4' => '
      <span class="hdr">&raquo; #data_1</span>
      <div class="splitter">&nbsp;</div>
      <table cols="3" class="admindata">
         <tr><th class="tlr" colspan="3">#data_2</th></tr>
         <tr><td class="l" width="200">#data_3</td><td width="100"><span class="#data_4">#data_5</span></td><td class="r">#data_6</td></tr>
         <tr><td class="l">#data_7</td><td><span class="#data_8">#data_9</span></td><td class="r">#data_10</td></tr>
         <tr><td class="l">#data_11</td><td><span class="#data_12">#data_13</span></td><td class="r">#data_14</td></tr>
         <tr><td class="l">#data_15</td><td><span class="#data_16">#data_17</span></td><td class="r">#data_18</td></tr>
         <tr><td class="l">#data_19</td><td><span class="#data_20">#data_21</span></td><td class="r">#data_22</td></tr>
         <tr><td class="l">#data_23</td><td><span class="#data_24">#data_25</span></td><td class="r">#data_26</td></tr>
         <tr><td class="l">#data_27</td><td><span class="#data_28">#data_29</span></td><td class="r">#data_30</td></tr>
         <tr><td class="l">#data_31</td><td><span class="#data_32">#data_33</span></td><td class="r">#data_34</td></tr>
         <tr><td class="l">#data_35</td><td><span class="#data_36">#data_37</span></td><td class="r">#data_38</td></tr>
         <tr><td class="lr" colspan="3">&nbsp;</td></tr>
         <tr><th class="lr" colspan="3">#data_39</th></tr>
         <tr><td class="l">#data_40</td><td><span class="#data_41">#data_42</span></td><td class="r">#data_43</td></tr>
         <tr><td class="l">#data_44</td><td><span class="#data_45">#data_46</span></td><td class="r">#data_47</td></tr>'."\r\n",
'check_5' => '
         <tr><td class="l">#data_1</td><td><span class="#data_2">#data_3</span></td><td class="r">#data_4</td></tr>
         <tr><td class="lr" colspan="3">&nbsp;</td></tr>
         <tr><th class="lr" colspan="3">#data_5 (#data_6)</th></tr>'."\r\n",
'check_6' => '
         <tr><td class="l">#data_1</td><td><span class="#data_2">#data_3</span></td><td class="r">&nbsp;</td></tr>'."\r\n",
'check_7' => '
         <tr><td class="lr" colspan="3">&nbsp;</td></tr>
         <tr><th class="lr" colspan="3">#data_1</th></tr>'."\r\n",
'check_8' => '
         <tr><td class="l">-</td><td>-</td><td class="r">-</td></tr>'."\r\n",
'check_9' => '
',
'check_10' => '
         <tr><td class="l">#data_1<br>(#data_2)</td><td><span class="#data_3">#data_4</span></td><td class="r">#data_5:#data_6<br>#data_7:#data_8</td></tr>'."\r\n",
'check_11' => '
         <tr><td class="blr" colspan="3">&nbsp;</td></tr>
      </table>'."\r\n",
'check_12' => '<br>- <span class="#data_1">#data_2</span>',

"userbars_1" => '
      <span class="hdr">&raquo; #data_1</span>
      <div class="splitter">&nbsp;</div>
      <input type="hidden" name="action" value="userbars_act">
      <table cols="3" class="admindata">
         <tr><th class="tlr" colspan="3">#data_2</th></tr>'."\r\n",
'userbars_2' => '
         <tr><td class="blr" colspan="3">#data_1</td></tr>'."\r\n",
'userbars_3' => '
         <tr><td class="lr" colspan="3">#data_1</td></tr>
         <tr><th class="lr" colspan="3">#data_2 (0)</th></tr>
         <tr><td class="l" width="200">-</td><td>-</td><td class="r" width="30">-</td></tr>
         <tr><td class="lr" colspan="3">&nbsp;</td></tr>
         <tr><th class="lr" colspan="3">#data_3</th></tr>
         <tr><td class="bl"><input type="submit" name="actionbtn" value="#data_4" class="btn"></td><td class="br" colspan="2">#data_5</td></tr>'."\r\n",
'userbars_4' => '
         <tr><td class="lr" colspan="3">#data_1</td></tr>
         <tr><th class="lr" colspan="3">#data_2 (#data_3)</th></tr>'."\r\n",
"userbars_5" => '
         <tr><td class="l" width="200">#data_1: #data_2<br>#data_3: #data_4<br>#data_5:<br><span class="#data_6">#data_7</span> ##data_8 #data_9<br>#data_10:<br><span class="#data_11">#data_12</span> ##data_13 #data_14</td>
             <td><img src="#data_15"></td>
             <td class="r" width="30"><input type="checkbox" name="#data_16" value="#data_17"></td>
         </tr>'."\r\n",
"userbars_6" => '
         <tr><td class="lr" colspan="3">&nbsp;</td></tr>
         <tr><th class="lr" colspan="3">#data_1</th></tr>
         <tr><td class="l"><input type="submit" name="actionbtn" value="#data_2" class="btn"></td><td class="r" colspan="3">#data_3</td></tr>
         <tr><td class="l"><input type="submit" name="actionbtn" value="#data_4" class="btn"></td><td class="r" colspan="3">#data_5</td></tr>
         <tr><td class="bl"><input type="submit" name="actionbtn" value="#data_6" class="btn"></td><td class="br" colspan="3">#data_7</td></tr>'."\r\n",
'userbars_7' => '
      </table>'."\r\n",
'userbars_8' => '
      <span class="hdr">&raquo; #data_1 &raquo; #data_2</span>
      <div class="splitter">&nbsp;</div>
      <input type="hidden" name="action" value="userbars_add">
      <input type="hidden" name="MAX_FILE_SIZE" value="102400">
      <table cols="2" class="admindata">
         <tr><th colspan="2">#data_3</th></tr>
         <tr><td class="l" width="200">#data_4</td><td class="r"><input type="file" name="imgfile" value="#data_5"></td></tr>
         <tr><td class="l">#data_6</td><td class="r"><select name="game">#data_7</select></td></tr>
         <tr><td class="l">#data_8</td><td class="r"><select name="ubt">#data_9</select></td></tr>
         <tr><td class="l">#data_10</td><td class="r"><input type="text" name="font1" value="#data_11">&nbsp;<input class="txtmiddle" type="text" name="color1" value="#data_12">&nbsp;<input class="txtmiddle" type="text" name="size1" value="#data_13"></td></tr>
         <tr><td class="l">#data_14</td><td class="r"><input type="text" name="font2" value="#data_15">&nbsp;<input class="txtmiddle" type="text" name="color2" value="#data_16">&nbsp;<input class="txtmiddle" type="text" name="size2" value="#data_17"></td></tr>
         <tr><td class="lr" colspan="2"><span class="err">#data_18&nbsp;</span></td></tr>
         <tr><th class="lr" colspan="2">#data_19</th></tr>
         <tr><td class="l"><input type="submit" name="actionbtn" value="#data_20" class="btn"></td><td class="r">#data_21</td></tr>
         <tr><td class="bl"><input type="submit" name="actionbtn" value="#data_22" class="btn"></td><td class="br">#data_23</td></tr>
      </table>'."\r\n",
'userbars_9' => '
      <span class="hdr">&raquo; #data_1 &raquo; #data_2</span>
      <div class="splitter">&nbsp;</div>
      <input type="hidden" name="action" value="userbars_mod">
      <table cols="2" class="admindata">'."\r\n",
'userbars_10' => '
         <input type="hidden" name="userbarid_#data_1" value="#data_2">
         <tr><th colspan="2">#data_3 #data_4</th></tr>
         <tr><td class="l" width="200">#data_5</td><td class="r"><select name="game_#data_1">#data_6</select></td></tr>
         <tr><td class="l">#data_7</td><td class="r"><select name="ubt_#data_1">#data_8</select></td></tr>
         <tr><td class="l">#data_9</td><td class="r"><input type="text" name="font1_#data_1" value="#data_10">&nbsp;<input class="txtmiddle" type="text" name="color1_#data_1" value="#data_11">&nbsp;<input class="txtmiddle" type="text" name="size1_#data_1" value="#data_12"></td></tr>
         <tr><td class="l">#data_13</td><td class="r"><input type="text" name="font2_#data_1" value="#data_14">&nbsp;<input class="txtmiddle" type="text" name="color2_#data_1" value="#data_15">&nbsp;<input class="txtmiddle" type="text" name="size2_#data_1" value="#data_16"></td></tr>
         <tr><td class="lr" colspan="2"><span class="err">#data_17&nbsp;</span></td></tr>'."\r\n",
'userbars_11' => '
         <tr><th class="lr" colspan="2">#data_1</th></tr>
         <tr><td class="l"><input type="submit" name="actionbtn" value="#data_2" class="btn"></td><td class="r">#data_3</td></tr>
         <tr><td class="bl"><input type="submit" name="actionbtn" value="#data_4" class="btn"></td><td class="br">#data_5</td></tr>
      </table>'."\r\n",


'server_1' => '
      <span class="hdr">&raquo; #data_1</span>
      <div class="splitter">&nbsp;</div>
      <input type="hidden" name="action" value="server_act">
      <input type="hidden" name="sid" value="#data_2">
      <table cols="2" class="admindata">
         <tr><th class="tlr" colspan="2">#data_3</th></tr>
         <tr><td class="l" width="200">#data_4</td><td class="r">#data_5</td></tr>
         <tr><td class="l">#data_6</td><td class="r">#data_7 / #data_8</td></tr>
         <tr><td class="l">#data_9</td><td class="r">#data_10</td></tr>
         <tr><td class="l">#data_11</td><td class="r">#data_12</td></tr>
         <tr><td class="lr" colspan="2">&nbsp;</td></tr>
         <tr><th class="lr" colspan="2">#data_13</th></tr>
         <tr><td class="bl"><input type="submit" name="actionbtn" value="#data_14" class="btn"></td><td colspan="2" class="br">#data_15</td></tr>
      </table>
      <div class="splitter">&nbsp;</div>
      <table cols="2" class="admindata">
         <tr><th class="tlr" colspan="2">#data_16</th></tr>
         <tr><td class="l" width="200">#data_17</td><td class="r">#data_18</td></tr>
         <tr><td class="l">#data_19</td><td class="r">#data_20</td></tr>
         <tr><td class="lr" colspan="2">&nbsp;</td></tr>
         <tr><th class="lr" colspan="2">#data_21</th></tr>
         <tr><td class="l"><input type="checkbox" name="cfsp" value="true" checked></td><td class="r">#data_37</td></tr>
         <tr><td class="bl"><input type="submit" name="actionbtn" value="#data_22" class="btn"></td><td colspan="2" class="br">#data_23</td></tr>
      </table>
      <div class="splitter">&nbsp;</div>
      <table cols="2" class="admindata">
         <tr><th class="tlr" colspan="2">#data_25</th></tr>
         <tr><td class="l" width="200">#data_26</td><td class="r">#data_27</td></tr>
         <tr><td class="lr" colspan="2">&nbsp;</td></tr>
         <tr><th class="lr" colspan="2">#data_28</th></tr>
         <tr><td class="l"><input type="submit" name="actionbtn" value="#data_29" class="btn"></td><td colspan="2" class="r">#data_30</td></tr>
         <tr><td class="l"><input type="submit" name="actionbtn" value="#data_31" class="btn"></td><td colspan="2" class="r">#data_32</td></tr>
         <tr><td class="l"><input type="submit" name="actionbtn" value="#data_33" class="btn"></td><td colspan="2" class="r">#data_34</td></tr>
         <tr><td class="bl"><input type="submit" name="actionbtn" value="#data_35" class="btn"></td><td colspan="2" class="br">#data_36</td></tr>
      </table>'."\r\n",
'server_2' => '(#data_1b) #data_2<br>',
'server_3' => '<input type="radio" name="dir" value="#data_2" checked>#data_1<br>',
'server_4' => '
      <span class="hdr">&raquo; #data_1 &raquo; #data_2</span>
      <div class="splitter">&nbsp;</div>
      <input type="hidden" name="action" value="server_ts">
      <input type="hidden" name="sid" value="#data_3">
      <table cols="4" class="admindata">
         <tr><th width="50">#data_4</th><th>#data_5</th><th width="100">#data_6</th><th width="100">#data_7</th></tr>'."\r\n",
'server_5' => '
         <tr><td class="l">-</td><td>-</td><td>-</td><td class="r">-</td></tr>'."\r\n",
'server_6' => '
         <tr><td class="l"><input type="radio" name="choosetrack" value="#data_1"></td><td>#data_2</td><td>#data_3</td><td class="arr">#data_4</td></tr>'."\r\n",
'server_7' => '
         <tr><td class="lr" colspan="4">&nbsp;</td></tr>
         <tr><th class="lr" colspan="4">#data_1</th></tr>
         <tr><td class="blr" colspan="4"><input type="submit" name="actionbtn" value="#data_2" class="btn"></td></tr>
      </table>'."\r\n",

'server_8' => '
      <span class="hdr">&raquo; #data_1 &raquo; #data_2</span>
      <div class="splitter">&nbsp;</div>
      <input type="hidden" name="action" value="server_msf">
      <input type="hidden" name="sid" value="#data_3">
      <table cols="6" class="admindata">
         <tr><th colspan="2">#data_4</th><th colspan="4">#data_5</th></tr>
         <tr><td colspan="2" class="l">#data_6</td><td colspan="4" class="r"><select name="gi_gamemode">#data_7</select></td></tr>
         <tr><td colspan="2" class="l">#data_8</td><td colspan="4" class="r"><input type="text" name="gi_chattime" value="10000"></td></tr>
         <tr><td colspan="2" class="l">#data_9</td><td colspan="4" class="r"><input type="text" name="gi_roundspointslimit" value="10"></td></tr>
         <tr><td colspan="2" class="l">#data_10</td><td colspan="4" class="r"><select name="gi_roundsusenewrules">#data_11</select></td></tr>
         <tr><td colspan="2" class="l">#data_12</td><td colspan="4" class="r"><input type="text" name="gi_timeattacklimit" value="360000"></td></tr>
         <tr><td colspan="2" class="l">#data_13</td><td colspan="4" class="r"><input type="text" name="gi_teampointslimit" value="5"></td></tr>
         <tr><td colspan="2" class="l">#data_14</td><td colspan="4" class="r"><input type="text" name="gi_teammaxpoints" value="6"></td></tr>
         <tr><td colspan="2" class="l">#data_15</td><td colspan="4" class="r"><select name="gi_teamusenewrules">#data_16</select></td></tr>
         <tr><td colspan="2" class="l">#data_17</td><td colspan="4" class="r"><input type="text" name="gi_lapsnblaps" value="100"></td></tr>
         <tr><td colspan="2" class="l">#data_18</td><td colspan="4" class="r"><input type="text" name="gi_lapstimelimit" value="0"></td></tr>
         <tr><td colspan="2" class="l">#data_19</td><td colspan="4" class="r"><select name="gi_randommaporder">#data_20</select></td></tr>
         <tr><td colspan="6" class="lr">&nbsp;</td></tr>
         <tr><th class="l" width="50">#data_21</th><th width="300">#data_22 (#data_23)</th><th>#data_24</th><th width="50">#data_25</th><th width="30">#data_26</th><th class="r" width="30">#data_27</th></tr>'."\r\n",
'server_9' => '
         <tr><td class="l">-</td><td>-</td><td>-</td><td>-</td><td>-</td><td class="r">-</td></tr>'."\r\n",
'server_10' => '
         <tr><td class="l"><input type="checkbox" name="t#data_1" value="#data_2" checked></td><td>#data_3 (#data_4)</td><td>#data_5</td><td>#data_6</td><td>#data_7</td><td class="r">#data_8</td></tr>'."\r\n",
'server_11' =>'
         <tr><td class="lr" colspan="6">
            <a href="javascript:void(0);" onclick="javascript:check(\'achk\')">#data_1</a>&nbsp;/&nbsp;
            <a href="javascript:void(0);" onclick="javascript:check(\'al\')">#data_2</a>&nbsp;/&nbsp;
            <a href="javascript:void(0);" onclick="javascript:check(\'ba\')">#data_3</a>&nbsp;/&nbsp;
            <a href="javascript:void(0);" onclick="javascript:check(\'co\')">#data_4</a>&nbsp;/&nbsp;
            <a href="javascript:void(0);" onclick="javascript:check(\'is\')">#data_5</a>&nbsp;/&nbsp;
            <a href="javascript:void(0);" onclick="javascript:check(\'ra\')">#data_6</a>&nbsp;/&nbsp;
            <a href="javascript:void(0);" onclick="javascript:check(\'sp\')">#data_7</a>&nbsp;/&nbsp;
            <a href="javascript:void(0);" onclick="javascript:check(\'st\')">#data_8</a>&nbsp;/&nbsp;
            <a href="javascript:void(0);" onclick="javascript:check(\'uchk\')">#data_9</a>
         </td></tr>
         <tr><th class="lr" colspan="6">#data_10</th></tr>
         <tr><td class="lr" colspan="6"><input type="text" name="msfilepath" value="#data_11" style="width:100%"></></td>
         <tr><td class="lr" colspan="6">&nbsp;</td></tr>
         <tr><th class="lr" colspan="6">#data_12</th></tr>
         <tr><td colspan="2" class="l"><input type="checkbox" name="restartserver" value="true" checked></td><td colspan="4" class="r">#data_13</td></tr>
         <tr><td class="bl" colspan="2"><input type="submit" name="actionbtn" value="#data_14" class="btn"></td><td class="br" colspan="4">#data_15</td></tr>
      </table>'."\r\n",
'server_12' =>'<?xml version="1.0" encoding="utf-8" ?>
<playlist>
   <gameinfos>
      <game_mode>#data_1</game_mode>
      <chat_time>#data_2</chat_time>
      <rounds_pointslimit>#data_3</rounds_pointslimit>
      <rounds_usenewrules>#data_4</rounds_usenewrules>
      <timeattack_limit>#data_5</timeattack_limit>
      <timeattack_synchstartperiod>0</timeattack_synchstartperiod>
      <team_pointslimit>#data_6</team_pointslimit>
      <team_maxpoints>#data_7</team_maxpoints>
      <team_usenewrules>#data_8</team_usenewrules>
      <laps_nblaps>#data_9</laps_nblaps>
      <laps_timelimit>#data_10</laps_timelimit>
   </gameinfos>
   <hotseat>
      <game_mode>0</game_mode>
      <timeattack_limit>3</timeattack_limit>
      <rounds_count>5</rounds_count>
   </hotseat>
   <filter>
      <is_solo>0</is_solo>
      <is_hotseat>0</is_hotseat>
      <is_lan>1</is_lan>
      <is_internet>0</is_internet>
      <sort_index>400</sort_index>
      <random_map_order>#data_11</random_map_order>
   </filter>',
'server_13' =>'
   <challenge>
      <file>#data_1</file>
      <ident>#data_2</ident>
   </challenge>',
'server_14' =>'
</playlist>'

);

// content template
$tmos_viewer_ct = array(


"common_1" => '&nbsp;<a href="#data_1"><img src="gfx/bl.gif" class="m"></a>',
"common_2" => '<a href="#data_1">#data_2</a>',
"common_3" => '<img src="gfx/bk.gif" class="m">',
"common_4" => '<a href="#data_1" class="#data_2">#data_3</a>',

"script_1" => '<script type="text/javascript" language="JavaScript">
<!--
   function mi(tablestr) {
      tablestr.className="light";
   } 
   function mo(tablestr) {
      tablestr.className="";
   }
//-->   
</script>',
"script_2" => ' onMouseOver="mi(this)" onMouseOut="mo(this)"',

"header_1" => '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>TM Offline Stats 1.0</title>
<link rel="stylesheet" type="text/css" href="css/#data_1">
#data_2
</head>
<body>
<table class="header">
   <tr><td class="logo"><img src="gfx/logo.gif" class="logo" alt="TM Offline Stats"></td></tr>
</table>
<table class="menu"><tr class="menu">
   <td class="ml">&nbsp;</td>'."\r\n",
"header_2" => 'ma',
"header_3" => 'm',
"header_4" => '   <td class="#data_1" nowrap>#data_2</td>'."\r\n",
"header_5" => '   <td class="#data_1" nowrap>&raquo;</td>'."\r\n",
"header_6" => '   <td class="mr">&nbsp;</td>
</tr></table>
<table class="menue"><tr class="menue">
   <td class="mel">&nbsp;</td>'."\r\n",
"header_7" => 'mea',
"header_8" => 'me',
"header_9" => '   <td class="#data_1">#data_2</td>'."\r\n",
"header_10" => '<img src="gfx/bus.gif" class="m">',
"header_11" => '   <td class="mlu">#data_1</td>'."\r\n",
"header_12" => '<a href="#data_1"><img src="gfx/bup.gif" class="uo"></a>',
"header_13" => '   <td class="mer">#data_1</td>
</tr></table>
<div class="splitter">&nbsp;</div>'."\r\n",

"footer_1" => '<div class="splitter">&nbsp;</div>
<table class="links">
   <tr><td class="links">&copy; 2006-2009 Alexander Domnin</td></tr>
   <tr><td class="links"><a href="http://tmos.pp.ru">www.tmos.pp.ru</a></td></tr>
</table>
</body>
</html>',

"servers_1" => '<table cols="5" class="data">
<tr><th class="infhdr" colspan="5">#data_1</th></tr>'."\r\n",
"servers_2" => '<tr><td class="l">-</td><td>-</td><td>-</td><td>-</td><td class="r">-</td></tr>'."\r\n",
"servers_3" => '<tr#data_1><td class="l"><a href="#data_2">#data_3</a></td><td width="100">#data_4</td><td width="200">#data_5</td><td width="70">#data_6 / #data_7</td><td class="r" width="70">#data_8&nbsp;#data_9</td></tr>'."\r\n",
"servers_4" => '<tr><td class="blr" colspan="5">&nbsp;</td></tr>
</table>'."\r\n",

"monitoring_1" => '
<table cols="3" class="data">
   <tr><th colspan="3" class="infhdr">#data_1</th></tr>
   <tr><td class="l" width="180">#data_3</td><td class="r" colspan="2">#data_4</td></tr>
   <tr><td class="l">#data_5</td><td class="r" colspan="2">#data_6</td></tr>
   <tr><td class="l">#data_7</td><td class="r" colspan="2">#data_8 / #data_9</td></tr>
   <tr><td class="l">#data_10</td><td class="r" colspan="2">#data_11 / #data_12</td></tr>
   <tr><td class="l">#data_13</td><td class="r" colspan="2">#data_14</td></tr>
   <tr><th class="lr" colspan="3">#data_15</th></tr>
   <tr>
      <td class="l">#data_16</td><td>#data_17</td>
      <td width="160" rowspan="6" class="infpictr"><img class="infpict" src="#data_18"></td>
   </tr>
   <tr><td class="l">#data_19</td><td>#data_20</td></tr>
   <tr><td class="l">#data_21</td><td>#data_22</td></tr>
   <tr><td class="l">#data_23</td><td>#data_24</td></tr>
   <tr><td class="l">#data_25</td><td>#data_26</td></tr>
   <tr><td class="bl">#data_27</td><td class="b">#data_28 (#data_29)</td></tr>
</table>
<div class="splitter">&nbsp;</div>'."\r\n",
"monitoring_2" => '
<table cols="4" class="data">
<tr><th width="50">#data_1</th><th>#data_2</th><th width="180">#data_3</th><th width="50">&nbsp;<img src="gfx/bsp.gif"/></th></tr>'."\r\n",
"monitoring_3" => '
<tr><td class="l">-</td><td>-</td><td>-</td><td class="r">-</td></tr>'."\r\n",
"monitoring_4" => '
<tr#data_1><td class="l">#data_2</td><td>#data_3</td><td class="ar">#data_4</td><td class="r">#data_5</td>'."\r\n",
"monitoring_5" => '
<tr><td colspan="4" class="blr">&nbsp</td></tr>'."\r\n",
"monitoring_6" => '
</table>'."\r\n",


"dscr_1"=>'<table cols="2" class="inf">
   <tr><th colspan="2" class="infhdr">#data_1</th></tr>
   <tr><td class="infpict"><img src="#data_2" class="infpict"></td><td class="infdata">
   <table cols="3" class="infdata">
      <tr><td width="150">#data_3</td><td>#data_4</td><td width="100" rowspan="6">
         <form action="#data_5" method="get">
         <input type="hidden" name="action" value="#data_6">
         <input type="hidden" name="sid" value="#data_7">
         <input type="hidden" name="sortfield" value="#data_8">
         <input type="hidden" name="sortdir" value="#data_9">
         <input type="hidden" name="page" value="1">
         #data_10<p class="splitter">
         <input type="text" name="query" value="#data_11" class="txt"><p class="splitter"><p>
         <input type="submit" value="#data_12" class="btn">
         </form>
      </td></tr>
      <tr><td>#data_13</td><td>#data_14</td></tr>
      <tr><td>#data_15</td><td>#data_16</td></tr>
      <tr><td>#data_17</td><td>#data_18</td></tr>
      <tr><td>#data_19</td><td>#data_20</td></tr>
      <tr><td>#data_21</td><td>#data_22</td></tr>
      </table>
   </td></tr>
</table>
<div class="splitter">&nbsp;</div>'."\r\n",

"players_1" => '<table cols="7" class="data"><tr>
<th width="50">#data_1</th>
<th nowrap>#data_2&nbsp;<a href="#data_3"><img src="#data_4" class="sort"></a></th>
<th width="50" nowrap><img src="gfx/ma.gif">&nbsp;<a href="#data_5"><img src="#data_6" class="sort"></a></th>
<th width="50" nowrap><img src="gfx/mg.gif">&nbsp;<a href="#data_7"><img src="#data_8" class="sort"></a></th>
<th width="50" nowrap><img src="gfx/ms.gif">&nbsp;<a href="#data_9"><img src="#data_10" class="sort"></a></th>
<th width="50" nowrap><img src="gfx/mb.gif">&nbsp;<a href="#data_11"><img src="#data_12" class="sort"></a></th>
<th width="100" nowrap>#data_13&nbsp;<a href="#data_14"><img src="#data_15" class="sort"></a></th>
</tr>'."\r\n",
"players_2" => '<tr><td class="bl">-</td><td class="b">-</td><td class="b">-</td><td class="b">-</td><td class="b">-</td><td class="b">-</td><td class="br">-</td></tr>'."\r\n",
"players_3" => '<tr#data_1><td class="l">#data_2</td><td><a href="#data_3">#data_4</a>#data_5</td><td>#data_6</td><td>#data_7</td><td>#data_8</td><td>#data_9</td><td class="r">#data_10</td></tr>'."\r\n",
"players_4" => '<tr><td class="pages" colspan="7">#data_1</td></tr>'."\r\n",
"players_5" => '</table>'."\r\n",

"dscr_2" => '<a href="#data_1"><img src="gfx/bub.gif" class="btn"></a>',
"dscr_3" => '<table cols="2" class="inf">
   <tr><th colspan="2" class="infhdr">
      <div style="float:left;">#data_1</div><div style="float:right;">#data_2</div>
   </th></tr>
   <tr><td class="infpict"><img src="#data_3" class="infpict"></td>
   <td class="infdata">
   <table cols="3" class="infdata">
      <tr><td width="150">#data_4</td><td>#data_5 (#data_26)</td><td width="140">#data_6 (#data_7):</td></tr>
      <tr><td>#data_8</td><td>#data_9</td><td>#data_21</td></tr>
      <tr><td><img src="gfx/ma.gif"> / <img src="gfx/mg.gif"> / <img src="gfx/ms.gif"> / <img src="gfx/mb.gif"> / <img src="gfx/mf.gif"></td><td>#data_10 / #data_11 / #data_12 / #data_13 / #data_14</td><td>#data_22</td></tr>
      <tr><td>#data_15</td><td>#data_16</td><td>#data_23</td></tr>
      <tr><td>#data_17</td><td>#data_18</td><td>#data_24</td></tr>
      <tr><td>#data_19</td><td>#data_20</td><td>#data_25</td></tr>
   </table>
   </td></tr>
</table>
<div class="splitter">&nbsp;</div>'."\r\n",

"player_1" => '<table cols="6" class="data">
<tr><th width="50">#data_1</th>
<th>#data_2&nbsp;<a href="#data_3"><img src="#data_4" class="sort"></a></th>
<th width="80" nowrap>#data_5</th>
<th width="120" nowrap>#data_6&nbsp;<a href="#data_7"><img src="#data_8" class="sort"></a><a href="#data_9"><img src="#data_10" class="sort"></a></th>
<th width="40" nowrap><img src="gfx/mh.gif">&nbsp;<a href="#data_12"><img src="#data_13" class="sort"></a></th>
<th width="150" nowrap>#data_14&nbsp;<a href="#data_15"><img src="#data_16" class="sort"></a></th>
</tr>'."\r\n",
"player_2" => '<tr><td class="bl">-</td><td class="b">-</td><td class="b">-</td><td class="b">-</td><td class="b">-</td><td class="br">-</td></tr>'."\r\n",
"player_3" => '<tr#data_1><td class="l">#data_2</td><td><a href="#data_3">#data_4</a></td><td class="ar">#data_5</td><td class="ar">#data_6</td><td class="ac"><img src="#data_7" class="m"></td><td class="r">#data_8</td></tr>'."\r\n",
"player_4" => '<tr><td class="pages" colspan="6">#data_1</td></tr>'."\r\n",
"player_5" => '</table>'."\r\n",

"tracks_1" => '<table cols="6" class="data">
<tr><th width="50">#data_1</th>
<th nowrap>#data_2&nbsp;<a href="#data_3"><img src="#data_4" class="sort"></a></th>
<th width="100" nowrap>#data_5&nbsp;<a href="#data_6"><img src="#data_7" class="sort"></a></th>
<th width="80" nowrap>#data_8&nbsp;<a href="#data_9"><img src="#data_10" class="sort"></a></th>
<th width="200" nowrap>#data_11&nbsp;<a href="#data_12"><img src="#data_13" class="sort"></a></th>
<th width="50" nowrap><img src="gfx/mf.gif">&nbsp;<a href="#data_14"><img src="#data_15" class="sort"></a></th>
</tr>'."\r\n",
"tracks_2" => '<tr><td class="bl">-</td><td class="b">-</td><td class="b">-</td><td class="b">-</td><td class="b">-</td><td class="br">-</td></tr>'."\r\n",
"tracks_3" => '<tr#data_1><td class="l">#data_2</td><td><a href="#data_3">#data_4</a></td><td>#data_5</td><td class="ar">#data_6</td><td>#data_7</td><td class="r">#data_8</td></tr>'."\r\n",
"tracks_4" => '<tr><td class="pages" colspan="6">#data_1</td></tr>'."\r\n",
"tracks_5" => '</table>'."\r\n",

"dscr_4" => '<a href="#data_1"><img src="gfx/bdl.gif" class="btn"></a>',
"dscr_5" => '<table cols="2" class="inf">
   <tr><th colspan="2" class="infhdr">
      <div style="float:left;">#data_1</div><div style="float:right;">#data_15</div>
   </th></tr>
   <tr><td class="infpict"><img src="#data_2" class="infpict"></td>
   <td class="infdata">
   <table cols="2" class="infdata">
      <tr><td width="150">#data_3</td><td>#data_4</td></tr>
      <tr><td>#data_5</td><td>#data_6</td></tr>
      <tr><td>#data_7</td><td>#data_8</td></tr>
      <tr><td>#data_9</td><td>#data_10</td></tr>
      <tr><td>#data_11</td><td>#data_12</td></tr>
      <tr><td>#data_13</td><td>#data_14</td></tr>
   </table>
   </td></tr>
</table>
<div class="splitter">&nbsp;</div>'."\r\n",

"track_1" => '<table cols="6" class="data">
<tr><th width="50">#data_1</th>
<th nowrap>#data_2&nbsp;<a href="#data_3"><img src="#data_4" class="sort"></th>
<th nowrap colspan="2">#data_5&nbsp;<a href="#data_6"><img src="#data_7" class="sort"></th>
<th width="40" nowrap><img src="gfx/mh.gif">&nbsp;<a href="#data_9"><img src="#data_10" class="sort"></th>
<th width="150" nowrap>#data_11&nbsp;<a href="#data_12"><img src="#data_13" class="sort"></th>
</tr>'."\r\n",
"track_2" => '<tr><td class="bl">-</td><td class="b">-</td><td class="b">-</td><td class="b">-</td><td class="b">-</td><td class="br">-</td></tr>'."\r\n",
"track_3" => '<tr#data_1><td class="l">#data_2</td><td><a href="#data_3">#data_4</a>#data_5</td><td class="ar" width="80">#data_6</td><td class="ar" width="80">#data_7</td><td class="ac"><img src="#data_8" class="m"></td><td class="r">#data_9</td></tr>'."\r\n",
"track_4" => '<tr><td class="pages" colspan="6">#data_1</td></tr>'."\r\n",
"track_5" => '</table>'."\r\n",

"clans_1" => '<table cols="8" class="data"><tr>
<th width="50">#data_1</th>
<th nowrap>#data_2&nbsp;<a href="#data_3"><img src="#data_4" class="sort"></a></th>
<th width="50" nowrap><img src="gfx/ma.gif">&nbsp;<a href="#data_5"><img src="#data_6" class="sort"></a></th>
<th width="50" nowrap><img src="gfx/mg.gif">&nbsp;<a href="#data_7"><img src="#data_8" class="sort"></a></th>
<th width="50" nowrap><img src="gfx/ms.gif">&nbsp;<a href="#data_9"><img src="#data_10" class="sort"></a></th>
<th width="50" nowrap><img src="gfx/mb.gif">&nbsp;<a href="#data_11"><img src="#data_12" class="sort"></a></th>
<th width="100" nowrap>#data_13&nbsp;<a href="#data_14"><img src="#data_15" class="sort"></a></th>
<th width="50" nowrap><img src="gfx/bm.gif">&nbsp;<a href="#data_16"><img src="#data_17" class="sort"></a></th>
</tr>'."\r\n",
"clans_3" => '<tr#data_1><td class="l">#data_2</td><td><a href="#data_3">#data_4</a>#data_5</td><td>#data_6</td><td>#data_7</td><td>#data_8</td><td>#data_9</td><td>#data_10</td><td class="r">#data_11</td></tr>'."\r\n",
"clans_2" => '<tr><td class="bl">-</td><td class="b">-</td><td class="b">-</td><td class="b">-</td><td class="b">-</td><td class="b">-</td><td class="b">-</td><td class="br">-</td></tr>'."\r\n",
"clans_4" => '<tr><td class="pages" colspan="8">#data_1</td></tr>'."\r\n",
"clans_5" => '</table>'."\r\n",

"clan_1" => '<table cols="7" class="data"><tr>
<th width="50">#data_1</th>
<th nowrap>#data_2&nbsp;<a href="#data_3"><img src="#data_4" class="sort"></a></th>
<th width="50" nowrap><img src="gfx/ma.gif">&nbsp;<a href="#data_5"><img src="#data_6" class="sort"></a></th>
<th width="50" nowrap><img src="gfx/mg.gif">&nbsp;<a href="#data_7"><img src="#data_8" class="sort"></a></th>
<th width="50" nowrap><img src="gfx/ms.gif">&nbsp;<a href="#data_9"><img src="#data_10" class="sort"></a></th>
<th width="50" nowrap><img src="gfx/mb.gif">&nbsp;<a href="#data_11"><img src="#data_12" class="sort"></a></th>
<th width="100" nowrap>#data_13&nbsp;<a href="#data_14"><img src="#data_15" class="sort"></a></th>
</tr>'."\r\n",
"clan_2" => '<tr><td class="bl">-</td><td class="b">-</td><td class="b">-</td><td class="b">-</td><td class="b">-</td><td class="b">-</td><td class="br">-</td></tr>'."\r\n",
"clan_3" => '<tr#data_1><td class="l">#data_2</td><td><a href="#data_3">#data_4</a></td><td>#data_5</td><td>#data_6</td><td>#data_7</td><td>#data_8</td><td class="r">#data_9</td></tr>'."\r\n",
"clan_4" => '<tr><td class="pages" colspan="7">#data_1</td></tr>'."\r\n",
"clan_5" => '</table>'."\r\n",

"preferences_1" => '
<table cols="2" class="preferences">
   <form action="#data_1" method="post" name="mainform">
   <input type="hidden" name="action" value="preferences_save">
   <input type="hidden" name="oldlanguage" value="#data_2">
   <tr><th colspan="2">#data_3</th></tr>
   <tr><td class="l" width="200">#data_4</td><td class="r"><select name="colorscheme">#data_5</select></td></tr>
   <tr><td class="l">#data_6</td><td class="r"><select name="language">#data_7</select></td></tr>
   <tr><td class="l">#data_8</td><td class="r"><input type="text" name="recperpage" value="#data_9"></td></tr>
   <tr><td class="l">#data_10</td><td class="r"><input type="checkbox" name="colortags" value="true"#data_11></td></tr>
   <tr><td class="blr ac" colspan="2"><input type="submit" name="actionbtn" value="#data_12" class="btn">&nbsp;&nbsp;<input type="submit" name="actionbtn" value="#data_13" class="btn"></td></tr>
   </form>
</table>'."\r\n",

"userbars_1" => '
<table cols="1">
   <tr><th class="infhdr">#data_1</th></tr>
   <tr><td class="blr">'."\r\n",
"userbars_2" => '
   <p><br><img src="#data_1">
   <p>#data_2
   <br><textarea>[img]#data_3[/img]'."\r\n".'<img src="#data_4"></textarea><p>'."\r\n",
"userbars_3" => '
   </td></tr>
</table>'."\r\n"

);

?>