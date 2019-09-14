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
class SelectType extends AbstractSource
{
    /**#@+
     * Size values
     */
    const TYPE_round = 'round';
    const TYPE_square = 'square';
    const TYPE_other = 'other';

    /**
     * @return array
     */
    public static function getOptionArray()
    {
        return [
            self::TYPE_round => __('Type 1'),
            self::TYPE_square => __('Type 2'),
            self::TYPE_other => __('Type 3'),
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
