<?php 
include('../../Config/Config.php');
$peliculas = new peliculas($conexion);

$proceso = '';
if( isset($_GET['proceso']) && strlen($_GET['proceso'])>0 ){
	$proceso = $_GET['proceso'];
}
$peliculas->$proceso( $_GET['peliculas'] );
print_r(json_encode($peliculas->respuesta));

class peliculas{
    private $datos = array(), $db;
    public $respuesta = ['msg'=>'correcto'];
    
    public function __construct($db){
        $this->db=$db;
    }
    public function recibirDatos($peliculas){
        $this->datos = json_decode($peliculas, true);
        $this->validar_datos();
    }
    private function validar_datos(){
        if( empty($this->datos['descripcion']) ){
            $this->respuesta['msg'] = 'por favor ingrese la descripcion de la pelicula';
        }
        if( empty($this->datos['sinopsis']) ){
            $this->respuesta['msg'] = 'por favor ingrese la sipnosis de la pelicula';
        }
        if( empty($this->datos['genero']) ){
            $this->respuesta['msg'] = 'por favor ingrese el genero de la pelicula';
        }
        if( empty($this->datos['duracion']) ){
            $this->respuesta['msg'] = 'por favor ingrese la duracion la pelicula';
        }
      
        $this->almacenar_peliculas();
    }
    private function almacenar_peliculas(){
        if( $this->respuesta['msg']==='correcto' ){
            if( $this->datos['accion']==='nuevo' ){
                $this->db->consultas('
                    INSERT INTO peliculas (descripcion,sinopsis,genero,duracion) VALUES(
                        "'. $this->datos['descripcion'] .'",
                        "'. $this->datos['sinopsis'] .'",
                        "'. $this->datos['genero'] .'",
                        "'. $this->datos['duracion'] .'"
                    )
                ');
                $this->respuesta['msg'] = 'Pelicula Registrada';
            }else if($this->datos['accion']==='modificar'){
                $this->db->consultas('
                UPDATE peliculas SET
                     descripcion     = "'. $this->datos['descripcion'] .'",
                     sinopsis        = "'. $this->datos['sinopsis'] .'",
                     genero          = "'. $this->datos['genero'] .'",
                     duracion        = "'. $this->datos['duracion'] .'"
                 WHERE idPelicula = "'. $this->datos['idPelicula'] .'"
             ');
             $this->respuesta['msg'] = 'Pelicula actualizada con exito';
            

            }
        }
    }
    public function buscarPeliculas($valor=''){
        $this->db->consultas('
            select peliculas.idPelicula, peliculas.descripcion, peliculas.sinopsis, peliculas.genero, peliculas.duracion
            from peliculas
            where peliculas.descripcion like "%'.$valor.'%" or " or peliculas.duracion like "%'.$valor.'%"
        ');
        return $this->respuesta = $this->db->obtener_datos();
    }
    public function eliminarPeliculas($idPelicula=''){
    
            $this->db->consultas( '
                delete peliculas
                from peliculas
                where peliculas.idPelicula = "'.$idPelicula.'"
            ');
           
                $this->respuesta['msg'] = 'Pelicula eliminada correctamente';
      
    }
 
}
?>