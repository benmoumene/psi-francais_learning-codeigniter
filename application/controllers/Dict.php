<?php 

class Dict extends CI_Controller{

	private $def_pattern = "\n\n\n\n\n\n";
	private $word_pattern = "/[^\s]+/";

	public function __construct(){
		parent::__construct();
		
		//restrict controller to command line
		if(!is_cli()){
			echo 'Not allowed';
			exit();
		}
	}

	public function shoot_data(){	
		$mydict = fopen("/home/stevan/french-english_dict.txt", "r") or die("Unable to open file!");
		$dict_data = fread($mydict,filesize("/home/stevan/french-english_dict.txt"));
		fclose($mydict);

		$words_def = explode($this->def_pattern,$dict_data);

		foreach($words_def as $word_def){
			preg_match($this->word_pattern, $word_def, $word);

			$params = [
					'index' => 'dict',
					'type' => 'type_fr',
					'body' => ['word' => $word[0], 'translation' => trim($word_def)]
			];

			$this->elasticsearch->client->index($params);
			echo "working...\n";
		}
	}

	public function search_data(){
		$params = [
				'index' => 'dict',
				'type' => 'type_fr',
				'body' => [
						'query' => [
									'query' =>[
										'match' => [
												'word' => 'ans'
										]
								]
						]
				]
		];

		$response = $this->elasticsearch->client->search($params);
		print_r($response);
	}

	public function create_index(){
			$params = ['index' => 'dict', 'body' => [
					'settings' => [
							'analysis' => [
									'filter' => [
											'stemmer_fr' => [
													'type' => 'stemmer',
													'name' => 'light_french'
											]
									],
									'analyzer' => [
											'analyzer_fr' => [
													'type' => 'custom',
													'tokenizer' => 'standard',
													'filter' => ['lowercase', 'stemmer_fr']
											]
									]
							]
					],
					'mappings' => [
							'type_fr' => [
									'properties' => [
										 'word' => [
												 'type' => 'string',
												 'analyzer' => 'analyzer_fr'
										 ],
										 'translation' =>[
										 		'type' => 'string'
											]
									]
							]
					]
			]
		];
		$response = $this->elasticsearch->client->indices()->create($params);
		print_r($response);
	}

	public function check_index(){
		$params = ['index' => 'dict'];
		$response = $this->elasticsearch->client->indices()->getSettings($params);
		print_r($response);
		$response = $this->elasticsearch->client->indices()->getMapping($params);
		print_r($response);
	}

	public function delete_index(){
		$params = ['index' => 'dict'];
		$response = $this->elasticsearch->client->indices()->delete($params);
		print_r($response);
	}
}
