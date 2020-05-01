var appcapacitador = new Vue({
    el:'#frm-capacitador',
    data:{
        capacitador:{
            idCapacitador:0,
            accion       :'nuevo',
            nombre       :'',
            apellido     :'',
            direccion    :'',
            correo       :'',
            genero       :'',
            msg          :''
            }
        },
        methods:{
            guardar:function(){
                fetch(`private/Modulos/Capacitador/procesos.php?proceso=recibirDatos&capacitador=${JSON.stringify(this.capacitador)}`).then(resp => resp.json()).then(resp=>{
                    this.capacitador.msg = resp.msg;
                    this.capacitador.idCapacitador= 0;
                    this.capacitador.nombre   = '';
                    this.capacitador.apellido = '';
                    this.capacitador.direccion= '';
                    this.capacitador.correo   = '';
                    this.capacitador.genero   = '';
                    this.capacitador.accion   = 'nuevo';
                    appBuscarcapacitador.buscarCapacitador();
                 });    
        }
        }
});