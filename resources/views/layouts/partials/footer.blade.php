<div class="row">
    <div class="col-md-12 text-center">
        <div>
            <h6><span class="text-secondary">Desarrollado por</span> David Durán</h6>
            <p class="mb-0">con Laravel + Bootstrap</p>
            <p class="my-0"><i class="far fa-smile"></i></p>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $(document).on("change","form#consulta_de_movimientos", function(){ // Si tratamos con HTML dinámico, AJAX funciona porque le decimos que el elemento dinámico es un form
            console.log('[ajax-onchange] Submit automático para: '+this.id);
            $('#'+this.id).submit();
        });

        $(document).on("submit","form#consulta_de_movimientos", function(e){
            e.preventDefault();
            var _token = $("input[name='_token']").val();
            var tarjeta = $("#select_consulta_movimientos option:selected").text();
            $.ajax({
                // url: "http://127.0.0.1:8000/movimientos/"+tarjeta,
                url: "https://kromasolbanco.duran.company/movimientos/"+tarjeta,
                type:'GET',
                data: {_token:_token, tarjeta:tarjeta},
                success: function(data) {
                    if($.isEmptyObject(data.error)){
                        $('#wrapper_resultado_consulta_de_movimientos').html(data.resultado);
                        jQuery("html, body").animate({
                            scrollTop: jQuery("#wrapper_resultado_consulta_de_movimientos").offset().top
                        }, 2000);
                    }
                    else{
                        printErrorMsg(data.error);
                    }
                }
            });
           
        });
    });
</script>
