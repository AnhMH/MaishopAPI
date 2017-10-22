<?php

use Fuel\Core\DB;

/**
 * Any query in Model Version
 *
 * @package Model
 * @created 2017-10-22
 * @version 1.0
 * @author AnhMH
 */
class Model_Admin extends Model_Abstract {
    
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'type',
        'account',
        'password',
        'name',
        'email',
        'address',
        'tel',
        'avatar',
        'website',
        'facebook',
        'description',
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
    protected static $_table_name = 'admins';

    /**
     * Login Admin
     *
     * @author AnhMH
     * @param array $param Input data
     * @return array|bool Detail Admin or false if error
     */
    public static function get_login($param)
    {
        $login = array();
        $user = self::find('first', array(
            'where' => array(
                'account' => $param['account'],
                'password' => Lib\Util::encodePassword($param['password'], $param['account'])
            )
        ));
        
        if (!empty($user['id'])) {
            $login = self::get_profile(array(
                'admin_id' => $user['id']
            ));
        }
        
        if (!empty($login)) {
            if (empty($login['disable'])) {
//                $login['token'] = Model_Authenticate::addupdate(array(
//                    'user_id' => $login['id'],
//                    'regist_type' => 'user'
//                ));
                return $login;
            }
            static::errorOther(static::ERROR_CODE_OTHER_1, 'User is disabled');
            return false;
        }
        static::errorOther(static::ERROR_CODE_AUTH_ERROR, 'Email/Password');
        return false;
    }
    
    /**
     * Get profile
     *
     * @author AnhMH
     * @param array $param Input data
     * @return array|bool Detail Admin or false if error
     */
    public static function get_profile($param)
    {
        if (empty($param['admin_id'])) {
            static::errorNotExist('admin_id');
            return false;
        }
        
        $query = DB::select(
                self::$_table_name.'.*'
            )
            ->from(self::$_table_name)
            ->where(self::$_table_name . '.id', $param['admin_id'])
        ;
        
        $data = $query->execute()->offsetGet(0);
        
        if (empty($data)) {
            static::errorNotExist('user_id');
            return false;
        }
        
        return $data;
    }
}
