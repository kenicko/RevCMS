<?php

/**
 * Validate data in general
 *
 * @author Kryptos
 * @author RastaLulz
 * @author Google
 */

/**
 * Deny direct file access
 */
    if(!defined('IN_INDEX')) { die('Sorry, you cannot access this file :('); } 
    
class Library_Validate
{
   
   /**
    * Validate a string based on its characters
   	*/
    public function validChars($str, $case)
    {
        switch($case)
        {
            case 'alpha':
                $case = '/[^a-zA-Z]/';
            break;
            
            case 'alphanum':
                $case = '/[^a-zA-Z0-9]/';
            break;
            
            case 'num':
                $case = '/[^0-9]/';
            break;
            
            case 'alphanumscore':
                $case = '/[^a-zA-Z0-9\ _]/';
            break;
        }
        
        return (preg_replace($case, null, $str) == $str ? true : false);
    }
    
   /**
    * Is the string's lenght between these two values?
   	*/
    public function validLenght($str, $min, $max)
    {
        return (strlen($str) > $min || strlen($str) < $max ? true : false);
    }
    
   /**
    * Valid password, hexadecimal and between two values
   	*/
    public function validPassword($value, $minLength = 6, $maxLength = 32)
    {
        return (preg_match('/^[a-zA-Z.0-9_-]{'.$minLength.','.$maxLength.'}$/i', $value) ? true : false);
    }

   /**
    * Check if a string is in email format { my [at] hotmail.com }
   	*/
    public function validEmail($value)
    {
        return (preg_match('/^([\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+\.)*[\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+@((((([a-z0-9]{1}[a-z0-9\-]{0,62}[a-z0-9]{1})|[a-z])\.)+[a-z]{2,6})|(\d{1,3}\.){3}\d{1,3}(\:\d{1,5})?)$/i', $value) || strpos($value, '--') !== false || strpos($value, '-.') !== false ? true : false);
    }

   /**
    * Is the string an URL?
   	*/
    public function validURL($value)
    {
        return (preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $value) ? true : false);
    }

   /**
    * Check if the string is a valid IP
   	*/
    public function validIP($value)
    {
        return (preg_match('/^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/', $value) ? true : false);
    }

   /**
    * Check if the string is a valid credit card, different types.
   	*/
    public function validCreditCard($value, $type)
    {
        switch($type)
        {
            case 'AmericanExpress':
                $this->validAmericanExpress($value);
            break;
        
            case 'MasterCard':
                $this->validMasterCard($value);
            break;
        
            case 'Visa':
                $this->validVisa($value);
            break;
        
            case 'Discover':
                $this->validDiscover($value);
            break;
        
            case 'DinersClub':
                $this->validDinersClub($value);
            break;
        
            default:
                return (preg_match('/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6011[0-9]{12}|3(?:0[0-5]|[68][0-9])[0-9]{11}|3[47][0-9]{13})$/', $value) ? true : false);
            break;
        }
    }

    public function validAmericanExpress($value)
    {
        return (preg_match('/^3[47][0-9]{13}$/', $value) ? true : false);
    }

    public function validDiscover($value)
    {
        return (preg_match('/^6011[0-9]{12}$/', $value) ? true : false);
    }

    public function validDinersClub($value)
    {
        return (preg_match('/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/', $value) ? true : false);
    }

    public function validMasterCard($value)
    {
        return (preg_match('/^5[1-5][0-9]{14}$/', $value) ? true : false);
    }

    public function validVisa($value)
    {
        return (preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/', $value) ? true : false);
    }

    public function validColorHex($value)
    {
        return (preg_match('/^#([0-9a-f]{1,2}){3}$/i', $value) ? true : false);
    }
    
    public function validName($name)
    {
        if($this->validChars($name, 'alphanum'))
        {
            if($this->validLenght($name, 2, 25))
            {
                return true;
            }
        }

        return false;
    }
    
}
?>