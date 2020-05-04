var apppeliculas = new Vue({
    el:'#frm-peliculas',
    data:{
        peliculas:{
            idPelicula    :0,
            accion      :'nuevo',
            codigo      :'',
            nombre      :'',
            genero      :'',
            pais        :'',
            año         :'',
            msg         :''
            }
        },
        methods:{
            guardarPelicula:function(){
                fetch(`private/Modulos/Peliculas/procesos.php?proceso=recibirDatos&peliculas=${JSON.stringify(this.peliculas)}`).then(resp => resp.json()).then(resp=>{
                    this.peliculas.msg = resp.msg;
                    this.peliculas.idPelicula = 0;
                    this.peliculas.codigo = '';
                    this.peliculas.nombre = '';
                    this.peliculas.genero = ''
                    this.peliculas.pais = '';
                    this.peliculas.año = '';
                    this.peliculas.accion = 'nuevo';
                    appBuscarPeliculas.buscarPeliculas();
                 });
        }
        }
});