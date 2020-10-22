<?php

namespace Tehla\ExtensionBundle\Component\MakerTwig;

use Symfony\Bundle\MakerBundle\FileManager;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

class TwigFileManager extends FileManager
{
    /** @var  FileManager */
    private $decorated;

    public function setDecorated(FileManager $decorated)
    {
        $this->decorated = $decorated;
    }

    /**
     * @param string $templatePath
     * @param array $parameters
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @Todo : injecter un ( le ? ) service twig
     */
    public function parseTemplate(string $templatePath, array $parameters): string
    {
        $templateInfo = new \SplFileInfo($templatePath);
        if ($templateInfo->getExtension() === 'twig') {
            $loader = new ArrayLoader([
                $templateInfo->getRealPath() => file_get_contents($templatePath)
            ]);
            $twig = new Environment($loader);
            return $twig->render($templateInfo->getRealPath(), $parameters);
        }

        return parent::parseTemplate($templatePath, $parameters);
    }
}
