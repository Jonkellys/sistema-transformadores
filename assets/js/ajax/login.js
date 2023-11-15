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


        new swal({
            title: "Comprobando...",
            icon: "question",
            iconHtml: '<div class="spinner-grow text-primary" role="status"><span class="sr-only"></span></div>',
            showConfirmButton: false,
            timer: 3000
        }).then(function() {
            $.ajax({
                url: accion,
                type: metodo,
                data: new FormData(form),
                processData: false,
                contentType: false,
                success: function(data) {
                    respuesta.html(data);
                },
                error: function() {
                    respuesta.html(msjError);
                }
            });
            return false;
        });
    });
});
