$(document).ready(function(){
    $("#division").change(function(){
        $.post(site_url+'/tracking/combo_coord/'+$(this).val(),function(data){
            $("#coord").html(data);
            
        })
        $.post(site_url+"/tracking/actor/"+$(this).val(),function(data){
            $("#actor").html(data);
            $(".draggable").draggable();
            
        })
        $.post(site_url+"/tracking/accion/"+$(this).val(),function(data){
            $("#accion").html(data);
            $( ".accordion" ).accordion();
            $(".draggable").draggable({
                appendTo: "body",
                helper: "clone"
            });
            $( "#droppable" ).find('td').droppable({
                drop: function( event, ui ) {
                    $( this ).addClass( "ui-state-highlight" ).html(ui.draggable);
                    console.log(this);                 
                }
             });
             
        })
        $.post(site_url+"/tracking/track/"+$(this).val(),function(data){
            $(".track").html(data);
        })
        
    });
    $("#coord").change(function(){
        $.post(site_url+"/tracking/combo_doc/"+$(this).val(),function(data){
            $("#doc").html(data);
        })
    });
    
    
    $("#accion").click(function(){
//        alert ($("#actor").children(".draggable").length);
          
        
    });
    
    
    

    ///click///
    
//    $("#division").click(function(){
//        $.post(site_url+'/tracking/combo_coord/'+$(this).val(),function(data){
//            $("#coord").html(data);
//        })
//        $.post(site_url+'/tracking/combo_actor/'+$(this).val(),function(data){
//            $("#actor").html(data);
//        })
//    });
//    $("#coord").click(function(){
//        $.post(site_url+"/tracking/combo_coord/"+$(this).val(),function(data){
//            $("#doc").html(data);
//        })
//    });
//    
//    $("#actor").click(function(){
//        $.post(site_url+"/tracking/combo_accion/"+$(this).val(),function(data){
//            $("#accion").html(data);
//        })
//    });
    
    ///////hasta aqui//////    
        
    $("#anos_itp").change(function(){
        $.post(site_url+'/itp/cargar_trimestre_itp/'+$(this).val(),function(data){
            $("#trimestres_itp").html(data);
        })
    });
    $("#trimestres_itp").change(function(){
        $.post(site_url+"/itp/cargar_consulta/"+$(this).val()+"/"+$("#anos_itp").val(),function(data){
            $("#div_consulta").html(data);
        })
    });
    $("#anos_itp").click(function(){
        $.post(site_url+'/itp/cargar_trimestre_itp/'+$(this).val(),function(data){
            $("#trimestres_itp").html(data);
        })
    });
    $("#trimestres_itp").click(function(){
        $.post(site_url+"/itp/cargar_consulta/"+$(this).val()+"/"+$("#anos_itp").val(),function(data){
            $("#div_consulta").html(data);
        })
    });
    
    $('#ci').blur(function(){
        var cedula = $(this).val();
        $.getJSON(site_url+'/inscripcion/ajax_blur_ci',{'ci':cedula},function(data){
            if (data.resp > 0){
                $('#form_inscripcion').attr('action',site_url+'/inscripcion/modificar_inscripcion/'+cedula);
                $('#form_inscripcion').attr('method','get');
                $('#form_inscripcion').submit();
            }
        })
    });
    
    
})