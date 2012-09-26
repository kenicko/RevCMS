<?php

# Get the whole MySQL database and dump it in /TDS/Database/
global $CONFIG;


if($CONFIG['DB']['driver'] == 'SQL_MySQL' || $CONFIG['DB']['driver'] == 'SQL_MySQLi' || $CONFIG['DB']['driver'] == 'SQL_PDO_MySQL') 
{
    $backupFile = 'TDS/Database/' . $CONFIG['DB']['mysql']['database'] . date('Y-m-d-H-i-s') . '.gz';

    system("mysqldump —opt -h {$CONFIG['DB']['mysql']['host']} -u {$CONFIG['DB']['mysql']['user']} -p {$CONFIG['DB']['mysql']['pass']} {$CONFIG['DB']['mysql']['database']} | gzip > {$backupFile}");
}
?>
