<?php

namespace Magenest\Rules\Block\Adminhtml\Chapter2\Advance;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Config\Model\Config\Backend\Serialized\ArraySerialized;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Customer\Model\ResourceModel\Group\Collection;

class Extend extends ArraySerialized
{
    protected $serializer;

    protected $customerGroup;

    public function __construct(SerializerInterface $serializer,Collection $customerGroup,\Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, ScopeConfigInterface $config, \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList, \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, array $data = [])
    {
        $this->serializer = $serializer;
        $this->customerGroup = $customerGroup;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    public function beforeSave()
    {
        $value = $this->getValue();
        if (is_array($value)) {
            unset($value['__empty']);
        }
        $this->setValue($value);
        return parent::beforeSave();
    }

    public function _afterLoad()
    {
        /** @var string $value */
        $value = $this->customerGroup->toOptionArray();
        if($value) {
            $value = $this->getCustomerGroupValue($value);
            $this->setValue($value);
        }
        return $this;
    }

    protected function getCustomerGroupValue($values)
    {
        $result = [];
        $count = 0;
        foreach ($values as $value)
        {
            $result[$count] = ['customer_group' => $value['value']];
            $count++;
        }
        return $result;
    }
}