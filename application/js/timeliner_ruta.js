$(document).ready(function() {
            $.timeliner({
                startOpen:['']
            });
            $.timeliner({
                timelineContainer: '#timelineContainer_2'
            });
            // Colorbox Modal
            $(".CBmodal").colorbox({inline:true, initialWidth:100, maxWidth:682, initialHeight:100, transition:"elastic",speed:750});
        });