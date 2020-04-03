<?php 
include('../../Config/Config.php');
$docente = new docente($conexion);

$proceso = '';
if( isset($_GET['proceso']) && strlen($_GET['proceso'])>0 ){
	$proceso = $_GET['proceso'];
}
$docente->$proceso( $_GET['docente'] );
print_r(json_encode($docente->respuesta));

class docente{
    private $datos = array(), $db;
    public $respuesta = ['msg'=>'correcto'];
    
    public function __construct($db){
        $this->db=$db;
    }
    public function recibirDatos($docente){
        $this->datos = json_decode($docente, true);
        $this->validar_datos();
    }
    private function validar_datos(){
        if( empty($this->datos['codigo']) ){
            $this->respuesta['msg'] = 'por favor ingrese el codigo del docente';
        }
        if( empty($this->datos['nombre']) ){
            $this->respuesta['msg'] = 'por favor ingrese el nombre del docente';
        }
        if( empty($this->datos['direccion']) ){
            $this->respuesta['msg'] = 'por favor ingrese la direccion del docente';
        }
        if( empty($this->datos['telefono']) ){
            $this->respuesta['msg'] = 'por favor ingrese el telefono del docente';
        }
      
        $this->almacenar_docentes();
    }
    private function almacenar_docentes(){
        if( $this->respuesta['msg']==='correcto' ){
            if( $this->datos['accion']==='nuevo' ){
                $this->db->consultas('
                    INSERT INTO docente (codigo,nombre,direccion,telefono,DUI) VALUES(
                        "'. $this->datos['codigo'] .'",
                        "'. $this->datos['nombre'] .'",
                        "'. $this->datos['direccion'] .'",
                        "'. $this->datos['telefono'] .'",
                        "'. $this->datos['DUI'] .'"
                    )
                ');
                $this->respuesta['msg'] = 'Registro Docente insertado correctamente';
            }else if($this->datos['accion']==='modificar'){
                $this->db->consultas('
                UPDATE docente SET
                     codigo     = "'. $this->datos['codigo'] .'",
                     nombre     = "'. $this->datos['nombre'] .'",
                     direccion  = "'. $this->datos['direccion'] .'",
                     telefono   = "'. $this->datos['telefono'] .'",
                     DUI        = "'. $this->datos['DUI'] .'"
                 WHERE idDocente = "'. $this->datos['idDocente'] .'"
             ');
             $this->respuesta['msg'] = 'Registro actualizado correctamente';
            

            }
        }
    }
    public function buscarDocente($valor=''){
        $this->db->consultas('
            select docente.idDocente, docente.codigo, docente.nombre, docente.direccion, docente.telefono,docente.DUI
            from docente
            where docente.codigo like "%'.$valor.'%" or docente.nombre like "%'.$valor.'%" or docente.DUI like "%'.$valor.'%"
        ');
        return $this->respuesta = $this->db->obtener_datos();
    }
    public function eliminarDocente($idDoncente=''){
    
            $this->db->consultas( '
                delete docente
                from docente
                where docente.idDocente = "'.$idDoncente.'"
            ');
           
                $this->respuesta['msg'] = 'Registro eliminado correctamente';
      
    }
 
}
?>