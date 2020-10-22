<?php


namespace Tehla\ExtensionBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    const ROOT = 'Tehla_extension';

    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(self::ROOT);

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('component')->children()
                    ->booleanNode('schema_filter')->defaultFalse()->end()
                    ->booleanNode('maker_twig')->defaultFalse()->end()
                    ->arrayNode('maker_generator')->scalarPrototype()->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
