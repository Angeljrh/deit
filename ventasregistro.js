document.getElementById('ventasRegistroForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('ventasregistro.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        this.reset();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hubo un error al guardar el registro.');
    });
});
