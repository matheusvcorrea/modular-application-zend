<?php

class Admin_Model_Content_Page extends Zend_Db_Table_Abstract
{
	/**
     * The default table name
     */
	protected $_name = 'content_pages';

    /**
    * Reference map
    */
    protected $_referenceMap = array(
        array(
            'refTableClass' => 'Admin_Model_User',
            'refColumns'    => 'user_id',
            'columns'       => 'user_id',
        )
    );
	
	/**
	 * Recursive function that makes a new array joining all recursive array gererado by Zend Form not in new array recursive
	 * @return array
	 */
	public function mergeValues($data)
	{
		$array = array();
		foreach ($data as $value)
		{
			$array = array_merge($array, $value);
		}

		$result = $this->array_remove_empty($array);

		return $result;
	}

	/**
	 * Recursive function that traverses the entire array and remove what is empty
	 */
	public function array_remove_empty($data)
	{
	    foreach ($data as $key => $value)
	    {
	        if (is_array($value))
	        {
	            $data[$key] = $this->array_remove_empty($data[$key]);
	        }

	        if (empty($data[$key]))
	        {
	            unset($data[$key]);
	        }
	    }
	    return $data;
	}
}