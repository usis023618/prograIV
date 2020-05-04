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
        if( empty($this->datos['codigo']) ){
            $this->respuesta['msg'] = 'por favor ingrese el codigo de la pelicula';
        }
        if( empty($this->datos['nombre']) ){
            $this->respuesta['msg'] = 'por favor ingrese el nombre de la pelicula';
        }
        if( empty($this->datos['genero']) ){
            $this->respuesta['msg'] = 'por favor ingrese el genero de la pelicula';
        }
        if( empty($this->datos['pais']) ){
            $this->respuesta['msg'] = 'por favor ingrese el pais de origen de la pelicula';
        }
        if( empty($this->datos['año']) ){
            $this->respuesta['msg'] = 'por favor ingrese el año de estreno de la pelicula';
        }
      
        $this->almacenar_peliculas();
    }
    private function almacenar_peliculas(){
        if( $this->respuesta['msg']==='correcto' ){
            if( $this->datos['accion']==='nuevo' ){
                $this->db->consultas('
                    INSERT INTO peliculas (codigo,nombre,genero,pais,año) VALUES(
                        "'. $this->datos['codigo'] .'",
                        "'. $this->datos['nombre'] .'",
                        "'. $this->datos['genero'] .'",
                        "'. $this->datos['pais'] .'",
                        "'. $this->datos['año'] .'"
                    )
                ');
                $this->respuesta['msg'] = 'Pelicula Registrada';
            }else if($this->datos['accion']==='modificar'){
                $this->db->consultas('
                UPDATE peliculas SET
                     codigo     = "'. $this->datos['codigo'] .'",
                     nombre     = "'. $this->datos['nombre'] .'",
                     genero     = "'. $this->datos['genero'] .'",
                     pais       = "'. $this->datos['pais'] .'",
                     año        = "'. $this->datos['año'] .'"
                 WHERE idPelicula = "'. $this->datos['idPelicula'] .'"
             ');
             $this->respuesta['msg'] = 'Pelicula actualizada con exito';
            

            }
        }
    }
    public function buscarPeliculas($valor=''){
        $this->db->consultas('
            select peliculas.idPelicula, peliculas.codigo, peliculas.nombre, peliculas.genero, peliculas.pais, peliculas.año
            from peliculas
            where peliculas.codigo like "%'.$valor.'%" or peliculas.nombre like "%'.$valor.'%" or peliculas.genero like "%'.$valor.'%"
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