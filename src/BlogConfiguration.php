<?php
namespace Example\Config;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Respect\Validation\Validator as v;

class BlogConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('blog');

        $rootNode
            ->children()
                ->arrayNode('user_blogs')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->prototype('array')
                    ->children()
                        ->scalarNode('blog_url')
                            ->info('設定したいブログのURL')
                            ->isRequired()
                            ->validate()
                                ->ifTrue(function ($value) {
                                    return !v::call(
                                        'parse_url',
                                        v::arr()->key('scheme', v::startsWith('http'))
                                            ->key('host',   v::domain())
                                    )->validate($value);
                                })
                                ->thenInvalid('ブログURLが無効: %s')
                            ->end()
                        ->end()
                        ->enumNode('permission')
                            ->info('publicなら公開、privateなら非公開')
                            ->values(['public', 'private'])
                            ->isRequired()
                        ->end()
                        ->arrayNode('can_be_edited_by')
                            ->info('編集権限を持つユーザ')
                            ->isRequired()
                            ->requiresAtLeastOneElement()
                            ->prototype('scalar')
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}