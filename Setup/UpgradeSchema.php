<?php

namespace Farmasi\Catalog\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * @codeCoverageIgnore
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '2.0.4', '<')) {
            $tableName = $setup->getTable('salesrule');
            $columns = [
                'popin_title' => [
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
        }

        if (version_compare($context->getVersion(), '2.0.7', '<')) {

            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order'),
                'arriere',
                [
                    'type' => Table::TYPE_TEXT,
                    'comment' => 'Arriérés des paiements'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order'),
                'penalty',
                [
                    'type' => Table::TYPE_TEXT,
                    'comment' => 'pinalités des paiements'
                ]
            );
            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order'),
                'ristourne',
                [
                    'type' => Table::TYPE_TEXT,
                    'comment' => 'ristournes des paiements'
                ]
            );
        }
        if (version_compare($context->getVersion(), '2.0.11', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('quote_item'),
                'is_gifted',
                [
                    'type' => Table::TYPE_SMALLINT,
                    'default' => 0,
                    'comment' => 'Cadeau ou Non'
                ]
            );
            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order_item'),
                'is_gifted',
                [
                    'type' => Table::TYPE_SMALLINT,
                    'comment' => 'Cadeau ou Non'
                ]
            );
        }

        $setup->endSetup();
    }

}
