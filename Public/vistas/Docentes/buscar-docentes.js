export function modulo(){
    var $ = el => document.querySelector(el),
        frmBuscarDocente = $("#txtBuscarDocente");
        frmBuscarDocente.addEventListener('keyup',e=>{
        traerDatos(frmBuscarDocente.value);
    });
    let modificarDocente = (docente)=>{
        $("#frmDocentes").dataset.accion = 'modificar';
        $("#frmDocentes").dataset.idDocente = docente.idDocente;
        $("#txtCodigoDocente").value = docente.codigo;
        $("#txtNombreDocente").value = docente.nombre;
        $("#txtDireccionDocente").value = docente.direccion;
        $("#txtTelefonoDocente").value = docente.telefono;
    
    };
    let eliminarDocente = (idDocente)=>{
        fetch(`private/Modulos/Docentes/procesosdoc.php?proceso=eliminarDocente&docente=${idDocente}`).then( resp=>resp.json() ).then(resp=>{
            traerDatos('');
        });
    };
    let traerDatos = (valor)=>{
        fetch(`private/Modulos/Docentes/procesosdoc.php?proceso=buscarDocente&docentes=${valor}`).then( resp=>resp.json() ).then(resp=>{
            let filas = ''
            resp.forEach(docente => {
                filas += `
                    <tr data-idDocente='${docente.idDocente}'data-idDocente='${ JSON.stringify(docente) }'>
                        <td>${docente.codigo}</td>
                        <td>${docente.nombre}</td>
                        <td>${docente.direccion}</td>
                        <td>${docente.telefono}</td>
                      
                        <td>
                            <input type="button" class="btn btn-outline-danger text-white" value="del">
                        </td>
                    </tr>
                `;
            });
            $("#tbl-buscar-docentes > tbody").innerHTML = filas;
            $("#tbl-buscar-docentes > tbody").addEventListener("click",e=>{
                if( e.srcElement.parentNode.dataset.docentes==null ){
                    let confirmacion = confirm(`¿Seguro que quiere eliminar el registro?`)

                    if (confirmacion == true) {
                    eliminarDocente( e.srcElement.parentNode.parentNode.dataset.idDocente );
                    }
                } else {
                    modificarDocente( JSON.parse(e.srcElement.parentNode.dataset.docente) );
                }
            });
        });
    };
    traerDatos('');
}