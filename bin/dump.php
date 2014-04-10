<?php
use Example\Config\BlogConfiguration;
use Symfony\Component\Config\Definition\Dumper\YamlReferenceDumper;

require_once __DIR__.'/../vendor/autoload.php';

$config = new BlogConfiguration();
$dumper = new YamlReferenceDumper();
echo $dumper->dump($config);