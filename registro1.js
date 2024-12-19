function redirigirFormulario() {
    var select = document.getElementById('opciones');
    var selectedOption = select.value;
    
    if (selectedOption) {
        window.location.href = "registro2.html?tabla=" + encodeURIComponent(selectedOption);
    }
}

                  