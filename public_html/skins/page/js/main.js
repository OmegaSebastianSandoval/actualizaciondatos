var videos = [];
$(document).ready(function(){
    $(".carouselsection").carousel({
        quantity : 4,
        sizes : {
          '900' : 3,
          '500' : 1
        }
    });
    $(".banner-video-youtube").each(function(){
        //console.log($(this).attr("data-video"));
        var datavideo = $(this).attr("data-video");
        var idvideo = $(this).attr("id");
        var playerDefaults = {autoplay: 0, autohide: 1, modestbranding: 0, rel: 0, showinfo: 0, controls: 0, disablekb: 1, enablejsapi: 0, iv_load_policy: 3};
        var video = {'videoId':datavideo, 'suggestedQuality': 'hd720'};
        videos[videos.length] = new YT.Player(idvideo,{ 'videoId':datavideo, playerVars: playerDefaults,events: {
          'onReady': onAutoPlay,
          'onStateChange': onFinish
        }});
    });
    function onAutoPlay(event){
        event.target.playVideo();
        event.target.mute();
    }
    function onFinish(event) {
        if(event.data === 0) {
            event.target.playVideo();
        }
    }
    function addCommas(nStr)
    {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }



    function calcularenvio(){

        var total = 0;
        var cantidadtotal = 0;
        var envio = $("#pedido_envio").val();
        if (!envio) {
            envio = 0;
        }
        $(".btn-minus").each(function() {
           var id = $(this).attr("data-id");
           var cantidad = $("#cantidad"+id).val();
            var valorunitario = $("#valorunitario"+id).val();
            var valortotal =  parseInt(valorunitario)*parseInt(cantidad);
            total = parseInt(total) + parseInt(valortotal);
            cantidadtotal = parseInt(cantidadtotal) + parseInt(cantidad);
        });
        var valorpagar = parseInt(envio) + total;

        $("#pedido_valorpagar").html("$ "+addCommas(parseInt(valorpagar))+" COP");
        $("#pedido_enviocosto").html("$ "+addCommas(parseInt(envio))+" COP");
        $("#pedido_valorpagar1").val(parseInt(valorpagar));
    }




    $("body").on("click",".addnom",function(){
        var id = $(this).attr("data-id");
        var nombre = $("#nombre"+id).val();
        var imagen1 = $("#imagen"+id).val();
        var imagen = "/images/"+imagen1;
        var descripcion = $("#descripcion"+id).val();
        var precio1 = $("#precio"+id).val();
        var precio = '<i class="fas fa-tag etiqueta_precio"></i> $'+precio1;
        var id = $("#id"+id).val();

        if(imagen1==""){
            imagen = "/corte/product.png";
        }

        document.getElementById("nombremodal").innerHTML = nombre;
        document.getElementById("nombremodal2").innerHTML = nombre;
        document.getElementById("imagenmodal").src = imagen;
        document.getElementById("descripcionmodal").innerHTML = descripcion;
        document.getElementById("btnModal").dataset.id = id;
        document.getElementById("preciomodal").innerHTML = precio;
    });






    $(".btn-menu").on("click",function(){
        if($(".botonera-resposive").is(":visible")){
            $(".botonera-resposive").slideUp(300);
        } else {
            $(".botonera-resposive").slideDown(300);
        }
    });


    $('#menu').find('ul').find('li');

    $('#menu').hover(function() {
        $(this).children('ul').stop();
        $(this).children('ul').slideDown();
    }, function() {
        $(this).children('ul').stop();
        $(this).children('ul').slideUp();
    });

/*

  $("#buscar").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#mydiv .product").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
*/

});