<?php

namespace Magenest\Rules\Block\Chapter1;

use Magento\Framework\View\Element\Template;
use Magenest\Rules\Model\ResourceModel\Rules\CollectionFactory;

Class Cau4 extends Template
{
    protected $collectionFactory;

    public function __construct(CollectionFactory $collectionFactory,Template\Context $context, array $data = [])
    {
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $data);
    }

    public function loadTable()
    {
        $ruleCollection = $this->collectionFactory->create();
        $ruleCollection->addFieldToFilter('status',["eq" => "pending"]);
        $data = $ruleCollection->getData();
        return $data;
    }
}