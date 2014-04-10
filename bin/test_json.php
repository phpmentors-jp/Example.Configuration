<?php
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Loader\LoaderResolver;

use Example\Config\JsonFileLoader;

require_once __DIR__.'/../vendor/autoload.php';

$locator = new FileLocator(__DIR__.'/../config');

$loaderResolver = new LoaderResolver([new JsonFileLoader($locator)]);
$delegatingLoader = new DelegatingLoader($loaderResolver);

try {
    $config = $delegatingLoader->load('config.json');
    var_dump($config);
} catch (InvalidConfigurationException $e)
{
    echo "コンフィギュレーション構文エラー".PHP_EOL;
    echo $e->getMessage().PHP_EOL;
}
