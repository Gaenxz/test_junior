<?php
namespace Magenest\Rules\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Ui\Component\Form\Fieldset;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Element\Select;
use Magento\Ui\Component\Form\Element\DataType\Text;

class NewField extends AbstractModifier
{
    private $locator;

    public function __construct(
        LocatorInterface $locator
    ) {
        $this->locator = $locator;
    }
    public function modifyData(array $data)
    {
        return $data;
    }
    public function modifyMeta(array $meta)
    {
        $meta = array_replace_recursive($meta,
            [
                'newFields' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'label' => __('Custom Fieldset'),
                                'componentType' => Fieldset::NAME,
                                'dataScope' => 'data.product.newFields',
                                'collapsible' => true,
                                'required' => 0,
                                'sortOrder' => 1,
                            ],
                        ],
                    ],
                    'children' => [
                        'custom_field' => $this->getCustomField()
                    ],
                ]
            ]
        );
        return $meta;
    }

    public function getCustomField()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Custom Field'),
                        'componentType' => Field::NAME,
                        'formElement' => Select::NAME,
                        'dataScope' => 'enabled',
                        'dataType' => Text::NAME,
                        'sortOrder' => 10,
                        'options' => [
                            ['value' => '0', 'label' => __('Loc')],
                            ['value' => '1', 'label' => __('Rat')],
                            ['value' => '2', 'label' => __('La')],
                            ['value' => '3', 'label' => __('Dep')],
                            ['value' => '4', 'label' => __('Trai')],
                        ],
                    ],
                ],
            ],
        ];
    }
}