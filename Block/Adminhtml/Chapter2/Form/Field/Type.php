<?php
namespace Magenest\Rules\Block\Adminhtml\Chapter2\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Customer\Model\ResourceModel\Group\Collection;
use Magento\Framework\Data\Form\Element\Factory;
use Magento\Backend\Block\Template\Context;
use Magenest\Rules\Model\Config\Source\SelectType;

/**
 * Class Ranges
 */
class Type extends AbstractFieldArray
{
    protected $customerGroup;

    protected $elementFactory;

    protected $selectype;

    protected $_template = 'Magenest_Rules::array.phtml';

    public function __construct(SelectType $selectType,Collection $customerGroup, Factory $elementFactory,Context $context, array $data = [])
    {
        parent::__construct($context, $data);
        $this->customerGroup = $customerGroup;
        $this->elementFactory = $elementFactory;
        $this->selectype = $selectType;
    }

    /**
     * Prepare rendering the new field by adding all the needed columns
     */
    protected function _prepareToRender()
    {
        $this->addColumn('customer_group', ['label' => __('Customer Group'), 'renderer' => $this->getRenderer()]);
        $this->addColumn('clock_type', ['label' => __('Clock Type'), 'renderer' => $this->getRenderer()]);
        $this->_addAfter = false;
        $this->_addButtonLabel = false;
    }

    public function renderCellTemplate($columnName)
    {
        if ($columnName == 'customer_group' && isset($this->_columns[$columnName])) {
            $options = $this->customerGroup->toOptionArray();;
            $element = $this->elementFactory->create('select');
            $element->setForm(
                $this->getForm()
            )->setName(
                $this->_getCellInputElementName($columnName)
            )->setHtmlId(
                $this->_getCellInputElementId('<%- _id %>', $columnName)
            )->setValues(
                $options
            )->setReadonly(true);
            return str_replace("\n", '', $element->getElementHtml());
        }
        if ($columnName == 'clock_type'
            && isset($this->_columns[$columnName])
        ) {
            $options = $this->selectype->getAllOptions();
            $element = $this->elementFactory->create('select');
            $element->setForm(
                $this->getForm()
            )->setName(
                $this->_getCellInputElementName($columnName)
            )->setHtmlId(
                $this->_getCellInputElementId('<%- _id %>', $columnName)
            )->setValues(
                $options
            );

            return str_replace("\n", '', $element->getElementHtml());
        }
        return parent::renderCellTemplate($columnName);
    }

    public function _prepareArrayRow(\Magento\Framework\DataObject $row)
    {
        $optionExtraAttr = [];
        $optionExtraAttr['option_' . 1]
            = 'selected="selected"';
        $optionExtraAttr['option_' . $this->getRenderer()
            ->calcOptionHash($row->getData('clock_type'))]
            = 'selected="selected"';
        $row->setData(
            'option_extra_attrs',
            $optionExtraAttr
        );
    }

    public function getRenderer()
    {
        $selectBlock = $this->getLayout()->createBlock(
            \Magento\Framework\View\Element\Html\Select::class,
            '',
            ['data' => ['is_render_to_js_template' => true]]
        );

        return $selectBlock;
    }
}