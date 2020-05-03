var appdocente = new Vue({
    el:'#frm-docentes',
    data:{
        docente:{
            idDocente    :0,
            accion      :'nuevo',
            codigo      :'',
            nombre      :'',
            direccion   :'',
            telefono    :'',
            DUI         :'',
            msg         :''
            }
        },
        methods:{
            guardarDocente:function(){
                fetch(`private/Modulos/Clientes/procesos.php?proceso=recibirDatos&clientes=${JSON.stringify(this.clientes)}`).then(resp => resp.json()).then(resp=>{
                    this.docente.msg = resp.msg;
                    this.docente.idDocente = 0;
                    this.docente.codigo = '';
                    this.docente.nombre = '';
                    this.docente.direccion = ''
                    this.docente.telefono = '';
                    this.docente.DUI = '';
                    this.docente.accion = 'nuevo';
                    appBuscarDocentes.buscarDocente();
                 });
        }
        }
});