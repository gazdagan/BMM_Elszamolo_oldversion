<?php

/* 
 * jutalék elszámolás orvosnak
 */


$tableform = new AdminSelectClass();
// ha orvos kérdezi le a jutalékot nem kell a form 

$tableform->post_orvos_havilekerdezese();    

echo '<script>
    function StartPrtintJutalekPage(){
        
        
        window.print();

}
</script>';