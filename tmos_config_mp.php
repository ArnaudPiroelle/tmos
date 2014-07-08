<?php

// TM Offline Stats v1.0

/* - commentary ------------------------------------------------------
   This file allows you to manage the process of parsing logs.

   Usage:
   - do changes
   - save file
   - reparse stats

   Tips:
   - if you don't understand what you do, make DB backup first =)
   - if you want use non latin (UTF-8) characters, open this file in
     UTF-8 editor (like windows notepad or http://www.unipad.org)
   - if you want use " in string do it with backslash - \"

   -!commentary --------------------------------------------------- */

/* - commentary ------------------------------------------------------
   Results of this players will by united. Format:
   $cfg_players = array(
      "SrcPlayerAccount"=>"DestPlayerAccount",
   );
   All results of player with account "SrcPlayerAccount" will
   be grabed by player with account "DestPlayerAccount". Player
   with account "SrcPlayerAccount" will be deleted from stats.
   You may view "account" in server's log-file.

   Example for /lan server:

   [2007/01/19 17:30:37] <time> [$000jago/213.85.135.45:2350 ($000Jago)] 1:18.47
   account - "$000jago"
   [2007/01/19 18:07:52] <time> [habicht/192.168.61.175:2350 (HabichT)] 1:29.61
   account - "habicht"

   $cfg_players = array(
      "$000jago"=>"habicht",
   );

   Example for /internet server:

   [2006/06/14 14:01:59] <time> [wjp84 ($i$f4fWJP)] 0:33.80
   account - "wjp84"
   [2006/06/14 14:02:07] <time> [saimi (zymiC)] 0:41.77
   account - "saimi"
   [2006/06/14 14:03:32] <time> [-a-p- (-A-P-)] 0:45.53
   account - "-a-p-"

   $cfg_players = array(
      "wjp84"=>"saimi",
      "-a-p-"=>"saimi",
   );
   -!commentary --------------------------------------------------- */

$cfg_players = array(
);

/* - commentary ------------------------------------------------------
   Results of this players will by deleted. Format:
   $cfg_players_ignorelist = array(
      "DeletePlayerAccount",
   );
   Player with account "DeletePlayerAccount" and all his results
   will by deleted from stats. You may view "account" in
   server's log-file.

   Example for /lan server:

   [2007/01/19 17:30:37] <time> [$000jago/213.85.135.45:2350 ($000Jago)] 1:18.47
   account - "$000jago"
   [2007/01/19 18:07:52] <time> [habicht/192.168.61.175:2350 (HabichT)] 1:29.61
   account - "habicht"

   $cfg_players_ignorelist = array(
      "$000jago",
      "habicht",
   );

   Example for /internet server:

   [2006/06/14 14:01:59] <time> [wjp84 ($i$f4fWJP)] 0:33.80
   account - "wjp84"
   [2006/06/14 14:02:07] <time> [saimi (zymiC)] 0:41.77
   account - "saimi"
   [2006/06/14 14:03:32] <time> [-a-p- (-A-P-)] 0:45.53
   account - "-a-p-"

   $cfg_players_ignorelist = array(
      "wjp84",
      "saimi",
      "-a-p-",
   );
   -!commentary --------------------------------------------------- */

$cfg_players_ignorelist = array(
);

/* - commentary ------------------------------------------------------
   Switch on/off autoparse team-tags. If false, will be used only
   $cfg_clans array.
   true - on
   false - off
   -!commentary --------------------------------------------------- */

$cfg_autofindclans = true;

/* - commentary ------------------------------------------------------
   With this array you can manual register teams. Format:
   $cfg_clans = array(
      "TeamTag"=>array("description"=>"Description: full name, site, mirc channel, e.t.c.",
                       "autofindmembers"=>true,
                       "members"=>"account_member_1;account_member_2;account_member_e_t_c"),
   );
   "TeamTag" is case-insensitive.

   Example:

   $cfg_clans = array(
      "BANANAS"=>array("description"=>" - BANANAS clan",
                       "autofindmembers"=>true),
       "UnItEd"=>array("description"=>" - Some players united to clan",
                       "autofindmembers"=>false,
                       "members"=>"crockett;fleckman;hsl;vasia."),
       "[TMos]"=>array("description"=>" - \"TM Offline Stats\" funs (http://tmos.pp.ru)",
                       "autofindmembers"=>true,
                       "members"=>"$000jago;habicht;rock"),
   );

   -!commentary --------------------------------------------------- */

$cfg_clans = array(

   // information from http://tm-ladder.com (few random teams)
   "{+}"=>array("description"=>" - <img src=\"./gfx/flags/fra.png\" class=\"f\">&nbsp;<a href=\"http://savoysrv.viallet.biz\">Team savoy</a>",
                 "autofindmembers"=>true),
   "2fast4u"=>array("description"=>" - <img src=\"./gfx/flags/fra.png\" class=\"f\">&nbsp;<a href=\"http://2fast4u.roxorgamers.com\">2fast4u</a>",
                 "autofindmembers"=>true),
   "[BBD]"=>array("description"=>" - <img src=\"./gfx/flags/fra.png\" class=\"f\">&nbsp;<a href=\"http://www.bbd.ze.cx\">Belgium Best Drivers</a>",
                 "autofindmembers"=>true),
   "[BLR]"=>array("description"=>" - <img src=\"./gfx/flags/rus.png\" class=\"f\">&nbsp;<a href=\"http://www.tm-belarus.com\">Belarus team</a>",
                 "autofindmembers"=>true),
   "~CAT>"=>array("description"=>" - <img src=\"./gfx/flags/fra.png\" class=\"f\">&nbsp;<a href=\"http://cat.tmu.free.fr\">Catl li</a>",
                 "autofindmembers"=>true),
   "[CDD]"=>array("description"=>" - <img src=\"./gfx/flags/pol.png\" class=\"f\"><img src=\"./gfx/flags/gbr.png\" class=\"f\">&nbsp;<a href=\"http://cddclan.republika.pl\">Crazy Demo Drivers</a>",
                 "autofindmembers"=>true),
   "[cHoe]"=>array("description"=>" - <img src=\"./gfx/flags/ger.png\" class=\"f\">&nbsp;<a href=\"http://www.chaos-hoernchen.de\">Choas-Hoernchen</a>",
                 "autofindmembers"=>true),
   "*CRT*"=>array("description"=>" - <img src=\"./gfx/flags/ger.png\" class=\"f\">&nbsp;<a href=\"http://www.cologne-racing-team.de\">Cologne Racing Team</a>",
                 "autofindmembers"=>true),
   "*CZ*"=>array("description"=>" - <img src=\"./gfx/flags/fra.png\" class=\"f\">&nbsp;<a href=\"http://www.sweb.cz/prizdisracz\">PrizdiSraCZ</a>",
                 "autofindmembers"=>true),
   "]DoW["=>array("description"=>" - <img src=\"./gfx/flags/ger.png\" class=\"f\">&nbsp;<a href=\"http://martin.tibit.de/andre\">DriveOrWalk Team</a>",
                 "autofindmembers"=>true),
   "-=E.T.M=-"=>array("description"=>" - <img src=\"./gfx/flags/fra.png\" class=\"f\">&nbsp;<a href=\"http://team.etm.free.fr\">Enter The Matrix</a>",
                 "autofindmembers"=>true),
   "(FG)"=>array("description"=>" - <img src=\"./gfx/flags/gbr.png\" class=\"f\">&nbsp;<a href=\"http://www.forsaken-gaming.com/home\">Forsaken Gaming</a>",
                 "autofindmembers"=>true),
   "Furia"=>array("description"=>" - <img src=\"./gfx/flags/fra.png\" class=\"f\">&nbsp;<a href=\"http://teamfuria.cmonfofo.com\">teamfuria</a>",
                 "autofindmembers"=>true),
   "|GT|"=>array("description"=>" - <img src=\"./gfx/flags/pol.png\" class=\"f\">&nbsp;<a href=\"http://www.gtteam.ovh.org\">Gothic Trackers</a>",
                 "autofindmembers"=>true),
   "JBRT"=>array("description"=>" - <img src=\"./gfx/flags/fra.png\" class=\"f\">&nbsp;<a href=\"http://www.jbrteam.info\">Joe Bar Racing Team</a>",
                 "autofindmembers"=>true),
   "KK`"=>array("description"=>" - <img src=\"./gfx/flags/esp.png\" class=\"f\">&nbsp;<a href=\"http://www.kkteam.es.kz\">KK team</a>",
                 "autofindmembers"=>true),
   "NWT"=>array("description"=>" - <img src=\"./gfx/flags/por.png\" class=\"f\">&nbsp;<a href=\"http://nwt.up.md/modules/news\">North Wind Traders</a>",
                 "autofindmembers"=>true),
   "OLD/"=>array("description"=>" - <img src=\"./gfx/flags/nor.png\" class=\"f\">&nbsp;<a href=\"http://teamold.activebb.net\">Overaged Lucky Drivers</a>",
                 "autofindmembers"=>true),
   "plan-B"=>array("description"=>" - <img src=\"./gfx/flags/aut.png\" class=\"f\">&nbsp;<a href=\"http://www.plan-b.at\">plan-B Team</a>",
                 "autofindmembers"=>true),
   "USSR"=>array("description"=>" - <img src=\"./gfx/flags/rus.png\" class=\"f\">&nbsp;<a href=\"http://www.ussr-team.com\">USSR Team.tmn</a>",
                 "autofindmembers"=>true),
   "BRW@TMN"=>array("description"=>" - <img src=\"./gfx/flags/ger.png\" class=\"f\">&nbsp;<a href=\"http://www.brwclan.redio.de\">Team Brauweiler</a>",
                 "autofindmembers"=>true),
   "[SP]"=>array("description"=>" - <img src=\"./gfx/flags/ger.png\" class=\"f\">&nbsp;<a href=\"http://www.spieleplanet.eu\">SpielePlanet</a>",
                 "autofindmembers"=>true),

);

/* - commentary ------------------------------------------------------
   With this array you can delete "bad" team-tags, that will not show
   in statistics. Format:
   $cfg_clans_ignorelist = array(
      "TeamTag 1",
      "TeamTag 2",
      "TeamTag e.t.c",
   );
   "TeamTag" is case-insensitive.
   -!commentary --------------------------------------------------- */

$cfg_clans_ignorelist = array(

"a.", "b.", "c.", "d.", "e.", "f.", "g.", "h.", "i.", "j.", "k.", "l.", "m.",
"n.", "o.", "p.", "q.", "r.", "s.", "t.", "u.", "v.", "w.", "x.", "y.", "z.",
".a", ".b", ".c", ".d", ".e", ".f", ".g", ".h", ".i", ".j", ".k", ".l", ".m",
".n", ".o", ".p", ".q", ".r", ".s", ".t", ".u", ".v", ".w", ".x", ".y", ".z",
".a.", ".b.", ".c.", ".d.", ".e.", ".f.", ".g.", ".h.", ".i.", ".j.", ".k.",
".l.", ".m.", ".n.", ".o.", ".p.", ".q.", ".r.", ".s.", ".t.", ".u.", ".v.",
".w.", ".x.", ".y.", ".z.",
"-a", "-b", "-c", "-d", "-e", "-f", "-g", "-h", "-i", "-j", "-k", "-l", "-m",
"-n", "-o", "-p", "-q", "-r", "-s", "-t", "-u", "-v", "-w", "-x", "-y", "-z",
"a-", "b-", "c-", "d-", "e-", "f-", "g-", "h-", "i-", "j-", "k-", "l-", "m-",
"n-", "o-", "p-", "q-", "r-", "s-", "t-", "u-", "v-", "w-", "x-", "y-", "z-",
"-a-", "-b-", "-c-", "-d-", "-e-", "-f-", "-g-", "-h-", "-i-", "-j-", "-k-",
"-l-", "-m-", "-n-", "-o-", "-p-", "-q-", "-r-", "-s-", "-t-", "-u-", "-v-",
"-w-", "-x-", "-y-", "-z-",
"_a", "_b", "_c", "_d", "_e", "_f", "_g", "_h", "_i", "_j", "_k", "_l", "_m",
"_n", "_o", "_p", "_q", "_r", "_s", "_t", "_u", "_v", "_w", "_x", "_y", "_z",
"a_", "b_", "c_", "d_", "e_", "f_", "g_", "h_", "i_", "j_", "k_", "l_", "m_",
"n_", "o_", "p_", "q_", "r_", "s_", "t_", "u_", "v_", "w_", "x_", "y_", "z_",
"_a_", "_b_", "_c_", "_d_", "_e_", "_f_", "_g_", "_h_", "_i_", "_j_", "_k_",
"_l_", "_m_", "_n_", "_o_", "_p_", "_q_", "_r_", "_s_", "_t_", "_u_", "_v_",
"_w_", "_x_", "_y_", "_z_", 
"a@", "b@", "c@", "d@", "e@", "f@", "g@", "h@", "i@", "j@", "k@", "l@", "m@",
"n@", "o@", "p@", "q@", "r@", "s@", "t@", "u@", "v@", "w@", "x@", "y@", "z@",
"@a", "@b", "@c", "@d", "@e", "@f", "@g", "@h", "@i", "@j", "@k", "@l", "@m",
"@n", "@o", "@p", "@q", "@r", "@s", "@t", "@u", "@v", "@w", "@x", "@y", "@z",
"a!", "b!", "c!", "d!", "e!", "f!", "g!", "h!", "i!", "j!", "k!", "l!", "m!",
"n!", "o!", "p!", "q!", "r!", "s!", "t!", "u!", "v!", "w!", "x!", "y!", "z!",
"!a", "!b", "!c", "!d", "!e", "!f", "!g", "!h", "!i", "!j", "!k", "!l", "!m",
"!n", "!o", "!p", "!q", "!r", "!s", "!t", "!u", "!v", "!w", "!x", "!y", "!z",

"_007", "_666", "_006", "_777", "_111", "__93", "_001",
"_00", "_01", "_02", "_03", "_04", "_05", "_06",  "_07", "_08", "_09",
"_0", "_1", "_2", "_3", "_4", "_5", "_6", "_7", "_8", "_9", "_10", 
"_11", "_12", "_13", "_14", "_15", "_16", "_17", "_18", "_19", "_20",
"_21", "_22", "_23", "_24", "_25", "_26", "_27", "_28", "_29", "_30",
"_31", "_32", "_33", "_34", "_35", "_36", "_37", "_38", "_39", "_40",
"_41", "_42", "_43", "_44", "_45", "_46", "_47", "_48", "_49", "_50",
"_51", "_52", "_53", "_54", "_55", "_56", "_57", "_58", "_59", "_60",
"_61", "_62", "_63", "_64", "_65", "_66", "_67", "_68", "_69", "_70",
"_71", "_72", "_73", "_74", "_75", "_76", "_77", "_78", "_79", "_80",
"_81", "_82", "_83", "_84", "_85", "_86", "_87", "_88", "_89", "_90",
"_91", "_92", "_93", "_94", "_95", "_96", "_97", "_98", "_99", "_100",

"-007", "-666", ":666",
"-00", "-01", "-02", "-03", "-04", "-05", "-06", "-07", "-08", "-09",
"-0", "-1", "-2", "-3", "-4", "-5", "-6", "-7", "-8", "-9", "-10", 
"-11", "-12", "-13", "-14", "-15", "-16", "-17", "-18", "-19", "-20",
"-21", "-22", "-23", "-24", "-25", "-26", "-27", "-28", "-29", "-30",
"-31", "-32", "-33", "-34", "-35", "-36", "-37", "-38", "-39", "-40",
"-41", "-42", "-43", "-44", "-45", "-46", "-47", "-48", "-49", "-50",
"-51", "-52", "-53", "-54", "-55", "-56", "-57", "-58", "-59", "-60",
"-61", "-62", "-63", "-64", "-65", "-66", "-67", "-68", "-69", "-70",
"-71", "-72", "-73", "-74", "-75", "-76", "-77", "-78", "-79", "-80",
"-81", "-82", "-83", "-84", "-85", "-86", "-87", "-88", "-89", "-90",
"-91", "-92", "-93", "-94", "-95", "-96", "-97", "-98", "-99", "-100",

".0", ".1", ".2", ".3", ".2006", "!1", "_1_", "1_", "_tr", "_rc", "_zi",
"_pl", "he-", "@blo", "kr@", "@ke", "@ga", "pl@", "@rd", "cr@", "fr@",
"@in", "@ne", "_nl", "w*", "_da", "-da", "da-", "da_", "!ke", "|n", "cpt.",
".bln", "!ng", "f(", "_pt", "css_", "je_", "/7", "es_", "#1", "#2",
"__", "___", "____", "_guest_", "|||", "_S.", "mk-", "mk_", "_mk", "-mk",
"ir_", "-moll", "oo-", "-oo", "!el", "!nk", "_abc", "!ger", "!ck", "_f1",
"my-", "-tj", "_hh", "_cr", "_bo", "ph_", "_er", "hg-", "_gt", "!ght",
"la_", "\$h", "_gr", "lp_", "\$e", ".on", "tr_", "zz-", "ale$", "-f1",
":D", "=)", ":)", ";)", "xx_", "_xx", "_me", "jb_", "evo_", "_by", "_te",
"mi_", "@rco", "@rk", "@ddy", "do_", "ex-", "bl@", "!0n", "@cK", "!ls",
"bl!", "@ce", "_5000", "_xd", "by_", "_ksk", "e*", "-xx", "xx-", "_bu",
"_i", "_ii", "_iii", "_2007", "_2008", "_2009", "_2010", "_2011", "_it",
"ch_", "-fox", "_fox", "_1991", "_1992", "_1993", "_1994", "_1995", "7.",
"_1996", "_1997", "_1998", "_1999", "_2000", "_2001", "_2001", "_2002",
"_2003", "_2004", "_2005", "2006", "_gll", "__13", '$o-', "__94", "_f.",
"0_", ".94", "im_", "_cc", "_c.", "__p", "_fr", "_1990", ".001", "_87_",
"_sp", '$o[', "_m.", "__d", "___d", ".4", ".5", ".6", ".7", ".8", ".9",
"no-", "bg_", "m__", "bj_", "_m5", "1.", ".06", "_el_", "_303", "_et",
"un_", "ze_", "_l__", "_jr.", "-1994", "le__", "_xxl", "_1905", "_1976",
"www.", "ww.", ".com", "robase.", ".ru", ".de", ".net", ".org", ".fr",
"ttp://", "_fin_", "fin_", "_fin", ".cz", "_svk", "_cz", "[fin]", "___2",
"[rus]", "(fin)", "_ukraine", ".ua", "_ua", "_ua_", ".ua_", "__ua_",
"_ger", "ukr_", "[ger]", "http://", ".exe", ".ger", ".be", "-dj", "__n",
"the_", "le_", "the-", "le-", "'s", "_an", "'n", "der_", "der-", "_sk",
"el-", "el.", "el_", "_jr", "viva_", "viva-", "de_", "de-", "de.", "l'",
"ger_", "_ger", "_pol_", "das_", "das-", "-jan", "_jan", "_usa", "_rus",
"_ch", "_mm", "st.", "st_", "st._", "_mr_", "mr.", "mr_", "mr._", "kl_",
"dr.", "dr_", "dr._", "sir_", "sir-", "sir._", "mister_", "mister-",
"mister._", "mrs.", "dj_", "dj.", "dj-", "mc.", "mc_", "mc-", "_mc",
"-mc", "sos_", "sos-", "sos.", "sen_", "sen-", "ing.", "al-", "-en",
"dc_", "ser_", "kz_", "dj__", "_ru", "is_", "_xxx_", "(rus)", "(cz)",
"_oh", "_rs", "the~", "miss_", "jazz-", "-rus", "_kz_", "di_", ".ch",
"mr-", "_lt", "ru__", "my_", ".rus", "-xxx",  "xxx-",  "-fr", ".pt",
"_zh", ".am", "_ck", "_cz_", "_rus_", "_it", "rus-", "ond_", "il_", ".pl",
"__3", "oOo_", "_123", "-dk", "_ok", ".nl", "-nl", "~b", "_d.", "@ss",
"@rma", "_br", "@sh", "'z", "_oe", "_lp", "ufo_", ";d", "_ger_", "-ger",
"aj-", "ss_", "_122", "ey_", "_st", "o'", "d'", "ka_", "9_", "_r.",
"-2008", "-2009", "-2010", "tha_", "the__", ".74", "_chicken", "cpt._",
"el__", "ja_", "__m_", "uk-", "lt.", "_br", "__ger_",

"lord_", "lord-", "-lord", "_lord", "_lord_", "general_", "general-",
"_boss", "-boss", "master_", "master-","-master", "_master", "capt_",
"capt-", "captain_", "captain-", "captain.", "_king_", "king_",
"king-", "-king", "_king",  "agent_", "agent-", "don_", "don.", "don-",
"_knight", "-knight", "knight-", "knight_", "ondra_", "mini-", "fast_",
"_man", "-man", ".man", "_mann", "-men", "_men", "_wolf", "-wolf",
"big_", "big-", "big.", "_duda", "_best", "-best", "best_", "best-",
"crazy_", "crazy-", "crazy.", "_boy", "-boy", "-green", "_green", "cry_",
"pro.", "pro-", "pro_", "short_", "_fury", "evil_", "evil-", "evil.",
".evil", "-evil", "death_", "death-", "death.", "_cool", "-cool",
"-power", "_power",  "black_", "_black", "silent_", "silent-", "_frag",
"_steel", "-steel", "-racer", "_racer", ".racer", "racer_", "racer-",
"racer.", "team.", "ninja_", "ninja-", "_ninja", "-ninja", "coca_",
"_fish", "-fish", "-monkey", "_monkey", "_girl", "-girl", "-unit", "hot_",
"silver_", "silver-", "shadow_", "shadow-", "_shadow", "-shadow", "_fast",
"dark_", "dark-", "best_", "best-", "flying-", "flying_", "next_",
"next-", "_speed", "-speed", "ice-", "ice_", "_back", "-back", "_cat",
"dutch_", "turkey_", "_mdk", "ui_", "_nos", "ksk", "one_", "one-",
"one.", "-one", ".one", "_one", "-0ne", "_viper", "dragon-", "_russian",
"blood_", "blood-", "-ghost", "_ghost", "ghost_", "ghost-", "_russia",
"]tiger", "-virus", "-star", ".star", "hell_", "hell-", "_gott", "yo_",
"_sniper", "lucky-", "lucky_", "die_", "die-", "ded_", "ded-", "sna_",
"aero-", "_driver", "-driver", "just_", "just-", "_shark", "-shark",
"dein_", "titan.", "anti-", "anti_", "racing_", "racing-", "-racing",
"_racing", "mad_", "mad-", "little_", "little-", "_ass", "-ass", "_punk",
"_killer", "-killer", "_rider", "-rider", "_weed", "andi-", "_blue",
"-blue", "red_", "red-", "free_", "free-", "-sky", "]shorty", "bad_",
"bad-", "deaf_", "deaf-", "_sonic", "super_", "super-", "-style", "sonic_",
"space-", "_pat", "mini_", "-force", "_devil", "_fan", "race_", "_kid",
"father_", "anty_", "_killa", "light_", "great_", "_chilla", "body_",
"_dragon", ".long", "can_", "]dragon", "]toxic", "monkey_", "prinz_",
".pink", ".freak", "solid_", "papa-", "war-", "kool_", "elite_", "_tank",
"_song", "wolf_", "black-", "_eve", "ferrari-", "_junior", "dirty_",
".angry", "_123", "_strike", "-strike", "_pro", "-pro", "herr_", "_no1",
"_root",  "_lo", "trackmania_", "_race", "-oh", "killer_", "killer-",
"nero_", "__gamer", "_gamer", "-gamer", "_rocks", "_tm", "_night", "_ice",
"gray_", "gray-", "_37reg", "_yeah", "fresh_", "fresh-", "seb-", "_action",
"god_", "god-", "sly_", "german_", "_san", "taxi_", "ska_", "_ver",
"_warrior", "_hell", "terminator_", "_pilot", "rock_", "real_", "_meh",
"speed_", "_nah", "hitman_", "_killer_", "_chaos", "nfs-", "demon_",
"ti-", "_sex", "alpha_", "papa_", "psy.", "speedy_", "qwe.", "-raser",
"_death", "-black", "green_", "chill_", "les_", "-zero", "_team", "_xxx",
"_noob", "hardcore_", "_kiz_", "-eye", "__ter", "_pro_", "_angel", "_aki",
"_you", "-flip", "wow_", "_dark", "cyber-", "prapor_", "_dog", "devil_",
"_style", "_fun", "russia_", "_masta", "air_", "flash_", "_kot", "_demon",
"sha_", "wolf_", "_electro", "bam_", "-kun", "lancer_", "_tueurs",
"omg_", "_player", "law_", "no_", "xxx_", "turbo_", "new_", "spirit_",
"driver_", "_on", "xtreme_", "_gll", "fcn_", "_off", "tm_", "_car",
"lady_", "commander_", "_rostov", "_rock", "bog-", "sunny_", "_mania",
"_user", "cooler_", "_prisoner", "_snake", "madzia_", "los_", "_road",
"_love", "san-", "nick-", "_star", "_loco", "_kok", "_babylon", "magic_",
"dead-", "fast-", "_frog", "road_", "-lol", "_dok", "_bastard", "_dk",
"young_", "latvia-", "-gll", ".gll", "_life", "fire-", "-freak", "_deluxe",
"nitro_", "_gll", "@gll", "_maniac", "_army", "-reaper", "bloody_",
"major_", "_x3", "metal_", "_guest_,", "hik-", "white_", "_rage", "alfa_",
"-maker", "gll-", "_winner", "omaha-", "lu-", "_lux", "_lan", "_moon",
"_fire", "_duck", "_noir", "_speedracer", "gold_", "disco_", "fuck_",
"_potato", "who_", "lost-", "_dong", "_bong", "amit_", "_kong", "-doom",
"punisher_", "_runner", "_doc", "_link", "_fix", "turtle_", "_freak",
"-sensei", "_yeti", "maj.", "_crazy", "_yu", "_zero", "gamer_", "kill_",
"unlimited-", "_diablo", "_turbo", "cat_", "_mother", "stone_", "snow_",

"alex_", "_johnson", "]max", "michael_", "-lapin", "ole_", "lil_",
"danny_", "_hitler", "jack_", "jack-", "ben-", "john_", "john-", "vlad_",
"tommy_", "lazy_", "den_",  "aris-", "bob_", "-dan", "rato_", "junior_",
"leo_", "_mickey", "_hatter", "sam_", "johnny_", "rafael_", "_rox",
"teh_", "andy.", "andy_", "-tom", "]terror", "jean-", "max_", "max-",
"_max", "-max", "_ann", "-willy", "_willy", "ray_", "ray-", "jojo_",
"-mac", ")chris", "chris_", ".max", "dominik_", "rookie_", "paul_",
"paul-", "jens_", "_al", "al.", "luke_", "luke-", "]benny", "_nielsen",
"_joe", "_rambo", "daniel_", "_maximus", "kenny_", "alex-", "_chris",
"-gandalf", "-bob", "hans_", "kimi_", "tuoppi_", "-kettu", "tim_",
"dimon_", "_galhao", "_deltaua", "yuriy_", "miha_", "d1mon_", "vocuk_",
"ben_", "jim_", "evo-", "_dave", "mac-", "-noy", "-san", "flo_", "karl_",
"]martin", "_lars", "_helmchen", "davidoff_", "ivan_", "oscar_", "jah_",
"_ole", "petit-", "roy_", "ali_", "dima_", "julien_", "anton_", "arno_",
"marc_", "denis_", "_leao", "patrick_", "miki_", "sam-", "remi_", "lukas.",
"sam_", "timbo_", "alan_", "vincent_", "-mike", "_mike", "felix_", "fred_",
"mark_", "roman_", "sergey_", "_nik", "nick_", "pascal_", "_bou", "mak_",
"raul_", "bruno_", "andrey_", "naruto_", "elvin_", "vince_", "-alex",
"razor_", "ilya_", "oleg_", "antoine_", "olivier.", "olivier_", "joey_",
"jo_", "_kevin", "kamil_", "harry_", "erik_", "igor_", "jos_", "julian_",
"stefan_", "clem-", "niko-", "david_", "_bill", "_sam", "enzo_", "kostya_",
"lukas_", "nik_", "andrew_", "pierre_", "tom-", "simon_", "homer_",
"thomas_", "fabio_", "rey-", "vitek_", "_rosso", "szymon_", "alexander_",
"ivan_", "dima_", "artem_", "vano_", "jeff_", "sanek_", "bobby_", "_hill",
"aleks.", "maitre_", "serega_", "marc_", "romain_", "martin_", "mago_",
"maxim_", "nico_", "jan-", "kaeptn_", "hugo_", "josh_", ".ronaldo",
"roma_", "nathan_", "emil_", "jonny_", "steven_", "juju_", "steve_",
"honza.", "_martin", "paulo_", "klaus_", "gerry_", "pedro_", "neo_",
"_daniel", "mehmet_", "jojo-", "mike_", "joe_", "florian.", "lucas_",
"sven_", "moritz_", "beqa.", "_alex", "joao_", "-leo", "leon_", "dima-",
"johannes_", "_tyler", "fernando_", "petit-", "david-", "fam.", "julius_",
"jonas_", "ricardo_", "chuck-", "_alexander", "patrick_", "ptit_", "_todd",
"atze_", "andre_", "andi_", "aleksey_", "tiago_", "vincent_", "myxa_",
"_andre", "diogo_", "marek_", "jan_", "luis_", "rui_", "quentin_", "tobi_",
"_mendes", "lolo_", "faust_", "_alonso", "marco_", "rayane_", "franck_",
"yannik_", "charles_", "_lexa", "_jack", "_ben", "]tom", "-kay", "zen-",
"george_", "onkel_", "will.", "_dachs", "_brot", "meister_", "-ben",
"rodrigo_", "cem_", "fabi_", "mert-", "chris-", "dennis_", "_kev", "_tom",
"robin_", "maria_", "marcel_", "linus_", "_lee", "maximilian_", "james_",
"-ray", "peter_", "victor_", "kevin_", "maxime_", "petit_", "tom_", "flo-",
"alex.", "tim-", "filou_", "dan_", "tony_", "philipp_", "jean_", "kalle_",
"cupa_", "mathieu.", "christian_", "darth_", ".dan", "_charles", "mario_",
"hugo.", "_schlumpf", "vadim_", "johny_", "fabian_", "michael-", "eric.",
"fluffy_", "magnus_", "phil_", "richard_", "mac_", "_hannover", "ronaldo_",
"_razzo", "mads_", "deine_", "django_", "frank_", "jet_",

);



/* - commentary ------------------------------------------------------
   All results of all players on this tracks will be deleted. Format:
   $cfg_tracks_ignorelist = array(
      "track_uid",
   );

   You may view "track_uid" in matchsettings file or in server's log-file.

   Example:

   [2006/06/14 14:00:41] Loading challenge E-3.Challenge.Gbx (yxUTF2YQd351q4iWVtrrqYV59tk)...
   track_uid - "yxUTF2YQd351q4iWVtrrqYV59tk"

   $cfg_tracks_ignorelist = array(
      "yxUTF2YQd351q4iWVtrrqYV59tk",
   );
   -!commentary --------------------------------------------------- */

$cfg_tracks_ignorelist = array(
);

?>