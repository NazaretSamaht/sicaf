$(document).ready(function(){
  $("#otro_adicional").click(function(){
     if ($(this).is(":checked")){
         
         $("#otro").show();
     }
     else{
         $("#otro").hide();
     }   
  });
  
  $("#tipo_destino").change(function(){console.log('hola');
    var html="<option value=''>--SELECCIONAR--</option>";
        $.getJSON(site_url+"/correspondencia/tipo_destino/"+$(this).val(),function(data){
            $.each(data.unidad, function(i){
              var unidad=this.division || this.coordinacion || this.direccion;
              html+="<option value='"+this.id+"'>"+unidad+"</option>";
            });
            $('#destino').html(html);
        },'post')
    });

  $("#tipo_correspondencia").change(function(){
    if($(this).val()==1){
      //es renuncia
      $("#implicado").show();
    }else{
      $("#implicado").hide();
    }
  });

  $('#ci').blur(function(){
        var cedula = $(this).val();
        var jubilado=0;
        var pensionado=0;
        var activo=0;
        var retirado=0;
        var tipo_nomina='';
        $.getJSON(site_url+'/solicitud/ajax_get_datos',{'ci':cedula},function(data){
            if (! data.error ){

                $.each(data.resp,function(j){
                   //console.log(i);
                    $.each(data.resp[j],function(i){
                    if (i=='tipo_nomina'){

                        if((/JUBILADOS/.test(data.resp[j][i]))&&(jubilado==0)){
                            
                            tipo_nomina+=data.resp[j][i]+' \n';
                        }
                        
                        else if((/PENSIONADOS/.test(data.resp[j][i]))&&(pensionado==0)){
                            
                            tipo_nomina+=data.resp[j][i]+' \n';
                        }
                        
                        else if((/RETIRADO/.test(data.resp[j][i]))&&(retirado==0)){
                            retirado=1;
                            
                            tipo_nomina='RETIRADO';
                           
                        }
                        else{
                            activo=1;
                            
                            tipo_nomina+=data.resp[j][i]+' \n';
                        }
                        $('#tipo_nomina').val(tipo_nomina);
                    }else{
                      $('#'+i).val(data.resp[j][i]);
                    }
                      
                  });  
                });
                
            }
        })
       
        
    });

    

    
    
    
    

});
