<?php 
include('../../config/config.php');
$docentes = new docentes($conexion);

$proceso = '';
if( isset($_GET['proceso']) && strlen($_GET['proceso'])>0 ){
	$proceso = $_GET['proceso'];
}
$docentes->$proceso( $_GET['docentes'] );
print_r(json_encode($docentes->respuesta));

class docentes{
    private $datos = array(), $db;
    public $respuesta = ['msg'=>'correcto'];
    
    public function __construct($db){
        $this->db=$db;
    }
    public function recibirDatos($docentes){
        $this->datos = json_decode($docentes, true);
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
        if( empty($this->datos['n. escalafon']) ){
            $this->respuesta['msg'] = 'por favor ingrese el numero de escalafon del docente';
        }
        $this->almacenar_docentes();
    }
    private function almacenar_docentes(){
        if( $this->respuesta['msg']==='correcto' ){
            if( $this->datos['accion']==='nuevo' ){
                $this->db->consultas('
                    INSERT INTO docentes (codigo,nombre,direccion,n. escalafon,telefono) VALUES(
                        "'. $this->datos['codigo'] .'",
                        "'. $this->datos['nombre'] .'",
                        "'. $this->datos['direccion'] .'",
                        "'. $this->datos['n. escalafon'] .'",
                        "'. $this->datos['telefono'] .'"
                    )
                ');
                $this->respuesta['msg'] = 'Registro Docente insertado correctamente';
            }
        }
    }
}
?>