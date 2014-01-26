<?php
class Admin_Model_User extends Zend_Db_Table_Abstract
{
    /**
     * The default table name
     */
    protected $_name = 'users';
 
    /**
     * Dependent tables
     */
    protected $_dependentTables = array('content_pages');
}