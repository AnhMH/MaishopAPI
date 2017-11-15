<?php

use Fuel\Core\DB;

/**
 * Any query in Model Version
 *
 * @package Model
 * @created 2017-11-15
 * @version 1.0
 * @author AnhMH
 */
class Model_Order_Product extends Model_Abstract {
    
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'order_id',
        'product_id',
        'qty',
        'price',
        'created',
        'updated',
        'disable'
    );

    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events'          => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events'          => array('before_update'),
            'mysql_timestamp' => false,
        ),
    );

    /** @var array $_table_name name of table */
    protected static $_table_name = 'order_products';

    /**
     * Add update info
     *
     * @author AnhMH
     * @param array $param Input data
     * @return int|bool
     */
    public static function add_update($param)
    {
        // Init
        $self = array();
        
        if (empty($param['order_id']) ) {
            self::errorNotExist('order_id');
            return false;
        }
        if (empty($param['product_id'])) {
            self::errorNotExist('product_id');
            return false;
        }
        
        // Check if exist
        if (!empty($param['id'])) {
            $self = self::find($param['id']);
            if (empty($self)) {
                self::errorNotExist('order_product_id');
                return false;
            }
        } else {
            $self = new self;
        }
        
        // Set data
        $self->set('order_id', $param['order_id']);
        $self->set('product_id', $param['product_id']);
        if (isset($param['qty'])) {
            $self->set('qty', $param['qty']);
        }
        if (isset($param['price'])) {
            $self->set('price', $param['price']);
        }
        
        // Save data
        if ($self->save()) {
            if (empty($self->id)) {
                $self->id = self::cached_object($self)->_original['id'];
            }
            return $self->id;
        }
        
        return false;
    }
}
