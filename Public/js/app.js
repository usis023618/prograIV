var $ = el => document.querySelector(el);
document.addEventListener("DOMContentLoaded",event=>{
    let alumnos = document.getElementById("id_alumnos");
    let docentes = document.getElementById("id_docentes");
    docentes.addEventListener("click",e=>{
        e.stopPropagation();
        let vistas="docentes";
        mostrarVista(vistas);
    });
    alumnos.addEventListener("click", e=>{
        e.stopPropagation();
        let vistas="alumnos"
        mostrarVista(vistas);
    });
}); 

 function mostrarVista(vistas){
    fetch(`Public/vistas/${vistas}/${vistas}.html`).then(resp => resp.text()).then(resp =>{
  document.getElementById(`vistas-${vistas}`).innerHTML=resp;
      let btnCerrar = $(".close");
            btnCerrar.addEventListener("click",event=>{
                $(`#vistas-${vistas}`).innerHTML = "";
            });

            let cuerpo = $("body"),
                script = document.createElement("script");
            script.src = `Public/vistas/${vistas}/${vistas}.js`;
            cuerpo.appendChild(script);

  });
  }

    
