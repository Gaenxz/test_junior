<?php

namespace Magenest\Rules\Block\Adminhtml\Chapter2\Advance;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Config\Block\System\Config\Form\Fieldset;
/**
 * Fieldset renderer which expanded by default
 */
class Expand extends Fieldset
{
    /**
     * Whether is collapsed by default
     *
     * @var bool
     */

    protected function _isCollapseState($element)
    {
        return false;
    }
}
