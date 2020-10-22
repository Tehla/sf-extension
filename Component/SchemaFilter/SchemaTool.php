<?php

namespace Tehla\ExtensionBundle\Component\SchemaFilter;

use Doctrine\Bundle\DoctrineBundle\Dbal\RegexSchemaAssetFilter;
use Doctrine\DBAL\Schema\SchemaDiff;
use Doctrine\ORM\EntityManagerInterface;
use \Doctrine\ORM\Tools\SchemaTool as BaseSchemaTool;


class SchemaTool extends BaseSchemaTool
{
    /** @var RegexSchemaAssetFilter */
    private $filter;

    public function __construct(EntityManagerInterface $em, RegexSchemaAssetFilter $filter)
    {
        parent::__construct($em);
        $this->filter = $filter;
    }

    /**
     * Cette méthode va parcourir les requêtes SQL générées
     * et filtrer toutes celles qui matchent
     * avec le doctrine.dbal.schema_filter
     * défini dans le doctrine.yaml
     *
     * @param array $classes
     * @param bool $saveMode
     * @return array
     */
    public function getUpdateSchemaSql(array $classes, $saveMode = false)
    {
        /**
         * Il serait sinon possible de réécrire la méthode getUpdateSchemaSql.
         * L'idée serait d'appliquer le même filtre, mais plus finement, sur les résultats du comparator (SchemaDiff)
         *
         * @see SchemaTool::getUpdateSchemaSql
         * @see SchemaDiff::$newTables
         * @see SchemaDiff::$changedTables
         * @see SchemaDiff::$removedTables
         */
        return array_filter(
            parent::getUpdateSchemaSql($classes, $saveMode),
            $this->filter
        );
    }
}

