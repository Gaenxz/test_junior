<?php
/**
 * Created by PhpStorm.
 */
namespace Magenest\Rules\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

/**
 * Class Size
 * @package Magenest\Rules\Model\Config\Source
 */
class Size extends AbstractSource
{
    /**#@+
     * Size values
     */
    const SIZE_SMALL = 'S';
    const SIZE_NORMAL = 'N';
    const SIZE_BIG = 'B';

    /**
     * @return array
     */
    public static function getOptionArray()
    {
        return [
            self::SIZE_SMALL => __('Small'),
            self::SIZE_NORMAL => __('Normal'),
            self::SIZE_BIG => __('Big'),
        ];
    }

    /**
     * Retrieve option array with empty value
     *
     * @return string[]
     */
    public function getAllOptions()
    {
        $result = [];
        foreach (self::getOptionArray() as $index => $value) {
            $result[] = ['value' => $index, 'label' => $value];
        }

        return $result;
    }
}
