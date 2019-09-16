<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 사용자인증 모델
 *
 * @author Jongwon Byun <advisor@cikorea.net>
 */
class Auth_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

	/**
	 * 아이디, 비밀번호 체크
	 *
	 * @author Jongwon Byun <advisor@cikorea.net>
	 * @param array $auth 폼전송 받은 아이디, 비밀번호
	 * @return array
	 */
    function login($auth)
    {
		// $un = $this->encryption->encrypt($auth['username']);
		// $un = $auth['username'];
		$un = openssl_encrypt($auth['username'], 'AES-256-CBC', KEY_256, 0, KEY_128);
		$pw = md5($auth['password']);
		$sql = "SELECT username, email FROM users WHERE username = '".$un."' AND password = '".$pw."' ";
   		$query = $this->db->query($sql);

		if ( $query->num_rows() > 0 )
     	{
			//맞는 데이터가 있다면 해당 내용 반환
     		return $query->row();
     	}
     	else
     	{
     		//맞는 데이터가 없을 경우
	    	return FALSE;
     	}
	}
	function signup($auth)
    {
		// $sql = "SELECT username, email FROM users WHERE username = '".$auth['username']."' AND password = '".$auth['password']."' ";
		// $sql = "INSERT INTO users VALUES (2, '".$auth['username']."', '".md5($auth['password'])."');";
		// $un = $this->encryption->encrypt($auth['username']);
		

		// $un = $auth['username'];
		$un = openssl_encrypt($auth['username'], 'AES-256-CBC', KEY_256, 0, KEY_128);

		
		$sql = "INSERT INTO users(username, password, email) VALUES ('".$un."', '".md5($auth['password'])."', '".$auth['email']."');";
		$query = $this->db->query($sql);
		   
		// $sql = "SELECT username FROM users WHERE username='".$auth['username']."' AND md5(password) = '".md5($auth['password'])."'; ";
		$sql = "SELECT username, email FROM users WHERE username='".$un."' AND password = '".md5($auth['password'])."'; ";
		$query = $this->db->query($sql);


		if ( $query->num_rows() > 0 )
     	{
			//맞는 데이터가 있다면 해당 내용 반환
     		return $query->row();
     	}
     	else
     	{
     		//맞는 데이터가 없을 경우
	    	return FALSE;
     	}
    }

}

/* End of file auth_m.php */
/* Location: ./application/models/auth_m.php */