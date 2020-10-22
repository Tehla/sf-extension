<?php

namespace Tehla\ExtensionBundle\Component\MakerGenerator;

use Tehla\ExtensionBundle\DependencyInjection\MakerGeneratorCompilerPass;
use Dedale\PumlBundle\Helper\MakerHelper;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\Util\ClassNameDetails;

class UnprefixedGenerator extends Generator
{
    /** @var  Generator */
    private $decorated;

    /** @var string[] */
    private $nonAppNamespaces = [];

    public function setDecorated(Generator $decorated)
    {
        $this->decorated = $decorated;
    }

    /**
     * @param array $nonAppNamespaces
     * @see MakerGeneratorCompilerPass
     */
    public function setNonAppNamespaces(array $nonAppNamespaces)
    {
        $this->nonAppNamespaces = $nonAppNamespaces;
    }

    public function createClassNameDetails(string $name, string $namespacePrefix, string $suffix = '', string $validationErrorMessage = ''): ClassNameDetails
    {
        foreach ($this->nonAppNamespaces as $nonAppNamespace) {
            if (strpos($namespacePrefix, $nonAppNamespace) !== false) {//use case : unwanted default prefix system from maker component
                $details = parent::createClassNameDetails($name, $namespacePrefix, $suffix, $validationErrorMessage);

                if (strpos($details->getFullName(), '\\', 0) !== false) {//use case : namespace starting with unwanted backslash
                    $details = new ClassNameDetails(
                        substr($details->getFullName(), 1),             //removing backslash
                        substr(MakerHelper::getNamespace($details), 1), //removing backslash
                        $suffix
                    );
                }

                return $details;
            }
        }

        return $this->decorated->createClassNameDetails($name, $namespacePrefix, $suffix, $validationErrorMessage);
    }


}