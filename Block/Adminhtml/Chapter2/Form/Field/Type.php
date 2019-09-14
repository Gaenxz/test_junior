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
        $this->addColumn('customer_group', ['label' => __('Customer Group')]);
        $this->addColumn('clock_type', ['label' => __('Clock Type')]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Type');
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
            );

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
}