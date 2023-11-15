$(document).ready(function(){

    $('.logoutBtn').click(function(e) {
        e.preventDefault();

        // var form = $('form').get(0);
        var formu = $(this);

        // var tipo = formu.attr('data-form');
        // var accion = formu.attr('action');
        // var metodo = formu.attr('method');
        var respuesta = formu.children('.answer');

        // var msjError = "<script>new swal('Ocurrió un error inesperado', 'Por favor actualice la página', 'error');</script>";


        // var textoAlerta;
        // if(tipo === "save") {
        //     textoAlerta = "Los datos se almacenarán en el sistema";
        // } else if(tipo === "delete") {
        //     textoAlerta = "Los datos se eliminarán del sistema";
        // } else if(tipo === "update") {
        //     textoAlerta = "Los datos se actualizarán";
        // } else if(tipo === "register") {
        //     textoAlerta = "El reporte será generado";
        // } else {
        //     textoAlerta = "¿Quieres realizar la operación?";
        // }

        new swal({
            title: "¿Quieres Cerrar la Sesión?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí",
            cancelButtonText: "No"
        }).then((result) => {
            if(result.isConfirmed) {
                $.ajax({
                    url: 'conexiones/logout.php',
                    type: "POST",
                    data: "",
                    processData: false,
                    contentType: false,
                    beforeSend: function(){},
                    success: function(data) {
                        respuesta.html(data);
                    },
                    error: function() {
                        respuesta.html(msjError);
                    }
                });
            } else if(result.isDenied) {
            }
        });
    });
});
