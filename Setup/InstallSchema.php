<?php
namespace Weverson83\Banner\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Weverson83\Banner\Model\ResourceModel\Banner;

/**
 * @deprecated Should use Magento 2.3 declarative schema
 * @see https://devdocs.magento.com/guides/v2.3/extension-dev-guide/declarative-schema/db-schema.html
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $table = $setup->getConnection()->newTable($setup->getTable(Banner::TABLE_NAME));

        $table
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'primary'  => true,
                    'nullable' => false,
                ]
            )
            ->addColumn(
                'content',
                Table::TYPE_TEXT,
                null,
                [
                    'unsigned' => true,
                    'nullable' => false,
                ]
            )
            ->addColumn(
                'enabled',
                Table::TYPE_BOOLEAN,
                1,
                [
                    'nullable' => false,
                    'default' => 1,
                ]
            )
            ->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                1,
                [
                    'nullable' => false,
                    'default' => Table::TIMESTAMP_INIT,
                ]
            )
            ->addColumn(
                'updated_at',
                Table::TYPE_TIMESTAMP,
                1,
                [
                    'nullable' => false,
                    'default' => Table::TIMESTAMP_INIT_UPDATE,
                ]
            )
            ;

        $setup->getConnection()->createTable($table);
    }
}
