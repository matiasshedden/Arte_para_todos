// Captura el formulario de reserva
document.addEventListener("DOMContentLoaded", function() {
    const reservationForm = document.querySelector("form.grid");
    if (!reservationForm) {
        console.error("Formulario de reserva no encontrado. Asegúrate de que tenga la clase 'grid'.");
        return;
    }

    reservationForm.addEventListener("submit", function(event) {
        event.preventDefault(); // Evita el envío tradicional

        let name = document.getElementById("name");
        let tel = document.getElementById("tel");
        let date = document.getElementById("date");
        let time = document.getElementById("time");
        let nro_personas = document.getElementById("nro_personas");

        if (!name || !tel || !date || !time || !nro_personas) {
            console.error("Uno o más campos del formulario no fueron encontrados. Verifica los IDs en el HTML.");
            return;
        }

        if (!(name.value && tel.value && date.value && time.value && nro_personas.value)) {
            alert("Por favor, completa todos los campos antes de reservar.");
            return;
        }

        // Enviar datos por AJAX
        const formData = new FormData(reservationForm);

        fetch("/Arte_para_todos/process_reservation.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data.includes("éxito") || data.includes("exito")) {
                alert("¡Reserva realizada con éxito!");
                reservationForm.reset();
                window.location.hash = "#home";
            } else {
                alert(data); // Muestra el mensaje de error del servidor
            }
        })
        .catch(error => {
            alert("Ocurrió un error al procesar la reserva.");
            console.error(error);
        });
    });

    const dateInput = document.getElementById('date');
    if (!dateInput) {
        console.error("El campo de fecha no fue encontrado. Verifica el ID 'date' en el HTML.");
        return;
    }

    dateInput.addEventListener('input', function () {
        const selectedDate = new Date(this.value);
        if (isNaN(selectedDate)) {
            console.error("Fecha seleccionada no válida. Verifica el formato de entrada.");
            return;
        }

        const day = selectedDate.getDay(); // 5 = Saturday

        // Permitir solo sábados (day === 5)
        if (day !== 5) {
            alert('Solo se permiten reservas los sábados.');
            this.value = ''; // Limpiar el valor si no es válido
        }
    });
});
