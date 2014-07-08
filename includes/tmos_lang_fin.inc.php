<?php
/*
   <dscr>FIN (jaypsi)</dscr>
   Translated by jaypsi
*/

$tmos_admin_it = array(

// MENU
"mnu_header"=>"TM Offline Stats",
"mnu_gs"=>"Yleiset asetukset",
"mnu_db"=>"Tietokanta",
"mnu_dbupd"=>"Rakennepäivitys",
"mnu_sl"=>"Palvelinrekisteri",
"mnu_sladd"=>"Lisää uusi palvelin",
"mnu_slmod"=>"Muokkaa palvelintietoja",
"mnu_ubl"=>"Userbars",
"mnu_ubladd"=>"Lisää uusi userbar",
"mnu_ublmod"=>"Muokkaa userbar-asetuksia",
"mnu_msf"=>"Matchsettings-tiedosto",
"mnu_ts"=>"Ratavalinta",
"mnu_chk"=>"Tarkista asetukset",
"mnu_cs"=>"Palvelimet",
"mnu_csnull"=>"(ei rekisteröity)",

// COMMON
"com_errorprefix"=>"Virhe: ",
"com_messageprefix"=>"> ",

// AUTORIZE
"az_authorize_header"=>"Valtuutus",
"az_login_btn"=>"LOGIN",
"az_status_1"=>"Väärä salasana!",

// GENERAL SETTINGS
// - Headers
"gs_db_header"=>"Tietokanta",
"gs_interface_header"=>"Käyttöliittymä",
"gs_parsing_header"=>"Laske tilastot",
"gs_admin_header"=>"Hallinta",
"gs_action_header"=>"Toimet",
// - DB
"gs_dbhost"=>"Tietokantapalvelin",
"gs_dbtype"=>"Tietokantatyyppi",
"gs_dblogin"=>"Tunnus tietokantaan",
"gs_dbpassword"=>"Salasana tietokantaan",
"gs_dbname"=>"Tietokannan nimi",
"gs_dbhost_desc"=>"Tietokantapalvelimen IP-osoite. Esimerkit:<br>* 192.168.40.111:1433<br>* localhost",
"gs_dbtype_desc"=>"Tietokannan tyyppi tilastojen tallentamiseen",
"gs_dblogin_desc"=>"Tietokantakäyttäjällä pitää olla tarpeeksi oikeuksia taulujen luomiseen ja muokkaamiseen",
"gs_dbpassword_desc"=>"Tietokantakäyttäjän salasana",
"gs_dbname_desc"=>"Tietokanta pitää luoda etukäteen",
// - Interface
"gs_defaultlanguage"=>"Käyttöliittymän oletuskieli",
"gs_defaultcolorscheme"=>"Oletusvärimalli",
"gs_defaultrecperpage"=>"Tietueiden oletusmäärä per sivu",
"gs_javascript"=>"JavaScript",
"gs_servertimeout"=>"Palvelin-timeout",
"gs_showsingleserver"=>"Yksi palvelin",
"gs_showmonitoring"=>"Tarkkailu-välilehti",
"gs_showclans"=>"Tiimi-välilehti",
"gs_showuserbars"=>"Userbars",
"gs_showpreferences"=>"Asetukset",
"gs_showlinks"=>"Linkit",
"gs_showdownloads"=>"Imurointi",
"gs_htmlcache"=>"HTML-välimuisti",
"gs_htmlcache_choice_1"=>"Pääsivut",
"gs_htmlcache_choice_2"=>"Kaikki sivut",
"gs_htmlcache_choice_3"=>"Kielletty",
"gs_gzipcompression"=>"gZIP-pakkaus",
"gs_defaultlanguage_desc"=>"Kielen valinta tilastosivuille, hallintapaneeliin ja userbareihin",
"gs_defaultcolorscheme_desc"=>"Tilastosivujen tyylisivut",
"gs_defaultrecperpage_desc"=>"Tietueiden maksimimäärä yhdellä sivulla. Loput tietueet siirretään seuraaville sivuille",
"gs_javascript_desc"=>"JavaScriptia käytetään taulukkorivien korostamiseen hiiren kohdistimen alla, jotta selaaminen helpottuu",
"gs_servertimeout_desc"=>"Jos pelipalvelimelta ei saada vastausta tässä ajassa (sekunneissa), palvelin merkitään offline-tilaan",
"gs_showsingleserver_desc"=>"(Älä) näytä 'Palvelimet'-välilehteä (esim. jos on vain yksi rekisteröity palvelin)",
"gs_showmonitoring_desc"=>"(Älä) näytä 'Tarkkailu'-välilehteä",
"gs_showclans_desc"=>"(Älä) näytä 'Tiimit'-välilehteä",
"gs_showuserbars_desc"=>"(Älä) näytä 'Userbars'-painiketta pelaajan tilastoissa tai linkeissä",
"gs_showpreferences_desc"=>"(Älä) näytä 'Asetukset'-painiketta",
"gs_showlinks_desc"=>"(Älä) näytä linkkejä pelaajien lempinimissä",
"gs_showdownloads_desc"=>"(Älä) näytä 'Imurointi'-painiketta",
"gs_htmlcache_desc"=>"Nopeuta HTML-sivuja tallentamalla PHP-skriptit välimuistiin",
"gs_gzipcompression_desc"=>"Pakkaa HTML-sivut ennen käyttäjälle lähettämistä (auttaa vähentämällä verkkoliikennettä)",
// - Parsing
"gs_minclansize"=>"Tiimikoko",
"gs_minclansize_desc"=>"Pelaajien minimimäärä tiimin muodostamiseen",
"gs_medalsscore"=>"Pisteet mitaleista",
"gs_medalsscore_desc"=>"Pisteiden anto tekijä-/kulta-/hopea-/pronssimitalin saamisesta ja radan läpäisemisestä",
// - Admin
"gs_adminpassword"=>"Pääkäyttäjän salasana",
"gs_adminpassword_desc"=>"TMOS-pääkäyttäjän salasana",
// - Action
"gs_savecfg_btn"=>"TALLENNA",
"gs_savecfg_desc"=>"Tallenna tämän sivun asetusten muutokset",
// - Errors
"gs_doublequotes_err"=>"Älä käytä kaksoislainausmerkkejä",
"gs_defaultrecperpage_err"=>"Parametrin 'Tietueita per sivu' pitää olla kokonaisluku >= 10",
"gs_servertimeout_err"=>"Parametrin 'Palvelin-timeout' pitää olla kokonaisluku > 0",
"gs_minclansize_err"=>"Parametrin 'Tiimikoko' pitää olla kokonaisluku >= 2",
"gs_medalsscore_err"=>"Parametrien 'Pisteet mitaleista' pitää kaikkien olla kokonaislukuja >= 0",
// - Operation results
"gs_status_1"=>"Asetukset tallennettu",
"gs_status_2"=>"Asetuksia ei voitu tallentaa. Tarkista, että tiedostoon 'tmos_config.php' on kirjoitusoikeus",

// DATABASE
// - Headers
"db_status_header"=>"Tietokannan tila",
"db_table_header"=>"Taulu",
"db_tablestate_header"=>"Tila",
"db_tablerecords_header"=>"Tietueita",
"db_action_header"=>"Toimet",
"db_updinfo_header"=>"Tietoja",
// - DB
"db_dbstatus_1"=>"Ok",
"db_dbstatus_2"=>"PHP ei tue tietokantaa",
// - Tables
"db_tablestatus_1"=>"Ok",
"db_tablestatus_2"=>"Epäkelpo formaatti",
"db_tablestatus_3"=>"Ei löytynyt",
// - Update
"db_updinfo_text"=>"Tietokantarakenne päivitetään <b>{0} => {1}</b>. Toimien järjestys:<br>* Nimeää vanhat taulut tmos_xxx => bk_tmos_xxx<br>* Luo uudet tmos_xxx-taulut formaatissa {1}<br>* Siirtää tiedot tauluista bk_tmos_xxx => tmos_xxx<br>* Tulkkaa kaikkien palvelimien lokitiedostot",
"db_support_err"=>"Päivitys versiosta {0} ei ole tuettu",
// - Action
"db_updatedb_btn"=>"PÄIVITÄ",
"db_createtables_btn"=>"LUO",
"db_droptables_btn"=>"PUDOTA",
"db_resetdata_btn"=>"RESET",
"db_cleardata_btn"=>"TYHJENNÄ",
"db_cancel_btn"=>"PERUUTA",
"db_updatedb_desc"=>"Päivitä TMOS-tietokantataulujen formaatti vanhoista TMOS-versioista (kaikki tiedot säilytetään)",
"db_createtables_desc"=>"Luo TMOS-taulut tietokantaan",
"db_droptables_desc"=>"Poista TMOS-taulut tietokannasta",
"db_resetdata_desc"=>"Poista kaikkien paitsi aktiivisten palvelimien tietueet",
"db_cleardata_desc"=>"Poista kaikki tietueet",
"db_cancel_desc"=>"Älä aja päivitystä",
// - Operation results
"db_status_1"=>"Tietokannan muokkaus onnistui",
"db_status_2"=>"Toiminto peruttu",

// SERVERS
// - Headers
"sl_status_header"=>"Tietokannan tila",
"sl_servers_header"=>"Palvelimet",
"sl_action_header"=>"Toimet",
"sl_add_header"=>"Perusta uusi palvelin",
"sl_mod_header"=>"Palvelin ID:",
// - Servers
"sl_ip"=>"IP-osoite",
"sl_server"=>"Palvelimen nimi",
"sl_id"=>"Palvelin ID",
"sl_game"=>"Peli",
"sl_login"=>"Palvelimen pääkäyttäjän tunnus",
"sl_password"=>"Palvelimen pääkäyttäjän salasana",
"sl_logfiles"=>"Lokitiedostot",
"sl_trackdirs"=>"Ratahakemistot",
"sl_ip_desc"=>"Osoiteformaatti on 'ip:xmlrpcportti'. Esimerkit:<br>* 192.168.40.111:5000<br>* localhost:5001",
"sl_server_desc"=>"Näytetään taulujen otsikoissa ja tilastojen userbareissa",
"sl_game_desc"=>"Kuvat ja userbarit näytetään tilastoissa tämän asetuksen mukaan",
"sl_login_desc"=>"Pitää olla sama kuin SuperAdmin dedicated.cfg-tiedostossa",
"sl_password_desc"=>"",
"sl_logfiles_desc"=>"Trackmania-palvelimen lokitiedostot (palvelimen hakemisto './Logs'). Voit määritellä useita lokeja erottelemalla ne ';'-merkillä. Esimerkit:<br>* c:\\tmn\Logs\GameLog..txt<br>* /usr/home/omatilini/tmn/Logs/GameLog..txt<br>* &lt;dir&gt;\GameLog.1.txt;&lt;dir&gt;\GameLog.2.txt;&lt;dir&gt;\GameLog.3.txt",
"sl_trackdirs_desc"=>"Hakemistot, joissa '.gbx'-ratatiedostot. Voit määritellä useita hakemistoja erottelemalla ne ';'-merkillä. Esimerkit:<br>* c:\\tmn\GameData\Tracks<br>* /usr/home/omatilini/tmn/GameData/Tracks<br>* &lt;dir1&gt;/Tracks;&lt;dir2&gt;/Tracks;&lt;dir3&gt;/Tracks",
// - Action
"sl_addserver_btn"=>"LISÄÄ",
"sl_deleteservers_btn"=>"POISTA",
"sl_modifyservers_btn"=>"MUOKKAA",
"sl_cancel_btn"=>"PERUUTA",
"sl_addserver_desc"=>"Rekisteröi uusi palvelin",
"sl_deleteservers_desc"=>"Poista valitut palvelimet",
"sl_modifyservers_desc"=>"Muuta valittujen palvelinten tietoja",
"sl_cancel_desc"=>"Peruuta muutokset",
// - Errors
"sl_doublequotes_err"=>"Älä käytä kaksoislainausmerkkejä",
// - Operation results
"sl_status_1"=>"Toiminto peruttu",
"sl_status_2"=>"Toiminto suoritettu onnistuneesti",
"sl_status_3"=>"Ei valittuja palvelimia",

// USERBARS             /////////////// new !!!!!!!!!!!!!!!!!!!!!
// - Headers
"ub_status_header"=>"GD-tila",
"ub_userbars_header"=>"Userbars",
"ub_action_header"=>"Toimet",
"ub_add_header"=>"Perusta uusi userbar",
"ub_mod_header"=>"Userbar ID:",
// - Data
"ub_gdstatus_1"=>"Ok",
"ub_gdstatus_2"=>"GD-kirjasto ei ole tuettu",
"ub_gdstatus_3"=>"FreeType-kirjasto ei tuettu",
"ub_id"=>"Userbar ID",
"ub_game"=>"Peli",
"ub_font1"=>"Kirjasin 1 / väri / koko",
"ub_font2"=>"Kirjasin 2 / väri / koko",
"ub_imgfile"=>"Kuvatiedosto (.png)",
"ub_type"=>"Tyyppi",
// - Action
"ub_adduserbar_btn"=>"LISÄÄ",
"ub_adduserbar_desc"=>"Lisää uusi userbar",
"ub_deleteuserbars_btn"=>"POISTA",
"ub_deleteuserbars_desc"=>"Poista valitut userbar:t",
"ub_modifyuserbars_btn"=>"MUOKKAA",
"ub_modifyuserbars_desc"=>"Muuta valittujen userbar:ien ominaisuuksia",
"ub_cancel_btn"=>"PERUUTA",
"ub_cancel_desc"=>"Peruuta muutokset",
// - Errors
"ub_imgfile_err"=>"Kuvatiedoston pitää olla .png-formaatissa, leveys <= 600, korkeus <= 100, koko <= 100 kt",
"ub_font1_err"=>"Kirjasin 1 ei löytynyt",
"ub_size1_err"=>"Kirjasinkoko 1 pitää olla kokonaisluku >= 1",
"ub_color1_err"=>"Kirjasinväri 1 pitää määritellä XXXXXX-formaatissa, missä X on mikä tahansa heksa-arvo (0-9, a-f)",
"ub_font2_err"=>"Kirjasin 2 ei löytynyt",
"ub_size2_err"=>"Kirjasinkoko 2 pitää olla kokonaisluku >= 1",
"ub_color2_err"=>"Kirjasinväri 2 pitää määritellä XXXXXX-formaatissa, missä X on mikä tahansa heksa-arvo (0-9, a-f)",
// - Operation results
"ub_status_1"=>"Toiminto peruttu",
"ub_status_2"=>"Ok",
"ub_status_3"=>"Määrittelemätön virhe",
"ub_status_4"=>"Ei valittuja userbar:ja",

// CHECK
// - Headers
"chk_php_header"=>"PHP",
"chk_db_header"=>"Tietokanta",
"chk_tables_header"=>"Taulut",
"chk_servers_header"=>"Palvelimet",
// - Inf
"chk_phpver"=>"Versio",
"chk_phpxml"=>"XML",
"chk_phpgd"=>"GD",
"chk_phpft"=>"FreeType",
"chk_phpcache"=>"Välimuisti",
"chk_phpzlib"=>"ZLib",
"chk_phpmetime"=>"max_execution_time",
"chk_phpallowurl"=>"allow_url_fopen",
"chk_phpmemlimit"=>"memory_limit",
"chk_phpver_desc"=>"PHP-version pitää olla 4.4.0 tai uudempi",
"chk_phpxml_desc"=>"XML-tuki",
"chk_phpgd_desc"=>"GD-kirjastot pitää olla asennettu userbar:eja varten",
"chk_phpft_desc"=>"Freetype-kirjastot pitää olla asennettu, jotta Truetype-kirjasimia voi käyttää userbar:eissa",
"chk_phpcache_desc"=>"Kokeile välimuistitiedoston kirjoitusta",
"chk_phpzlib_desc"=>"ZLib-kirjastot pitää olla asennettu, jotta verkkosivuja voidaan pakata",
"chk_phpmetime_desc"=>"Maksimi PHP-skriptin ajoaika. Jos PHP-vikasietotila on päällä (SM = On), skriptit eivät voi muuttaa tätä arvoa ja se pitää muuttaa käsin",
"chk_phpallowurl_desc"=>"Jos tämä optio on pois päältä, skriptit eivät voi käsitellä tiedostoja file:// kautta",
"chk_phpmemlimit_desc"=>"Maksimimäärä muistia skriptille. Suositus vähintään 32 Mt",
"chk_dbtype"=>"Tietokantatyyppi",
"chk_dbconnect"=>"Yhteys",
"chk_dbver"=>"Versio",
"chk_logfiles"=>"Lokitiedostot",
"chk_trackdirs"=>"Ratahakemistot",
"chk_dbtype_desc"=>"",
"chk_dbconnect_desc"=>"Tietokannan saavutettavuus",
"chk_dbver_desc"=>"Tietokantaversion pitää olla:<br>* 4.1.0 tai uudempi - MySQL<br>* 8.0 tai uudempi - PostgreSQL<br>* 8.0 (2000) tai uudempi - Microsoft SQL",
// - Check results
"chk_statusok"=>"Ok",
"chk_statusfailed"=>"Virhe",
"chk_srvonline"=>"Online",
"chk_srvoffline"=>"Offline",

// CURRENT SERVER
// - Headers
"cs_inf_header"=>"Tietoja",
"cs_parsing_header"=>"Lokitiedostojen tulkkaus",
"cs_action_header"=>"Toimet",
"cs_msf_header"=>"Matchsettings-tiedosto / Radat",
// - Inf
"cs_status"=>"Tila",
"cs_totalplayers"=>"Pelaajia",
"cs_totaltracks"=>"Ratojen määrä",
"cs_currtrack"=>"Nykyinen rata",
// - Parsing
"cs_parselast"=>"Viimeisin tulkkaus",
"cs_logfiles"=>"Lokitiedostot",
// - Tracks
"cs_trackdirs"=>"Ratahakemistot",
// - Action
"cs_refresh_btn"=>"PÄIVITÄ",
"cs_parse_btn"=>"TULKKAA",
"cs_createmsf_btn"=>"MSF",
"cs_restarttrack_btn"=>"RESTART",
"cs_nexttrack_btn"=>"SEURAAVA",
"cs_choosetrack_btn"=>"VALITSE",
"cs_refresh_desc"=>"Päivitä palvelintiedot",
"cs_restarttrack_desc"=>"Käynnistä nykyinen rata uudelleen",
"cs_nexttrack_desc"=>"Siirrä palvelin seuraavaan rataan",
"cs_choosetrack_desc"=>"Valitse ja vaihda yhteen ratalistan rataan",
"cs_cfsp_desc"=>"Continue from saved position",
"cs_parse_desc"=>"Tulkkaa lokitiedostot ja kirjoita tulokset tietokantaan",
"cs_createmsf_desc"=>"Luo uusi matchsettings-tiedosto",
// - Errors
"cs_unknown_err"=>"Tuntematon virhe",
"cs_ip_err"=>"Väärä IP-osoite",
"cs_offline_err"=>"Palvelin offline",
"cs_authenticate_err"=>"Väärä käyttäjänimi / salasana",
"cs_choosetrack_err"=>"Ei valittua rataa",
"cs_servers_err"=>"Palvelinta ei löydy",
"cs_skipped_err"=>"Ohitettu",
"cs_trackdirs_err"=>"Ratahakemisto(ja) ei löydy tai pystytä lukemaan",
"cs_logfiles_err"=>"Lokitiedosto(ja) ei löydy tai pystytä lukemaan",
"cs_msfwrite_err"=>"Ei voitu tallentaa matchsettings-tiedostoa. Mahdollisia syitä:<br>* ei tarpeeksi oikeuksia<br>* hakemistoa ei ole olemassa<br>* tiedostonimessä kiellettyjä merkkejä ('*', '?', ...)",
"cs_msftracks_err"=>"Ei valittuja ratoja",
"cs_msfrestartserver_err"=>"Palvelinta ei voitu uudelleenkäynnistää",
// - Operation results
"cs_status_1"=>"Ok",
"cs_status_2"=>"Matchsettings-tiedosto tallennettu",
"cs_status_3"=>"Palvelin uudelleenkäynnistetty",
"cs_status_4"=>"Epäonnistuminen",

// MSF
// - Headers
"msf_parameter_header"=>"Parametri",
"msf_value_header"=>"Arvo",
"msf_checkbox_header"=>"?",
"msf_trackname_header"=>"Radan nimi",
"msf_trackauthor_header"=>"Tekijä",
"msf_trackuid_header"=>"UID",
"msf_ml_header"=>"ML",
"msf_envir_header"=>"Ympär.",
"msf_version_header"=>"TM",
"msf_msfilename_header"=>"Matchsettings-tiedosto",
"msf_action_header"=>"Toimet",
// - Options
"msf_gamemode"=>"Pelitila",
"msf_chattime"=>"Rupatteluaika (ms)",
"msf_roundspointslimit"=>"Pisteraja 'Rounds'-tilaan",
"msf_roundsusenewrules"=>"Käytä 'Rounds'-tilassa uusia sääntöjä",
"msf_timeattacklimit"=>"Aikaraja 'TimeAttack'-tilaan (ms)",
"msf_teampointslimit"=>"Pisteraja 'Team'-tilaan",
"msf_teammaxpoints"=>"Maksimimäärä tiimipisteitä 'Team'-tilaan",
"msf_teamusenewrules"=>"Käytä 'Team'-tilassa uusia sääntöjä",
"msf_laps_nblaps"=>"Pakota kierrosmäärä 'Laps'-tilaan",
"msf_lapstimelimit"=>"Aikaraja 'Laps'-tilaan (ms)",
"msf_randommaporder"=>"Sekoita ratalista",
// - Action
"msf_chkall"=>"Valitse kaikki",
"msf_chkalpine"=>"Alpine",
"msf_chkbay"=>"Bay",
"msf_chkcoast"=>"Coast",
"msf_chkisland"=>"Island",
"msf_chkrally"=>"Rally",
"msf_chkspeed"=>"Speed",
"msf_chkstadium"=>"Stadium",
"msf_chknull"=>"Poista kaikki",
"msf_savetofile_btn"=>"TALLENNA",
"msf_srvrestart_desc"=>"Uudelleenkäynnistä palvelin uusilla asetuksilla. Varoitus: Kaikkien rata- ja matchsettings.txt-tiedostojen pitää sijaita ...\GameData\Tracks\-hakemistossa tai sen alihakemistoissa!",
"msf_savetofile_desc"=>"Tallenna asetukset tiedostoon",

// CHOOSE TRACK
"ts_radio_header"=>"?",
"ts_track_header"=>"Radan nimi",
"ts_envir_header"=>"Ympär.",
"ts_length_header"=>"Pituus",
"ts_choosetrack_btn"=>"VALITSE",
"ts_action_header"=>"Toimet",
);


$tmos_viewer_it = array(

// MENU
"mnu_servers"=>"Palvelimet",
"mnu_monitoring"=>"Tarkkailu",
"mnu_players"=>"Pelaajien sijoitukset",
"mnu_tracks"=>"Radat",
"mnu_clans"=>"Tiimit",
"mnu_pages"=>"Sivut: ",
"mnu_envir_!"=>"???",
"mnu_envir_*"=>"YHTEENSÄ",
"mnu_envir_a"=>"STADIUM",
"mnu_envir_b"=>"ISLAND",
"mnu_envir_c"=>"BAY",
"mnu_envir_d"=>"COAST",
"mnu_envir_e"=>"ALPINE",
"mnu_envir_f"=>"RALLY",
"mnu_envir_g"=>"SPEED",

// SERVERLIST
"sl_header"=>"Palvelimet",
"sl_online"=>"Online",
"sl_offline"=>"Offline",

// MONITORING
"mon_header"=>"Tarkkailu",
"mon_game"=>"Peli",
"mon_gamemode"=>"Tila",
"mon_players"=>"Pelaajia",
"mon_spectators"=>"Katsojia",
"mon_tracks"=>"Ratojen määrä",
"mon_trackheader"=>"Rata",
"mon_trackname"=>"Radan nimi",
"mon_trackenvir"=>"Ympäristö",
"mon_trackauthor"=>"Tekijä",
"mon_tracklaps"=>"Kierroksia",
"mon_trackauthortime"=>"Tekijän aika",
"mon_trackbesttime"=>"Paras aika",
"mon_playernum"=>"#",
"mon_playername"=>"Pelaaja",
"mon_playerbesttime"=>"Paras aika",
"mon_playerlaps"=>"Kierroksia ajettu",

// PLAYERLIST
"pl_header"=>"Pelaaja sijoitukset",
"pl_totalplayers"=>"Pelaajia yhteensä",
"pl_totalawards"=>"Mitaleja yhteensä",
"pl_findplayer"=>"Etsi pelaaja:",
"pl_findplayer_btn"=>"ETSI",
"pl_num"=>"#",
"pl_player"=>"Pelaaja",
"pl_score"=>"Pisteet",

// PLAYERINFO
"pi_header"=>"Pelaaja",
"pi_rank"=>"Sija",
"pi_afp"=>"Keskimääräinen sijoitus",
"pi_finishedtracks"=>"Läpäistyt radat",
"pi_firstplaces"=>"Kärkisijat",
"pi_lastonline"=>"Viimeisin yhteys",
"pi_aliases"=>"Aliakset",
"pi_num"=>"#",
"pi_track"=>"Rata",
"pi_besttime"=>"Paras aika",
"pi_place"=>"Sija",
"pi_award"=>"Mitali",
"pi_ts"=>"Päivä",

// TRACKLIST
"tl_header"=>"Radat",
"tl_totaltracks"=>"Ratoja yhteensä",
"tl_totalauthors"=>"Tekijöitä yhteensä",
"tl_findtrack"=>"Etsi rata:",
"tl_findtrack_btn"=>"ETSI",
"tl_num"=>"#",
"tl_track"=>"Rata",
"tl_author"=>"Tekijä",
"tl_bestresult"=>"Aika",
"tl_player"=>"Paras pelaaja",
"tl_severalplayers"=>"Pelaajia: {0}",

// TRACKINFO
"ti_header"=>"Rata",
"ti_author"=>"Tekijä",
"ti_timeauthor"=>"Tekijän aika",
"ti_timegold"=>"Kulta-aika",
"ti_timesilver"=>"Hopea-aika",
"ti_timebronze"=>"Pronssiaika",
"ti_envir"=>"Ympäristö",
"ti_num"=>"#",
"ti_player"=>"Pelaaja",
"ti_bestresult"=>"Paras aika",
"ti_award"=>"Mitali",
"ti_ts"=>"Päivä",

// CLANLIST
"cl_header"=>"Tiimit",
"cl_totalclans"=>"Tiimejä yhteensä",
"cl_findclan"=>"Etsi tiimi:",
"cl_findclan_btn"=>"ETSI",
"cl_num"=>"#",
"cl_clan"=>"Tiimi",
"cl_score"=>"Pisteet",

// CLANINFO   // new !!!
"ci_header"=>"Tiimi",
"ci_mc"=>"Jäseniä yhteensä",
"ci_num"=>"#",
"ci_player"=>"Pelaaja",
"ci_score"=>"Pisteet",

// USERBAR
"ub_header"=>"Userbar",
"ub_links"=>"BBCode foorumeille ja HTML-linkki:",
"ub_null_err"=>"> Userbar-tiedostoja ei löydy!",
"ub_gd_err"=>"> PHP GD-kirjasto ei tuettu!",

// PREFERENCES // new !!!
"pr_header"=>"Asetukset",
"pr_colorscheme"=>"Värimalli",
"pr_language"=>"Käyttöliittymän kieli",
"pr_recperpage"=>"Tietueita sivulla",
"pr_colortags"=>"Näytä värikoodit",
"pr_save_btn"=>"TALLENNA",
"pr_default_btn"=>"OLETUS",

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
"ub_ttt_server"=>"Palvelin",
"ub_ttt_player"=>"Pelaaja",
"ub_ttt_rank"=>"Sija",
"ub_ttt_score"=>"Pisteet",
"ub_ttt_separator"=>"  -  ",

"ub_ttt_oa_info"=>'{0} >> {1}',
"ub_ttt_oa_overall"=>"Yhteensä",
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
