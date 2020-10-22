<?php

namespace  Tehla\ExtensionBundle;

use Tehla\ExtensionBundle\DependencyInjection\MakerGeneratorCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TehlaExtensionBundle extends \Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new MakerGeneratorCompilerPass());
    }
}