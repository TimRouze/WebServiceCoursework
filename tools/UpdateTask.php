<?php
require_once(__DIR__.'/config/Autoload.php');
require_once('../autoloadTask.php');

$newsUpdater = new NewsUpdater();
$newsUpdater->updateNews();



