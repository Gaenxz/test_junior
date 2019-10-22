<?php
namespace Magenest\CustomerAttributes\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Eav\Setup\EavSetupFactory;

class UpgradeData implements UpgradeDataInterface
{
    protected $eavSetupFactory;

    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.2') < 0) {
            /* @var \Magento\Eav\Setup\EavSetup $eavSetup */
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'custom_customer_group',
                [
                    'type' => 'text',
                    'label' => 'Customer Group',
                    'input' => 'text',
//                    'source' => 'Magenest\Rules\Model\Category\Attribute\Source\Custom',
//                    'backend' => 'Magenest\Rules\Model\Category\Attribute\Backend\Custom',
                    'required' => true,
                    'sort_order' => 15,
                    'global' => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_GLOBAL,
                    'used_in_product_listing' => false,
                    'visible_on_front' => false,
                    'is_used_in_grid' => true,
                ]
            );
        }
        $setup->endSetup();
    }
}