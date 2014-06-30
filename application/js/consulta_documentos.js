$(document).ready(function() {
                var id_solc = $('#id_solicitud').val();
                var asInitVals = new Array();
                oTable = $('#dt_documentos').dataTable({
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers",
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": site_url+'/consulta/documentos_solicitud/'+id_solc,
                    "oLanguage":{
                        "sProcessing":     "Procesando...",
                        "sLengthMenu":     "Mostrar _MENU_ registros",
                        "sZeroRecords":    "No se encontraron resultados",
                        "sEmptyTable":     "Ning&uacute;n dato disponible en esta tabla",
                        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix":    "",
                        "sSearch":         "Buscar:",
                        "sUrl":            "",
                        "sInfoThousands":  ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                                "sFirst":    "Primero",
                                "sLast":     "&Uacute;ltimo",
                                "sNext":     "Siguiente",
                                "sPrevious": "Anterior"
                        },
                        "fnInfoCallback": null,
                        "oAria": {
                                "sSortAscending":  ": Activar para ordernar la columna de manera ascendente",
                                "sSortDescending": ": Activar para ordernar la columna de manera descendente"
                        }  
                    }
                });
                $("#search input").keyup( function () {
                    
                    /* Filter on the column (the index) of this element */
                    oTable.fnFilter( this.value, $("#search input").index(this) );
                } );
     
     
     
                /*
                 * Support functions to provide a little bit of 'user friendlyness' to the textboxes in
                 * the footer
                 */
                $("#search input").each( function (i) {
                    asInitVals[i] = this.value;
                } );
     
                $("#search input").focus( function () {
                    
                    if ( this.className == "search_init" )
                    {
                        this.className = "";
                        this.value = "";
                    }
                } );
     
                $("#search input").blur( function (i) {
                    if ( this.value == "" )
                    {
                        this.className = "search_init";
                        this.value = asInitVals[$("#search input").index(this)];
                    }
                } );
            } );
