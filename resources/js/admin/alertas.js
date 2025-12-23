function alertaNormal(mensaje) {
    event.preventDefault();

    if (mensaje == "Creado") {
        Swal.fire({
            icon: "success",
            title: mensaje,
            showConfirmButton: false,
            timer: 2500,
        });
    } else if (mensaje == "Actualizado") {
        Swal.fire({
            icon: "success",
            title: mensaje,
            showConfirmButton: false,
            timer: 2500,
        });
    } else if (mensaje == "Eliminado") {
        Swal.fire({
            icon: "success",
            title: mensaje,
            showConfirmButton: false,
            timer: 2500,
        });
    } else {
    }
}

Livewire.on("alertaLivewire", (mensaje) => {
    if (
        mensaje == "Creado" ||
        mensaje == "Actualizado" ||
        mensaje == "Validado" ||
        mensaje == "Enviado"
    ) {
        Swal.fire({
            icon: "success",
            title: mensaje,
            showConfirmButton: false,
            timer: 2500,
        });
    } else if (mensaje == "Error") {
        Swal.fire({
            icon: "error",
            title: "¡Alto!",
            text: mensaje,
            showConfirmButton: false,
            timer: 2500,
        });
    } else if (mensaje == "Eliminado") {
        Swal.fire({
            icon: "error",
            title: mensaje,
            text: mensaje,
            showConfirmButton: false,
            timer: 2500,
        });
    } else {
        Swal.fire({
            icon: "error",
            title: "¡Alto!",
            text: mensaje,
            showConfirmButton: true,
            timer: 2500,
        });
    }
});
