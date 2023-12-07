$(document).ready(function(){

    $('.FormularioAjax').submit(function(e) {
        e.preventDefault();

        var form = $('form').get(0);
        var formu = $(this);

        var tipo = formu.attr('data-form');
        var accion = formu.attr('action');
        var metodo = formu.attr('method');
        var respuesta = formu.children('.RespuestaAjax');

        var msjError = "<script>new swal('Ocurrió un error inesperado', 'Por favor actualice la página', 'error');</script>";


        var textoAlerta;
        if(tipo === "save") {
            textoAlerta = "Los datos se almacenarán en el sistema";
        } else if(tipo === "delete") {
            textoAlerta = "Los datos se eliminarán del sistema";
        } else if(tipo === "update") {
            textoAlerta = "Los datos se actualizarán";
        } else if(tipo === "report") {
            textoAlerta = "El reporte será generado";
        } else {
            textoAlerta = "¿Quieres realizar la operación?";
        }

        new swal({
            title: "¿Estás seguro?",
            text: textoAlerta,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if(result.isConfirmed) {
                $.ajax({
                    url: accion,
                    type: metodo,
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    beforeSend: function(){},
                    success: function(data) {
                        respuesta.html(data);
                        // console.log(data);
                    },
                    error: function(error) {
                        respuesta.html("Error: " + error);
                        // console.log("Error: " + error);
                    }
                });
            } else if(result.isDenied) {
            }
        });
    });
});
