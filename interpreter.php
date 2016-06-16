<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>解释器模式</title>
</head>

<body>
解释器模式：用于分析一个实体的关键元素，并且针对每个元素都提供自己的解释或相应的动作。
目的：当使用关键字或宏语言应用一组指令时，就可以使用基于解释器设计模式的类。
<br/>

<?php
class User{
	protected $_username = '';
	
	public function __construct($username){
		$this->_username = $username;
	}
	public function getProfilePage(){
		$prolife = "<h2> I like Never Again! </h2>";
		$prolife .= "I love all of their songs. My favorite CD: <br/>";
		$prolife .= "{{myCD.getTitle}}!!";
		
		return $profile;
	}
}

class userCD{
	protected $_user = NULL;
	
	public function setUser($user){
		$this->_user = $user;
	}
	public function getTitle(){
		$title = 'Waste of a Rib';
		return $title;
	}
}

// 解释器类
class userCDInterpreter{
	protected $_user = NULL;
	
	public function setUser($user){
		$this->_user = $user;
	}
	public function getInterpreted(){
		$profile = $this->_user->getProfilePage();
		
		if(preg_match_all('/\{\{myCD\.(.*?)\}\}/', $profile, $triggers, PREG_SET_ORDER)){
			$replacements = array();
			
			foreach($triggers as $trigger){
				$replacements[] = $trigger[1];
			}
			
			$replacements = array_unique($replacements);
			
			$myCD = new userCD();
			$myCD->setUser($this->_user);
			
			foreach($replacements as $replacement){
				$profile = str_replace("{{myCD.{$replacement}}}", call_user_func(array($myCD, $replacement)), $profile);
			}
		}
		
		return $profile;
	}
}

$username = 'aaron';
$user = new User($username);
$interpreter = new userCDInterpreter();
$interpreter->setUser($user);

print "<h1> {$username}`s Profile </h1>";
print $interpreter->getInterpreted();

?>
</body>
</html>