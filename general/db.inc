<?php
	ini_set('default_charset','UTF-8');
	
	include_once CAR_ROOT_GENERAL . '/functions.inc';

	class DatabaseSessionHandler{
		private $db;
		
		public function open() {
			$this->db = new mysqli(CAR_DB_HOST, CAR_DB_USER, CAR_DB_PASSWORD, CAR_DB_NAME, CAR_DB_PORT);
			$this->db->set_charset(CAR_DB_CHARSET);
			
			return true;
		}
		
		public function close() {
			return true;
		}
		
		function read($id) {
			$id = $this->db->real_escape_string(car_never_null($id));
			$record = '';
			
			$sql = sprintf("select value
                              from car_session
                             where id = '%s'",
                            $id);
			
			$result = $this->db->query($sql, MYSQLI_STORE_RESULT);
			if (!empty($result) && $result != ''){
				while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
					$record = $row['value'];
				}
			}
			return $record;
		}
		
		
		
		function write($id, $value) {
			$access = time();
			
			$id = $this->db->real_escape_string(car_never_null($id));
			
			$access = $this->db->real_escape_string(car_never_null($access));
			
			$value = $this->db->real_escape_string(car_never_null($value));
			
			$sql = sprintf("replace into car_session
                                (id, access, value)
                            values ('%s', '%s', '%s')",
                            $id,
                            $access,
                            $value);
			
			$result = $this->db->query($sql);
			$this->db->commit();
			
			return $result;
			
		}
		
		function destroy($id) {
			$id = $this->db->real_escape_string(car_never_null($id));
			$sql = sprintf("delete from car_session
                             where id = '%s'",
                            $id);
			
			$result = $this->db->query($sql);
			$this->db->commit();
			return $result;
		}
		
		
		
		function clean($max) {
			$old = time() - $max;
			$old = $this->db->real_escape_string(car_never_null($old));
			$sql = sprintf("delete from car_session
                             where access < '%s'",
                            $old);
			
			$result = $this->db->query($sql);
			$this->db->commit();
			return $result;
		}
	}
	
	date_default_timezone_set('America/Sao_Paulo');

	error_reporting(car_is_production() ? 0 : -1);

	// Iniciando o objeto para conexão com o banco de dados
	$mysqli = new mysqli(CAR_DB_HOST, CAR_DB_USER, CAR_DB_PASSWORD, CAR_DB_NAME);
	$mysqli->set_charset(CAR_DB_CHARSET);
	$mysqli->autocommit(CAR_DB_AUTOCOMMIT);
	
	$database_session = new DatabaseSessionHandler(); 
	
	session_set_save_handler(array(&$database_session, 'open'),
                         array(&$database_session, 'close'),
                         array(&$database_session, 'read'),
                         array(&$database_session, 'write'),
                         array(&$database_session, 'destroy'),
                         array(&$database_session, 'clean'));

	if (!isset($_SESSION)) {
		session_cache_expire(5256000); // ~10 anos
		session_set_cookie_params(315360000); // ~10 anos
		session_start([
			'cookie_lifetime' => 315360000,
		]);
	}
	
	// Verificar a coneção
	if (mysqli_connect_errno()) {
	    printf('Connect failed: %s\n', mysqli_connect_error());
	    exit();
	}
