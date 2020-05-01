var appBuscarCapacitador = new Vue({
    el: '#frm-buscar-capacitador',
    
    data: {
        miscapacitador: [],
        valor: ''
    },
    methods: {
        buscarCapacitador: function () {
            fetch(`private/Modulos/Capacitador/procesos.php?proceso=buscarCapacitador&capacitador=${this.valor}`).then(resp => resp.json()).then(resp => {
                this.miscapacitador = resp;
            });
        },
        modificarCapacitador: function (capacitador) {
            appcapacitador.capacitador = capacitador;
            appcapacitador.capacitador.accion = 'modificar';
        },
        eliminarCapacitador: function (idCapacitador) {
            fetch(`private/Modulos/Capacitador/procesos.php?proceso=eliminarCapacitador&capacitador=${idCapacitador}`).then(resp => resp.json()).then(resp => {
                this.buscarCapacitador();
            });
        
        }
    },
    created: function () {
        this.buscarCapacitador();
    }
});
