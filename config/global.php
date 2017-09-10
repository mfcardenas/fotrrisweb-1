<?php
/**
 * This file contains global configuration variables
 * Things like whether anyone can register.
 * 
 * Whether or not it's a secure (https) connection could
 * also go here...
 */

/**
 * These are the database login details
 */
define("DRIVER","mysql");
define("HOST", "localhost"); 			// The host you want to connect to. 
define("USER", "adminfotrris"); 			// The database username.
define("PASSWORD", "f0trr1s?"); 	// The database password. 
define("DATABASE", "fotrrisdb");             // The database name.
define("CHARSET", "utf-8");

/**
 * Who can register and what the default role will be
 * Values for who can register under a standard setup can be:
 *      any  == anybody can register (default)
 *      admin == members must be registered by an administrator
 *      root  == only the root user can register members
 * 
 * Values for default role can be any valid role, but it's hard to see why
 * the default 'member' value should be changed under the standard setup.
 * However, additional roles can be added and so there's nothing stopping
 * anyone from defining a different default.
 */
define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");

/**
 * Is this a secure connection?  The default is FALSE, but the use of an
 * HTTPS connection for logging in is recommended.
 * 
 * If you are using an HTTPS connection, change this to TRUE
 */
define("SECURE", FALSE);    // For development purposes only!!!!

#FORMAT INTERFACE DATE AND OTHER RESOURCES
define("CONTROLADOR_DEFECTO", "User");
define("ACCION_DEFECTO", "index");
define("KEY_DEFAUL","");
define("FORMAT_DATE", "d/m/Y");
define("FORMAT_DATE_CALENDAR", "dd/mm/yy");
define("FORMAT_DATE_DB", "Y-m-d");

define('DOCROOT', $_SERVER['DOCUMENT_ROOT'].'');

#FASES PROJECT FOTRRIS AUX
define('NAME_FASE_0','Abstract');
define('NAME_FASE_1','Goal');
define('NAME_FASE_2','Participants');
define('NAME_FASE_3','Solutions');
define('NAME_FASE_4','Elaboration');
define('NAME_FASE_5','');
define('NAME_FASE_6','');
define('NAME_FASE_7','');
define('NAME_FASE_8','');
define('NAME_FASE_9','');
define('NAME_FASE_10','');
define('NAME_FASE_11','');
define('NAME_FASE_12','');
define('NAME_FASE_13','');
define('NAME_FASE_14','');
define('NAME_FASE_15','');
define('DESC_FASE_0','Abstract');
define('DESC_FASE_1','Describe the aim of the project');
define('DESC_FASE_2','Working on different partipants');
define('DESC_FASE_3','Working on possibles solutions');
define('DESC_FASE_4','Process of the project');
define('DESC_FASE_5','');
define('DESC_FASE_6','');
define('DESC_FASE_7','');
define('DESC_FASE_8','');
define('DESC_FASE_9','');
define('DESC_FASE_10','');
define('DESC_FASE_11','');
define('DESC_FASE_12','');
define('DESC_FASE_13','');
define('DESC_FASE_14','');
define('DESC_FASE_15','');
define('PAD_CON', 'CON');
define('PAD_ABS', 'ABS');
define('PAD_REP', 'REP');

define('URL_SERVER_PAD', 'http://ingenias.fdi.ucm.es:3128');

