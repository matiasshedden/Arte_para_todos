// Captura el formulario de reserva
document.addEventListener("DOMContentLoaded", function() {
    const reservationForm = document.querySelector("form.grid");
    if (!reservationForm) {
        console.error("Formulario de reserva no encontrado. Asegúrate de que tenga la clase 'grid'.");
        return;
    }

    reservationForm.addEventListener("submit", function(event) {
        event.preventDefault(); // Evita el envío del formulario por defecto

        // Captura los valores ingresados por el usuario
        let name = document.getElementById("name");
        let tel = document.getElementById("tel");
        let date = document.getElementById("date");
        let time = document.getElementById("time");

        if (!name || !tel || !date || !time) {
            console.error("Uno o más campos del formulario no fueron encontrados. Verifica los IDs en el HTML.");
            return;
        }

        // Verifica que los campos no estén vacíos
        if (name.value && tel.value && date.value && time.value) {
            alert(`¡Gracias, ${name.value}! Tu reserva para el ${date.value} a las ${time.value} ha sido registrada. Te enviaremos un mensaje de confirmación a: ${tel.value}.`);
            reservationForm.reset(); // Limpia el formulario después del envío
        } else {
            alert("Por favor, completa todos los campos antes de reservar.");
        }
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

        const day = selectedDate.getDay(); //5 = Saturday
        console.log("Día seleccionado: " + day); // Para depuración

        // Permitir solo sábados (day === 5)
        if (day !== 5) {
            alert('Solo se permiten reservas los sábados.');
            this.value = ''; // Limpiar el valor si no es válido
        }
    });
});
