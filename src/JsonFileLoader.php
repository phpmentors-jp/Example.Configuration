<?php
namespace Example\Config;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Loader\FileLoader;

class JsonFileLoader extends FileLoader
{
    public function load($resource, $type = null)
    {
        $path = $this->locator->locate($resource);
        $config = ['blog' => ['user_blogs' => $this->loadFile($path)]];

        if (null === $config) {
            return;
        }

        $configuration = new BlogConfiguration();
        $processor = new Processor();
        $processedConfig = $processor->processConfiguration(
            $configuration,
            $config
        );

        return $processedConfig;
    }

    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'json' === pathinfo(
            $resource,
            PATHINFO_EXTENSION
        );
    }

    private function loadFile($path)
    {
        return json_decode(file_get_contents($path), true);
    }
}