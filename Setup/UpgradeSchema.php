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
        
        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('quote_item'),
                'is_gifted',
                [
                    'type' => Table::TYPE_SMALLINT,
                    'default' => 0,
                    'comment' => 'Gifted or Not'
                ]
            );
            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order_item'),
                'is_gifted',
                [
                    'type' => Table::TYPE_SMALLINT,
                    'comment' => 'Gifted or Not'
                ]
            );
        }

        $setup->endSetup();
    }

}
