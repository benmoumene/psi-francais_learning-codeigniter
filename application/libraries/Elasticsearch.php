<?php 
 use Elasticsearch\ClientBuilder;

 class Elasticsearch{
	 public $client;

	 public function __construct(){
		$this->client = ClientBuilder::create()->build();
	 }
 }
