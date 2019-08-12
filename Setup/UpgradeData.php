<?php
namespace Magenest\Rules\Setup;
use Magento\Framework\DB\DataConverter\SerializedToJson;
use Magenest\Rules\DB\DataConverter\ConvertJsontoSerialize;
use Magento\Framework\DB\FieldDataConverterFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
/**
 * Class UpgradeData
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * Field Data Converter Factory
     *
     * @var FieldDataConverterFactory
     */
    private $fieldDataConverterFactory;
    /**
     * UpgradeData constructor
     *
     * @param FieldDataConverterFactory $fieldDataConverterFactory
     */
    public function __construct(FieldDataConverterFactory $fieldDataConverterFactory)
    {
        $this->fieldDataConverterFactory = $fieldDataConverterFactory;
    }
    /**
     * {@inheritdoc}
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), "1.0.1", '<')) {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $productMetadata = $objectManager->get('Magento\Framework\App\ProductMetadataInterface');
            if (version_compare($productMetadata->getVersion(),'2.1.0') > 0)
                $this->convertSerializedDataToJson($setup);
            if (version_compare($productMetadata->getVersion(),'2.1.0') <= 0)
                $this->convertJsonDataToSerialize($setup);
        }
    }
    /**
     * Convert data for the atwix_sample_table.sample_config from serialized to JSON format
     *
     * @param ModuleDataSetupInterface $setup
     *
     * @return void
     */
    protected function convertSerializedDataToJson(ModuleDataSetupInterface $setup)
    {
        $tableName = 'magenest_rules';
        $identifierFieldName = 'id';
        $serializedFieldName = 'conditions_serialized';
        /** @var \Magento\Framework\DB\FieldDataConverter $fieldDataConverter */
        $fieldDataConverter = $this->fieldDataConverterFactory->create(SerializedToJson::class);
        $fieldDataConverter->convert(
            $setup->getConnection(),
            $setup->getTable($tableName),
            $identifierFieldName,
            $serializedFieldName
        );
    }

    protected function convertJsonDataToSerialize(ModuleDataSetupInterface $setup)
    {
        $tableName = 'magenest_rules';
        $identifierFieldName = 'id';
        $serializedFieldName = 'conditions_serialized';
        /** @var \Magento\Framework\DB\FieldDataConverter $fieldDataConverter */
        $fieldDataConverter = $this->fieldDataConverterFactory->create(ConvertJsontoSerialize::class);
        $fieldDataConverter->convert(
            $setup->getConnection(),
            $setup->getTable($tableName),
            $identifierFieldName,
            $serializedFieldName
        );
    }
}