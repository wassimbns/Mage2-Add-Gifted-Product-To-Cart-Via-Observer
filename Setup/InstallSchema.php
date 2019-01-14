<?php

namespace Farmasi\Catalog\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {

        $setup->startSetup();

        $tableName = $setup->getTable('salesrule');

        $columns = [
            'popin_description' => [
                'type' => Table::TYPE_TEXT,
                'nullable' => true,
                'comment' => 'Popin description text',
            ],
            'popin_sku' => [
                'type' => Table::TYPE_TEXT,
                'length' => 255,
                'nullable' => true,
                'comment' => 'Popin description text',
            ],
        ];

        $connection = $setup->getConnection();
        foreach ($columns as $name => $definition) {
            $connection->addColumn($tableName, $name, $definition);
        }

        $setup->endSetup();
    }

}
