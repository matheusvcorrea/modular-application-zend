<?php

class Admin_Model_Content_Page extends Zend_Db_Table
{
	protected $_name = 'content_pages';
	
	/**
	 * Função Recursiva que faz um novo array unindo todo o array recursivo gererado pelo Zend Form em novo array nao recursivo
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
	 * Função Recursiva que percorre todo o array e remove o que for vazio
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