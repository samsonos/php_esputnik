<?php
namespace samson\esputnik;

use samson\core\iModuleCompressable;

class eSputnik extends \samson\core\Service implements iModuleCompressable
{
    protected $id = 'esputnik';
    protected $sUrl  = 'https://esputnik.com.ua/api/v1/message/sms';

    public $module = 'esputnik';
    public $login;
    public $password;

    public function beforeCompress(& $obj = null, array & $code = null)
	{
		
	}

    public function afterCompress( & $obj = null, array & $code = null )
	{
		
	}

    public function send($text, $phones = array('380634202325'), $from = 'SamsonOS')
    {
        $json_value = new \stdClass();
        $json_value->text = $text;
        $json_value->from = $from;
        $json_value->phoneNumbers = $phones;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json_value));
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_URL, $this->sUrl);
        curl_setopt($ch,CURLOPT_USERPWD, $this->login.':'.$this->password);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
    }
}