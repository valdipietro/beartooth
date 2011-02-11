<?php
/**
 * sabretooth.ini.php
 * 
 * Defines initialization settings for sabretooth.
 * DO NOT edit this file, to override these settings use sabretooth.local.ini.php instead.  Any
 * changes in the local ini file will override the settings found here.
 * 
 * @author Patrick Emond <emondpd@mcmaster.ca>
 * @package sabretooth
 */

namespace sabretooth;
global $SETTINGS;

// always leave as false when running as production server
$SETTINGS[ 'general' ][ 'development_mode' ] = false;
$SETTINGS[ 'general' ][ 'script_name' ] = false === strrchr( $_SERVER['SCRIPT_NAME'], '/' )
                                        ? $_SERVER['SCRIPT_NAME']
                                        : substr( strrchr( $_SERVER['SCRIPT_NAME'], '/' ), 1 );

// system URLs
$SETTINGS[ 'url' ][ 'BASE' ] = ( $_SERVER["HTTPS"] ? 'https' : 'http' ).'://'.$_SERVER["HTTP_HOST"];
$SETTINGS[ 'url' ][ 'FULL' ] = $SETTINGS[ 'url' ][ 'BASE' ].$_SERVER["REQUEST_URI"];

// the location of sabretooth internal path
$SETTINGS[ 'path' ][ 'SABRETOOTH' ] = '/usr/local/lib/sabretooth';
$SETTINGS[ 'path' ][ 'API' ] = $SETTINGS[ 'path' ][ 'SABRETOOTH' ].'/api';
$SETTINGS[ 'path' ][ 'DOC' ] = $SETTINGS[ 'path' ][ 'SABRETOOTH' ].'/doc';
$SETTINGS[ 'path' ][ 'SQL' ] = $SETTINGS[ 'path' ][ 'SABRETOOTH' ].'/sql';
$SETTINGS[ 'path' ][ 'TPL' ] = $SETTINGS[ 'path' ][ 'SABRETOOTH' ].'/tpl';

// the location of libraries
$SETTINGS[ 'path' ][ 'ADODB' ] = '/usr/local/lib/adodb';
$SETTINGS[ 'path' ][ 'PHPAGI' ] = '/usr/local/lib/phpagi';
$SETTINGS[ 'path' ][ 'PHPEXCEL' ] = '/usr/local/lib/phpexcel';
$SETTINGS[ 'path' ][ 'TWIG' ] = '/usr/local/lib/twig';
$SETTINGS[ 'path' ][ 'JS' ] = 'js';
$SETTINGS[ 'path' ][ 'CSS' ] = 'css';

// javascript libraries
$SETTINGS[ 'version' ][ 'JQUERY' ] = '1.4.4';
$SETTINGS[ 'version' ][ 'JQUERY_UI' ] = '1.8.9';

$SETTINGS[ 'url' ][ 'JQUERY' ] = $SETTINGS[ 'url' ][ 'BASE' ].'/jquery';
$SETTINGS[ 'url' ][ 'JQUERY_UI' ] = $SETTINGS[ 'url' ][ 'JQUERY' ].'/ui';
$SETTINGS[ 'url' ][ 'JQUERY_PLUGINS' ] = $SETTINGS[ 'url' ][ 'JQUERY' ].'/plugins';
$SETTINGS[ 'path' ][ 'JQUERY_UI_THEMES' ] = '/var/www/jquery/ui/css';

$SETTINGS[ 'url' ][ 'JQUERY_JS' ] = 
  $SETTINGS[ 'url' ][ 'JQUERY' ].'/jquery-'.$SETTINGS[ 'version' ][ 'JQUERY' ].'.min.js';
$SETTINGS[ 'url' ][ 'JQUERY_UI_JS' ] =
  $SETTINGS[ 'url' ][ 'JQUERY_UI' ].'/js/jquery-ui-'.$SETTINGS[ 'version' ][ 'JQUERY_UI'].'.custom.min.js';

$SETTINGS[ 'url' ][ 'JQUERY_LAYOUT_JS' ] =
  $SETTINGS[ 'url' ][ 'JQUERY_PLUGINS' ].'/jquery.layout.min.js';
$SETTINGS[ 'url' ][ 'JQUERY_COOKIE_JS' ] =
  $SETTINGS[ 'url' ][ 'JQUERY_PLUGINS' ].'/jquery.cookie.js';
$SETTINGS[ 'url' ][ 'JQUERY_HOVERINTENT_JS' ] =
  $SETTINGS[ 'url' ][ 'JQUERY_PLUGINS' ].'/jquery.hoverIntent.min.js';
$SETTINGS[ 'url' ][ 'JQUERY_METADATA_JS' ] =
  $SETTINGS[ 'url' ][ 'JQUERY_PLUGINS' ].'/jquery.metadata.js';
$SETTINGS[ 'url' ][ 'JQUERY_FLIPTEXT_JS' ] =
  $SETTINGS[ 'url' ][ 'JQUERY_PLUGINS' ].'/jquery-mb.flipText.js';
$SETTINGS[ 'url' ][ 'JQUERY_EXTRUDER_JS' ] =
  $SETTINGS[ 'url' ][ 'JQUERY_PLUGINS' ].'/jquery-mb.extruder.js';
$SETTINGS[ 'url' ][ 'JQUERY_LOADING_JS' ] =
  $SETTINGS[ 'url' ][ 'JQUERY_PLUGINS' ].'/jquery.loading.min.js';
$SETTINGS[ 'url' ][ 'JQUERY_LOADING_OVERFLOW_JS' ] =
  $SETTINGS[ 'url' ][ 'JQUERY_PLUGINS' ].'/jquery.loading.overflow.min.js';
$SETTINGS[ 'url' ][ 'JQUERY_JEDITABLE_JS' ] =
  $SETTINGS[ 'url' ][ 'JQUERY_PLUGINS' ].'/jquery.jeditable.min.js';

// css files
$SETTINGS[ 'url' ][ 'JQUERY_UI_THEMES' ] = $SETTINGS[ 'url' ][ 'JQUERY_UI' ].'/css';

// the location of log files
$SETTINGS[ 'path' ][ 'LOG_FILE' ] = '/var/local/sabretooth/log';

// database settings
$SETTINGS[ 'db' ][ 'driver' ] = 'mysql';
$SETTINGS[ 'db' ][ 'server' ] = 'localhost';
$SETTINGS[ 'db' ][ 'username' ] = 'sabretooth';
$SETTINGS[ 'db' ][ 'password' ] = '';
$SETTINGS[ 'db' ][ 'database' ] = 'sabretooth';

// themes
$SETTINGS[ 'interface' ][ 'default_theme' ] = 'humanity';
?>
