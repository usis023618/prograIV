var appBuscarClientes = new Vue({
    el: '#frm-buscar-clientes',
    data: {
        misclientes: [],
        valor: ''
    },
    methods: {
        buscarCliente: function () {
            fetch(`private/Modulos/Clientes/procesos.php?proceso=buscarClientes&clientes=${this.valor}`).then(resp => resp.json()).then(resp => {
                this.misclientes = resp;
            });
        },
        modificarCliente: function (clientes) {
            appcliente.clientes = clientes;
            appcliente.clientes.accion = 'modificar';
        },
        eliminarClientes: function (idCliente) {
            var confirmacion = confirm("¿estas seguro de eliminar el registro?..");
            if (confirmacion) {
                alert(" El registro se elimino corretamente");
                fetch(`private/Modulos/Clientes/procesos.php?proceso=eliminarClientes&clientes=${idCliente}`).then(resp => resp.json()).then(resp => {
                    this.buscarCliente();
                });
            }
        }
    },
    created: function () {
        this.buscarCliente();
    }
});