<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Credit_hist_model extends \CI_Model {        
    function get_hist_data( $limit, $offset, $order_by = null) {
        $this -> db -> from('envio_hist cm');            
        $this -> db -> select('cm.id, cm.detail, cm.hist_date, cm.hist_time, cm.enviados, cm.excluidos, cm.usuario, cm.fecha_programado', FALSE  );
   //     $this->db->where('company_id', $this->user->company_id);
        if($order_by){               
            foreach ($order_by as $order => $tipo) { 
                $this -> db -> order_by($order, $tipo);
                }            
            
        }               
        $this -> db -> limit($limit, $offset);
        $query = $this -> db -> get(); 
        $result = $query->result(); 
        // echo $this->db->last_query();
        return $result;                   
        
    }                 
    public function get_hist_count() {
                $this -> db -> from('envio_hist cm');            
        $this -> db -> select('cm.id, cm.detail, cm.hist_date, cm.hist_time, cm.enviados, cm.excluidos, cm.usuario', FALSE  );
       // $this->db->where('company_id', $this->user->company_id);
        return $this->db->count_all_results();
        
    }
        }