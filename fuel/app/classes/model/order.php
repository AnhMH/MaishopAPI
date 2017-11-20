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
class Model_Order extends Model_Abstract {
    
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'admin_id',
        'customer_id',
        'supplier_id',
        'sub_name',
        'sub_address',
        'sub_tel',
        'ext_cost',
        'ship_cost',
        'total',
        'pay_debt',
        'pay_total',
        'note',
        'type',
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
    protected static $_table_name = 'orders';

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
        $adminId = !empty($param['admin_id']) ? $param['admin_id'] : '';
        $self = array();
        
        if (empty($param['customer_id']) && empty($param['supplier_id'])) {
            self::errorNotExist('user_id');
            return false;
        }
        
        // Check if exist
        if (!empty($param['id'])) {
            $self = self::find($param['id']);
            if (empty($self)) {
                self::errorNotExist('order_id');
                return false;
            }
        } else {
            $self = new self;
        }
        
        // Set data
        $self->set('admin_id', $adminId);
        if (!empty($param['customer_id'])) {
            $self->set('customer_id', $param['customer_id']);
        }
        if (!empty($param['supplier_id'])) {
            $self->set('supplier_id', $param['supplier_id']);
        }
        if (!empty($param['sub_name'])) {
            $self->set('sub_name', $param['sub_name']);
        }
        if (!empty($param['sub_address'])) {
            $self->set('sub_address', $param['sub_address']);
        }
        if (!empty($param['sub_tel'])) {
            $self->set('sub_tel', $param['sub_tel']);
        }
        if (!empty($param['ext_cost'])) {
            $self->set('ext_cost', $param['ext_cost']);
        }
        if (!empty($param['ship_cost'])) {
            $self->set('ship_cost', $param['ship_cost']);
        }
        if (!empty($param['total'])) {
            $self->set('total', $param['total']);
        }
        if (!empty($param['pay_debt'])) {
            $self->set('pay_debt', $param['pay_debt']);
        }
        if (!empty($param['pay_total'])) {
            $self->set('pay_total', $param['pay_total']);
        }
        if (!empty($param['note'])) {
            $self->set('note', $param['note']);
        }
        if (isset($param['type'])) {
            $self->set('type', $param['type']);
        }
        
        // Save data
        if ($self->save()) {
            if (empty($self->id)) {
                $self->id = self::cached_object($self)->_original['id'];
            }
            if (!empty($param['product_data'])) {
                if (!is_array($param['product_data'])) {
                    $param['product_data'] = json_decode($param['product_data'], true);
                }
                $orderProducts = array();
                foreach ($param['product_data'] as $v) {
                    $tmpData = array(
                        'order_id' => $self->id,
                        'product_id' => !empty($v['id']) ? $v['id'] : '',
                        'qty' => !empty($v['qty']) ? $v['qty'] : '',
                        'price' => !empty($v['price']) ? $v['price'] : ''
                    );
                    $orderProducts[] = $tmpData;
                }
                if (!empty($orderProducts)) {
                    self::batchInsert('order_products', $orderProducts);
                }
            }
            return $self->id;
        }
        
        return false;
    }
    
    /**
     * Get list
     *
     * @author AnhMH
     * @param array $param Input data
     * @return array|bool
     */
    public static function get_list($param)
    {
        // Init
        $adminId = !empty($param['admin_id']) ? $param['admin_id'] : '';
        
        // Query
        $query = DB::select(
                self::$_table_name.'.*'
            )
            ->from(self::$_table_name)
            ->where(self::$_table_name.'.admin_id', $adminId)
        ;
                        
        // Filter
        if (!empty($param['name'])) {
            $query->where(self::$_table_name.'.name', 'LIKE', "%{$param['name']}%");
        }
        if (!empty($param['address'])) {
            $query->where(self::$_table_name.'.address', 'LIKE', "%{$param['address']}%");
        }
        if (!empty($param['tel'])) {
            $query->where(self::$_table_name.'.tel', 'LIKE', "%{$param['tel']}%");
        }
        if (!empty($param['email'])) {
            $query->where(self::$_table_name.'.email', 'LIKE', "%{$param['email']}%");
        }
        if (!empty($param['disable'])) {
            $query->where(self::$_table_name.'.disable', 1);
        } else {
            $query->where(self::$_table_name.'.disable', 0);
        }
        
        // Pagination
        if (!empty($param['page']) && $param['limit']) {
            $offset = ($param['page'] - 1) * $param['limit'];
            $query->limit($param['limit'])->offset($offset);
        }
        
        // Sort
        if (!empty($param['sort'])) {
            if (!self::checkSort($param['sort'])) {
                self::errorParamInvalid('sort');
                return false;
            }

            $sortExplode = explode('-', $param['sort']);
            if ($sortExplode[0] == 'created') {
                $sortExplode[0] = self::$_table_name . '.created';
            }
            $query->order_by($sortExplode[0], $sortExplode[1]);
        } else {
            $query->order_by(self::$_table_name . '.created', 'DESC');
        }
        
        // Get data
        $data = $query->execute()->as_array();
        $total = !empty($data) ? DB::count_last_query(self::$slave_db) : 0;
        
        return array(
            'total' => $total,
            'data' => $data
        );
    }
}
