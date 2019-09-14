<?php

namespace Magenest\Rules\Block\Chapter2;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Config\ScopeConfigInterface;

Class Clock extends Template
{
    protected $scopeConfig;
    public function __construct(ScopeConfigInterface $scopeConfig,Template\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
        $this->scopeConfig = $scopeConfig;
    }

    public function getClockConfig()
    {
        $size = $this->scopeConfig->getValue('clock_config/clock/clock_size');
        switch ($size)
        {
            case 'N': $size = ['width' => 300, 'font-width' => 60];break;
            case 'S': $size = ['width' => 250, 'font-width' => 50];break;
            case 'B': $size = ['width' => 350, 'font-width' => 70];break;
        }
        $clockConfig = [
            'size' => $size,
            'clockColor' => $this->scopeConfig->getValue('clock_config/clock/color_picker'),
            'clockTextColor' => $this->scopeConfig->getValue('clock_config/clock/text_color'),
        ];
        return $clockConfig;
    }
}