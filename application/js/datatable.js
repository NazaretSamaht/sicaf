$(document).ready(function() {
                var asInitVals = new Array();
                oTable = $('#example').dataTable({
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers",
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": "../views/itp/server_processing.php",
                    
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