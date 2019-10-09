<?php

namespace Magenest\Rules\Controller\Chapter1;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

Class Loc extends \Magento\Framework\App\Action\Action
{
    protected $resultPageFactory;

    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
//        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $pageResuleFactory = $this->resultPageFactory->create();
        return $pageResuleFactory;
    }
}