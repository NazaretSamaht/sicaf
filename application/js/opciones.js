function showMessages(objMessages, inner){
    html = "";
    for (typeMessage in objMessages){
        for (message in objMessages[typeMessage]){
            html += '<div class="'+typeMessage+'">'+objMessages[typeMessage][message]+'</div>';
        }
    }
    $(inner).html(html).fadeIn();
}


$(document).ready(function(){
    
    $("#t_usuario").change(function(){
        $.post(site_url+'/usuario/cargar_opciones/'+$(this).val(),function(data){
            $("#div").html(data);
             
        })
        $('#div_div').empty();
        $('#coord').empty();
        
    });
    $("#cargo").live('change',function(){

        $.post(site_url+'/usuario/cargar_ad/'+$(this).val(),function(data){
            $("#div_div").html(data);
             
        })
	
        
    });
    
    $("#division").live('change',function(){
        $.post(site_url+"/usuario/cargar_coord/"+$(this).val(),function(data){
            $("#coord").html(data);
        })
    }); 
    var correo='';
    $('#ci').blur(function(){
        $(".spinner").fadeIn("fast");
        $("#divResult").fadeOut();
        $("#divError").fadeOut();
        $.getJSON(site_url+"/usuario/datos_usuario/"+$(this).val()).done(function(data) {
            $(".spinner").hide();
            if (! data.error){
                usuario = data.usuario;
                $('#nombres').text(usuario.nombre_apellido);
                correo=usuario.correo;
                $("#divResult").fadeIn('fast');
            }
            
            showMessages(data.messages, '#divError');

        });
        
    });
    
    $('#crearUsuario').click(function(e){
        $data = {
            'user' : $('#ci').val(),
            'password' : $('#password').val(),
            'password_repeat' : $('#password_repeat').val(),
            'correo':correo
        };
        $sp = $('<span class="spinner" stile="float:left; clear:both"></span>').hide().appendTo('#tdBoton').fadeIn();
        $("#divError").fadeOut();
        
        
        $.getJSON(site_url+"/usuario/crear_usuario", $data).done(function(data) {
            $sp.hide('fast', function() {
                $sp.remove()
                });
            showMessages(data.messages, '#divError');
        });
        e.preventDefault();
    })
    
    
    
    
});