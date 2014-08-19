<?php
namespace samson\esputnik;

use samson\core\iModuleCompressable;

/* Main class for sending messages  via eSputnik service */
class eSputnik extends \samson\core\Service implements iModuleCompressable
{
    protected $id = 'esputnik';
    protected $sUrl  = 'https://esputnik.com.ua/api/v1/message/sms';
    protected $ccUrl = 'https://esputnik.com.ua/api/v1/contact';

    public $module = 'esputnik';

    /* Login for account on eSputnik service */
    public $login;

    /* Password for account on eSputnik service */
    public $password;

    public function beforeCompress(& $obj = null, array & $code = null)
	{
		
	}

    public function afterCompress( & $obj = null, array & $code = null )
	{
		
	}

    /** Send SMS with text
     * @param string $text Text for SMS
     * @param array  $phones Phone list of recipients
     * @param string $from Sender's name
     */
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
        curl_setopt($ch, CURLOPT_USERPWD, $this->login.':'.$this->password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
    }

    /**
     * Adds new contact
     * @param string $firstName person first name
     * @param array $channels array of channels represented with arrays which contain pare type => value.
     * There are two types of first parameter: sms and email. Value is string field.
     */
    public function createContact($firstName, $channels = array(array('type' => 'sms', 'value' => '380634202325')))
    {
        $contact = new \stdClass();
        $contact->firstName = $firstName;
        $contact->channels = $channels;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($contact));
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_URL, $this->ccUrl);
        curl_setopt($ch, CURLOPT_USERPWD, $this->login.':'.$this->password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
//        echo $output;
    }
}
