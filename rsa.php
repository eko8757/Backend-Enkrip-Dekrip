<?

class Cipher {
    
	private $data = array();

	public function hex2txt($hash) {
		for ($i = 0; $i < strlen($hash); $i += 2) {
			$result .= chr(hexdec(substr($hash, $i, 2)) + 32);
		}
		return $result;
	}

	public function txt2hex($string) {
		$string = str_split($string);
		for ($i = 0; $i < count($string); $i++) {
			$result .= substr('0' . dechex(ord($string[$i]) - 32), -2);
		}
		return $result;
	}

	public function decrypt($hash) {
		//using key private
		$d = $this -> data['d'];
		$n = $this -> data['n'];
		$hash = gmp_init('0x' . $hash);
		$result = gmp_powm($hash, $d, $n);
		$result = gmp_strval($result, 16);
		$result = substr($result, 1);
		$result = $this -> hex2txt($result);
		return $result;
	}

	public function encrypt($string) {
		//using key public
		$e = $this -> data['e'];
		$n = $this -> data['n'];
		$hash = gmp_init('0x1' . $this -> txt2hex($string));
		$result = gmp_powm($hash, $e, $n);
		$result = gmp_strval($result, 16);
		return $result;
	}

	public function __construct($e, $d, $n) {
		$this -> data['e'] = gmp_init('0x' . $e);
		$this -> data['d'] = gmp_init('0x' . $d);
		$this -> data['n'] = gmp_init('0x' . $n);
	}

	public function __set($variable, $value) {
		$this -> data[$variable] = $value;
	}

	public function __get($variable) {
		if (isset($this -> data[$variable])) {
			return $this -> data[$variable];
		} else {
			return '$' . $variable . ' does not exists';
		}

	}

}
?>