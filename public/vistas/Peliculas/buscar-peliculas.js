var appBuscarPeliculas= new Vue({
    el: '#frm-buscar-peliculas',
    
    data: {
        mispeliculas: [],
        valor: ''
    },
    methods: {
        buscarPelicula: function () {
            fetch(`private/Modulos/Peliculass/procesosdoc.php?proceso=buscarPeliculas&peliculas=${this.valor}`).then(resp => resp.json()).then(resp => {
                this.mispeliculas = resp;
            });
        },
        modificarPelicula: function (peliculas) {
            apppeliculas.peliculas = peliculas;
            apppeliculas.peliculas.accion = 'modificar';
        },
        eliminarPelicula: function (idPelicula) {
            fetch(`private/Modulos/Peliculas/procesosdoc.php?proceso=eliminarPeliculas&peliculas=${idPelicula}`).then(resp => resp.json()).then(resp => {
                this.buscarPelicula();
            });
        
        }
    },
    created: function () {
        this.buscarPelicula();
    }
});
