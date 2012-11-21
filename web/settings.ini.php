<?php
/**
 * settings.ini.php
 * 
 * Defines initialization settings for beartooth.
 * DO NOT edit this file, to override these settings use settings.local.ini.php instead.
 * Any changes in the local ini file will override the settings found here.
 */

global $SETTINGS;

// tagged version
$SETTINGS['general']['application_name'] = 'beartooth';
$SETTINGS['general']['version'] = '1.0.5';

// always leave as false when running as production server
$SETTINGS['general']['development_mode'] = false;

// the name of the cohort associated with this application
$SETTINGS['general']['cohort'] = 'default';

// the location of beartooth internal path
$SETTINGS['path']['APPLICATION'] = '/usr/local/lib/beartooth';

// the location of the Shift8 Asterisk library
$SETTINGS['path']['SHIFT8'] = '/usr/local/lib/shift8';

// the url of mastodon (set to NULL to disable mastodon support)
$SETTINGS['url']['MASTODON'] = NULL;

// the url of limesurvey
$SETTINGS['path']['LIMESURVEY'] = '/var/www/limesurvey';
$SETTINGS['url']['LIMESURVEY'] = '../limesurvey';

// additional javascript libraries
$SETTINGS['url']['JQUERY'] = '/jquery';
$SETTINGS['url']['JQUERY_PLUGINS'] = $SETTINGS['url']['JQUERY'].'/plugins';
$SETTINGS['url']['JQUERY_JSTREE_JS'] = $SETTINGS['url']['JQUERY_PLUGINS'].'/jsTree.js';

// database settings
$SETTINGS['db']['driver'] = 'mysql';
$SETTINGS['db']['server'] = 'localhost';
$SETTINGS['db']['username'] = 'beartooth';
$SETTINGS['db']['password'] = '';
$SETTINGS['db']['database'] = 'beartooth';
$SETTINGS['db']['prefix'] = '';

// audit database settings (false values use the limesurvey database settings)
$SETTINGS['audit_db']['enabled'] = false;
$SETTINGS['audit_db']['driver'] = false;
$SETTINGS['audit_db']['server'] = false;
$SETTINGS['audit_db']['username'] = false;
$SETTINGS['audit_db']['password'] = false;
$SETTINGS['audit_db']['database'] = false;
$SETTINGS['audit_db']['prefix'] = 'audit_';

// voip settings
$SETTINGS['voip']['enabled'] = false;
$SETTINGS['voip']['url'] = 'http://localhost:8088/mxml';
$SETTINGS['voip']['username'] = '';
$SETTINGS['voip']['password'] = '';
$SETTINGS['voip']['prefix'] = '';
$SETTINGS['voip']['xor_key'] = '';

// the directory to write recorded calls
// (must be an absolute path that the asterisk server's user has access to)
$SETTINGS['path']['VOIP_MONITOR'] = '/var/local/beartooth/monitor';
?>
