<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reportes extends CI_Controller {

    function __construct() {
        parent::__construct();
        // Ignorar los abortos hechos por el usuario y permitir que el script
        // se ejecute para siempre, evita que se detenga el proceso por cerrar el navegador
        ignore_user_abort(true);
    }

    /* Llamada al formulario 
     * enlace de llamada:
     * <a id="call-php" href="#" data-target="messagesout" php-function="common/index/viewScreen/module/controller/open_ml_empresa">Nuevo</a>
     */

    function open_view_reporte_mes($id = 0) {
        //      $res['id'] = $id;
        $this->load->view("tabla_general_mes");
    }
	
	public function open_view_gestiones($id = 0){
        $this->load->view("tabla_gestiones");
    }

    function open_view_reporte($id = 0) {
        //      $res['id'] = $id;
        $this->load->view("tabla_general");
    }

    public function open_view2() {

        $this->load->view('view_graficos/grafica_produccionGestiones.php');
    }
//grafica comparativa mes a mes
    public function open_view3() {
        // $res['id'] = $id;

        $this->load->view('view_graficos/grafica_cumplimientoOficial.php');
    }
//grafica comparativa actual
    public function open_view3_general() {
        // $res['id'] = $id;

        $this->load->view('view_graficos/grafica_cumplimiento_general.php');
    }
    //tabla de produccion
  public function open_view_produccion() {

        $this->load->view("tabla_produccion");
    }
  public function open_graf_produccion() {

        $this->load->view('view_graficos/grafica_produccionGestiones.php');
    }
}
