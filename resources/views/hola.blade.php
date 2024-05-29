<form id="formulario-cp" method="POST">
    <label for="codigo_postal">Código Postal:</label>
    <input type="text" id="codigo_postal" name="codigo_postal">
    <button type="submit">Buscar</button>
</form>

<div id="resultado-colonias"></div>

<script>
document.getElementById('formulario-cp').addEventListener('submit', function(e) {
    e.preventDefault();
    var codigoPostal = document.getElementById('codigo_postal').value;

    fetch('/buscar-colonia', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ codigo_postal: codigoPostal })
    })
    .then(response => response.json())
    .then(data => {
        if(data.error) {
            alert(data.error);
        } else {
            var colonias = data.colonias;
            var resultadoHTML = '';
            colonias.forEach(function(colonia) {
                resultadoHTML += '<p>' + colonia + '</p>';
            });
            document.getElementById('resultado-colonias').innerHTML = resultadoHTML;
        }
    })
    .catch(error => console.error('Error:', error));
});
</script>
