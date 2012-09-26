<?php

/**
 * Everything is done here.
 *
 * @author Kryptos
 * @author Heaplink
 * @author Joopie
 */

define('IN_INDEX', 1);

/**
 * Initialize Environment.
 */ 
    require 'Application/Rev/Bootstrap.php';

/**
* Call the respective controller and build the template
*/
    
    $Application->Controller->InitializeRendering();
          

/**
 * Output the template
 */
    $Application->Controller->vView->driver->outputTPL();

/**
 * Stop processes
 */
    $Application->Controller->lSession->terminateSessionWriting();
    
/**
 * Output web page load time
 */

    $total_time = round(abs(getTime() - $time_start), 4);
   
    //echo '<!--<br /><center>Load Time: ' . $total_time . ' | Memory Load: ' . round((memory_get_usage() / 1024 / 1024), 2) . ' MB | Queries: ' . Model::$queries . '</center><br />-->';

?>