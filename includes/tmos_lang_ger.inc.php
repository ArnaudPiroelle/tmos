<?php
/*
   <dscr>GER (Fleckman)</dscr>
   Translated by Fleckman
*/

$tmos_admin_it = array(

// MENU
"mnu_header"=>"TM Offline Stats",
"mnu_gs"=>"Allgemeine Einstellungen",
"mnu_db"=>"Datenbank",
"mnu_dbupd"=>"Update der Struktur",
"mnu_sl"=>"Server Registrierung",
"mnu_sladd"=>"Neuen Server hinzufügen",
"mnu_slmod"=>"Server Informationen bearbeiten",
"mnu_ubl"=>"Userbars",
"mnu_ubladd"=>"Neue Userbar hinzufügen",
"mnu_ublmod"=>"Userbar-Eigenschaften bearbeiten",
"mnu_msf"=>"Matchsettings-Datei",
"mnu_ts"=>"Streckenauswahl",
"mnu_chk"=>"Überprüfung der Konfiguration",
"mnu_cs"=>"Server",
"mnu_csnull"=>"(nicht registriert)",

// COMMON
"com_errorprefix"=>"Fehler: ",
"com_messageprefix"=>"> ",

// AUTORIZE
"az_authorize_header"=>"Autorisation",
"az_login_btn"=>"LOGIN",
"az_status_1"=>"Falsches Passwort!",

// GENERAL SETTINGS
// - Headers
"gs_db_header"=>"Datenbank",
"gs_interface_header"=>"Interface",
"gs_parsing_header"=>"Statistiken errechnen",
"gs_admin_header"=>"Administration",
"gs_action_header"=>"Aktionen",
// - DB
"gs_dbhost"=>"Datenbankhost",
"gs_dbtype"=>"Datenbanktyp",
"gs_dblogin"=>"Datenbanklogin",
"gs_dbpassword"=>"Datenbankpasswort",
"gs_dbname"=>"Datenbankname",
"gs_dbhost_desc"=>"IP-Adresse des Servers mit der Datenbank. Beispiele:<br>* 192.168.40.111:1433<br>* localhost",
"gs_dbtype_desc"=>"Art der Datenbank in der die Statistiken gespeichert werden",
"gs_dblogin_desc"=>"Der Datenbanknutzer muss über ausreichende Rechte verfügen, um Tabellen anzulegen und zu editieren",
"gs_dbpassword_desc"=>"Passwort des Datenbanknutzers",
"gs_dbname_desc"=>"Datenbank muss vorher angelegt werden",
// - Interface
"gs_defaultlanguage"=>"Standard Interfacesprache",
"gs_defaultcolorscheme"=>"Standard Farbschema",
"gs_defaultrecperpage"=>"Standard Rekordanzahl pro Seite",
"gs_javascript"=>"JavaScript",
"gs_servertimeout"=>"Server timeout",
"gs_showsingleserver"=>"Einzelserver",
"gs_showmonitoring"=>"Übersichts-Tab",
"gs_showclans"=>"Team-Option",
"gs_showuserbars"=>"Userbars",
"gs_showpreferences"=>"Einstellungen",
"gs_showlinks"=>"Links",
"gs_showdownloads"=>"Downloads",
"gs_htmlcache"=>"Cache HTML",
"gs_htmlcache_choice_1"=>"Hauptseiten",
"gs_htmlcache_choice_2"=>"Alle Seiten",
"gs_htmlcache_choice_3"=>"Verboten",
"gs_gzipcompression"=>"gZIP Kompression",
"gs_defaultlanguage_desc"=>"Sprachauswahl für die Statistikseiten, das Administratormenü und die 'userbars'",
"gs_defaultcolorscheme_desc"=>"Stylesheets für die Statistikseiten",
"gs_defaultrecperpage_desc"=>"Maximalanzahl der pro Seite anzuzeigenden Rekorde. Restliche Rekorde werden auf den folgenden Seiten ausgegeben",
"gs_javascript_desc"=>"JavaScript wird benutzt, um Tabellenzeilen mit dem Cursor farbig zu markieren und so bequemes Browsen zu ermöglichen",
"gs_servertimeout_desc"=>"Falls in diesem Zeitraum (in Sek.) keine Antwort vom Server eingeht, wird er als 'offline' interpretiert",
"gs_showsingleserver_desc"=>"'Server' Option (nicht) anzeigen ( z.B. falls es nur einen registrierten Server gibt)",
"gs_showmonitoring_desc"=>"'Übersicht' Option (nicht) anzeigen",
"gs_showclans_desc"=>"'Teams' Option (nicht) anzeigen",
"gs_showuserbars_desc"=>"'Userbar'-Knopf in den persönlichen Spieler Statistiken (nicht) anzeigen",
"gs_showpreferences_desc"=>"'Einstellungen'-Knopf (nicht) anzeigen",
"gs_showlinks_desc"=>"Links in Spielernamen (nicht) anzeigen",
"gs_showdownloads_desc"=>"'Downloads'-Knopf (nicht) anzeigen",
"gs_htmlcache_desc"=>"HTML-Seiten durch das Cachen der 'PHP scripts' beschleunigen",
"gs_gzipcompression_desc"=>"HTML-Seiten vor dem Versenden zum Nutzer komprimieren (nützlich um den 'Traffic' zu reduzieren)",
// - Parsing
"gs_minclansize"=>"Teamgröße",
"gs_minclansize_desc"=>"Mindestspieleranzahl in einem Team",
"gs_medalsscore"=>"Medaillenpunkte",
"gs_medalsscore_desc"=>"Punkte die verliehen werden für das Erreichen der Autoren-/Gold-/Silber-/Bronzemedaille und für das Erreichen des Ziels",
// - Admin
"gs_adminpassword"=>"Administratorpasswort",
"gs_adminpassword_desc"=>"TMOS Administratorpasswort",
// - Action
"gs_savecfg_btn"=>"SPEICHERN",
"gs_savecfg_desc"=>"Einstellungsänderungen auf dieser Seite speichern",
// - Errors
"gs_doublequotes_err"=>"Keine doppelten Anführungszeichen benutzen",
"gs_defaultrecperpage_err"=>"Der Parameter 'Rekorde pro Seite' muss ein ganze Zahl >= 10 sein",
"gs_servertimeout_err"=>"Der Parameter 'Server timeout' muss eine ganze Zahl > 0 sein",
"gs_minclansize_err"=>"Der Parameter 'Teamgröße' muss eine ganze Zahl >= 2 sein",
"gs_medalsscore_err"=>"Die Parameter der 'Medaillenpunkte' muss alle ganze Zahlen >= 0 sein",
// - Operation results
"gs_status_1"=>"Einstellungen gespeichert",
"gs_status_2"=>"Einstellungen konnten nicht gespeichert werden. Überprüfen Sie, dass die Datei'tmos_options.php' Schreibberechtigung hat",

// DATABASE
// - Headers
"db_status_header"=>"Datenbank Status",
"db_table_header"=>"Tabelle",
"db_tablestate_header"=>"Status",
"db_tablerecords_header"=>"Rekorde",
"db_action_header"=>"Aktionen",
"db_updinfo_header"=>"Informationen",
// - DB
"db_dbstatus_1"=>"Ok",
"db_dbstatus_2"=>"Datenbank wird nicht von PHP unterstützt",
// - Tables
"db_tablestatus_1"=>"Ok",
"db_tablestatus_2"=>"Falsches Format",
"db_tablestatus_3"=>"Nicht gefunden",
// - Update
"db_updinfo_text"=>"Databankstruktur wird aktualisiert <b>{0} => {1}</b>. Die Reihenfolge der Aktionen:<br>* Alte Tabellen tmos_xxx umbennant zu to bk_tmos_xxx<br>* ANlegen neuer Tabellen tmos_xxx in format {1}<br>* Übertragen der Daten von Tabellen bk_tmos_xxx => tmos_xxx<br>*VErarbeitet die Log-Dateien aller Server",
"db_support_err"=>"Ein Update von Version {0} wird nicht unterstützt",
// - Action
"db_updatedb_btn"=>"UPDATE",
"db_createtables_btn"=>"ERZEUGEN",
"db_droptables_btn"=>"LÖSCHEN",
"db_resetdata_btn"=>"ZURÜCKSETZEN",
"db_cleardata_btn"=>"LEEREN",
"db_cancel_btn"=>"ABBRUCH",
"db_updatedb_desc"=>"Update der TMOS Databanktabellen von früheren Versionen von TMOS (alle Daten bleiben erhalten)",
"db_createtables_desc"=>"TMOS Tabellen in der Datenbank erzeugen",
"db_droptables_desc"=>"TMOS Tabellen aus der Datenbank löschen",
"db_resetdata_desc"=>"Entfernung aller Eintragungen ausser der aktiven Server",
"db_cleardata_desc"=>"Entfernung aller Eintragungen",
"db_cancel_desc"=>"Update nicht Durchführen",
// - Operation results
"db_status_1"=>"Änderungen der Datenbank erfolgreich durchgeführt",
"db_status_2"=>"Operation abgebrochen",

// SERVERS
// - Headers
"sl_status_header"=>"Datenbank Status",
"sl_servers_header"=>"Server",
"sl_action_header"=>"Aktionen",
"sl_add_header"=>"Neuen Server einrichten",
"sl_mod_header"=>"Server ID:",
// - Servers
"sl_ip"=>"IP-Adresse",
"sl_server"=>"Servername",
"sl_id"=>"Server ID",
"sl_game"=>"Spiel",
"sl_login"=>"Server Admin-Login",
"sl_password"=>"Server Admin-Passwort",
"sl_logfiles"=>"Log-Dateien",
"sl_trackdirs"=>"Streckenverzeichnisse",
"sl_ip_desc"=>"Server Fernsteuerungs Port Einstellungen 'ip:xmlrpcport'. Beispiele:<br>* 192.168.40.111:5000<br>* localhost:5001",
"sl_server_desc"=>"Wird in den Tabellenüberschriften und 'userbars' angezeigt",
"sl_game_desc"=>"Bilder der 'userbars' werden gemäß dieser Eistellung angezeigt",
"sl_login_desc"=>"Muss mit dem Passwort für den 'SuperAdmin' in der 'dedicated.cfg' Datei übereinstimmen",
"sl_password_desc"=>"",
"sl_logfiles_desc"=>"Trackmania server Log-Dateien ('./Logs' Ordner des Servers). Mehrere Logs können durch Verwendung von ';' voneinanrder abgetrennt werden. Beispiele:<br>* c:\\tmn\Logs\GameLog..txt<br>* /usr/home/myaccount/tmn/Logs/GameLog..txt<br>* &lt;dir&gt;\GameLog.1.txt;&lt;dir&gt;\GameLog.2.txt;&lt;dir&gt;\GameLog.3.txt",
"sl_trackdirs_desc"=>"Ordner mit '.gbx' Streckendateien. Mehrere Ordner können durch Verwendung von ';' voneinander getrennt werden. Beispiele:<br>* c:\\tmn\GameData\Tracks<br>* /usr/home/meinaccount/tmn/GameData/Tracks<br>* &lt;dir1&gt;/Tracks;&lt;dir2&gt;/Tracks;&lt;dir3&gt;/Tracks",
// - Action
"sl_addserver_btn"=>"HINZUFÜGEN",
"sl_deleteservers_btn"=>"ENTFERNEN",
"sl_modifyservers_btn"=>"ÄNDERN",
"sl_cancel_btn"=>"ABBRUCH",
"sl_addserver_desc"=>"Neuen Server registrieren",
"sl_deleteservers_desc"=>"Ausgewählte Server entfernen",
"sl_modifyservers_desc"=>"Einstellungen der gewählten Server ändern",
"sl_cancel_desc"=>"Änderungen verwerfen",
// - Errors
"sl_doublequotes_err"=>"Keine doppelten Anführungszeichen verwenden",
// - Operation results
"sl_status_1"=>"Operation abgebrochen",
"sl_status_2"=>"Operation erfolgreich durchgeführt",
"sl_status_3"=>"Keine Server gewählt",

// USERBARS             /////////////// new !!!!!!!!!!!!!!!!!!!!!
// - Headers
"ub_status_header"=>"GS Status",
"ub_userbars_header"=>"Userbars",
"ub_action_header"=>"Aktionen",
"ub_add_header"=>"Neuen Userbar einrichten",
"ub_mod_header"=>"Userbar ID:",
// - Data
"ub_gdstatus_1"=>"Ok",
"ub_gdstatus_2"=>"GD-Bibliothek nicht unterstützt",
"ub_gdstatus_3"=>"FreeType-Bibliothek nicht unterstützt",
"ub_id"=>"Userbar ID",
"ub_game"=>"Spiel",
"ub_font1"=>"Zeichensatz 1 / Farbe / Größe",
"ub_font2"=>"Zeichensatz 2 / Farbe / Größe",
"ub_imgfile"=>"Bilddatei (.png)",
"ub_type"=>"Typ",
// - Action
"ub_adduserbar_btn"=>"HINZUFÜGEN",
"ub_adduserbar_desc"=>"Neuer 'Userbar' hinzufügen",
"ub_deleteuserbars_btn"=>"ENTFERNEN",
"ub_deleteuserbars_desc"=>"Ausgewählte 'Userbars' entfernen",
"ub_modifyuserbars_btn"=>"ÄNDERN",
"ub_modifyuserbars_desc"=>"Eogenschaften der ausgewählten 'Userbars' ändern",
"ub_cancel_btn"=>"ABBRUCH",
"ub_cancel_desc"=>"Änderungen verwerfen",
// - Errors
"ub_imgfile_err"=>"Bilddatei mussim +png-Format sein, Breite <=600, Höhe <= 100, Größe <= 100Kb",
"ub_font1_err"=>"Zeichensatz 1 nicht gefunden",
"ub_size1_err"=>"Größe des Zeichensatzes 1 muss eine ganze Zahl >= 1 sein",
"ub_color1_err"=>"Farbe des Zeichensatzes 1 muss im Format XXXXX angegeben werden, wobei X eine Hexadezimalzahl (0-9,a-f) ist",
"ub_font2_err"=>"Zeichensatz 2 nicht gefunden",
"ub_size2_err"=>"Größe des Zeichensatzes 2 muss eine ganze Zahl >= 1 sein",
"ub_color2_err"=>"Farbe des Zeichensatzes 2 muss im Format XXXXX angegeben werden, wobei X eine Hexadezimalzahl (0-9,a-f) ist",
// - Operation results
"ub_status_1"=>"Operation abgebrochen",
"ub_status_2"=>"Ok",
"ub_status_3"=>"Unbekannter Fehler",
"ub_status_4"=>"Keine 'Userbars' gewählt",

// CHECK
// - Headers
"chk_php_header"=>"PHP",
"chk_db_header"=>"Datenbank",
"chk_tables_header"=>"Tabellen",
"chk_servers_header"=>"Server",
// - Inf
"chk_phpver"=>"Version",
"chk_phpxml"=>"XML",
"chk_phpgd"=>"GD",
"chk_phpft"=>"FreeType",
"chk_phpcache"=>"Cache",
"chk_phpzlib"=>"ZLib",
"chk_phpmetime"=>"max_execution_time",
"chk_phpallowurl"=>"allow_url_fopen",
"chk_phpmemlimit"=>"memory_limit",
"chk_phpver_desc"=>"PHP Version muss mindestens 4.4.0 sein",
"chk_phpxml_desc"=>"XML Unterstützung",
"chk_phpgd_desc"=>"GD Bibliotheken müssen installiert sein um 'Userbars' zu nutzen",
"chk_phpft_desc"=>"Freetype Bibliotheken müssen installiert sein um 'Truetype' Zeichensätze in 'Userbars' zu nutzen",
"chk_phpcache_desc"=>"Testschreibvorgang zum Cachen von Dateien",
"chk_phpzlib_desc"=>"ZLib Bibliotheken müssen installiert sein um Webseitenkompression zu ermöglichen",
"chk_phpmetime_desc"=>"Maximale 'PHP script' Ausführungszeit. Falls der 'PHP safe mode' aktiviert ist (SM = On), können die Scripts diese Variable nicht verändern und sie muss von Hand geändert werden",
"chk_phpallowurl_desc"=>"Falls diese Option deaktiviert ist können die Scripts keine Dateien per file:// bearbeiten",
"chk_phpmemlimit_desc"=>"Maximaler Speicherbedarf eines Scripts. Minimum 32MB empfohlen",
"chk_dbtype"=>"Datenbanktyp",
"chk_dbconnect"=>"Verbindung",
"chk_dbver"=>"Version",
"chk_logfiles"=>"Log-Dateien",
"chk_trackdirs"=>"Streckenverzeichnisse",
"chk_dbtype_desc"=>"",
"chk_dbconnect_desc"=>"Datenbankanbindung",
"chk_dbver_desc"=>"Databankversion muss sein:<br>* 4.1.0 oder höher - MySQL<br>* 8.0 oder höher - PostgreSQL<br>* 8.0 (2000) oder höher - Microsoft SQL",
// - Check results
"chk_statusok"=>"Ok",
"chk_statusfailed"=>"Fehler",
"chk_srvonline"=>"Online",
"chk_srvoffline"=>"Offline",

// CURRENT SERVER
// - Headers
"cs_inf_header"=>"Informationen",
"cs_parsing_header"=>"Log-Dateienverarbeitung",
"cs_action_header"=>"Aktionen",
"cs_msf_header"=>"'Matchsettings' Datei / Strecken",
// - Inf
"cs_status"=>"Status",
"cs_totalplayers"=>"Spieler",
"cs_totaltracks"=>"Streckenanzahl",
"cs_currtrack"=>"Aktuelle Strecke",
// - Parsing
"cs_parselast"=>"Letzte Analyse",
"cs_logfiles"=>"Log-Dateien",
// - Tracks
"cs_trackdirs"=>"Streckenverzeichnisse",
// - Action
"cs_refresh_btn"=>"AKTUALISIEREN",
"cs_parse_btn"=>"ANALYSE",
"cs_createmsf_btn"=>"MSD",
"cs_restarttrack_btn"=>"NEUSTART",
"cs_nexttrack_btn"=>"NÄCHSTE",
"cs_choosetrack_btn"=>"WÄHLEN",
"cs_refresh_desc"=>"Serverinformationen aktualisieren",
"cs_restarttrack_desc"=>"Aktuelle Strecke neu starten",
"cs_nexttrack_desc"=>"Server zur nächsten Strecke schicken",
"cs_choosetrack_desc"=>"Auswählen und Wechseln zu einer der Strecken in der Streckenliste",
"cs_cfsp_desc"=>"Continue from saved position",
"cs_parse_desc"=>"Log-Dateien analysieren und Ergebnisse in die Datenbank schreiben",
"cs_createmsf_desc"=>"Neue 'matchsettings' Datei schreiben",
// - Errors
"cs_unknown_err"=>"Unbekannter Fehler",
"cs_ip_err"=>"Falsche IP-Adresse",
"cs_offline_err"=>"Server offline",
"cs_authenticate_err"=>"Falscher Benutzername / Passwort",
"cs_choosetrack_err"=>"Keine Strecke gewählt",
"cs_servers_err"=>"Server nicht gefunden",
"cs_skipped_err"=>"Übersprungen",
"cs_trackdirs_err"=>"Streckenverzeichnis nicht gefunden ???",
"cs_logfiles_err"=>"Log-Datei nicht gefunden oder nicht lesbar",
"cs_msfwrite_err"=>"Konnte 'matchsettings'-Datei nicht schreiben. Mögliche Ursachen:<br>* unzureichende Rechte<br>* Verzeichnis existiert nicht<br>* Dateiname beinhaltet unzulässige Zeichen ('*', '?' ...)",
"cs_msftracks_err"=>"Keine Strecken gewählt",
"cs_msfrestartserver_err"=>"Konnte Server nicht neu starten",
// - Operation results
"cs_status_1"=>"Ok",
"cs_status_2"=>"'Matchsettings' Datei gespeichert",
"cs_status_3"=>"Server neu gestartet",
"cs_status_4"=>"Misserfolg",

// MSF
// - Headers
"msf_parameter_header"=>"Parameter",
"msf_value_header"=>"Wert",
"msf_checkbox_header"=>"?",
"msf_trackname_header"=>"Streckenname",
"msf_trackauthor_header"=>"Autor",
"msf_trackuid_header"=>"UID",
"msf_ml_header"=>"ML",
"msf_envir_header"=>"Umgeb.",
"msf_version_header"=>"TM",
"msf_msfilename_header"=>"Matchsettings Datei",
"msf_action_header"=>"Aktionen",
// - Options
"msf_gamemode"=>"Spielmodus",
"msf_chattime"=>"Chatzei (MSek.)",
"msf_roundspointslimit"=>"Punktelimit im 'Rounds' Modus",
"msf_roundsusenewrules"=>"Neue Regeln im 'Rounds' Modus verwenden",
"msf_timeattacklimit"=>"Punktelimit im 'TimeAttack' Modus (MSek.)",
"msf_teampointslimit"=>"Punktelimit im 'Team' Modus",
"msf_teammaxpoints"=>"Maximale Teampunkte im 'Team' Modus",
"msf_teamusenewrules"=>"Neue Regeln im 'Team' Modus verwenden",
"msf_laps_nblaps"=>"Rundenanzahl im 'Laps' Modus erzwingen",
"msf_lapstimelimit"=>"Zeitlimit im 'Laps' mode (MSek.)",
"msf_randommaporder"=>"Zufällige Streckenreihenfolge",
// - Action
"msf_chkall"=>"Alle auswählen",
"msf_chkalpine"=>"Alpine",
"msf_chkbay"=>"Bay",
"msf_chkcoast"=>"Coast",
"msf_chkisland"=>"Island",
"msf_chkrally"=>"Rally",
"msf_chkspeed"=>"Speed",
"msf_chkstadium"=>"Stadium",
"msf_chknull"=>"Alle entfernen",
"msf_savetofile_btn"=>"SPEICHERN",
"msf_srvrestart_desc"=>"Server mit neuen Einstellungen starten. Warnung: alle Streckendateien und die Datei 'matchsettingsfile.txt' müssen im Ordner ...\GameData\Tracks\ oder einem Unterordner sein!",
"msf_savetofile_desc"=>"In Datei speichern",

// CHOOSE TRACK
"ts_radio_header"=>"?",
"ts_track_header"=>"Streckenname",
"ts_envir_header"=>"Umgeb.",
"ts_length_header"=>"Länge",
"ts_choosetrack_btn"=>"WÄHLEN",
"ts_action_header"=>"Aktionen",
);


$tmos_viewer_it = array(

// MENU
"mnu_servers"=>"Server",
"mnu_monitoring"=>"Übersicht",
"mnu_players"=>"Spielerrangliste",
"mnu_tracks"=>"Strecken",
"mnu_clans"=>"Teams",
"mnu_pages"=>"Seiten: ",
"mnu_envir_!"=>"???",
"mnu_envir_*"=>"INSGESAMT",
"mnu_envir_a"=>"STADIUM",
"mnu_envir_b"=>"ISLAND",
"mnu_envir_c"=>"BAY",
"mnu_envir_d"=>"COAST",
"mnu_envir_e"=>"ALPINE",
"mnu_envir_f"=>"RALLY",
"mnu_envir_g"=>"SPEED",

// SERVERLIST
"sl_header"=>"Server",
"sl_online"=>"Online",
"sl_offline"=>"Offline",

// MONITORING
"mon_header"=>"Übersicht",
"mon_game"=>"Spiel",
"mon_gamemode"=>"Modus",
"mon_players"=>"Spieler",
"mon_spectators"=>"Zuschauer",
"mon_tracks"=>"Anzahl Strecken",
"mon_trackheader"=>"Strecke",
"mon_trackname"=>"Streckenname",
"mon_trackenvir"=>"Umgebung",
"mon_trackauthor"=>"Autor",
"mon_tracklaps"=>"Runden",
"mon_trackauthortime"=>"Zeit des Autors",
"mon_trackbesttime"=>"Bestzeit",
"mon_playernum"=>"#",
"mon_playername"=>"Spieler",
"mon_playerbesttime"=>"Bestzeit",
"mon_playerlaps"=>"Vollständige Runden",

// PLAYERLIST
"pl_header"=>"Spielerrangliste",
"pl_totalplayers"=>"Anzahl Spieler",
"pl_totalawards"=>"Anzahl Ehrungen",
"pl_findplayer"=>"Spieler finden:",
"pl_findplayer_btn"=>"FINDEN",
"pl_num"=>"#",
"pl_player"=>"Spieler",
"pl_score"=>"Punkte",

// PLAYERINFO
"pi_header"=>"Spieler",
"pi_rank"=>"Rang",
"pi_afp"=>"Durchschnittliche Position",
"pi_finishedtracks"=>"Beendete Strecken",
"pi_firstplaces"=>"Erste Plätze",
"pi_lastonline"=>"Zum letzten Mal online",
"pi_aliases"=>"Aliases",
"pi_num"=>"#",
"pi_track"=>"Strecke",
"pi_besttime"=>"Bestzeit",
"pi_place"=>"Platz",
"pi_award"=>"Ehrung",
"pi_ts"=>"Datum",

// TRACKLIST
"tl_header"=>"Strecken",
"tl_totaltracks"=>"Anzahl Strecken",
"tl_totalauthors"=>"Anzahl Autoren",
"tl_findtrack"=>"Strecke finden:",
"tl_findtrack_btn"=>"FINDEN",
"tl_num"=>"#",
"tl_track"=>"Strecke",
"tl_author"=>"Autor",
"tl_bestresult"=>"Zeit",
"tl_player"=>"Bester Spieler",
"tl_severalplayers"=>"Spieler: {0}",

// TRACKINFO
"ti_header"=>"Strecke",
"ti_author"=>"Autor",
"ti_timeauthor"=>"Zeit der Autors",
"ti_timegold"=>"Gold Zeit",
"ti_timesilver"=>"Silber Zeit",
"ti_timebronze"=>"Bronze Zeit",
"ti_envir"=>"Umgebung",
"ti_num"=>"#",
"ti_player"=>"Spieler",
"ti_bestresult"=>"Bestzeit",
"ti_award"=>"Ehrung",
"ti_ts"=>"Datum",

// CLANLIST
"cl_header"=>"Teams",
"cl_totalclans"=>"Anzahl Teams",
"cl_findclan"=>"Team finden:",
"cl_findclan_btn"=>"FINDEN",
"cl_num"=>"#",
"cl_clan"=>"Team",
"cl_score"=>"Punkte",

// CLANINFO   // new !!!
"ci_header"=>"Team",
"ci_mc"=>"Anzahl Mitglieder",
"ci_num"=>"#",
"ci_player"=>"Spieler",
"ci_score"=>"Punkte",

// USERBAR
"ub_header"=>"Userbar",
"ub_links"=>"BB-Code für Foren und HTML link:",
"ub_null_err"=>"> Keine 'userbar'-Dateien gefunden!",
"ub_gd_err"=>"> PHP GD Bibliothek nicht unterstützt!",

// PREFERENCES // new !!!
"pr_header"=>"Einstellungen",
"pr_colorscheme"=>"Farbschema",
"pr_language"=>"Interfacesprache",
"pr_recperpage"=>"Rekorde pro Seite",
"pr_colortags"=>"Farbcodes anzeigen",
"pr_save_btn"=>"SPEICHERN",
"pr_default_btn"=>"ZURÜCKSETZEN",

);


$tmos_userbar_it = array (

// GD TEXT (only latin)
"ub_gdt_server"=>"Server - ",
"ub_gdt_player"=>"Player - ",
"ub_gdt_rank"=>"Rank   - ",
"ub_gdt_score"=>"Score  - ",


"ub_gdt_oa_info"=>'{0} >> {1}',
"ub_gdt_oa_overall"=>"Overall: ",
"ub_gdt_oa_stadium"=>"Stadium: ",
"ub_gdt_oa_island"=>"Island: ",
"ub_gdt_oa_bay"=>"Bay: ",
"ub_gdt_oa_coast"=>"Coast: ",
"ub_gdt_oa_alpine"=>"Alpine: ",
"ub_gdt_oa_rally"=>"Rally: ",
"ub_gdt_oa_speed"=>"Speed: ",

"ub_gdt_link_err"=>"Error: bad userbar link",
"ub_gdt_offline_err"=>"Error: not connected",
"ub_gdt_data_err"=>"Error: data not found (UbID - {0}; SID - {1}; PID - {2})",
"ub_gdt_file_err"=>"Error: userbar file not found or not valid picture",
"ub_gdt_cfg_err"=>"Error: userbars disabled",


// TRUETYPE TEXT (utf8)
"ub_ttt_server"=>"Server",
"ub_ttt_player"=>"Spieler",
"ub_ttt_rank"=>"Rang",
"ub_ttt_score"=>"Punkte",
"ub_ttt_separator"=>"  -  ",

"ub_ttt_oa_info"=>'{0} >> {1}',
"ub_ttt_oa_overall"=>"Insgesamt",
"ub_ttt_oa_stadium"=>"Stadium",
"ub_ttt_oa_island"=>"Island",
"ub_ttt_oa_bay"=>"Bay",
"ub_ttt_oa_coast"=>"Coast",
"ub_ttt_oa_alpine"=>"Alpine",
"ub_ttt_oa_rally"=>"Rally",
"ub_ttt_oa_speed"=>"Speed",
"ub_ttt_oa_separator"=>": ",

);

?>
