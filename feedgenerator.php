<?php
ini_set('memory_limit', '9999999999');
set_time_limit(3600);
require_once(dirname(__FILE__) . '/../config/ProjectConfiguration.class.php');
$configuration = sfApplicationConfiguration::getApplicationConfiguration('frontend', 'dev', true);
//$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'dev', true);
sfContext::createInstance($configuration);
// Borra las dos líneas siguientes si no utilizas una base de datos
$databaseManager = new sfDatabaseManager($configuration);
$databaseManager->loadConfiguration();
sfContext::getInstance()->getConfiguration()->loadHelpers(array('I18N', 'Asset', 'Url', 'Tag'));

include 'shoopingfuncs.php';

$feed_generado = feedshooping();


