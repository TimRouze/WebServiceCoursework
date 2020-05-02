<?php
/**
 * When this cript is called, the news are updated in function of the rss flux
 * It's designed to work as a stand alone
 */
require_once(__DIR__.'/config/Autoload.php');
require_once('../autoloadTask.php');

$newsUpdater = new NewsUpdater();
$newsUpdater->updateNews();



