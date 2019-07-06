#!/usr/bin/env php
<?php

require_once __DIR__.'/vendor/autoload.php';

use MaqeBot\MaqeCommand;
use Symfony\Component\Console\Application;

$maqeCommand = new MaqeCommand();

$app = new Application('MaqeBot', '1.0.0');
$app->add($maqeCommand);
$app->setDefaultCommand($maqeCommand->getName(), true);
$app->run();