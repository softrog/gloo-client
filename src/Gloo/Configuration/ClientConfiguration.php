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
        ->scalarNode('base_uri')->defaultNull()->end()
        ->arrayNode('headers')
          ->prototype('scalar')->end()
        ->end()
      ->end()
    ;

    return $treeBuilder;
  }

}
