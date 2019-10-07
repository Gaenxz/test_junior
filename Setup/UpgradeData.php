<?php
namespace Magenest\Rules\Setup;
use Magento\Framework\DB\DataConverter\SerializedToJson;
use Magenest\Rules\DB\DataConverter\ConvertJsontoSerialize;
use Magento\Framework\DB\FieldDataConverterFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Cache\Frontend\Pool;
/**
 * Class UpgradeData
 */
class UpgradeData implements UpgradeDataInterface
{
    private $cacheTypeList;

    private $cacheFrontendPool;
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
    public function __construct(FieldDataConverterFactory $fieldDataConverterFactory, TypeListInterface $cacheTypeList, Pool $cacheFrontendPool)
    {
        $this->cacheTypeList = $cacheTypeList;
        $this->cacheFrontendPool = $cacheFrontendPool;
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

        $paths_and_values = [
            'clock_config/clock/clock_title' => 'Clock',
            'clock_config/clock/clock_size' => 'S',
            'clock_config/clock/color_picker' => '#fa2af3',
            'clock_config/clock/text_color' => '#7bbd83',
        ];

        foreach ($paths_and_values as $path => $value)
        {
            $this->setClockConfig($setup,$path,$value);
        }
    }
    /**
     * Convert data for the atwix_sample_table.sample_config from serialized to JSON format
     *
     * @param ModuleDataSetupInterface $setup
     *
     * @return void
     */
    private function convertSerializedDataToJson(ModuleDataSetupInterface $setup)
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

    /**
     * @param ModuleDataSetupInterface $setup
     * @throws \Magento\Framework\DB\FieldDataConversionException
     */
    private function convertJsonDataToSerialize(ModuleDataSetupInterface $setup)
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

    /**
     * @param $setup
     * @param $path
     * @param $value
     */
    private function setClockConfig($setup, $path, $value)
    {
        $clockData = [
            'scope' => 'default',
            'scope_id' => 0,
            'path' => $path,
            'value' => $value,
        ];

        $setup->getConnection()->insertOnDuplicate($setup->getTable('core_config_data'), $clockData, ['value']);

        $types = ['layout','block_html'];
        foreach ($types as $type)
        {
            $this->cacheTypeList->cleanType($type);
        }
        foreach ($this->cacheFrontendPool as $cacheFrontend) {
            $cacheFrontend->getBackend()->clean();
        }
    }
}