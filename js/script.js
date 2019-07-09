function goSite(site){
    window.location.href = site;
}

function cargarDatosPerfil(){
    var inputDatos = document.getElementById("datosUser").getAttribute("name").split(",");
    document.getElementById("name").setAttribute("placeholder", inputDatos[0]);
    document.getElementById("name").value = inputDatos[0];
    document.getElementById("email").setAttribute("placeholder", inputDatos[1]);
    document.getElementById("email").value = inputDatos[1];
    document.getElementById("email").setAttribute("placeholder", inputDatos[1]);
    document.getElementById("gender").value = inputDatos[2];
    document.getElementById("gender").setAttribute("placeholder", inputDatos[2]);
    document.getElementById("birthdate").value = inputDatos[3];
    document.getElementById("birthdate").setAttribute("value", inputDatos[3]);
    document.getElementById("birthdate").setAttribute("placeholder", inputDatos[3]);
    if (inputDatos[4] != ""){
        document.getElementById("image").setAttribute("placeholder", "Ruta de la imagen: jpg, png, svg, gif");
        document.getElementById("image").value = inputDatos[4];
    }
    
}

function abrirInputRespuesta(){
    let boton = event.target;
    if (boton.nextSibling == null || (boton.nextSibling.nodeName != "TEXTAREA" && boton.nextSibling.nodeName != "DIV")) {
        let textRespuesta = $("<textarea></textarea").attr({
            "class" : "form-control text_area text_area_respuesta",
            "rows" : "5",
            "maxlength" : "1000",
            "placeholder" : "¿En qué estás pensando?",
        }).css("font-family", "Philosopher Regular").insertAfter(boton);
        let boton_enviar = $("<button>").attr({
           "value" : "Enviar",
           "class" : "send-text-area submit_enviar boton_respuesta_enviar",
           "onclick" : "peticionPagina('POST', 'config/showThisPage.php', " + getPageColor() +",cargarPosts)"
        }).css("font-family", "Philosopher Regular").html("Enviar");
        boton_enviar.insertAfter(textRespuesta);
    } else {
        document.getElementById("posts_container").removeChild(boton.nextSibling);
        document.getElementById("posts_container").removeChild(boton.nextSibling);
    }
}

function getPageColor(){
    let num = parseInt($("a[style*='color: red']").text());
    if (num == null){
        return 1;
    } else {
        return num;
    }
}

function cargarEmojis(){
    // Initializes and creates emoji set from sprite sheet
    window.emojiPicker = new EmojiPicker({
      emojiable_selector: '[data-emojiable=true]',
      assetsPath: 'emoji/img/',
      popupButtonClasses: 'fa fa-smile-o'
    });
    // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
    // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
    // It can be called as many times as necessary; previously converted input fields will not be converted again
    window.emojiPicker.discover();

}