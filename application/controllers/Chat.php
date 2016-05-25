<?php
class Chat extends Chat_Controller{
	public function index(){
		$data = parent::session_menu_data();
		$data['chat_id'] = $this->francais_model->get_chat($this->session->userdata('id'),$this->session->userdata('user_id'));
		$data['user'] = $this->francais_model->get_user_info($this->session->userdata('user_id'));
		$data['messages'] = $this->francais_model->get_messages($data['chat_id']);
		parent::create_page('chat', $data);
	}

	public function send_message(){
		$messageData = array(
			'chat_id' => set_value('chat_id'),
			'sender' => $this->session->userdata('id'),
			'data' => set_value('msg_text')
		);


		$this->francais_model->new_message($messageData['chat_id'], $messageData['sender'], $messageData['data']);

		$context = new ZMQContext();
    $socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'my chat');
    $socket->connect("tcp://localhost:5555");

    $socket->send(json_encode($messageData));
	}

	public function set_user_id(){
		$this->session->set_userdata('user_id', set_value('user_id'));
	}
}
