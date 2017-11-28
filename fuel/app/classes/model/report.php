<?php

use Fuel\Core\DB;
use Lib\Util;

/**
 * Any query in Model Report
 *
 * @package Model
 * @created 2017-11-28
 * @version 1.0
 * @author AnhMH
 * @copyright Oceanize INC
 */
class Model_Report extends Model_Abstract
{
    /**
     * Get general
     *
     * @author AnhMH
     * @param array $param Input data.
     * @return array Returns the array.
     */
    public static function get_general($param)
    {        
        $orderCnt =      
            DB::select(                
                DB::expr("COUNT(id) AS cnt")
            )
            ->from('orders')
            ->where('disable', '0')
            ->execute(self::$slave_db)
            ->offsetGet(0);
        
        $customerCnt =      
            DB::select(                
                DB::expr("COUNT(id) AS cnt")
            )
            ->from('customers')
            ->where('disable', '0')
            ->execute(self::$slave_db)
            ->offsetGet(0);
        
        $productCnt =      
            DB::select(                
                DB::expr("COUNT(id) AS cnt")
            )
            ->from('products')
            ->where('disable', '0')
            ->execute(self::$slave_db)
            ->offsetGet(0);
        
        $supplierCnt =      
            DB::select(                
                DB::expr("COUNT(id) AS cnt")
            )
            ->from('suppliers')
            ->where('disable', '0')
            ->execute(self::$slave_db)
            ->offsetGet(0);
        
        $item = array(
            'order_count' => !empty($orderCnt['cnt']) ? $orderCnt['cnt'] : 0,
            'customer_count' => !empty($customerCnt['cnt']) ? $customerCnt['cnt'] : 0,
            'supplier_count' => !empty($supplierCnt['cnt']) ? $supplierCnt['cnt'] : 0,
            'product_count' => !empty($productCnt['cnt']) ? $productCnt['cnt'] : 0
        );
        
        return $item; 
    }
}
