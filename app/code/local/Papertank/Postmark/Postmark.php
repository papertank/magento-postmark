<?php

class Postmark {

	private $api_key;
	private $attachment_count = 0;
	private $data = array();

	function __construct()
	{
		$this->api_key = 'your-api-key-here';
		$this->data['From'] = 'Your Name <you@example.com>';
		$this->data['To'] = '';
	}

	function send()
	{
		$headers = array(
			'Accept: application/json',
			'Content-Type: application/json',
			'X-Postmark-Server-Token: '.$this->api_key
		);

		$ch = curl_init('http://api.postmarkapp.com/email');

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$return = curl_exec($ch);
		$curl_error = curl_error($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);

		// do some checking to make sure it sent
		if($http_code !== 200)
			return false;
		else
			return true;
	}

	function to($email, $name = false)
	{
		if (isset($this->data['To']) && !empty($this->data['To']))
		{
			$this->data['To'] .= ', ';		
		}
		
		$this->data['To'] .= ($name ? $email : "{$name} <{$email}>" );
		
		return $this;
	}

	function cc($cc)
	{
		$this->data["Cc"] = $cc;
		return $this;
	}

	function bcc($bcc)
	{
		$this->data["Bcc"] = $bcc;
		return $this;
	}

	function subject($subject)
	{
		$this->data['Subject'] = $subject;
		return $this;
	}

	function html_message($html)
	{
		$this->data['HtmlBody'] = $html;
		return $this;
	}

	function plain_message($msg)
	{
		$this->data['TextBody'] = $msg;
		return $this;
	}

	function tag($tag)
	{
		$this->data['Tag'] = $tag;
		return $this;
	}

	function attachment($name, $content, $content_type)
	{
		$this->data['Attachments'][$this->attachment_count]['Name']		= $name;
		$this->data['Attachments'][$this->attachment_count]['ContentType']	= $content_type;

		// Check if our content is already base64 encoded or not
		if( ! base64_decode($content, true))
			$this->data['Attachments'][$this->attachment_count]['Content']	= base64_encode($content);
		else
			$this->data['Attachments'][$this->attachment_count]['Content']	= $content;

		// Up our attachment counter
		$this->attachment_count++;

		return $this;
	}

}
