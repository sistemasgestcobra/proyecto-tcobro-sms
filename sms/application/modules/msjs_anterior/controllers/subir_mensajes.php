<?php
class Subir_mensajes extends MX_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->user->check_session();
        ignore_user_abort(true);
        $this->load->library('comunications/commws');
    }

    public $abecedario = array(
        "A" => "0",
        "B" => "1",
        "C" => "2"
     );
//Mensajes Personalizados
    function load_mensajes() {
        set_time_limit(0);
        $this->load->library('excel');
        $logo_path = './uploads/' . $this->user->company_id . '/files/';
        makedirs($logo_path, $mode = 0755);
        $config['upload_path'] = $logo_path;
        $config['allowed_types'] = '*';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload()) {
            $error = $this->upload->display_errors();
            toast($error);
            exit();
        } else {
            $upl_data = $this->upload->data();
        }
        $upl_data = $this->upload->data();
        if (file_exists($logo_path . $upl_data['file_name'])) {            
            // Cargando la hoja de c�lculo
            $Reader = new PHPExcel_Reader_Excel2007();
            $PHPExcel = $Reader->load($logo_path . $upl_data['file_name']);
            $objFecha = new PHPExcel_Shared_Date();
            // Asignar hoja de excel activa
            $PHPExcel->setActiveSheetIndex(0);
                  $mensajes= array();
                  $numeros=array();
                  $num_malos=array();
            for ($x = 2; $x <= $PHPExcel->getActiveSheet()->getHighestRow(); $x++) {
                $numero_celular = get_value_xls($PHPExcel, $this->abecedario["A"], $x);
                $mensaje = get_value_xls($PHPExcel, $this->abecedario["B"], $x);
                $num_operacion = get_value_xls($PHPExcel, $this->abecedario["C"], $x);
                
                $credit_id = (new \gestcobra\credit_detail_model())
                        ->where('nro_pagare', $num_operacion)
                        ->find_one();
                
                $id_credito= $credit_id->id;               
                
                $client_referncia = (new \gestcobra\client_referencias_model())
                        ->where('credit_detail_id', $credit_id->id)
                        ->where('reference_type_id', 3)
                        ->find_one();
                
                $id_ref= $client_referncia->id;
                
                if($client_referncia->id != 0 ){
                    $id_credito= $credit_id->id;
                    $id_ref= $client_referncia->id;
                    $this->save_comunication('MENSAJE TEXTO', 1, $numero_celular, $id_ref );
                    $this->save_hist($credit_id->id);
                   
                }
                
                $numero_celular1=trim($numero_celular);
                $numero_celular2=substr($numero_celular1, 1);
		$numero_celular3='593'.$numero_celular2;
                
                if(strlen($numero_celular3)==12 && strlen($mensaje)>1){
                    array_push($mensajes, $mensaje);
                    array_push($numeros, $numero_celular3); 
                }else{
                    array_push($num_malos, $numero_celular);
                }
            }
            if(count($numeros)>900){
                $this->dividir($mensajes,$numeros);
            }else{
                $this->enviar($mensajes,$numeros);
            }
                $enviados = count($numeros);
                if(!empty($num_malos)){
                    echo $this->erroneos("Numeros Erroneos o Con Mensaje Vacio",$num_malos);
                }
            if (true) {
                successAlert('Archivo cargado correctamente', lang('ml_success'));
                $this->envio_hist("MENSAJES PERSONALIZADOS",$enviados,$num_malos);
                
            } else {
                errorAlert('Error al cargar el archivo');
            }
        } else {
            errorAlert('Error al cargar el archivo');
        }
    }

     function load_mensajes_masivos() {
        set_time_limit(0);
        $this->load->library('excel');
        $logo_path = './uploads/' . $this->user->company_id . '/files/';
        makedirs($logo_path, $mode = 0755);
        $config['upload_path'] = $logo_path;   $config['allowed_types'] = '*'; $config['max_size'] = '0'; $config['max_width'] = '0';
        $config['max_height'] = '0';
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload()) {
            $error = $this->upload->display_errors();
            toast($error);
            exit();
        } else {
            $upl_data = $this->upload->data();
        }
        $upl_data = $this->upload->data();
        $mensaje=  set_post_value('mensaje');
        if (file_exists($logo_path . $upl_data['file_name'])) {
            $Reader = new PHPExcel_Reader_Excel2007();
            $PHPExcel = $Reader->load($logo_path . $upl_data['file_name']);
            $PHPExcel->setActiveSheetIndex(0);
                  $mensajes= array();
                  $numeros=array(); 
                  $num_malos=array();
            //$fp = fopen("mensajes_mas.txt", "a");
            for ($x = 2; $x <= $PHPExcel->getActiveSheet()->getHighestRow(); $x++) {
                $numero_celular = get_value_xls($PHPExcel, $this->abecedario["A"], $x);
                $num_operacion = get_value_xls($PHPExcel, $this->abecedario["B"], $x);
                
                $credit_id = (new \gestcobra\credit_detail_model())
                        ->where('nro_pagare', $num_operacion)
                        ->find_one();
                
                $id_credito= $credit_id->id;               
                
                $client_referncia = (new \gestcobra\client_referencias_model())
                        ->where('credit_detail_id', $credit_id->id)
                        ->where('reference_type_id', 3)
                        ->find_one();
                
                $id_ref= $client_referncia->id;
                
                if($client_referncia->id != 0 ){
                    $id_credito= $credit_id->id;
                    $id_ref= $client_referncia->id;
                    $this->save_comunication('MENSAJE TEXTO', 1, $numero_celular, $id_ref );
                    $this->save_hist($credit_id->id);
                }
                
                $numero_celular1=trim($numero_celular);
                $numero_celular2=substr($numero_celular1, 1);
				$numero_celular3='593'.$numero_celular2;
                if(strlen($numero_celular3)==12){
                array_push($mensajes, $mensaje);
                array_push($numeros, $numero_celular3);
                }else{
                    array_push($num_malos, $numero_celular);
                }
            }
            if(count($numeros)>900){
                
                $this->dividir($mensajes,$numeros);
            }else{
              $var=  $this->enviar($mensajes,$numeros);
                
            }
                $enviados = count($numeros);
                if(!empty($num_malos)){
                    echo $this->erroneos("Numeros Erroneos",$num_malos);
                }
            	
                //fputs($fp, $resp."\r\n");
                //fclose($fp);
                
            if (true) {
                
                //successAlert('Archivo cargado correctamente', lang('ml_success'));
                
				if ($var!=null){
			 successAlert(lang('ml_success_msg'), lang('ml_success'));}else{
				 errorAlert('SALDO INSUFICIENTE');
			 }	
				
				$this->envio_hist($mensaje,$enviados,$num_malos);   
                
                
            } else {
                errorAlert('Error al cargar el archivo');
            }
        } else {
            errorAlert('Error al cargar el archivo');
        }
    }
    
    function envio_hist($detail,$enviados,$num_malos) {
        $envio= new \gestcobra\envio_hist_model();
        $envio->hist_date = date('Y-m-d', time());
        $envio->hist_time = date('H:i:s', time());
        $envio->detail=$detail;
        $envio->enviados=$enviados;
        $envio->excluidos=count($num_malos);
		
		$oficial = (new gestcobra\oficial_credito_model())
			->where('id', $this->user->id)
			->find_one();
			
		$usuario= $oficial->firstname;
		
		$envio->usuario=$usuario;
		
        $envio->save();
    }
    
	
    function dividir($mensajes,$numeros) {
        
        $mensajes1=array_chunk($mensajes, 900);
        $numeros1=array_chunk($numeros, 900);
            $div= count($numeros1);
            for($x=0;$x<$div;$x++){
                $m=$mensajes1[$x];
                $n=$numeros1[$x];
                $this->enviar($m, $n);
                
            }
            //fputs($fp, $resp."\r\n");
                
        
    }
    
     function erroneos($men,$num_malos) {
         echo $men.": ".count($num_malos);
                    echo '<pre>';
                    foreach ($num_malos as $value) {
                        print $value.'<br>';
                    }
         echo  '</pre>';
    }
    
    function enviar($mensajes,$numeros) {
		
		
        $men=$mensajes[0];
        array_push($mensajes,$men);
        array_push($numeros,"593995164158");
        $message = array(
            "Mensaje"=>"Hola",
            "Mensajes"=>$mensajes,
            "Destinatarios"=>$numeros,
            "apiKey"=>"3D78493FB7"
                );
                    $obj_commws = new Commws();
                  $var=  $obj_commws->http_conn_comunication_1($message);
					return $var;
			 	
    }
    
     function save_comunication($type, $status, $contact, $client_referencia) {
        $comunication = new gestcobra\comunication_model();
        $comunication->type = $type;
        $comunication->status = $status;
        $comunication->detalle_notificacion = null;
        $comunication->contact = $contact;
        $comunication->curr_date = date("Y-m-d", time());
        $comunication->curr_time = date("H:i:s", time());
        $comunication->user_id = $this->user->id;
        $comunication->notificador = null;
        $comunication->comunication_type_id = 2;
        $comunication->client_referencias_id = $client_referencia;
        $comunication->notification_format_id = 5;
        $comunication->save();
    }
    
	
	
//    function load_mensajes_base() {
//        $nombre_base = set_post_value('id_grupo');
//        $mensaje_o = set_post_value('mensaje');
//        
//       
//        $contactos = (new gestcobra\contact_grupo_model())
//                ->where('id_grupo', $nombre_base)
//                ->find();
//        $mensajes = array();
//        $numeros = array();
//        $num_malos=array();
//        if ($contactos) {
//            foreach ($contactos as $contact) {
//                $NUMERO = $contact->numero;
//                $numero_celular2=substr($NUMERO, 3);
//				$numero_celular3='0'.$numero_celular2;
//                
//                $contact = (new \gestcobra\contact_model())
//                        ->where('contact_value', $numero_celular3)
//                        ->find_one();
//                
//                $referencia= $contact->person_id;
//                $contacto_sms= $contact->contact_value;
//                
//                $client_referncia = (new \gestcobra\client_referencias_model())
//                        ->where('person_id', $referencia)
//                        ->find_one();
//                
//                $id_ref= $client_referncia->id;
//                
//                $NOMBRE = $contact->nombre;
//                $VARIABLE_1 = $contact->variable1;
//                $VARIABLE_2 = $contact->variable2;
//                $VARIABLE_3 = $contact->variable3;
//                $VARIABLE_4 = $contact->variable4;
//                
//                $mensaje = str_replace('NOMBRE', $NOMBRE, $mensaje_o);
//                $mensaje = str_replace('VAR1', $VARIABLE_1, $mensaje);
//                $mensaje = str_replace('VAR2', $VARIABLE_2, $mensaje);
//                $mensaje = str_replace('VAR3', $VARIABLE_3, $mensaje);
//                $mensajeF = str_replace('VAR4', $VARIABLE_4, $mensaje);
//                
//                $numero_celular1=trim($NUMERO);
//                if(strlen($numero_celular1)==12){
//                array_push($mensajes, $mensajeF);
//                array_push($numeros, $numero_celular1);
//                }else{
//                    array_push($num_malos, $NUMERO);
//                }
//                
//                
//               }
//               
//        }
//
//               if (count($numeros) > 900) {
//                $this->dividir($mensajes, $numeros);
//            } else {
//                $this->enviar($mensajes, $numeros);
//                if($id_ref != 0 ){
//                    $this->save_comunication('MENSAJE TEXTO', 0, $contacto_sms, $id_ref );
//                }
//            }
//
//        $enviados = count($numeros);
//
//        if (true) {
//            successAlert('Archivo cargado correctamente', lang('ml_success'));
//            $this->envio_hist($mensaje_o, $enviados, $num_malos);
//        } else {
//            errorAlert('Error al cargar el archivo');
//        }
//    }
    
        function load_mensajes_base() {
        $nombre_base = set_post_value('id_grupo');
        if($nombre_base=='-1'){
            exit(errorAlert('No se selecciono Base'));
        }
        if(set_post_value('message_format')=='-1'){
         $mensaje_o = set_post_value('mensaje');
          if($mensaje_o==''){
            exit(errorAlert('Mensaje vacio'));
        }
        }else{
         $mensaje_o = set_post_value('message_format');
                   if($mensaje_o==''){
            exit(errorAlert('Mensaje vacio'));
        }
        }
       
        $contactos = (new gestcobra\contact_grupo_model())
                ->where('id_grupo', $nombre_base)
                ->find();
        $mensajes = array();
        $numeros = array();
        $num_malos=array();
        if ($contactos) {
            foreach ($contactos as $contact) {
                $NUMERO = $contact->numero;
                $NUM_OPERACION= $contact->numero_operacion;
                //print_r($NUM_OPERACION);
                
                
                $NOMBRE = $contact->nombre;
                $VARIABLE_1 = $contact->variable1;
                $VARIABLE_2 = $contact->variable2;
                $VARIABLE_3 = $contact->variable3;
                $VARIABLE_4 = $contact->variable4;
                
                $mensaje = str_replace('NOMBRE', $NOMBRE, $mensaje_o);
                $mensaje = str_replace('VAR1', $VARIABLE_1, $mensaje);
                $mensaje = str_replace('VAR2', $VARIABLE_2, $mensaje);
                $mensaje = str_replace('VAR3', $VARIABLE_3, $mensaje);
                $mensajeF = str_replace('VAR4', $VARIABLE_4, $mensaje);
                
                $numero_celular1=trim($NUMERO);
                if(strlen($numero_celular1)==12){
                array_push($mensajes, $mensajeF);
                array_push($numeros, $numero_celular1);
                }else{
                    array_push($num_malos, $NUMERO);
                }
                
                $credit_id = (new \gestcobra\credit_detail_model())
                        ->where('nro_pagare', $NUM_OPERACION)
                        ->find_one();
                
                
                $client_referncia = (new \gestcobra\client_referencias_model())
                        ->where('credit_detail_id', $credit_id->id)
                        ->where('reference_type_id', 3)
                        ->find_one();
                
                $id_ref= $client_referncia->id;
                //print_r($id_ref); 
                
                
                if($client_referncia->id != 0 ){
                    //$id_credito= $credit_id->id;
                 //
                    $id_ref= $client_referncia->id;
                 
                    $this->save_comunication('MENSAJE TEXTO', 1, $NUMERO, $id_ref );
                    $this->save_hist($credit_id->id);
                    
                }
                
               }
               
        }

               if (count($numeros) > 900) {
                $this->dividir($mensajes, $numeros);
            } else {
                $this->enviar($mensajes, $numeros);
                
            }

        $enviados = count($numeros);

        if (true) {
            successAlert('Archivo cargado correctamente', lang('ml_success'));
            $this->envio_hist($mensaje_o, $enviados, $num_malos);
        } else {
            errorAlert('Error al cargar el archivo');
        }
    }
    
    
    private function save_hist($credit_detail_id) {  
        $credti_hist = new gestcobra\credit_hist_model();
        $credti_hist->credit_detail_id = $credit_detail_id;
        $credti_hist->detail = 'ENVIO DE MENSAJE DE TEXTO';
        $credti_hist->hist_date = date('Y-m-d', time());
        $credti_hist->hist_time = date('H:i:s', time());
        $credti_hist->credit_status_id = 8;
        $credti_hist->oficial_credito_id = $this->user->id;
        $credti_hist->comision_id = 7;
        $credti_hist->compromiso_max = 0;
        $credti_hist->compromiso_pago_date = date(0000-00-00);
        $credti_hist->save();
       
    }
function leer() {
            $mensaje_o = set_post_value('message_format');
            //leer($mensaje_o);
            echo 'MENSAJE A ENVIAR';
            echo '</br>';
            echo $mensaje_o;
            //break;
        }
	}


