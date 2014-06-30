$(document).ready(function(){
 
       
        $( "#datepicker_nac" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd",
            shortYearCutoff: 50,
            yearRange: "1930:1990"
            
            
        });
        
        $( "#datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd",
            shortYearCutoff: 50
        });       
     
});
