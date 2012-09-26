<?php

/**
 * Simple to use CronJob class
 *
 * @author Kryptos
 */

/**
 * Deny direct file access
 */
    if(!defined('IN_INDEX')) { die('Sorry, you cannot access this file :('); } 
    
class Library_CronJobs
{
    
    private $jobs;
    
    public function __construct()
    {          
        $this->Rev = getInstance();
        
        $this->parseJobs();
        $this->getJobs();
    }
    
    private function getJobs()
    {
        $this->Rev->load->Model()->query("SELECT * FROM rev_cron WHERE activated = ?", array('i', 1));
        
        if($this->Rev->mModel->num_rows() > 0)
        {
            foreach($this->Rev->mModel->get() as $job)
            {
                if(file_exists(CRON . $job['name'] . '.php'))
                {
                    if($job['last_executed'] + $CRON[$job['name']]['execute_every'] <= time())
                    {
                        $this->run($job['name']);
                        
                        $this->Rev->mModel->query("UPDATE rev_cron SET last_executed = '" . time() . "' LIMIT 1");
                    }
                }
                else
                {
                    $this->Rev->load->Library_Log()->error('Cron Job: ' . $job['name'] . ' was not found.');
                }
            }
        }
    }
    
    public function run($job)
    {
        require_once CRON . $job . '.php';
    }
    
}

?>
