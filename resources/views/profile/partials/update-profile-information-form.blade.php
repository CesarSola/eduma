<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informacion de perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#buscar-btn').click(function() {
            var codigoPostal = $('#codigo_postal').val();

            // Realizar la solicitud AJAX
            $.ajax({
                type: 'POST',
                url: "{{ route('obtener-detalles-codigo-postal') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    codigo_postal: codigoPostal
                },
                success: function(response) {
                    if (response.codigosPostales) {
                        var coloniaSelect = $('#d_asenta');
                        var municipioSelect = $('#D_mnpio');
                        var estadoSelect = $('#d_estado');
                        var ciudadSelect = $('#d_ciudad');

                        coloniaSelect.empty().append('<option value="">Selecciona una colonia</option>'); // Limpiar y agregar la opción predeterminada
                        municipioSelect.empty().append('<option value="">Selecciona un municipio</option>'); // Limpiar y agregar la opción predeterminada
                        estadoSelect.empty().append('<option value="">Selecciona un estado</option>'); // Limpiar y agregar la opción predeterminada
                        ciudadSelect.empty().append('<option value="">Selecciona una ciudad</option>'); // Limpiar y agregar la opción predeterminada

                        var municipiosUnicos = new Set();
                        var estadosUnicos = new Set();
                        var ciudadesUnicas = new Set();

                        var primerLugar = response.codigosPostales[0];

                        coloniaSelect.append('<option value="' + primerLugar.d_asenta + '" selected>' + primerLugar.d_asenta + '</option>'); // Seleccionar la primera opción
                        municipioSelect.append('<option value="' + primerLugar.D_mnpio + '" selected>' + primerLugar.D_mnpio + '</option>'); // Seleccionar la primera opción
                        estadoSelect.append('<option value="' + primerLugar.d_estado + '" selected>' + primerLugar.d_estado + '</option>'); // Seleccionar la primera opción
                        ciudadSelect.append('<option value="' + primerLugar.d_ciudad + '" selected>' + primerLugar.d_ciudad + '</option>'); // Seleccionar la primera opción

                        municipiosUnicos.add(primerLugar.D_mnpio);
                        estadosUnicos.add(primerLugar.d_estado);
                        ciudadesUnicas.add(primerLugar.d_ciudad);

                        $.each(response.codigosPostales, function(index, lugar) {
                            if (index !== 0) {
                                coloniaSelect.append('<option value="' + lugar.d_asenta + '">' + lugar.d_asenta + '</option>'); // Agregar opciones de colonia

                                if (!municipiosUnicos.has(lugar.D_mnpio)) {
                                    municipioSelect.append('<option value="' + lugar.D_mnpio + '">' + lugar.D_mnpio + '</option>'); // Agregar opciones de municipio
                                    municipiosUnicos.add(lugar.D_mnpio);
                                }
                                if (!estadosUnicos.has(lugar.d_estado)) {
                                    estadoSelect.append('<option value="' + lugar.d_estado + '">' + lugar.d_estado + '</option>'); // Agregar opciones de estado
                                    estadosUnicos.add(lugar.d_estado);
                                }
                                if (!ciudadesUnicas.has(lugar.d_ciudad)) {
                                    ciudadSelect.append('<option value="' + lugar.d_ciudad + '">' + lugar.d_ciudad + '</option>'); // Agregar opciones de ciudad
                                    ciudadesUnicas.add(lugar.d_ciudad);
                                }
                            }
                        });
                    } else {
                        console.log(response.error); // Manejar mensaje de error
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log('Error al obtener los detalles: ' + textStatus); // Manejar error de solicitud AJAX
                }
            });
        });
    });
</script>
