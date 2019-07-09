/*(function popstate(){
    window.addEventListener("popstate", function(){
        let rutaActual = window.location.pathname;
        peticionPagina("POST", window.location.origin + "/ProyectoBlog_v3/config/showThisPage.php", rutaActual.slice(rutaActual.length - 1) ,cargarPosts)
        alert(rutaActual);
    });
    if(performance.navigation.type == 1) {
        alert("recargó!");
    }
    //history.replaceState(window.location.origin + "/ProyectoBlog_v3/app.php", null, window.location.origin + "/ProyectoBlog_v3/app/");
})();

/* -------------------------------------------------------------------------
 * -------------------------CARGADO DE POSTS--------------------------------
 * -------------------------------------------------------------------------
 */

// HECHO! Te pilla los datos con un callback
function cargarPosts(data){
    vaciarPostsContainer();
    for (let i = 0; i < data.Posts.length; i++) {
        let post = document.createElement("p");
        let fecha_post = document.createElement("p");
        let usuario_post = document.createElement("p");
        let boton_flecha = document.createElement("button");
        
        boton_flecha.setAttribute("class", "form-control boton_respuesta");
        boton_flecha.setAttribute("onclick", "abrirInputRespuesta()");
        post.setAttribute("class", "form-control posts");
        usuario_post.setAttribute("class", "form-control usuario");
        fecha_post.setAttribute("class", "form-control fecha");
        fecha_post.setAttribute("name", data.Posts[i].Fecha);
        
        let myDate = new Date(data.Posts[i].Fecha);
        post.innerHTML = data.Posts[i].Texto;
        usuario_post.innerHTML = data.Posts[i].Usuario;
        fecha_post.innerHTML = myDate.getHours() + ":" + myDate.getMinutes() + ":" + myDate.getSeconds() + " " + myDate.getDate() + "/" + ("0" + (myDate.getMonth() + 1)).slice(-2) + "/" + myDate.getFullYear();
        
        document.getElementById("posts_container").appendChild(post);
        document.getElementById("posts_container").appendChild(fecha_post);
        document.getElementById("posts_container").appendChild(usuario_post);
        document.getElementById("posts_container").appendChild(boton_flecha);
        
        for (let x = 0; x < data.Posts[i].Comentarios.length; x++) {
            let comentario = document.createElement("p");
            let fecha_comentario = document.createElement("p");
            let usuario_comentario = document.createElement("p");
            comentario.setAttribute("class", "form-control comentarios");
            usuario_comentario.setAttribute("class", "form-control usuario");
            fecha_comentario.setAttribute("class", "form-control fecha");
            let myDate = new Date(data.Posts[i].Comentarios[x].Fecha);
            comentario.innerHTML = data.Posts[i].Comentarios[x].Texto;
            usuario_comentario.innerHTML = data.Posts[i].Comentarios[x].Usuario;
            fecha_comentario.innerHTML = myDate.getHours() + ":" + myDate.getMinutes() + ":" + myDate.getSeconds() + " " + myDate.getDate() + "/" + ("0" + (myDate.getMonth() + 1)).slice(-2) + "/" + myDate.getFullYear();
            document.getElementById("posts_container").appendChild(comentario);
            document.getElementById("posts_container").appendChild(fecha_comentario);
            document.getElementById("posts_container").appendChild(usuario_comentario);
        }
    }
}

function vaciarPostsContainer(){
    while(document.getElementById("posts_container").firstChild){
        document.getElementById("posts_container").removeChild(document.getElementById("posts_container").firstChild);
    }
}

/* -------------------------------------------------------------------------
 * -------------------------CARGADO DE PÁGINAS------------------------------
 * -------------------------------------------------------------------------
 */

// Devuelve el número total de páginas
function peticionCuantasPaginas(method, url, callback){
    var xhr = new XMLHttpRequest();
    try{
        xhr.onreadystatechange = function(){
          if(this.readyState == 4 && this.status == 200){
              var datos = JSON.parse(this.responseText);
              return callback(datos);         
          }
        };
        xhr.open(method, url, true);
        xhr.send();  
    }catch(error){
        return null;
    }    
}

// Devuelve la página concreta pedida
function peticionPagina(method, url, page, callback){
    evento = event.target;
    var xhr = new XMLHttpRequest();
    var formData = new FormData();
    formData.append('page',page);
    if (evento.nodeName == "INPUT") {
        formData.append('textArea', document.getElementById("text_area").value);
    } else if (evento.nodeName == "BUTTON") {
        formData.append('textComentario', evento.previousSibling.value);
        formData.append('autorPost', evento.previousSibling.previousSibling.previousSibling.innerHTML);
        formData.append('fechaPost', evento.previousSibling.previousSibling.previousSibling.previousSibling.getAttribute("name"));
    } else if (evento.nodeName == "A") {
        $("a").css("color", "white");
        evento.style.color = "red";
    }
    try{
        xhr.onreadystatechange = function(){
          if(this.readyState == 4 && this.status == 200){
              var datos = JSON.parse(this.responseText);
              return callback(datos);         
          }
        };
        xhr.open(method, url, true);
        xhr.send(formData);  
    }catch(error){
        return null;
    }    
}

// HECHO! Te pilla los datos con un callback
function cargarPaginas(data){
    while (document.getElementById("footer").firstChild) {
        document.getElementById("footer").removeChild(document.getElementById("footer").firstChild);
    }
    for (let i = 1; i < data.Paginas + 1; i++) {
        let enlace = document.createElement("a");
        enlace.innerHTML = i;
        enlace.setAttribute("onclick", "peticionPagina('POST', '" + window.location.origin + "/ProyectoBlog_v3/config/showThisPage.php', " + i + ",cargarPosts)");
        enlace.setAttribute("href", "javascript:;");
        document.getElementById("footer").appendChild(enlace);
        if(data.Paginas != 1 && i != data.Paginas){
            let separador = document.createElement("span");
            separador.innerHTML = " - ";
            document.getElementById("footer").appendChild(separador);
        }
    }
}

function changeURL(){
    console.log(window.location.origin);
    history.pushState(event.target.pathname, "page:" + event.targetinnerHTML, window.location.origin + "/ProyectoBlog_v3/app/" + event.target.innerHTML);
}
