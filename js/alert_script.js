// script de ocultacion de alertas
document.addEventListener('DOMContentLoaded', function() {
    // Después de 3 segundos, hacer las alertas transparentes
    setTimeout(function() {
        home.classList.toggle("scroll_hidden");
        var alertas = document.querySelectorAll('.alert');

        alertas.forEach(function(alerta) {
            alerta.classList.add('transparente');
        });
              
        // Después de otros 3 segundos, eliminar las alertas
        setTimeout(function() {
            alertas.forEach(function(alerta) {
                alerta.style.display = 'none';
            });
        }, 3000);
    }, 3000);
});