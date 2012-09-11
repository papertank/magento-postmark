<?php

require_once(dirname(__FILE__).'/../../Postmark.php');

class Papertank_Postmark_Model_Email_Template extends Mage_Core_Model_Email_Template
{

    /**
     * Send mail to recipient
     *
     * @param   array|string       $email        E-mail(s)
     * @param   array|string|null  $name         receiver name(s)
     * @param   array              $variables    template variables
     * @return  boolean
     **/
    public function send($email, $name = null, array $variables = array())
    {

		$postmark = new Postmark();   
    
        if (!$this->isValidForSend()) {
            Mage::logException(new Exception('This letter cannot be sent.')); // translation is intentionally omitted
            return false;
        }

        $emails = array_values((array)$email);
        $names = is_array($name) ? $name : (array)$name;
        $names = array_values($names);
        foreach ($emails as $key => $email) {
            if (!isset($names[$key])) {
                $names[$key] = substr($email, 0, strpos($email, '@'));
            }
        }

        $variables['email'] = reset($emails);
        $variables['name'] = reset($names);

        foreach ($emails as $key => $email) {
            $postmark->to($email, $names[$key]);
        }      

        $this->setUseAbsoluteLinks(true);
        $text = $this->getProcessedTemplate($variables, true);

        if($this->isPlain()) {
            $postmark->plain_message($text);
        } else {
        	$postmark->html_message($text);
        }

        $postmark->subject($this->getProcessedTemplateSubject($variables));

        try {
            $postmark->send();
        }
        catch (Exception $e) {
            Mage::logException($e);
            return false;
        }

        return true;
    }


}