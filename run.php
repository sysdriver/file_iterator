<?php

require 'FileIterator.php';

$path = 'sample.txt';
$file = new FileIterator($path);
$file->next();
$file->next();
$file->next();
echo $file->key() . PHP_EOL;
echo $file->current() . PHP_EOL;
$file->seek(21589585);
echo $file->current() . PHP_EOL;
