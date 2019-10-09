<?php
/**
 * Created by PhpStorm.
 * User: gialam
 * Date: 8/22/2016
 * Time: 5:26 PM
 */
namespace  Magenest\Rules\Model\ResourceModel;

class Rules extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function _construct()
    {
        $this->_init('magenest_rules', 'id');
    }
}
