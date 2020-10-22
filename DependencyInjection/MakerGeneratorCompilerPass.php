<?php

namespace Tehla\ExtensionBundle\DependencyInjection;

use Tehla\ExtensionBundle\Component\MakerGenerator\UnprefixedGenerator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MakerGeneratorCompilerPass implements CompilerPassInterface
{

    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->getParameter('kernel.environment') !== 'dev') {
            return;
        }
        $config = $container->getExtensionConfig(Configuration::ROOT);
        if (isset($config[0]['component']['maker_generator'])
            && is_array($config[0]['component']['maker_generator'])) {

            if ($def = $container->findDefinition(UnprefixedGenerator::class)) {
                $def->addMethodCall(
                    'setNonAppNamespaces',
                    [$config[0]['component']['maker_generator']]
                );
            }
        }
    }
}
