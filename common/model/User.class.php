<?php
/**
 * User Model
 */
class User extends Model {
	
    protected static $tableName = 'User';
    protected static $primaryKey = 'user_id';
    
    function setUsername($value){
        $this->setColumnValue('name', $value);
    }
    function getUsername(){
        return $this->getColumnValue('name');
    }

    function setPassword($value){
        $this->setColumnValue('password', $value);
    }
    function getPassword(){
        return $this->getColumnValue('password');
    }
}
