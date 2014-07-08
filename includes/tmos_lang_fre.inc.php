<?php
/*
   <dscr>FRE (godkagoul)</dscr>
   Translated by godkagoul
*/

$tmos_admin_it = array(

// MENU
"mnu_header"=>"TM Offline Stats",
"mnu_gs"=>"Paramètres global",
"mnu_db"=>"Base de donées",
"mnu_dbupd"=>"Mise à jour structure",
"mnu_sl"=>"Enregistrement serveurs",
"mnu_sladd"=>"Ajouter nouveau serveur",
"mnu_slmod"=>"Editer information serveur",
"mnu_ubl"=>"Userbars",
"mnu_ubladd"=>"Ajouter nouvelle Userbar",
"mnu_ublmod"=>"Editer Propriété Userbar",
"mnu_msf"=>"Fichier Matchsettings",
"mnu_ts"=>"Sélection circuits",
"mnu_chk"=>"Vérifier configuration",
"mnu_cs"=>"Serveurs",
"mnu_csnull"=>"(non enregistré)",

// COMMON
"com_errorprefix"=>"Erreur: ",
"com_messageprefix"=>"> ",

// AUTORIZE
"az_authorize_header"=>"Autorisation",
"az_login_btn"=>"LOGIN",
"az_status_1"=>"Mot de passe incorrect!",

// GENERAL SETTINGS
// - Headers
"gs_db_header"=>"Base de données",
"gs_interface_header"=>"Interface",
"gs_parsing_header"=>"Calculer statistiques",
"gs_admin_header"=>"Administration",
"gs_action_header"=>"Actions",
// - DB
"gs_dbhost"=>"Database host",
"gs_dbtype"=>"Type",
"gs_dblogin"=>"Login",
"gs_dbpassword"=>"Mot de passe",
"gs_dbname"=>"Nom de la base",
"gs_dbhost_desc"=>"Adresse IP du serveur contenant la base de données. Examples:<br>* 192.168.40.111:1433<br>* localhost",
"gs_dbtype_desc"=>"Type de base de données pour le stockage des statistiques",
"gs_dblogin_desc"=>"L'utilisateur de la base de données doit avoir les privilèges suffisant pour créer et éditer les tables",
"gs_dbpassword_desc"=>"Mot de passe utilisateur base de données",
"gs_dbname_desc"=>"La base données doit etre créer au préalable",
// - Interface
"gs_defaultlanguage"=>"Language par défault de l'interface",
"gs_defaultcolorscheme"=>"Couleur par défault du thème",
"gs_defaultrecperpage"=>"Nombre de records par défault pour une page",
"gs_javascript"=>"Javascript",
"gs_servertimeout"=>"Serveur timeout",
"gs_showsingleserver"=>"Serveur unique",
"gs_showmonitoring"=>"Onglet monitoring",
"gs_showclans"=>"Onglet Team",
"gs_showuserbars"=>"Userbars",
"gs_showpreferences"=>"Préférences",
"gs_showlinks"=>"Liens",
"gs_showdownloads"=>"Télèchargements",
"gs_htmlcache"=>"Cache HTML",
"gs_htmlcache_choice_1"=>"Pages principales",
"gs_htmlcache_choice_2"=>"Toutes pages",
"gs_htmlcache_choice_3"=>"Interdit",
"gs_gzipcompression"=>"gZIP Kompression",
"gs_defaultlanguage_desc"=>"Sélection du langage pour les pages statistiques, panneau d'administration et userbar",
"gs_defaultcolorscheme_desc"=>"Feuille de style pour les pages statistiques",
"gs_defaultrecperpage_desc"=>"Quantité maximum de records visible sur une page. Les autres records seront visible sur les pages suivantes",
"gs_javascript_desc"=>"Javascript est utilisé pour la colorisation des lignes de la table sous le curseur de la souris pour faciliter la navigation",
"gs_servertimeout_desc"=>"Si le serveur ne répond pas dans cet interval de temps (en secondes), le serveur sera notifié comme hors-ligne",
"gs_showsingleserver_desc"=>"(Ne pas) montrer l'onglet 'serveur' (Si il n'y a que un seul serveur d'enregistré)",
"gs_showmonitoring_desc"=>"(Ne pas) montrer l'onglet 'Monitoring'",
"gs_showclans_desc"=>"(Ne pas) montrer l'onglet (Equipe)",
"gs_showuserbars_desc"=>"(Ne pas) montrer 'Usersbars' dans les statistiques personnelles du joueur et dans les liens",
"gs_showpreferences_desc"=>"(Ne pas) montrer le boutton 'Préférences'",
"gs_showlinks_desc"=>"(Ne pas) montrer les liens vers les pseudos des joueurs",
"gs_showdownloads_desc"=>"(Ne pas) montrer le boutton 'Télèchargements'",
"gs_htmlcache_desc"=>"Accélerer le chargement des pages HTML grace au cache des scripts PHP",
"gs_gzipcompression_desc"=>"Compression des pages HTML avant l'envoi à l'utilisateur (utiles pour diminuer le trafic Web)",
// - Parsing
"gs_minclansize"=>"Taille de l'équipe",
"gs_minclansize_desc"=>"Nombre minimum de joueurs pour former une équipe",
"gs_medalsscore"=>"Points pour les médailles",
"gs_medalsscore_desc"=>"Nombre de points pour obtenir les médailles Auteur/or/argent/bronze et à la réalisation de l'objectif",
// - Admin
"gs_adminpassword"=>"Mot de passe administrateur",
"gs_adminpassword_desc"=>"Mot de passe Administrateur TMOS",
// - Action
"gs_savecfg_btn"=>"SAUVER",
"gs_savecfg_desc"=>"Sauvegarder les changements sur cette page",
// - Errors
"gs_doublequotes_err"=>"Ne pas utiliser les guillemets",
"gs_defaultrecperpage_err"=>"Le paramètre 'Record par page' doit être nombre entier >= 10",
"gs_servertimeout_err"=>"Le paramètre 'Serveur timeout' doit être nombre entier >= 0",
"gs_minclansize_err"=>"Le paramètre 'Taille de l'équipe' doit être nombre entier >= 2",
"gs_medalsscore_err"=>"Le paramètre 'Points pour les médailles' doit être nombre entier >= 0",
// - Operation results
"gs_status_1"=>"Paramètres sauvegarder",
"gs_status_2"=>"Les paramètres n'ont pas pu être sauvegarder. Verifier que le fichier 'tmos_config.php' a les permisssions en écriture",

// DATABASE
// - Headers
"db_status_header"=>"Status base de données",
"db_table_header"=>"Table",
"db_tablestate_header"=>"Etat",
"db_tablerecords_header"=>"Records",
"db_action_header"=>"Actions",
"db_updinfo_header"=>"Information",
// - DB
"db_dbstatus_1"=>"Ok",
"db_dbstatus_2"=>"Ne pas inclure le support de bases de données en PHP",
// - Tables
"db_tablestatus_1"=>"Ok",
"db_tablestatus_2"=>"Format incorrect",
"db_tablestatus_3"=>"Pas trouvé",
// - Update
"db_updinfo_text"=>"Pour mettre à jour la structure de la base de donées <b>{0} => {1}</b>. La séquence d'actions: <br>* L'ancienne table tmos_xxx<br>* Creer les nouvelles tables tmos_xxx dans format {1}<br>* Transfert des donées de la tables bk_tmos_xxx => tmos_xxx<br>* Analyse terminé pour les fichiers log de tous les serveurs",
"db_support_err"=>"Mise à jour depuis la version {0} n'est pas supportée",
// - Action
"db_updatedb_btn"=>"Mise à jour",
"db_createtables_btn"=>"Créer",
"db_droptables_btn"=>"Vider",
"db_resetdata_btn"=>"Reset",
"db_cleardata_btn"=>"Néttoyer",
"db_cancel_btn"=>"Annuler",
"db_updatedb_desc"=>"Mise à jour des tables TMOS de la bases de données des versions précédentes de TMOS (toutes les données seront conservées)",
"db_createtables_desc"=>"Créer les tables TMOS dans la base de données",
"db_droptables_desc"=>"Supprimer les tables de TMOS de la base de données",
"db_resetdata_desc"=>"Supprimer tous les records éxcepter pour les serveurs actifs",
"db_cleardata_desc"=>"Supprimer tous les records",
"db_cancel_desc"=>"Ne pas éxecuté la mise à jour",
// - Operation results
"db_status_1"=>"Modification de la base de données terminé avec succés",
"db_status_2"=>"Opération annulé",

// SERVERS
// - Headers
"sl_status_header"=>"Statut base de données",
"sl_servers_header"=>"Serveurs",
"sl_action_header"=>"Actions",
"sl_add_header"=>"Parametrer un nouveau serveur",
"sl_mod_header"=>"Serveur ID:",
// - Servers
"sl_ip"=>"Adresse IP",
"sl_server"=>"Nom du serveur",
"sl_id"=>"Serveur ID",
"sl_game"=>"Jeu",
"sl_login"=>"Login admin du serveur",
"sl_password"=>"Mot de passe admin du serveur",
"sl_logfiles"=>"Fichiers log",
"sl_trackdirs"=>"Répertoire des circuits",
"sl_ip_desc"=>"Le format de l'adresse est 'ip:xmlrpcport'. Exemple: <br>* 192.168.40.111:5000<br>* localhost:5001",
"sl_server_desc"=>"Affiche les tables dans les rubriques et sur la userbar des statistiques",
"sl_game_desc"=>"Photos et 'userbars' affichée dans les statistiques en fonction de ce paramètre",
"sl_login_desc"=>"Doit corespondre avec SuperAdmin dans le fichier dedicated.cfg",
"sl_password_desc"=>"",
"sl_logfiles_desc"=>"Fichier log Trackmania serveur ('./Logs' repertoire serveur). Plusieurs logs peuvent être specifier en utilisant ';' entre les logs. Exemples:<br> c:\\tmn\Logs\Gamelog..txt<br>* /usr/home/myaccount/tmn/Logs/Gamelog..txt<br>* &lt;dir&gt;\Gamelog.1.txt;&lt;dir&gt;\GameLog.2.txt;&lt;dir&gt;\GameLog.3.txt",
"sl_trackdirs_desc"=>"Repertoire avec les circuits en '.gbx'. Plusieurs répertoire peuvent être specifier en utilisant ';' entre les repertoire. Exemples:<br>* c:\\tmn\GameData\Tracks<br>* /usr/home/myaccount/tmn/GameData/Tracks<br>* &lt;dir1&gt;/Tracks;&lt;dir2&gt;/Tracks;&lt;dir3&gt;/Tracks",
// - Action
"sl_addserver_btn"=>"Ajouter",
"sl_deleteservers_btn"=>"Supprimer",
"sl_modifyservers_btn"=>"Modifier",
"sl_cancel_btn"=>"Annuler",
"sl_addserver_desc"=>"Enregistrer un nouveau serveur",
"sl_deleteservers_desc"=>"Supprimer le serveur selectionné",
"sl_modifyservers_desc"=>"Changer les valeurs pour le serveur selectionné",
"sl_cancel_desc"=>"Annuler les changements",
// - Errors
"sl_doublequotes_err"=>"Ne pas utiliser de guillemets",
// - Operation results
"sl_status_1"=>"Opération annulée",
"sl_status_2"=>"Opération terminée avec succès",
"sl_status_3"=>"Pas de serveurs selectionnés",

// USERBARS             /////////////// new !!!!!!!!!!!!!!!!!!!!!
// - Headers
"ub_status_header"=>"GD Status",
"ub_userbars_header"=>"Userbars",
"ub_action_header"=>"Actions",
"ub_add_header"=>"Parametrer le nouvelle userbar",
"ub_mod_header"=>"Userbar ID:",
// - Data
"ub_gdstatus_1"=>"Ok",
"ub_gdstatus_2"=>"GD librairie n'est pas supportée",
"ub_gdstatus_3"=>"Freetype librairie n'est pas supportée",
"ub_id"=>"Userbar ID",
"ub_game"=>"Jeu",
"ub_font1"=>"Font 1 / Couleur / Taille",
"ub_font2"=>"Font 2 / Couleur / Taille",
"ub_imgfile"=>"Fichier image (.png)",
"ub_type"=>"Type",
// - Action
"ub_adduserbar_btn"=>"Ajouter",
"ub_adduserbar_desc"=>"Ajouter une nouvelle userbar",
"ub_deleteuserbars_btn"=>"Supprimer",
"ub_deleteuserbars_desc"=>"Supprimer la userbar selectionnée",
"ub_modifyuserbars_btn"=>"Modifier",
"ub_modifyuserbars_desc"=>"Change les proprietés pour la userbar selectionnée",
"ub_cancel_btn"=>"Annulé",
"ub_cancel_desc"=>"Annulé les changements",
// - Errors
"ub_imgfile_err"=>"Le fichier image doit être au format .png, Taille <= 600, Hauteur <= 100, Poids <= 100Kb",
"ub_font1_err"=>"Font 1 non trouvé",
"ub_size1_err"=>"La taille du font 1 doit etre un nombre entier >= 1",
"ub_color1_err"=>"La couleur du font 1 doit être specifier au format XXXXXX, ou X doit être une valeur hexadécimale (0-9, a-f)",
"ub_font2_err"=>"Font 2 non trouvé",
"ub_size2_err"=>"La taille du font 2 doit etre un nombre entier >= 1",
"ub_color2_err"=>"La couleur du font 2 doit être specifier au format XXXXXX, ou X doit être une valeur hexadécimale (0-9, a-f)",
// - Operation results
"ub_status_1"=>"Opération annulée",
"ub_status_2"=>"Ok",
"ub_status_3"=>"Même erreur",
"ub_status_4"=>"Pas de userbar selectionnée",

// CHECK
// - Headers
"chk_php_header"=>"PHP",
"chk_db_header"=>"Base de données",
"chk_tables_header"=>"Tables",
"chk_servers_header"=>"Serveurs",
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
"chk_phpver_desc"=>"PHP version doit être 4.4.0 ou superieur",
"chk_phpxml_desc"=>"Support XML",
"chk_phpgd_desc"=>"Librairie GD doit être installé pour utiliser les userbars",
"chk_phpft_desc"=>"Freetype librairie doir être installé pour utiliser les fonts Truetype avec les userbars",
"chk_phpcache_desc"=>"Test d'écriture en fichier cache",
"chk_phpzlib_desc"=>"Zlib librairies doit être installé pour supporter la compression des pages web",
"chk_phpmetime_desc"=>"Temps d'execution maximum 'PHP script. Si le mode sans échec de PHP est activé (SM = On) les scripts ne peuvent pas modifier cette variable et doivent être changé manuellement",
"chk_phpallowurl_desc"=>"Si cette option est sur Off, les scripts ne peuvent pas traiter les fichiers via file://",
"chk_phpmemlimit_desc"=>"Valeur maximal de mémoire alloué à un script. 32 Mo minimum recommandé",
"chk_dbtype"=>"Type de la base de données",
"chk_dbconnect"=>"Connexion",
"chk_dbver"=>"Version",
"chk_logfiles"=>"Fichiers logs",
"chk_trackdirs"=>"Répertoire des circuits",
"chk_dbtype_desc"=>"",
"chk_dbconnect_desc"=>"Accessibilité de la base de données",
"chk_dbver_desc"=>"La vesion de la base de données doit être :<br>* 4.1.0 ou superieur - MySQL<br>* 8.0 ou supérieur - PostgreSQL<br>* 8.0 (2000) ou supérieur - Microsoft SQL",
// - Check results
"chk_statusok"=>"Ok",
"chk_statusfailed"=>"Erreur",
"chk_srvonline"=>"Online",
"chk_srvoffline"=>"Offline",

// CURRENT SERVER
// - Headers
"cs_inf_header"=>"Information",
"cs_parsing_header"=>"Analyse du fichier log",
"cs_action_header"=>"Actions",
"cs_msf_header"=>"Fichier Matchsettings / Circuits",
// - Inf
"cs_status"=>"Status",
"cs_totalplayers"=>"Joueurs",
"cs_totaltracks"=>"Nombre de circuits",
"cs_currtrack"=>"Circuit actuel",
// - Parsing
"cs_parselast"=>"Dernière analyse",
"cs_logfiles"=>"Fichier log",
// - Tracks
"cs_trackdirs"=>"Répertoire des circuits",
// - Action
"cs_refresh_btn"=>"Rafraîchir",
"cs_parse_btn"=>"Analyse",
"cs_createmsf_btn"=>"MSF",
"cs_restarttrack_btn"=>"Restart",
"cs_nexttrack_btn"=>"Suivant",
"cs_choosetrack_btn"=>"Choisir",
"cs_refresh_desc"=>"Rafraîchir les informations serveur",
"cs_restarttrack_desc"=>"Redémarrer le circuit actuel",
"cs_nexttrack_desc"=>"Envoyer au serveur comme prochaine map",
"cs_choosetrack_desc"=>"Sélectionnez et téléchargez le circuit de la playlist",
"cs_cfsp_desc"=>"Continue from saved position",
"cs_parse_desc"=>"Analiser les fichiers log et écrire les résultats dans la base de données",
"cs_createmsf_desc"=>"Créer un nouveau fichier matchsettings",
// - Errors
"cs_unknown_err"=>"Erreur inconnue",
"cs_ip_err"=>"Adresse IP incorrect",
"cs_offline_err"=>"Serveur offline",
"cs_authenticate_err"=>"Login / mot de passe incorrect",
"cs_choosetrack_err"=>"Pas de circuit sélectionné",
"cs_servers_err"=>"Serveur (s) non trouvé",
"cs_skipped_err"=>"Ignoré",
"cs_trackdirs_err"=>"Répertoire circuits non trouvé ou non accessible",
"cs_logfiles_err"=>"Fichier log non trouvé ou non accessible",
"cs_msfwrite_err"=>"Impossible de sauvegarder le fichier matchsettings. Causes possibles :<br>* Permissions non accordés<br>* Le répertoire n'éxiste pas<br>* Les noms de fichiers contiennent des caractères illegaux ('*', '?' ...)",
"cs_msftracks_err"=>"Pas de circuits sélectionnés",
"cs_msfrestartserver_err"=>"Impossible de redémarrer le serveur",
// - Operation results
"cs_status_1"=>"Ok",
"cs_status_2"=>"Fichier matchsettings sauvegardé",
"cs_status_3"=>"Serveur redémarré",
"cs_status_4"=>"Echec",

// MSF
// - Headers
"msf_parameter_header"=>"Paramètre",
"msf_value_header"=>"Valeur",
"msf_checkbox_header"=>"?",
"msf_trackname_header"=>"Nom du circuit",
"msf_trackauthor_header"=>"Auteur",
"msf_trackuid_header"=>"UID",
"msf_ml_header"=>"ML",
"msf_envir_header"=>"Envir.",
"msf_version_header"=>"TM",
"msf_msfilename_header"=>"Fichier matchsettings",
"msf_action_header"=>"Actions",
// - Options
"msf_gamemode"=>"Mode du jeu",
"msf_chattime"=>"Chat time (msec)",
"msf_roundspointslimit"=>"Limite de points pour le mode 'Round'",
"msf_roundsusenewrules"=>"Utiliser les nouvelles règles pour le mode 'Rounds'",
"msf_timeattacklimit"=>"Temps limite pour le mode 'TimeAttack' (msec)",
"msf_teampointslimit"=>"Limite de points pour le mode 'Team'",
"msf_teammaxpoints"=>"Points maximum par équipe pour le mode 'Team'",
"msf_teamusenewrules"=>"Utiliser les nouvelles règles pour le mode 'Team'",
"msf_laps_nblaps"=>"Forcer le nombre de tours pour le mode 'Laps'",
"msf_lapstimelimit"=>"Temps limite pour le mode 'Laps' (msec)",
"msf_randommaporder"=>"Mélanger la playlist",
// - Action
"msf_chkall"=>"Tout sélectionner",
"msf_chkalpine"=>"Alpine",
"msf_chkbay"=>"Bay",
"msf_chkcoast"=>"Coast",
"msf_chkisland"=>"Island",
"msf_chkrally"=>"Rally",
"msf_chkspeed"=>"Speed",
"msf_chkstadium"=>"Stadium",
"msf_chknull"=>"Supprimer tout",
"msf_savetofile_btn"=>"Sauvegarder",
"msf_srvrestart_desc"=>"Redémarrer le serveur avec les nouveaux paramètres. Attention: Tous les circuits et fichiers matchesettings.txt doivent être dans le repertoire ...\GameData\Tracks\ ou un sous-repertoire",
"msf_savetofile_desc"=>"Sauvegarder la configuration dans le fichier",

// CHOOSE TRACK
"ts_radio_header"=>"?",
"ts_track_header"=>"Nom du circuit",
"ts_envir_header"=>"Envir.",
"ts_length_header"=>"Longueur",
"ts_choosetrack_btn"=>"Choisir",
"ts_action_header"=>"Actions",
);


$tmos_viewer_it = array(

// MENU
"mnu_servers"=>"Serveurs",
"mnu_monitoring"=>"Monitoring",
"mnu_players"=>"Classement joueurs",
"mnu_tracks"=>"Circuits",
"mnu_clans"=>"Equipes",
"mnu_pages"=>"Pages: ",
"mnu_envir_!"=>"???",
"mnu_envir_*"=>"TOUT",
"mnu_envir_a"=>"STADIUM",
"mnu_envir_b"=>"ISLAND",
"mnu_envir_c"=>"BAY",
"mnu_envir_d"=>"COAST",
"mnu_envir_e"=>"ALPINE",
"mnu_envir_f"=>"RALLY",
"mnu_envir_g"=>"SPEED",

// SERVERLIST
"sl_header"=>"Serveurs",
"sl_online"=>"En ligne",
"sl_offline"=>"Hors ligne",

// MONITORING
"mon_header"=>"Monitoring",
"mon_game"=>"Jeu",
"mon_gamemode"=>"Mode",
"mon_players"=>"Joueurs",
"mon_spectators"=>"Spectateurs",
"mon_tracks"=>"Tous les circuits",
"mon_trackheader"=>"Circuit",
"mon_trackname"=>"Nom",
"mon_trackenvir"=>"Environnement",
"mon_trackauthor"=>"Auteur",
"mon_tracklaps"=>"Tours",
"mon_trackauthortime"=>"Temps de l'auteur",
"mon_trackbesttime"=>"Meilleur temps",
"mon_playernum"=>"#",
"mon_playername"=>"Joueur",
"mon_playerbesttime"=>"Meilleur temps",
"mon_playerlaps"=>"Tours accomplis",

// PLAYERLIST
"pl_header"=>"Classement joueurs",
"pl_totalplayers"=>"Total des joueurs",
"pl_totalawards"=>"Total des médailles",
"pl_findplayer"=>"Rechercher un joueur:",
"pl_findplayer_btn"=>"Rechercher",
"pl_num"=>"#",
"pl_player"=>"Joueur",
"pl_score"=>"Points",

// PLAYERINFO
"pi_header"=>"Joueur",
"pi_rank"=>"Classement",
"pi_afp"=>"Place moyenne",
"pi_finishedtracks"=>"Circuit fini",
"pi_firstplaces"=>"1er Place",
"pi_lastonline"=>"Derniere connexion",
"pi_aliases"=>"Pseudo",
"pi_num"=>"#",
"pi_track"=>"Circuit",
"pi_besttime"=>"Meilleur temps",
"pi_place"=>"Place",
"pi_award"=>"Récompenses",
"pi_ts"=>"Date",

// TRACKLIST
"tl_header"=>"Circuits",
"tl_totaltracks"=>"Total circuits",
"tl_totalauthors"=>"Total auteur",
"tl_findtrack"=>"Rechercher circuit:",
"tl_findtrack_btn"=>"Rechercher",
"tl_num"=>"#",
"tl_track"=>"Circuit",
"tl_author"=>"Auteur",
"tl_bestresult"=>"Temps",
"tl_player"=>"Meilleur joueur",
"tl_severalplayers"=>"Joueurs: {0}",

// TRACKINFO
"ti_header"=>"Circuit",
"ti_author"=>"Auteur",
"ti_timeauthor"=>"Temps Auteur",
"ti_timegold"=>"Temps Or",
"ti_timesilver"=>"Temps Argent",
"ti_timebronze"=>"Temps Bronze",
"ti_envir"=>"Environemment",
"ti_num"=>"#",
"ti_player"=>"Joueur",
"ti_bestresult"=>"Meilleur temps",
"ti_award"=>"Récompenses",
"ti_ts"=>"Date",

// CLANLIST
"cl_header"=>"Equipes",
"cl_totalclans"=>"Total équipes",
"cl_findclan"=>"Trouver une équipe:",
"cl_findclan_btn"=>"Rechercher",
"cl_num"=>"#",
"cl_clan"=>"Equipe",
"cl_score"=>"Points",

// CLANINFO   // new !!!
"ci_header"=>"Equipe",
"ci_mc"=>"Total membres",
"ci_num"=>"#",
"ci_player"=>"Joueur",
"ci_score"=>"Points",

// USERBAR
"ub_header"=>"Userbar",
"ub_links"=>"BBcode pour forums et liens HTML:",
"ub_null_err"=>"> Pas de userbar trouvée!",
"ub_gd_err"=>"> PHP GD Library non supporté!",

// PREFERENCES // new !!!
"pr_header"=>"Préférences",
"pr_colorscheme"=>"Couleur du thème",
"pr_language"=>"Langage de l'interface",
"pr_recperpage"=>"Records par page",
"pr_colortags"=>"Afficher les couleurs du pseudo",
"pr_save_btn"=>"Sauvegarder",
"pr_default_btn"=>"Défault",

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
"ub_ttt_server"=>"Serveur",
"ub_ttt_player"=>"Joueur",
"ub_ttt_rank"=>"Classement",
"ub_ttt_score"=>"Points",
"ub_ttt_separator"=>"  -  ",

"ub_ttt_oa_info"=>'{0} >> {1}',
"ub_ttt_oa_overall"=>"Tout",
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
