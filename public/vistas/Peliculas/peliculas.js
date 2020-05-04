var apppeliculas = new Vue({
    el:'#frm-peliculas',
    data:{
        peliculas:{
            idPelicula    :0,
            accion        :'nuevo',
            descripcion   :'',
            sinopsis      :'',
            genero        :'',
            duracion      :'',
            msg           :''
            }
        },
        methods:{
            guardarPelicula:function(){
                fetch(`private/Modulos/Peliculas/procesos.php?proceso=recibirDatos&peliculas=${JSON.stringify(this.peliculas)}`).then(resp => resp.json()).then(resp=>{
                    this.peliculas.msg = resp.msg;
                    this.peliculas.idPelicula = 0;
                    this.peliculas.descripcion = '';
                    this.peliculas.sinopsis = '';
                    this.peliculas.genero = ''
                    this.peliculas.duracion = '';
                    this.peliculas.accion = 'nuevo';
                    appBuscarPeliculas.buscarPeliculas();
                 });
        }
        }
});