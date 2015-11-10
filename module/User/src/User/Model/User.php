<?php

namespace User\Model;

class User
{
    const IS_ACTIVE = 1;
    const IS_NOT_ACTIVE = 0;

    const SUPER_USER = 4;
    const INVESTOR = 1;
    const ADVISER = 2;
    const VISITOR = 3;

    public $id;
    public $email;
    public $roleId;
    public $action;
    public $dateCreate;
    public $pass;
    public $urlImg;
    public $keyAction;
    public $keyReset;
    public $keyMail;
    public $keyDelete;

    public $map = array(
        'id' => 'id',
        'email' => 'email',
        'roleId' => 'role_id',
        'action' => 'action',
        'dateCreate' => 'data_create',
        'pass' => 'pass',
        'urlImg' => 'url_img',
        'keyAction' => 'key_action',
        'keyReset' => 'key_reset',
        'keyMail' => 'key_mail',
        'keyDelete' => 'key_delete',
    );

    public function exchangeArray($data)
    {
        foreach ($this->map as $key =>$value) {
            (array_key_exists($value,$data)) ? $this->$key = $data[$value] : false;
        }
    }

    public static $roleMap = array(
        self::SUPER_USER => 'SUPER_USER',
        self::INVESTOR => 'INVESTOR',
        self::ADVISER => 'ADVISER',
        self::VISITOR => 'VISITOR',
    );

    public static $statusMap = array(
        self::IS_ACTIVE => 'Active',
        self::IS_NOT_ACTIVE => 'Inactive',
    );

    public static function isAdmin($id) {
        return self::SUPER_USER == $id;
    }

    public static function getRoleName() {
        return self::$roleMap;
    }

    public static function getRoleNameById($id) {
        return self::$roleMap[$id];
    }

    public static function getStatusNameById($id) {
        return self::$statusMap[$id];
    }

}