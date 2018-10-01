<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
//use Chadicus\Slim\OAuth2\Middleware;
//use OAuth2;
//use OAuth2\Storage;
//use OAuth2\GrantType;
//use Slim;

require '../vendor/autoload.php';




/*


//set up storage for oauth2 server
$storage = new Storage\Memory(
    [
        'client_credentials' => [
            'administrator' => [
                'client_id' => 'administrator',
                'client_secret' => 'password',
                'scope' => 'superUser',
            ],
            'foo-client' => [
                'client_id' => 'foo-client',
                'client_secret' => 'p4ssw0rd',
                'scope' => 'basicUser canViewFoos',
            ],
            'bar-client' => [
                'client_id' => 'foo-client',
                'client_secret' => '!password1',
                'scope' => 'basicUser',
            ],
        ],
    ]
);

// create the oauth2 server
$server = new OAuth2\Server(
    $storage,
    [
        'access_lifetime' => 3600,
    ],
    [
        new GrantType\ClientCredentials($storage),
    ]
);




*/

class ExampleMiddleware
{
    /**
     * Example middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {

//$response->getBody()->write($_REQUEST['token']." ".time());

	if(isset($_REQUEST['token']))
	{
          $token = intval($_REQUEST["token"]);

		if((time() - $token ) < 100)
			$newResponse = $next($request, $response);
		else
		 	$newResponse = $response->withStatus(403);
	}
		else
		 	$newResponse = $response->withStatus(403);

    // $response->getBody()->write($token." ".time());

	//echo session_encode();

	// $newResponse = $response->withHeader('Content-type', 'application/json');

 //   $response->getBody()->write('BEFORE');

 //   $response->getBody()->write('AFTER');

    return $newResponse;
    }
}





$app = new \Slim\App;

//$authMiddleware = new Middleware\Authorization($server, $app->getContainer());


$app->any('/login', function (Request $request, Response $response) {
	    //session_start();

		$resp_data = array("status"=>"error");
 		if(isset($_REQUEST["token"]) && $_REQUEST["token"] != ""){

		 $token = intval($_REQUEST["token"]);

		if((time() - $token) < 100)

		$resp_data["status"] = "success";

        } elseif(isset($_REQUEST["username"]) && isset($_REQUEST["userpass"]) && $_REQUEST["username"] == "admin" && $_REQUEST["userpass"] == "admin"){
			//$_SESSION['login'] = "1";
            $resp_data["status"] = "success";
            $resp_data["token"] = time();


		}


        $response->getBody()->write(json_encode($resp_data));




  return $response;
});


$app->any('/', function (Request $request, Response $response) {
   // $name = $request->getAttribute('name');


    $response->getBody()->write(file_get_contents("mainpage.html"));

    return $response;
}); //->add(new ExampleMiddleware());



$app->get('/frontend/{name}', function (Request $request, Response $response) {
    $name = str_ireplace(".js","",$request->getAttribute('name'));
    $content = "";

    if(file_exists("scripts/{$name}.js"))
    $content = file_get_contents("scripts/{$name}.js");
    else
    $content = "define(function () {
       return function(){

       	this.destroy = function(){

		}
       }
	});";


    $response->getBody()->write($content);

    return $response;
}); //->add(new ExampleMiddleware());

/*
$app->any('/{class}/{method}', function (Request $request, Response $response) {
    $class = $request->getAttribute('class');
    $method = $request->getAttribute('method');
  //  $content = $class.", ".$method.", ".json_encode($request->getParams());

   $content ="{rows:[{ id:4, data: [\"4\",\"A Time to Kill\", \"John Grisham\", \"100\"]},{ id:5, data: [\"5\",\"Blood and Smoke\", \"Stephen King\", \"1000\"]},{ id:6, data: [\"6\",\"The Rainmaker\", \"John Grisham\", \"-200\"]}]}";

    $response->getBody()->write($content);

    return $response;
})->add(new ExampleMiddleware());
*/



$app->any('/v1[/{params:.*}]', function (Request $request, Response $response, Array $args) use ($app) {
    $params = explode('/', $args['params']);

     if(isset($params[0]) && $params[0]){

     	if($request->getQueryParams() && $request->getParsedBody())
		$req = array_merge($request->getQueryParams(),$request->getParsedBody());
	elseif($request->getQueryParams())
		$req = $request->getQueryParams();
	elseif($request->getParsedBody())
		$req = $request->getParsedBody();
	else
		$req = array();

         $app = new  class_selector($params,$request,$response,$req);
        //$new_response =
      return  $app->run();

    } else {
     	//$new_response =

     	$response->getBody()->write(file_get_contents("mainpage.html"));
     	//

    }
 		return $response;
});//->add(new ExampleMiddleware());

$app->run();


class class_selector {	private $request,$response,$path,$req;

	function __construct($path = array(),Request &$request, Response &$response,$req){

		$this->request = $request;
		$this->response = $response;
        $this->path = $path;
        $this->req = $req;
    }

    function run(){        $path = $this->path;
		$main_class = $path[0];
		unset($path[0]);

		if(class_exists($main_class))
		$obj = new $main_class();
		else {				$msg = "Class $main_class not found!";
                     $data = array("success"=>false,
                     	"status"=>array("code"=>111,"description"=>$msg)
                     	);

                    	return $this->response->withJson($data, 400);
		}

		//$methods = implode("->",$path);

	//	eval('$obj->'.$methods.'($this->request,$this->response);');
     /*
		if($path[1]){


          		if(!isset($path[2])){
          			$obj->{$path[1]}($this->request,$this->response);

            	} else {
					$ob = $obj->{$path[1]};
    				$ob->{$path[2]}($this->request,$this->response);            	}


        }

    */




        function create($path,$obj,$request,$response,$req){
        		$curr = current($path);



            	if(!next($path)){
            	    if(method_exists($obj,$curr)){
          			return $obj->$curr($request,$response,$req);
          			} else {
          			$msg = "Method $curr not found!";
                     $data = array("success"=>false,
                     	"status"=>array("code"=>111,"description"=>$msg)
                     	);

                    	return $response->withJson($data, 400);
                    }

            	} else {
                    if(property_exists($obj,$curr)) {
						$child_obg = $obj->$curr;
						return create($path,$child_obg,$request,$response);
                    } else {
						$msg = "Property $curr not found ";
                    	if(method_exists($obj,$curr))
                     		$msg .= ", this is function!";
                     	else
                     		$msg .= " и процедуры такой тоже нет!";

                     	$data = array("success"=>false,
                     	"status"=>array("code"=>111,"description"=>$msg)
                     	);

                    	return $response->withJson($data, 400);
                    }

            	}
        }




 	 return create($path,$obj,$this->request,$this->response,$this->req);


    }
}

class requests {
    function __construct(){
		//echo "requests constructor";

    }
    function show(&$request,&$response,$req){
		$data = array("success"=> true,"data"=>$req);

      return $response->withJson($data, 201);    }

}

 /*
class sends {

    function __construct(){

		$this->show = new Show();

    }
    function show(&$request,&$response){        //         $params = array();
		//$response->withJson($params,200);
        $response->getBody()->write("sends show");

    }

}

class show {
	function __construct(){

		$this->test = new test();

    }
	  function test(&$request,&$response){
	  		$response->getBody()->write("sends show test");
	  }
}

class test{
      function dd(&$request,&$response){        $response->getBody()->write("sends show test dd");
      }}



class modules {

}


 class login {


	function get ($request,$response){
		$resp_data = array("status"=>"error");
 		if(isset($_REQUEST["token"]) && $_REQUEST["token"] != ""){

		 $token = intval($_REQUEST["token"]);

		if((time() - $token) < 100)

		$resp_data["status"] = "success";

        } elseif(isset($_REQUEST["username"]) && isset($_REQUEST["userpass"]) && $_REQUEST["username"] == "admin" && $_REQUEST["userpass"] == "admin"){
			//$_SESSION['login'] = "1";
            $resp_data["status"] = "success";
            $resp_data["token"] = time();


		}


        $response->getBody()->write(json_encode($resp_data));




  return $response;
	}

 }
*/

?>