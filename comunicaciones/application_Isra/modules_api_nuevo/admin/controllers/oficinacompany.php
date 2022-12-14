<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Oficinacompany extends CI_Controller {
               
	function __construct() {
 		parent::__construct();
                // Ignorar los abortos hechos por el usuario y permitir que el script
                // se ejecute para siempre, evita que se detenga el proceso por cerrar el navegador
                ignore_user_abort(true);                
	}
        public function get_oficina_company_report(){
            $this->load->model('oficina_company_model');
            $sort = $this->input->get('sort');
            $order = $this->input->get('order');
            $limit = $this->input->get('limit');
            $offset = $this->input->get('offset');
            $filter = json_decode($this->input->get('filter'));
            $order_by = array($sort=>$order);
            $res = $this->oficina_company_model->get_oficina_company_data( $limit, $offset,$filter, $order_by );
            $total = $this->oficina_company_model->get_oficina_company_count( $filter );
            echo '{"total": '.$total.', "rows":'.json_encode($res).'}';
        }
        
        public function borrar(){
            $ids = set_post_value('id');
            $name = set_post_value('nombre');
            $direccion = set_post_value('observaciones');
            $cont = 0;
            print_r($name);
            print_r($ids);
            if($ids){
                foreach($ids as $value) {
                    $oficial = new \gestcobra\oficina_company_model($value);
                    $grupo=new \gestcobra\grupo_model($value);
                    if(!empty($name[$cont]) AND $direccion[$cont] != 'undefined'){
                        $grupo->nombre = $name[$cont];
                        $grupo->observaciones  = $name[$cont];
                        $oficial->save();
                        $cont++;     
                        array_push($ids, $grupo->id);
                    }
                }
            }
          //  $value_company_id=$this->user->company_id;
            $this->db->delete('grupo', array('id' => $value));
           // $this->db->where('company_id', $value_company_id); 
            //$this->db->update('oficina_company', array('status'=>'-1') );                        
            echo $this->db->last_query();
            successAlert( lang('ml_success_msg'), lang('ml_success') );
            ?>
                <script>
                    $("#table_bases").bootstrapTable('refresh');
                </script>
            <?php
        }
        /* Llamada al formulario 
        * enlace de llamada:
        * <a id="call-php" href="#" data-target="messagesout" php-function="common/index/viewScreen/module/controller/open_ml_empresa">Nuevo</a>
        */
        function open_lista_contactos($id = 0) {
            $res['id'] = $id;
            $this->load->view("contact_report", $res);
        }
        
        
}