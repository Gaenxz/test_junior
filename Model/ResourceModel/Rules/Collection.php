<?php
/**
 * Created by PhpStorm.
 * User: gialam
 * Date: 8/22/2016
 * Time: 5:27 PM
 */
namespace Magenest\Rules\Model\ResourceModel\Rules;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';

    public function _construct()
    {
        $this->_init('Magenest\Rules\Model\Rules', 'Magenest\Rules\Model\ResourceModel\Rules');
    }
}
