<?php

require_once 'vendor/autoload.php';

use Aws\Sns\SnsClient;
use Aws\Sns\Exception\SnsException;

class Sensors_model extends CI_Model
{
	private $client;
	
	function __construct()
	{
		$this->config->load('aws');
		$this->client = SnsClient::factory(array(
			'region' => $this->config->item('aws_region'),
			'key'    => $this->config->item('aws_access'),
			'secret' => $this->config->item('aws_secret'),
		));
	}
	
	public function publish($json)
	{
		if($json == null)
		{
			return FALSE;
		}
		
		try
		{
			$this->client->publish(array(
				'TopicArn'         => $this->config->item('sensors_topic'),
				'Message'          => $json,
			));
			return TRUE;
		}
		catch(SnsException $e)
		{
			return FALSE;
		}
	}
}
