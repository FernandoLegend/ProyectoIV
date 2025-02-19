
// Datos de las opciones

const options = {
    contrato_a_tiempo_determinado: [
        { value: "fin_de_contrato", text: "Culminación de contrato" },
        { value: "despido", text: "Despido" },
        { value: "renuncia", text: "Renuncia" },
        { value: "incapacidad", text: "Incapacidad" },
        { value: "deceso", text: "Deceso" },
    ],
    renovacion_de_contrato: [
        { value: "fin_de_contrato", text: "Culminación de contrato" },
        { value: "despido", text: "Despido" },
        { value: "renuncia", text: "Renuncia" },
        { value: "incapacidad", text: "Incapacidad" },
        { value: "deceso", text: "Deceso" },
    ],
    contrato_sin_fecha_de_culminacion: [
        { value: "despido", text: "Despido" },
        { value: "renuncia", text: "Renuncia" },
        { value: "incapacidad", text: "Incapacidad" },
        { value: "deceso", text: "Deceso" },
    ],
    empleado_fijo: [
        { value: "despido", text: "Despido" },
        { value: "renuncia", text: "Renuncia" },
        { value: "incapacidad", text: "Incapacidad" },
        { value: "deceso", text: "Deceso" },
    ],
    comision_de_servicio: [
        { value: "culminacion_de_comision_de_servicio", text: "Culminación de comisión de servicio" },
        { value: "despido", text: "Despido" },
        { value: "renuncia", text: "Renuncia" },
        { value: "incapacidad", text: "Incapacidad" },
        { value: "deceso", text: "Deceso" },
    ],
};

// Referencias a los selects
const categorySelect = document.getElementById("category");
const subcategorySelect = document.getElementById("subcategory");

// Evento para cambiar las opciones del segundo select
categorySelect.addEventListener("change", function () {
    const selectedCategory = categorySelect.value;

    // Limpiar las opciones previas
    subcategorySelect.innerHTML = '<option value="">Seleccione...</option>';

    // Verificar si hay opciones para la categoría seleccionada
    if (options[selectedCategory]) {
        options[selectedCategory].forEach(option => {
            const optElement = document.createElement("option");
            optElement.value = option.value;
            optElement.textContent = option.text;
            subcategorySelect.appendChild(optElement);
        });
    }
});