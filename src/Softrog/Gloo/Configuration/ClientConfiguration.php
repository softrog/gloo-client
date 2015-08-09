<?php

namespace Softrog\Gloo\Configuration;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class ClientConfiguration implements ConfigurationInterface
{

  /**
   * Define valid configuration for a client
   *
   * @return TreeBuilder
   */
  public function getConfigTreeBuilder()
  {
    $treeBuilder = new TreeBuilder();
    $rootNode = $treeBuilder->root('configuration');

    $rootNode
      ->children()
        ->arrayNode('base_uri')
          ->beforeNormalization()
            ->always()
              ->then(function ($uri) {
                $components = parse_url($uri);
                if (array_key_exists('path', $components)) {
                  $components['path'] = rtrim($components['path'],'/').'/';
                }
                return $components;
              })
          ->end()
          ->children()
            ->scalarNode('user')->defaultNull()->end()
            ->scalarNode('pass')->defaultNull()->end()
            ->scalarNode('scheme')->defaultNull()->end()
            ->scalarNode('host')->defaultNull()->end()
            ->scalarNode('port')->defaultNull()->end()
            ->scalarNode('path')->defaultValue('/')->end()
            ->scalarNode('query')->defaultNull()->end()
            ->scalarNode('fragment')->defaultNull()->end()
          ->end()
        ->end()
        ->arrayNode('headers')
          ->prototype('scalar')->end()
        ->end()
        ->integerNode('max_tries')->defaultValue(10)->end()
      ->end()
    ;

    return $treeBuilder;
  }

}
