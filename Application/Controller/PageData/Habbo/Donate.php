<?php

/**
 * Logout user
 * @author Kryptos
 */

   /**
    * Deny direct file access
    */
        if(!defined('IN_INDEX')) die('Sorry, you cannot access this file :(');
        
class Controller_PageData_Habbo_Logout extends Controller
{
    
    private $cript;
    
    public function __construct()
    {
        parent::__construct();
       
        $this->load->Controller_User()->access(true, false, 'index');
        
        $this->load->Library_Paypal()->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';   
        $this->Script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
        
        $this->Handle();
    }

    private function Handle()
    { 
		switch($_GET['action']) 
		{
			case 'process':      // Process and order...
	
			      $this->load->Library_Paypal()->add_field('business', 'innova_1315078729_biz@gmail.com');
			      $this->load->Library_Paypal()->add_field('return', $this->Script.'?action=success');
			      $this->load->Library_Paypal()->add_field('cancel_return', $this->Script .'?action=cancel');
			      $this->load->Library_Paypal()->add_field('notify_url', $this->Script .'?action=ipn');
			      $this->load->Library_Paypal()->add_field('item_name', $_POST['product']);
			      ->add_field('username', $this->cUser->getUsername());   
			      ->add_field('amount', $_POST['product_price']);
			      $this->load->Library_Paypal()->submit_paypal_post(); // submit the fields to paypal
			      //->dump_fields();      // for debugging, output a table of all the fields
			      break;

		    case 'success':      // Order was successful...

		    	$this->vView->redirect('thanks');

		    break;

		    case 'cancel':       // Order was canceled...

		    	// The order was canceled before being completed.
		    	$this->vView->redirect('me');
		    break;

		    case 'ipn':          // Paypal is calling page for IPN validation...

			    // It's important to remember that paypal calling this script.  There
			    // is no output here.  This is where you validate the IPN data and if it's
			    // valid, update your database to signify that the user has payed.  If
	      		// you try and use an echo or printf function here it's not going to do you
	      		// a bit of good.  This is on the "backend".  That is why, by default, the
	      		// class logs all IPN data to a text file.

	      		if ($this->load->Library_Paypal()->validate_ipn()) 
	      		{

	      			
         		}
         	break;
      }
 }   
}
?>
