// Las siguientes 3 lÃ­neas indican que navegador se esta utilizando. 
isOPERA = (navigator.userAgent.indexOf('Opera') >= 0)? true : false;
isIE    = (document.all && !isOPERA)? true : false;
isDOM   = (document.getElementById && !isIE && !isOPERA)? true : false;

function formatoNumerico(numeroSinFormato){
    var valueCompleto=valueFinal=numeroSinFormato.replace(/\./g,"");
    if (valueCompleto.length > 3){
        pos= ((valueCompleto.length - 1) % 3)+1;
        valueFinal=valueCompleto.substr(0,pos)+".";
        valueCompleto=valueCompleto.substr(pos);
        punto=".";
        while (valueCompleto.length/3 > 0){
            if (valueCompleto.length/3==1) punto="";
            valueFinal+=valueCompleto.substr(0,3)+punto;
            valueCompleto=valueCompleto.substr(3);
        }
    }
    return valueFinal;
}

function formatoTelefono(campo){
    patron=/^0(414|424|416|426|412|212)-\d{3}-\d{2}-\d{2}$/
    if (campo.value.search(patron)==-1) {
		
    }
}

function formatoNumericoKeyPress(campo,e){
    var patron =/^\d$/;
    if (isDOM) codigoTecla = e.which;
    else if (isIE) codigoTecla = e.keyCode;
    if (codigoTecla == 13) return true; // Enter
    if (codigoTecla == 8) return true; // backspace
    if (codigoTecla == 0) return true; // para dejar pasar el tab pero su codigo es 9 y no funciona JAJAJ
    var tecla = String.fromCharCode(codigoTecla);
    if (tecla.search(patron)==-1) return false;
    campo.value=campo.value + tecla;
    return false;
}


function buscar(texto,cadena){
    for(i=0; i<texto.length; i++){
        if (cadena.indexOf(texto.charAt(i),0)!=-1){
            return 1;
        }
    }
    return 0;
}

function formatoSoloTextoKeyPress(campo,e){
    var patron =/^[A-Za-záéíóúü\s]$/;
    if (isDOM) codigoTecla = e.which;
    else if (isIE) codigoTecla = e.keyCode;
    if (codigoTecla == 13) return true; // Enter
    if (codigoTecla == 8) return true; // backspace
    if (codigoTecla == 0) return true; // para dejar pasar el tab pero su codigo es 9 y no funciona JAJAJ
    var tecla = String.fromCharCode(codigoTecla);
    if (tecla.search(patron)==-1) return false;
    campo.value=campo.value + tecla;
    return false;
}

function formatoTelefonoKeyPress(campo,e,tipo){
    var patron =/^\d$/;
    if (isDOM) codigoTecla = e.which;
    else if (isIE) codigoTecla = e.keyCode;
    if (codigoTecla == 13) return true; // Enter
    if (codigoTecla == 8) return true; // backspace
    if (codigoTecla == 0) return true; // para dejar pasar el tab pero su codigo es 9 y no funciona JAJAJ
    var tecla = String.fromCharCode(codigoTecla);
    if (tecla.search(patron)==-1) return false;
    switch (campo.value.length){
        case 4:
            if (tipo == undefined || tipo=='celular')
                patron=/^0(414|424|416|426|412)$/;
            else
                patron = /^0212$/;
            if (campo.value.search(patron)==-1) {
                campo.value=0;
                return false;
            }
        case 8: 
        case 11:
            campo.value=campo.value + "-" + tecla;
            break;
        case 14:
            return false;
            break;
        default:
            return true;
    }
    return false;
}

$(function(){
    $('#ci_resp_legal').keypress(function(e){
        if ($(this).val().length + 1 > 11) return false;
        return formatoNumericoKeyPress(this,e);
    }).blur(function(){
        $(this).val(formatoNumerico(this.value));
    });
    $('.formatoTexto').keypress(function(e){
        return formatoSoloTextoKeyPress(this,e);
    }).blur(function(){
        
        if (buscar(this.value,'0123456789')) {
            
            this.value='';
            
        }
    });
    $('.formatoTelefonoLocal').keypress(function(e){
        return formatoTelefonoKeyPress(this,e,'local');
    });
    $('.formatoNumerico').keypress(function(e){
        //if (this.value.length + 1 > $(this).attr('max')) return false;
        return formatoNumericoKeyPress(this,e);
        
    }).blur(function(){
        
        if (buscar(this.value,'ABCDEFGHIJKLMNÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyzáéíóúü')) {
            
            this.value='';
            
        }
    });
    $('.formatoTelefonoCelular').keypress(function(e){
        return formatoTelefonoKeyPress(this,e,'celular');
    });
    $('.formatoEmail').blur(function(e){
        var patron=/[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
        if ($(this).val()!='' && $(this).val().search(patron)==-1){
            alert("Email Invalido\nEj: ejemplo@gmail.com");
            this.value='';
            $(this).focus();
        }
    });
    $('#Monto0').blur();
        
    $('#rclave').blur(function(){
        var pass_1 = $('#clave').val();
        var pass_2 = $('#rclave').val();
        var _this = $('#rclave');
        _this.attr('style', 'background:white');
        if($('#clave').val() != $('#rclave').val() && $('#rclave').val() != ''){
            alert("La Contraseña No Coincide");
            this.value='';
            $('#clave').val('');
            $(this).focus();
                                
        }
    });
        
        



	
})

