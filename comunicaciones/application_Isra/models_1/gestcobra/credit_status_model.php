<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class credit_status_model extends \Orm_model {

	public static $table = 'credit_status';

	/**
	 * @property integer $id
	 * @property string $status_name
	 * @property string $color
	 * @property string $background
	 * @property integer $company_id
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'status_name', 'type' => 'string'),
		array('name' => 'color', 'type' => 'string'),
		array('name' => 'background', 'type' => 'string', 'allow_null' => true),
		array('name' => 'company_id', 'type' => 'int')
	);

	public static $primary_key = 'id';

	/**
	 * @method company_model company() has_one
	 * @method company_model company() has_one
	 */
	public static $associations = array(
		array('association_key' => 'company', 'model' => 'company_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'company_id'),
		array('association_key' => 'company', 'model' => 'company_model', 'type' => 'has_one', 'primary_key' => 'id', 'foreign_key' => 'company_id')
	);
}

