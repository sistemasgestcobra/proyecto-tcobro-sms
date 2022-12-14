<?php
namespace gestcobra;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class envio_hist_model extends \Orm_model {

	public static $table = 'envio_hist';

	/**
	 * @property integer $id
	 * @property integer $credit_detail_id
	 * @property date $hist_date
	 * @property string $hist_time
	 * @property string $detail
	 * @property integer $credit_status_id
	 * @property date $compromiso_pago_date
	 */
	public static $fields = array(
		array('name' => 'id', 'type' => 'int'),
		array('name' => 'hist_date', 'type' => 'date', 'date_format' => 'Y-m-d'),
		array('name' => 'hist_time', 'type' => 'string'),
		array('name' => 'detail', 'type' => 'string', 'allow_null' => true),
        array('name' => 'enviados', 'type' => 'string', 'allow_null' => true),
        array('name' => 'excluidos', 'type' => 'string', 'allow_null' => true),
		array('name' => 'usuario', 'type' => 'string', 'allow_null' => true),
		array('name' => 'fecha_programado', 'type' => 'string', 'allow_null' => true)
            );

	public static $primary_key = 'id';

	/**
	 * @method credit_detail_model credit_detail() has_one
	 * @method credit_status_model credit_status() has_one
	 */
}

