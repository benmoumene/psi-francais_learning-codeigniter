<?php
namespace ChatRoom;
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\WampServerInterface;

class Chat implements WampServerInterface{
	protected $clients;
  protected $subscribedTopics = array();

	public function __construct() {
	}

	public function onSubscribe(ConnectionInterface $conn, $topic) {
		$this->subscribedTopics[$topic->getId()] = $topic;
	}

	public function onUnSubscribe(ConnectionInterface $conn, $topic) {

	}

	public function onMessageData($data){
		$messageData = json_decode($data,true);
		// If the lookup topic object isn't set there is no one to publish to
		if (!array_key_exists($messageData['chat_id'], $this->subscribedTopics))
			return;
		$topic = $this->subscribedTopics[$messageData['chat_id']];
		$topic->broadcast($messageData);
	}

	public function onOpen(ConnectionInterface $conn) {
	}

	public function onClose(ConnectionInterface $conn) {
	}

	public function onCall(ConnectionInterface $conn, $id, $topic, array $params){
		$conn->callError($id, $topic, 'You are not allowed to make calls')->close();
	}

	public function onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible) {
		$conn->close();
	}

	public function onError(ConnectionInterface $conn, \Exception $e) {
	}
}
