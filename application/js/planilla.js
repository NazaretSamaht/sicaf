$(document).ready(function(){
  $("#otro_adicional").click(function(){
     if ($(this).is(":checked")){
         
         $("#otro").show();
     }
     else{
         $("#otro").hide();
     }   
  });
  
  
  $("#matrimonio").click(function(){
     if ($(this).is(":checked")){
         
         $("#r_matrimonio").show();
     }
     else{
         $("#r_matrimonio").hide();
     }   
  });
  $("#hijo").click(function(){
     if ($(this).is(":checked")){
         
         $("#r_hijo").show();
     }
     else{
         $("#r_hijo").hide();
     }   
  });
  
  $("[type=text]").keyup(function(){
      $(this).val(this.value.toUpperCase());
      
  });
  
 
  
  
  
  $(".gastos").click(function(){
     var cant=$(".gastos:checked").length;
     if (cant>0){
         $("#r_mortuorio").show();
     }
     else{
         $("#r_mortuorio").hide();
     }  
  });
  
  $("#hcm").click(function(){
     if ($(this).is(":checked")){
         $("#r_hcm").show();
         $(".opciones_hcm").show();
     }
     else{
         $(".opciones_hcm").hide();
         $("#r_hcm").hide();
      }  
  });
  
  $("#pago").click(function(){
     if ($(this).is(":checked")){
         
         $("#primas").show();
     }
     else{
         $("#primas").hide();
     }   
  });
  
  $("#inclusion").click(function(){
     if ($(this).is(":checked")){
         
         $("#r_inclusion").show();
     }
     else{
         $("#r_inclusion").hide();
     }   
  });
  
  $("#exclusion").click(function(){
     if ($(this).is(":checked")){
         
         $("#r_exclusion").show();
     }
     else{
         $("#r_exclusion").hide();
     }   
  });
  
  $("#reclamos").click(function(){
     if ($(this).is(":checked")){
         
         $("#r_reclamos").show();
     }
     else{
         $("#r_reclamos").hide();
     }   
  });
  
  $("#vac").click(function(){
     if ($(this).is(":checked")){
         
         $("#r_vacaciones").show();
     }
     else{
         $("#r_vacaciones").hide();
     }   
  });
  
  $("#poliza").click(function(){
     if ($(this).is(":checked")){
         
         $("#r_poliza").show();
     }
     else{
         $("#r_poliza").hide();
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

                $.each(data.resp,function(i){
                   //console.log(i);
                   
                    if (i=='tipo_nomina'){

                        if((/JUBILADOS/.test(data.resp[i]))&&(jubilado==0)){
                            $(".activo_opciones").hide(); 
                            $(".jubilado_opciones").show();
                            $(".act_jub_opc").show();
                            $("#fid").hide();
                            $("#liq").hide();
                            jubilado=1;
                            tipo_nomina+=data.resp[i]+' \n';
                        
                        }
                        else if((/PENSIONADOS/.test(data.resp[i]))&&(pensionado==0)){
                            $(".activo_opciones").hide(); 
                            $(".act_jub_opc").show();
                            $("#fid").hide();
                            $("#liq").hide();
                            if (jubilado==1){
                              $(".jubilado_opciones").show();
                            }else{
                              $(".jubilado_opciones").hide();
                            }
                            pensionado=1;
                            tipo_nomina+=data.resp[i]+' \n';
                        }
                        
                        else if((/RETIRADO/.test(data.resp[i]))&&(retirado==0)){
                            retirado=1;
                            $(".activo_opciones").hide(); 
                            $(".jubilado_opciones").hide();
                            $(".act_jub_opc").hide();
                            $("#liq").show();
                            $("#fid").hide();
                            tipo_nomina='RETIRADO';
                           
                        }
                        else{
                            activo=1;
                            $(".activo_opciones").show(); 
                            $(".act_jub_opc").show();
                            $("#liq").hide();
                            $("#fid").show();
                            if (jubilado==1){
                              $(".jubilado_opciones").show();
                            }else{
                              $(".jubilado_opciones").hide();
                            }
                            tipo_nomina+=data.resp[i]+' \n';
                        }
                        $('#tipo_nomina').val(tipo_nomina);
                    }else{
                      $('#'+i).val(data.resp[i]);
                    }
                      
                   
                });
                
            }
        })
       
        
    });
    $("#const_trab").click(function(){
     if ($(this).is(":checked")){
         $("#tipo_const_trab").show();
         $("#n_const_trab").show();
     }
     else{
         $("#tipo_const_trab").hide();
         $("#n_const_trab").hide();
     }   
  });
    
    $("#exp").click(function(){
     if ($(this).is(":checked")){
         
         $("#tipo_copia").show();
     }
     else{
         $("#tipo_copia").hide();
     }  
  });
  
  $("#const_jub").click(function(){
     if ($(this).is(":checked")){
         $("#tipo_const_jub").show();
         $("#n_const_jub").show();
     }
     else{
         $("#tipo_const_jub").hide();
         $("#n_const_jub").hide();
     }   
  });
    
    $("#fideicomiso").change(function(){
     $("#r_liquidacion").hide();
     $("#r_anticipo").show();
  });
  $("#liquidacion").change(function(){
     $("#r_anticipo").hide(); 
     $("#r_liquidacion").show();
  });
    
    
    
    
    $("#antiguedad").click(function(){
     if ($(this).is(":checked")){
         
         $("#r_antig").show();
     }
     else{
         $("#r_antig").hide();
     }   
  });
  
  $("#b_matrimonio").click(function(){
     if ($(this).is(":checked")){
         
         $("#r_bmatrimonio").show();
     }
     else{
         $("#r_bmatrimonio").hide();
     }   
  });
  
  $("#b_hijo").click(function(){
     if ($(this).is(":checked")){
         
         $("#r_bhijo").show();
     }
     else{
         $("#r_bhijo").hide();
     }   
  });
  $("#trayecto").click(function(){
     if ($(this).is(":checked")){
         
         $("#n_trayecto").show();
     }
     else{
         $("#n_trayecto").hide();
     }   
  });
  $("#antecedente").click(function(){
     if ($(this).is(":checked")){
         
         $("#n_antecedente").show();
     }
     else{
         $("#n_antecedente").hide();
     }   
  });
  $("#faov").click(function(){
     if ($(this).is(":checked")){
         
         $("#n_const_faov").show();
     }
     else{
         $("#n_const_faov").hide();
     }   
  });
  $("#14-02").click(function(){
     if ($(this).is(":checked")){
         
         $("#n_14-02").show();
     }
     else{
         $("#n_14-02").hide();
     }   
  });
  $("#14-03").click(function(){
     if ($(this).is(":checked")){
         
         $("#n_14-03").show();
     }
     else{
         $("#n_14-03").hide();
     }   
  });
  $("#14-100").click(function(){
     if ($(this).is(":checked")){
         
         $("#n_14-100").show();
     }
     else{
         $("#n_14-100").hide();
     }   
  });
});
