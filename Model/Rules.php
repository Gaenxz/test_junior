<?php
/**
 * Created by PhpStorm.
 * User: gialam
 * Date: 8/22/2016
 * Time: 5:26 PM
 */
namespace Magenest\Rules\Model;

class Rules extends \Magento\Framework\Model\AbstractModel
{
    public function _construct()
    {
        $this->_init('Magenest\Rules\Model\ResourceModel\Rules');
    }
}
