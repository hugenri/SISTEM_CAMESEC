document.addEventListener('DOMContentLoaded', function () {
    // Cargar estados al inicio
    fetch('actions/estados.php')
        .then(response => response.json())
        .then(data => {
            const estadosSelect = document.getElementById('estado');
            
            // Verificar si los datos son un objeto con la propiedad 'data' que es un array
            if (data && Array.isArray(data.data)) {
                data.data.forEach(estado => {
                    const option = document.createElement('option');
                    option.value = estado.estado;
                    option.textContent = estado.estado;
                    estadosSelect.appendChild(option);
                });
            } else {
                console.error('Error: Los datos de estados no son un array válido', data);
            }
        })
        .catch(error => {
            console.error('Error al cargar estados: ' + error);
        });

    // Manejar cambio de estado
    document.querySelector('#estado').addEventListener('change', event => {
        const formData = new FormData();
        formData.append('estado', event.target.value);

        fetch('actions/municipios.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                const municipiosSelect = document.getElementById('municipio');
                municipiosSelect.innerHTML = '<option value="">Seleccionar municipio</option>';
                
                // Verificar si los datos son un objeto con la propiedad 'data' que es un array
                if (data && Array.isArray(data.data)) {
                    data.data.forEach(municipio => {
                        const option = document.createElement('option');
                        option.value = municipio.municipio;
                        option.textContent = municipio.municipio;
                        municipiosSelect.appendChild(option);
                    });
                } else {
                    console.error('Error: Los datos de municipios no son un array válido', data);
                }
            })
            .catch(error => {
                console.error('Error al cargar municipios: ' + error);
            });
    });
});
