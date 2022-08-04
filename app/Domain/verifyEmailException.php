<?php
/**
 * Created by PhpStorm.
 * User: Tapiwanashe
 * Date: 02/11/2018
 * Time: 15:48
 */

namespace App\Domain;


use Exception;

/**
 * verifyEmail exception handler
 */
class verifyEmailException extends Exception
{

    /**
     * Prettify error message output
     * @return string
     */
    public function errorMessage()
    {
        //$errorMsg = '<strong>' . $this->getMessage() . "</strong><br />\n";
        $errorMsg = $this->getMessage();
        return $errorMsg;
    }

}