<?php
class ChatModule {
	//DB login
	protected $host = 'localhost';
	protected $user = 'root';
	protected $password = '83Kci45';
	protected $database = 'main';
	protected $conn = null;

	public function _construct() {
		//Open Connection
		$this->conn = mysql_connect($this->host,$this->user,$this->password);
		if($this->conn) {
			//Select database
			if(!mysql_select_db($this->database)) { die("Database not found");}
		} else {
			die("Can't connect");
		}
		//Start
		$this->getMessages();
	}
	protected function getMessages() {
		$t_end = time() + 20;
		$t_last = $this->fetch('lastRun');
		$t_curr = null;

		while(time() <= $t_end) {
			$query = "SELECT * FROM chat_msg ORDER BY t_created DESC LIMIT 1";
			while($row = mysql_fetch_array($query)) {
				$messages[] = array(
						'time' => $row['t_created']
					);
			}
			$t_curr = strtotime($messages[0]['time']);
		}
		if(!empty($messages) && $t_curr != $t_last) {
			$query = "SELECT * FROM chat_msg ORDER BY t_created DESC";
			while($row = mysql_fetch_array($query)) {
				$messages[] = array(
						'user' => $row['user'],
						'text' => $row['content'],
						'time' => $row['t_created']
					);
			}
			$t_curr = strtotime($messages[0]['time']);
			$this->output(true,'',array_reverse($messages),$t_curr);
			break;
		} else {
			sleep(1);
		}
	}
	protected function fetch($n) {
		$val = isset($_POST[$n]) ? $_POST[$n] : '';
		return mysql_real_escape_string($val, $this->conn);
	}
	protected function output($result, $output, $messages = null, $last = null) {
		echo json_encode(array(
			'result' => $result,
			'msg' => $messages,
			'output' => $output,
			'last' => $last
		));
	}
}

new ChatModule();
?>