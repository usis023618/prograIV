var appBuscarUsuario= new Vue({
    el: '#frm-buscar-usuario',
    
    data: {
        misusuario: [],
        valor: ''
    },
    methods: {
        buscarUsuario: function () {
            fetch(`private/Modulos/Usuario/procesos.php?proceso=buscarUsuario&usuario=${this.valor}`).then(resp => resp.json()).then(resp => {
                this.misusuario = resp;
            });
        },
        modificarUsuario: function (usuario) {
            appusuario.usuario =usuario;
            appusuario.usuario.accion = 'modificar';
        },
        eliminarUsuario: function (idUsuario) {
            fetch(`private/Modulos/Usuario/procesos.php?proceso=eliminarUsuario&usuario=${idUsuario}`).then(resp => resp.json()).then(resp => {
                this.buscarUsuario();
            });
        
        }
    },
    created: function () {
        this.buscarUsuario();
    }
});
