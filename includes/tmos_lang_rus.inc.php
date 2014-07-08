<?php
/*
   <dscr>RUS</dscr>
*/

$tmos_admin_it = array(

// MENU
"mnu_header"=>"TM Offline Stats",
"mnu_gs"=>"Общие настройки",
"mnu_db"=>"База данных",
"mnu_dbupd"=>"Обновление структуры",
"mnu_sl"=>"Регистрация серверов",
"mnu_sladd"=>"Добавление нового сервера",
"mnu_slmod"=>"Редактирование информации о сервере",
"mnu_ubl"=>"Userbars",
"mnu_ubladd"=>"Добавление нового userbar",
"mnu_ublmod"=>"Редактирование свойств userbar",
"mnu_msf"=>"Matchsettings файл",
"mnu_ts"=>"Выбор трассы",
"mnu_chk"=>"Проверка настроек",
"mnu_cs"=>"Серверы",
"mnu_csnull"=>"(нет)",

// COMMON
"com_errorprefix"=>"Ошибка: ",
"com_messageprefix"=>"> ",

// AUTORIZE
"az_authorize_header"=>"Авторизация",
"az_login_btn"=>"LOGIN",
"az_status_1"=>"Неправильный пароль!",

// GENERAL SETTINGS
// - Headers
"gs_db_header"=>"База данных",
"gs_interface_header"=>"Интерфейс",
"gs_parsing_header"=>"Расчет статистики",
"gs_admin_header"=>"Администрирование",
"gs_action_header"=>"Действия",
// - DB
"gs_dbhost"=>"Хост",
"gs_dbtype"=>"Тип базы",
"gs_dblogin"=>"Имя пользователя",
"gs_dbpassword"=>"Пароль",
"gs_dbname"=>"Имя базы данных",
"gs_dbhost_desc"=>"IP адрес сервера с базой данных. Примеры:<br>* 192.168.40.111:1433<br>* localhost",
"gs_dbtype_desc"=>"Тип СУБД для хранения статистики",
"gs_dblogin_desc"=>"Пользователь должен обладать правами на создание и редактирование таблиц",
"gs_dbpassword_desc"=>"Пароль пользователя",
"gs_dbname_desc"=>"База должна быть создана заранее",
// - Interface
"gs_defaultlanguage"=>"Язык интерфейса по умолчанию",
"gs_defaultcolorscheme"=>"Цветовая схема по умолчанию",
"gs_defaultrecperpage"=>"Кол-во записей на странице по умолчанию",
"gs_javascript"=>"JavaScript",
"gs_servertimeout"=>"Timeout сервера",
"gs_showsingleserver"=>"Один сервер",
"gs_showmonitoring"=>"Вкладка мониторинг",
"gs_showclans"=>"Вкладка команды",
"gs_showuserbars"=>"Userbars",
"gs_showpreferences"=>"Настройки",
"gs_showlinks"=>"Ссылки",
"gs_showdownloads"=>"Загрузки",
"gs_htmlcache"=>"HTML кэш",
"gs_htmlcache_choice_1"=>"Главные страницы",
"gs_htmlcache_choice_2"=>"Все страницы",
"gs_htmlcache_choice_3"=>"Запретить",
"gs_gzipcompression"=>"gZIP компрессия",
"gs_defaultlanguage_desc"=>"Язык выбирается для самой статистики, панели администратора и userbar'ов",
"gs_defaultcolorscheme_desc"=>"Настройки цветов отображения статистики",
"gs_defaultrecperpage_desc"=>"Максимальное количество записей в каждой из таблиц статистики, которое отображается на одной странице. Остальные записи переносятся на следующие страницы",
"gs_javascript_desc"=>"JavaScript используется для подсветки строки таблицы под курсором мышы для более удобного просмотра",
"gs_servertimeout_desc"=>"Если нет ответа от сервера игры в течении данного промежутка времени (сек), сервер помечается как offline",
"gs_showsingleserver_desc"=>"(Не) показывать вкладку 'Серверы', если зарегестрирован только один игровой сервер",
"gs_showmonitoring_desc"=>"(Не) показывать вкладку 'Мониторинг'",
"gs_showclans_desc"=>"(Не) показывать вкладку 'Команды'",
"gs_showuserbars_desc"=>"(Не) показывать 'Userbars'",
"gs_showpreferences_desc"=>"(Не) показывать кнопку 'Настройки'",
"gs_showlinks_desc"=>"(Не) показывать ссылки в nickname'ах игроков",
"gs_showdownloads_desc"=>"(Не) показывать кнопку 'Download'",
"gs_htmlcache_desc"=>"Кэшировать полученные php скриптом html страницы для ускорения",
"gs_gzipcompression_desc"=>"Сжимать html страницы перед отправкой пользователю для уменьшения траффика",
// - Parsing
"gs_minclansize"=>"Размер команды",
"gs_minclansize_desc"=>"Минимальное количество членов команды",
"gs_medalsscore"=>"Очки за медали",
"gs_medalsscore_desc"=>"Очки за получение авторской/золотой/серебрянной/бронзовой медали и за прохождение трассы",
// - Admin
"gs_adminpassword"=>"Пароль администратора",
"gs_adminpassword_desc"=>"Пароль на админский интерфейс, вводится при входе",
// - Action
"gs_savecfg_btn"=>"СОХРАНИТЬ",
"gs_savecfg_desc"=>"Сохранить настройки в файл",
// - Errors
"gs_doublequotes_err"=>"Не используйте двойные кавычки",
"gs_defaultrecperpage_err"=>"Параметр 'Кол-во записей на странице по умолчанию' должен быть целым числом >= 10",
"gs_servertimeout_err"=>"Параметр 'Timeout сервера' должен быть целым числом > 0",
"gs_minclansize_err"=>"Параметр 'Размер команды' должен быть целым числом >= 2",
"gs_medalsscore_err"=>"Параметры 'Очки за медали' должены быть целыми числами >= 0",
// - Operation results
"gs_status_1"=>"Настройки сохранены",
"gs_status_2"=>"Не удалось сохранить настройки, возможно, файл 'tmos_config.php' не доступен для записи (read only)",

// DATABASE
// - Headers
"db_status_header"=>"Статус базы данных",
"db_table_header"=>"Таблица",
"db_tablestate_header"=>"Состояние",
"db_tablerecords_header"=>"Записи",
"db_action_header"=>"Действия",
"db_updinfo_header"=>"Информация",
// - DB
"db_dbstatus_1"=>"Ok",
"db_dbstatus_2"=>"Не включена поддержка СУБД в PHP",
// - Tables
"db_tablestatus_1"=>"Ok",
"db_tablestatus_2"=>"Неправильный формат",
"db_tablestatus_3"=>"Не найдена",
// - Update
"db_updinfo_text"=>"Будет произведено обновление структуры базы данных <b>{0} => {1}</b>. Последовательность действий:<br>* Старые таблицы tmos_xxx переименовываются в bk_tmos_xxx<br>* Создаются новые таблицы tmos_xxx в формате {1}<br>* Переносятся данные из таблиц bk_tmos_xxx => tmos_xxx<br>* Выполняется парсинг лог-файлов всех серверов для корректного отображения статистики",
"db_support_err"=>"Обновление с версии {0} не поддерживается",
// - Action
"db_updatedb_btn"=>"ОБНОВИТЬ",
"db_createtables_btn"=>"СОЗДАТЬ",
"db_droptables_btn"=>"УДАЛИТЬ",
"db_resetdata_btn"=>"ОБНУЛИТЬ",
"db_cleardata_btn"=>"ОЧИСТИТЬ",
"db_cancel_btn"=>"ОТМЕНА",
"db_updatedb_desc"=>"Обновить формат таблиц базы данных",
"db_createtables_desc"=>"Создать таблицы в базе данных",
"db_droptables_desc"=>"Удалить таблицы из базы данных",
"db_resetdata_desc"=>"Удалить все записи кроме записей о серверах",
"db_cleardata_desc"=>"Удалить все записи из таблиц",
"db_cancel_desc"=>"Не выполнять обновление",
// - Operation results
"db_status_1"=>"Модификация базы данных завершена успешно",
"db_status_2"=>"Операция отменена",

// SERVERS
// - Headers
"sl_status_header"=>"Статус базы данных",
"sl_servers_header"=>"Серверы",
"sl_action_header"=>"Действия",
"sl_add_header"=>"Настройки нового сервера",
"sl_mod_header"=>"ID сервера:",
// - Servers
"sl_ip"=>"IP адрес",
"sl_server"=>"Имя сервера",
"sl_id"=>"ID сервера",
"sl_game"=>"Игра",
"sl_login"=>"Имя администратора",
"sl_password"=>"Пароль администратора",
"sl_logfiles"=>"Лог-файлы",
"sl_trackdirs"=>"Директории с трассами",
"sl_ip_desc"=>"Формат адреса 'ip:xmlrpcport'. Примеры:<br>* 192.168.40.111:5000<br>* localhost:5001",
"sl_server_desc"=>"Отображается в заголовках таблиц и на userbar'ах статистики",
"sl_game_desc"=>"Контекстные картинки и userbar'ы отображаются в соответсвии с этой настройкой",
"sl_login_desc"=>"Должно совпадать с именем пользователя с правами ServerAdmin в dedicated.cfg файле сервера",
"sl_password_desc"=>"",
"sl_logfiles_desc"=>"Пути к лог-файлам выделенного сервера игры (находятся в папке './Logs' сервера). Несколько лог-файлов могут быть указаны через символ ';'.<br>Примеры:<br>* c:\\tmn\Logs\GameLog..txt<br>* /usr/home/myaccount/tmn/Logs/GameLog..txt<br>* &lt;dir&gt;\GameLog.1.txt;&lt;dir&gt;\GameLog.2.txt;&lt;dir&gt;\GameLog.3.txt",
"sl_trackdirs_desc"=>"Директории с '.gbx' файлами трасс. Несколько директорий могут быть указаны через символ ';'.<br>Примеры:<br>* c:\\tmn\GameData\Tracks<br>* /usr/home/myaccount/tmn/GameData/Tracks<br>* &lt;dir1&gt;/Tracks;&lt;dir2&gt;/Tracks;&lt;dir3&gt;/Tracks",
// - Action
"sl_addserver_btn"=>"ДОБАВИТЬ",
"sl_deleteservers_btn"=>"УДАЛИТЬ",
"sl_modifyservers_btn"=>"ИЗМЕНИТЬ",
"sl_cancel_btn"=>"ОТМЕНА",
"sl_addserver_desc"=>"Зарегистрировать новый сервер",
"sl_deleteservers_desc"=>"Удалить выделенные серверы",
"sl_modifyservers_desc"=>"Изменить данные для выделенных серверов",
"sl_cancel_desc"=>"Отменить изменения",
// - Errors
"sl_doublequotes_err"=>"Не используйте двойные кавычки",
// - Operation results
"sl_status_1"=>"Операция отменена",
"sl_status_2"=>"Операция завершена успешно",
"sl_status_3"=>"Серверы не выбраны",

// USERBARS             /////////////// new !!!!!!!!!!!!!!!!!!!!!
// - Headers
"ub_status_header"=>"Статус GD",
"ub_userbars_header"=>"Userbars",
"ub_action_header"=>"Действия",
"ub_add_header"=>"Настройки нового userbar",
"ub_mod_header"=>"Userbar ID:",
// - Data
"ub_gdstatus_1"=>"Ok",
"ub_gdstatus_2"=>"Библиотека PHP GD не поддерживается",
"ub_gdstatus_3"=>"Библиотека PHP FreeType не поддерживается",
"ub_id"=>"Userbar ID",
"ub_game"=>"Игра",
"ub_font1"=>"Шрифт 1 / цвет / размер",
"ub_font2"=>"Шрифт 2 / цвет / размер",
"ub_imgfile"=>"Файл с картинкой (.png)",
"ub_type"=>"Тип",
// - Action
"ub_adduserbar_btn"=>"ДОБАВИТЬ",
"ub_adduserbar_desc"=>"Добавить новый userbar",
"ub_deleteuserbars_btn"=>"УДАЛИТЬ",
"ub_deleteuserbars_desc"=>"Удалить выделенные userbar'ы",
"ub_modifyuserbars_btn"=>"ИЗМЕНИТЬ",
"ub_modifyuserbars_desc"=>"Изменить настройки выделенных userbar'ов",
"ub_cancel_btn"=>"ОТМЕНА",
"ub_cancel_desc"=>"Отменить изменения",
// - Errors
"ub_imgfile_err"=>"Картинка userbar'а должна быть в формате .png, ширина <= 600, высота <= 100, размер <= 100Kb",
"ub_font1_err"=>"Шрифт 1 не найден",
"ub_size1_err"=>"Размер шрифта 1 должен быть целым числом >= 1",
"ub_color1_err"=>"Цвет шрифта 1 должен быть задан в формате XXXXXX, где X - любое шеснадцатиричное число (0-9, a-f)",
"ub_font2_err"=>"Шрифт 2 не найден",
"ub_size2_err"=>"Размер шрифта 2 должен быть целым числом >= 1",
"ub_color2_err"=>"Цвет шрифта 2 должен быть задан в формате XXXXXX, где X - любое шеснадцатиричное число (0-9, a-f)",
// - Operation results
"ub_status_1"=>"Операция отменена",
"ub_status_2"=>"Операция завершена успешно",
"ub_status_3"=>"Какая-то ошибка",
"ub_status_4"=>"Userbar'ы не выбраны",

// CHECK
// - Headers
"chk_php_header"=>"PHP",
"chk_db_header"=>"База данных",
"chk_tables_header"=>"Таблицы",
"chk_servers_header"=>"Серверы",
// - Inf
"chk_phpver"=>"Версия",
"chk_phpxml"=>"XML",
"chk_phpgd"=>"GD",
"chk_phpft"=>"FreeType",
"chk_phpcache"=>"Кэш",
"chk_phpzlib"=>"ZLib",
"chk_phpmetime"=>"max_execution_time",
"chk_phpallowurl"=>"allow_url_fopen",
"chk_phpmemlimit"=>"memory_limit",
"chk_phpver_desc"=>"Версия PHP должна быть 4.4.0 или выше",
"chk_phpxml_desc"=>"Поддержка XML",
"chk_phpgd_desc"=>"Библиотека GD необходима для использования userbar'ов",
"chk_phpft_desc"=>"Библиотека FreeType необходима для использования TrueType шрифтов c userbar'ами",
"chk_phpcache_desc"=>"Тест записи кэш-файла",
"chk_phpzlib_desc"=>"Библиотека ZLib необходима для использования сжатия html страниц",
"chk_phpmetime_desc"=>"Максимальное время выполнения скрипта. Если в PHP включена опция safe_mode = On, скрипты не могут устанавливать эту переменную, необходимо сделать это вручную",
"chk_phpallowurl_desc"=>"Если эта настройка установлена в Off, скрипты не могут обрабатывать файлы на file:// серверах, могут только локальные",
"chk_phpmemlimit_desc"=>"Максимальное количество памяти, которое может использовать PHP скрипт. Рекомендуется как минимум 32MB",
"chk_dbtype"=>"Тип СУБД",
"chk_dbconnect"=>"Соединение",
"chk_dbver"=>"Версия",
"chk_logfiles"=>"Лог-файлы",
"chk_trackdirs"=>"Директории с трассами",
"chk_dbtype_desc"=>"",
"chk_dbconnect_desc"=>"Доступность базы данных",
"chk_dbver_desc"=>"Версия СУБД должна быть:<br>* 4.1.0 или выше - MySQL<br>* 8.0 или выше - PostgreSQL<br>* 8.0 (2000) или выше - Microsoft SQL",
// - Check results
"chk_statusok"=>"Ok",
"chk_statusfailed"=>"Ошибка",
"chk_srvonline"=>"Online",
"chk_srvoffline"=>"Offline",

// CURRENT SERVER
// - Headers
"cs_inf_header"=>"Информация",
"cs_parsing_header"=>"Разбор лог-файлов",
"cs_action_header"=>"Действия",
"cs_msf_header"=>"Matchsettings файл / Трассы",
// - Inf
"cs_status"=>"Статус",
"cs_totalplayers"=>"Игроки",
"cs_totaltracks"=>"Всего трасс",
"cs_currtrack"=>"Текущая трасса",
// - Parsing
"cs_parselast"=>"Последний разбор",
"cs_logfiles"=>"Лог-файлы",
// - Tracks
"cs_trackdirs"=>"Директории с трассами",
// - Action
"cs_refresh_btn"=>"ОБНОВИТЬ",
"cs_parse_btn"=>"РАЗОБРАТЬ",
"cs_createmsf_btn"=>"MSF",
"cs_restarttrack_btn"=>"RESTART",
"cs_nexttrack_btn"=>"СЛЕДУЮЩИЙ",
"cs_choosetrack_btn"=>"ВЫБРАТЬ",
"cs_refresh_desc"=>"Обновить информацию о сервере",
"cs_restarttrack_desc"=>"Перезагрузить текущую трассу на сервере",
"cs_nexttrack_desc"=>"Загрузить следующую трассу из matchsettings файла",
"cs_choosetrack_desc"=>"Выбрать и загрузить трассу из списка",
"cs_cfsp_desc"=>"Продолжить с сохраненной позиции",
"cs_parse_desc"=>"Считать новые результаты из лог-файлов и записать в базу данных",
"cs_createmsf_desc"=>"Создать новый matchsettings файл",
// - Errors
"cs_unknown_err"=>"???",
"cs_ip_err"=>"Неправильный IP адрес",
"cs_offline_err"=>"Сервер offline",
"cs_authenticate_err"=>"Неправильное имя пользователя / пароль",
"cs_choosetrack_err"=>"Трасса не выбрана",
"cs_servers_err"=>"Сервер(ы) не найден",
"cs_skipped_err"=>"Пропущен",
"cs_trackdirs_err"=>"Директория(и) с трассами не найдена или не доступна для чтения",
"cs_logfiles_err"=>"Лог-файл(ы) не найден или не доступен для чтения",
"cs_msfwrite_err"=>"Не удалось сохранить matchsettings файл. Возможные причины:<br>* недостаточно прав<br>* директория не существует<br>* имя файла содержит недопустимые символы ('*', '?' ...)",
"cs_msftracks_err"=>"Трассы не выбраны",
"cs_msfrestartserver_err"=>"Не удалось перезапустить сервер",
// - Operation results
"cs_status_1"=>"Ok",
"cs_status_2"=>"Matchsettings файл сохранён",
"cs_status_3"=>"Сервер перезапущен",
"cs_status_4"=>"Неудача",

// MSF
// - Headers
"msf_parameter_header"=>"Параметр",
"msf_value_header"=>"Значение",
"msf_checkbox_header"=>"?",
"msf_trackname_header"=>"Трасса",
"msf_trackauthor_header"=>"Автор",
"msf_trackuid_header"=>"UID",
"msf_ml_header"=>"ML",
"msf_envir_header"=>"Окруж.",
"msf_version_header"=>"TM",
"msf_msfilename_header"=>"Matchsettings файл",
"msf_action_header"=>"Действия",
// - Options
"msf_gamemode"=>"Режим игры",
"msf_chattime"=>"Время чата (мсек)",
"msf_roundspointslimit"=>"Ограничение очков для режима 'Rounds'",
"msf_roundsusenewrules"=>"Использовать новые правила в режиме 'Rounds'",
"msf_timeattacklimit"=>"Ограничение времени для режима 'TimeAttack' (мсек)",
"msf_teampointslimit"=>"Ограничение очков для режима 'Team'",
"msf_teammaxpoints"=>"Максимально количество очков для режима 'Team'",
"msf_teamusenewrules"=>"Использовать новые правила в режиме 'Team'",
"msf_laps_nblaps"=>"Количество кругов для режима 'Laps'",
"msf_lapstimelimit"=>"Ограничение времени для режима 'Laps' (мсек)",
"msf_randommaporder"=>"Трассы в случайном порядке",
// - Action
"msf_chkall"=>"Выбрать всё",
"msf_chkalpine"=>"Alpine",
"msf_chkbay"=>"Bay",
"msf_chkcoast"=>"Coast",
"msf_chkisland"=>"Island",
"msf_chkrally"=>"Rally",
"msf_chkspeed"=>"Speed",
"msf_chkstadium"=>"Stadium",
"msf_chknull"=>"Убрать всё",
"msf_savetofile_btn"=>"СОХРАНИТЬ",
"msf_srvrestart_desc"=>"Перезапустить сервер с новыми настройками. Предупрежедение: все файлы трасс и сам msf файл должны находится в директории ...\GameData\Tracks\ сервера или в под-директориях!",
"msf_savetofile_desc"=>"Сохранить настройки в файл",

// CHOOSE TRACK
"ts_radio_header"=>"?",
"ts_track_header"=>"Трасса",
"ts_envir_header"=>"Окружение",
"ts_length_header"=>"Длина",
"ts_choosetrack_btn"=>"ВЫБРАТЬ",
"ts_action_header"=>"Действия",
);


$tmos_viewer_it = array(

// MENU
"mnu_servers"=>"Серверы",
"mnu_monitoring"=>"Мониторинг",
"mnu_players"=>"Рейтинг игроков",
"mnu_tracks"=>"Трассы",
"mnu_clans"=>"Команды",
"mnu_pages"=>"Страницы: ",
"mnu_envir_!"=>"???",
"mnu_envir_*"=>"OVERALL",
"mnu_envir_a"=>"STADIUM",
"mnu_envir_b"=>"ISLAND",
"mnu_envir_c"=>"BAY",
"mnu_envir_d"=>"COAST",
"mnu_envir_e"=>"ALPINE",
"mnu_envir_f"=>"RALLY",
"mnu_envir_g"=>"SPEED",

// SERVERLIST
"sl_header"=>"Серверы",
"sl_online"=>"Online",
"sl_offline"=>"Offline",

// MONITORING
"mon_header"=>"Мониторинг",
"mon_game"=>"Игра",
"mon_gamemode"=>"Режим",
"mon_players"=>"Игроки",
"mon_spectators"=>"Зрители",
"mon_tracks"=>"Всего трасс",
"mon_trackheader"=>"Трасса",
"mon_trackname"=>"Наименование",
"mon_trackenvir"=>"Окружение",
"mon_trackauthor"=>"Автор",
"mon_tracklaps"=>"Круги",
"mon_trackauthortime"=>"Авторское время",
"mon_trackbesttime"=>"Лучшее время",
"mon_playernum"=>"#",
"mon_playername"=>"Игрок",
"mon_playerbesttime"=>"Лучшее время",
"mon_playerlaps"=>"Кругов завершено",

// PLAYERLIST
"pl_header"=>"Рейтинг игроков",
"pl_totalplayers"=>"Всего игроков",
"pl_totalawards"=>"Всего наград",
"pl_findplayer"=>"Найти игрока:",
"pl_findplayer_btn"=>"НАЙТИ",
"pl_num"=>"#",
"pl_player"=>"Игрок",
"pl_score"=>"Очки",

// PLAYERINFO
"pi_header"=>"Игрок",
"pi_rank"=>"Ранг",
"pi_afp"=>"Усредненная позиция",
//"pi_afp"=>"Средн. поз. на финише",
"pi_finishedtracks"=>"Трасс пройдено",
"pi_firstplaces"=>"Первые места",
"pi_lastonline"=>"Последний online",
"pi_aliases"=>"Имена",
"pi_num"=>"#",
"pi_track"=>"Трасса",
"pi_besttime"=>"Лучш. время",
"pi_place"=>"Место",
"pi_award"=>"Награда",
"pi_ts"=>"Дата",

// TRACKLIST
"tl_header"=>"Трассы",
"tl_totaltracks"=>"Всего трасс",
"tl_totalauthors"=>"Всего авторов",
"tl_findtrack"=>"Найти трассу:",
"tl_findtrack_btn"=>"НАЙТИ",
"tl_num"=>"#",
"tl_track"=>"Трасса",
"tl_author"=>"Автор",
"tl_bestresult"=>"Время",
"tl_player"=>"Лучший игрок",
"tl_severalplayers"=>"Игроки: {0}",

// TRACKINFO
"ti_header"=>"Трасса",
"ti_author"=>"Автор",
"ti_timeauthor"=>"Авторское время",
"ti_timegold"=>"Золото",
"ti_timesilver"=>"Серебро",
"ti_timebronze"=>"Бронза",
"ti_envir"=>"Окружение",
"ti_num"=>"#",
"ti_player"=>"Игрок",
"ti_bestresult"=>"Лучшее время",
"ti_award"=>"Награда",
"ti_ts"=>"Дата",

// CLANLIST
"cl_header"=>"Команды",
"cl_totalclans"=>"Всего команд",
"cl_findclan"=>"Найти команду:",
"cl_findclan_btn"=>"НАЙТИ",
"cl_num"=>"#",
"cl_clan"=>"Команда",
"cl_score"=>"Очки",

// CLANINFO   // new !!!
"ci_header"=>"Команда",
"ci_mc"=>"Всего участников",
"ci_num"=>"#",
"ci_player"=>"Игрок",
"ci_score"=>"Очки",

// USERBAR
"ub_header"=>"Userbar",
"ub_links"=>"BB Код для форумов и ссылка для HTML:",
"ub_null_err"=>"> Файлы userbar'ов не найдены!",
"ub_gd_err"=>"> Библиотека PHP GD не поддерживается!",

// PREFERENCES // new !!!
"pr_header"=>"Настройки",
"pr_colorscheme"=>"Цветовая схема",
"pr_language"=>"Язык интерфейса",
"pr_recperpage"=>"Записей на страницу",
"pr_colortags"=>"Показывать цветовые тэги",
"pr_save_btn"=>"СОХРАНИТЬ",
"pr_default_btn"=>"УМОЛЧАНИЕ",

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
"ub_ttt_server"=>"Сервер",
"ub_ttt_player"=>"Игрок",
"ub_ttt_rank"=>"Ранг",
"ub_ttt_score"=>"Очки",
"ub_ttt_separator"=>"  -  ",

"ub_ttt_oa_info"=>'{0} >> {1}',
"ub_ttt_oa_overall"=>"Overall",
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
