<?php
//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
//header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Дата в прошлом
//header("Content-Type: text/html; charset=utf-8");


mysql_connect("u441612.mysql.masterhost.ru", "u441612", "de5SieStry_");

mysql_select_db("u441612");





	if(isset($_COOKIE["auth"]))
	{
       // echo $_COOKIE["auth"];

	  	$query = mysql_query("SELECT user_id,contragent_id FROM users WHERE user_hash = '".$_COOKIE["auth"]."' and  user_ip=INET_ATON('".$_SERVER['REMOTE_ADDR']."') LIMIT 1");
		$userdata = mysql_fetch_assoc($query);


	}
    $contragent_id = $userdata["contragent_id"];

	if(!isset($userdata["user_id"]))
	{



			if(isset($_POST["username"])){

			$query = mysql_query("SELECT user_id, user_password FROM users WHERE user_login='".mysql_real_escape_string($_POST['username'])."' and user_password='".$_POST["userpass"]."' LIMIT 1");
    		$data = mysql_fetch_assoc($query);
				if($data["user_id"])
			     {			     	if($_POST["remme"] == "1"){
			     	setcookie("username", $_POST["username"], time()+3600);  /* срок действия 1 час */
					setcookie("userpass", $_POST["userpass"], time()+3600);
			        }

			       $hash = generateCode(32);

			       setcookie("auth",$hash, time()+3600);
			       mysql_query("UPDATE users SET user_hash='".$hash."', user_ip=INET_ATON('".$_SERVER['REMOTE_ADDR']."') WHERE user_id='".$data['user_id']."'");


			       echo "true";			     }
			     else
			     {
			     echo "false";
			     }


		   }



		   else
		   {




?>
<html>

<head>
  <title></title>
  <link rel="stylesheet" type="text/css" href="codebase/dhtmlx.css"/>
  <script src="codebase/dhtmlx.js"></script>
  <style>
		html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			overflow: hidden;
		}
		body {		background-image: url(calmar_logo.jpg);		}
		#logo_bg {        width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			overflow: hidden;
        opacity: 0.9;
        background-color: #FFFFFF;		}
	</style>
	<script>
	function doOnLoad() {
	        var dhxWins = new dhtmlXWindows();

	        var auth_win = dhxWins.createWindow("auth",( window.innerWidth/2-190), (window.innerHeight/2-110), 380, 250);
            auth_win.setText("Авторизация");
            var formData = [
				{type: "settings", position: "label-left", labelWidth: 130, inputWidth: 120},
				{type: "fieldset", label: "Welcome", inputWidth: 340,offsetLeft:10,list:[

						{type: "input", label: "Имя пользователя", value: "<?php echo $_COOKIE["username"]; ?>",name:"username"},
						{type: "password", label: "Пароль", value: "<?php echo $_COOKIE["userpass"]; ?>",name:"userpass"},
						{type: "checkbox", label: "Запомнить меня", checked: false,name:"remme"},
                        {type: "label", label: "", name:"status"},
					{type: "button", value: "Войти", name:"login"}
				]}
			];

            var auth_form = auth_win.attachForm(formData);

            auth_form.attachEvent("onButtonClick",login);
            auth_form.attachEvent("onEnter",login);

            function login(){
	auth_form.send("auth.php", function(loader, response){
						auth_form.setItemLabel("status",response);
						if(response == "true"){
							              location.reload();
						}
					});

	}


	}
</script></head><body onload="doOnLoad();"><div id="logo_bg"></div></body></html>

<?php

 exit();

  }

  }



  function generateCode($length=6) {

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";

    $code = "";

    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {

            $code .= $chars[mt_rand(0,$clen)];
    }

    return $code;

}
?>