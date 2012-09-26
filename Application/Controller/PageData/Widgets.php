<?php

/**
 * Handle template widgets with MySQL and files.
 * Handle template components with files.
 *
 * @author Kryptos
 */

/**
 * Deny direct file access
 */
    if(!defined('IN_INDEX')) { die('Sorry, you cannot access this file :('); } 

    #############################
    #                           #
    #         Interface         #
    #                           #
    #############################

interface iWidget
{
    public function Initialize();
    public function Submit();
    public function Render();
}

    #############################
    #                           #
    #           Class           #
    #                           #
    #############################
    
class Controller_PageData_Widgets extends Controller
{
    
    private $widgets;
    
    public function __construct()
    {   
        parent::__construct();

        $this->load->Library_Log();
    }
    
    /**
     * Call template widgets and assign a param to them.
     * 
     * @param type $file - Name of the file called
     */
    public function getWidgets($file, $tpl)
    {   
        $dir = THEMES . $this->vView->driver->data->name . '/Widgets/';
        if(is_dir($dir)) 
        {
            if($dh = opendir($dir)) 
            {   
                while(($file = readdir($dh)) !== false) 
                {
                    if(filetype($dir . $file) == 'file')
                    {
                        $handle = fopen($dir . $file, "r");

                        if(pathinfo($dir . $file, PATHINFO_EXTENSION) == 'php')
                        {
                            ob_start();
                            eval('?>' . fread($handle, filesize($dir . $file)));
                            $php = ob_get_contents();
                            ob_end_clean();

                            $this->vView->driver->assign("widget->{$file}", $php);
                            continue;
                        }
            
                        $this->vView->driver->assign("widget->{$file}", fread($handle, filesize($dir . $file)));
                        
                        $this->InitializeWidgetClass($file, $tpl);
                    }
                    else
                    {                    
                        $this->GetWidgetsInDir($dir, $file, $tpl);
                    }
                }
        
                closedir($dh);
            }
            else
            {
                $this->lLog->writeError("Could not open directory: {$dir} when trying to get Widgets.", 2);
            }
        }
        else 
        {
            $this->lLog->writeError("Could not find directory: {$dir} to get Widgets since it is not a directory.", 1);
        }
    }
    
   /**
    * Extra directories? Check if there are widgets in them and assign a param for them.
   	*/
    public function getWidgetsInDir($dir, $file, $tpl, $actual_dir = null)
    {
        if(is_dir($dir . $file) && !in_array($file, $this->load->blockedFiles))
        {
            $dir = $dir . $file . DS;

            (is_null($actual_dir) ? $actual_dir = $file : $actual_dir .= '->' . $file);
                           
            if($dh = opendir($dir))
            {
                while(($file = readdir($dh)) !== false) 
                {
                    if(filetype($dir . $file) == 'file')
                    {
                        if(strpos($file, '.'))
                        {
                            $handle = fopen($dir . $file, "r"); 

                            if(pathinfo($dir . $file, PATHINFO_EXTENSION) == 'php')
                            {
                                ob_start();
                                eval('?>' . fread($handle, filesize($dir . '/' . $file)));
                                $php = ob_get_contents();
                                ob_end_clean();

                                $this->vView->driver->assign("widget->{$actual_dir}->{$file}", $php);
                                continue;
                            }
                           
                            $this->vView->driver->assign("widget->{$actual_dir}->{$file}", fread($handle, filesize($dir . '/' . $file)));

                            $this->InitializeWidgetClass(str_replace('->', '/', "{$actual_dir}/{$file}"), $tpl);
                        }
                    }
                    else
                    {
                        $this->getWidgetsInDir($dir, $file, $tpl, $actual_dir);
                    }
                }
            }
        }
    }
    
   /**
    * Check if the Widget has a class, if it has - Load it
   	*/
    private function InitializeWidgetClass($widget, $tpl)
    {
        if(file_exists(PAGEDATA . $this->rConfigure->config->skin->name . DS . 'Widget' . DS . str_replace(array('.html', '.php'), '', $widget) . '.php'))
        {   
            if($this->widgetBeingUsed($widget, $tpl))
            {
                $this->load->widget(ucfirst(str_replace('/', '_', str_replace(array('.html', '.php'), '', str_replace(array('.html', '.php'), '', $widget)))));
            }
        }
        else
        {
            if(file_exists(PAGEDATA . $this->rConfigure->config->skin->pagedata->default . DS . 'Widget' . DS . str_replace(array('.html', '.php'), '', $widget) . '.php'))
            {
                if($this->widgetBeingUsed($widget, $tpl))
                {
                    $class = "Controller_PageData_{$this->rConfigure->config->skin->pagedata->default}_Widget_" . str_replace(array('.html', '.php'), '', $widget) . "}";
           
                    $this->load->widget(ucfirst(str_replace('/', '_', str_replace(array('.html', '.php'), '', str_replace(array('.html', '.php'), '', $widget)))));
                }
            }
        }
    }
    
    private function widgetBeingUsed($widget, $tpl)
    {
        return (strpos($tpl, '{$widget->' . str_replace('/', '->', $widget) . '}') ? true : false);
    }
    
}

?>