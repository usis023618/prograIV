<?php 
include('../../Config/Config.php');
$capacitador = new capacitador($conexion);

$proceso = '';
if( isset($_GET['proceso']) && strlen($_GET['proceso'])>0 ){
	$proceso = $_GET['proceso'];
}
$capacitador->$proceso( $_GET['capacitador'] );
print_r(json_encode($capacitador->respuesta));

class capacitador{
    private $datos = array(), $db;
    public $respuesta = ['msg'=>'correcto'];
    
    public function __construct($db){
        $this->db=$db;
    }
    public function recibirDatos($capacitador){
        $this->datos = json_decode($capacitador, true);
        $this->validar_datos();
    }
    private function validar_datos(){
        if( empty($this->datos['nombre']) ){
            $this->respuesta['msg'] = 'por favor ingrese el nombre del capacitador';
        }
        if( empty($this->datos['apellido']) ){
            $this->respuesta['msg'] = 'por favor ingrese el apellido del capacitador';
        }
        if( empty($this->datos['correo']) ){
            $this->respuesta['msg'] = 'por favor ingrese el correo ';
        }
        $this->almacenar_capacitador();
    }
    private function almacenar_capacitador(){
        if( $this->respuesta['msg']==='correcto' ){
            if( $this->datos['accion']==='nuevo' ){
                $this->db->consultas('
                    INSERT INTO capacitador (nombre,apellido,direccion,correo,genero) VALUES(
                     
                        "'. $this->datos['nombre'] .'",
                        "'. $this->datos['apellido'] .'",
                        "'. $this->datos['direccion'] .'",
                        "'. $this->datos['correo'] .'",
                        "'. $this->datos['genero'] .'"
                    )
                ');
                $this->respuesta['msg'] = 'Registro insertado correctamente';
            } else if( $this->datos['accion']==='modificar' ){
                $this->db->consultas('
                   UPDATE capacitador SET
                      
                        nombre      = "'. $this->datos['nombre'] .'",
                        apellido    = "'. $this->datos['apellido'] .'",
                        direccion   = "'. $this->datos['direccion'] .'",
                        correo      = "'. $this->datos['correo'] .'",
                        genero      = "'. $this->datos['genero'] .'"
                    WHERE idCapacitador = "'. $this->datos['idCapacitador'] .'"
                ');
                $this->respuesta['msg'] = 'Registro actualizado correctamente';
            }
        }
    }
    public function buscarCapacitador($valor=''){
        $this->db->consultas('
            select capacitador.idCapacitador, capacitador.nombre, capacitador.apellido, capacitador.direccion, capacitador.correo,capacitador.genero
            from capacitador
            where capacitador.nombre like "%'.$valor.'%" or capacitador.apellido like "%'.$valor.'%" or capacitador.direccion like "%'.$valor.'%"
        ');
        return $this->respuesta = $this->db->obtener_datos();
    }
    public function eliminarCapacitador($idCpacitador=''){
    
            $this->db->consultas( '
                delete capacitador
                from capacitador
                where capacitador.idCapacitador = "'.$idCapacitador.'"
            ');
           
                $this->respuesta['msg'] = 'Registro eliminado correctamente';
      
    }
 
}
?>