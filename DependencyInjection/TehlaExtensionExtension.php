<?php
namespace Tehla\ExtensionBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;


class TehlaExtensionExtension extends Extension implements ExtensionInterface
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $config =  $this->processConfiguration(new Configuration(), $configs);
        if (isset($config['component']) && is_iterable($config['component'])) {
            foreach ($config['component'] as $name => $status) {
                if ($container->getParameter('kernel.environment') !== 'dev' && strpos($name, 'maker', 0) !== false) {
                    continue;//les extensions liées au maker ne sont pas traitées en dehors de l'env de dev
                }

                if (!empty($status)) {
                    $loader->load($name . '.yaml');
                }
            }
        }
    }
}
