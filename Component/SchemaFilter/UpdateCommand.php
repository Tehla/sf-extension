<?php

namespace Tehla\ExtensionBundle\Component\SchemaFilter;

use Doctrine\Bundle\DoctrineBundle\Command\Proxy\UpdateSchemaDoctrineCommand as BaseUpdateSchemaDoctrineCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use \Doctrine\ORM\Tools\SchemaTool as BaseSchemaTool;

/**
 * Class SchemaFilteredUpdateCommand
 *
 * doctrine:schema:update wont modify tables defined in doctrine.dbal.schema_filter configuration
 *
 */
class UpdateCommand extends BaseUpdateSchemaDoctrineCommand
{
    /** @var SchemaTool */
    private $schemaTool;

    public function __construct(SchemaTool $schemaTool, string $name = null)
    {
        parent::__construct($name);
        $this->schemaTool = $schemaTool;
    }

    protected function executeSchemaCommand(InputInterface $input, OutputInterface $output, BaseSchemaTool $schemaTool, array $metadatas, SymfonyStyle $ui)
    {
        return parent::executeSchemaCommand($input, $output, $this->schemaTool, $metadatas, $ui);
    }
}
