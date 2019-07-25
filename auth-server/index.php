<?php

function read_file($filename){
    if(!file_exists($filename)) return [];
    $data = file($filename);

    return array_map(function($item){
        return unserialize($item);
    }, $data);
}

function write_file($filename, $data){
    $data = array_map(function($item){
        return serialize($item);
    }, $data);

    file_put_contents($filename, implode(PHP_EOL, $data));
}

function getApp($clientId) {
  $apps = read_file('./data/app.data');
  foreach ($apps as $app) {
    
    if($app['client_id'] === $clientId) return $app;
  }
  return false;
}

function registerApp(){
    $app = $_POST;
    $app['client_id'] = uniqid('id_');
    $app['client_secret'] = uniqid('secret_');

    $apps = read_file('./data/app.data');
    $apps[] = $app;
    write_file('./data/app.data', $apps);

    echo json_encode([
        "client_id" => $app["client_id"],
        "client_secret" => $app["client_secret"],
    ]);
}

$path = strtok($_SERVER['REQUEST_URI'], '?');
switch($path){
    case '/register';
        registerApp();
        break;
    case '/auth';
        askAuthorization();
        break;
    case '/auth-success';
        askAuthorizationSuccess();
        break;
    case '/token';
        askToken();
        break;
}

function askAuthorization() {
  $clientId = $_GET['client_id'];
  $app = getApp($clientId);

  if ($app) {
    $redirectSuccess = "/auth-success?state={$_GET['state']}&client_id={$_GET['client_id']}"; 
    $redirectError = "/auth-error?state={$_GET['state']}&client_id={$_GET['client_id']}";  
    echo "
          <h3>{$app['name']}</h3>
          <a href='{$redirectSuccess}'>Accept</a>
          <a href='{$redirectError}'>Refuse</a>
         ";
  } else {
    echo "App not Found";
  }
}

function askAuthorizationSuccess() {
    $clientId = $_GET['client_id'];
    $app = getApp($clientId);

    if ($app) {
        $code = uniqid('code_');
        $redirect = $app['redirect_uri_success'];
        $redirect .= "?code={$code}&state={$_GET['state']}";

        $codes = read_file('./data/code.data');
        $codes[] = ["code" => $code, "client_id" => $clientId];
        write_file('./data/code.data', $codes);

        header("Location: {$redirect}");
    } else {
        echo "App not Found";
    }
}

function askToken() {
    $clientId = $_GET['client_id'];
    $app = getApp($clientId);

    if ($app) {
        if ($app['client_secret'] === $_GET['client_secret']) {
            $code = $_GET['code'];
            $code = getCode($clientId, $code);

            if ($code) {
                $token = uniqid(('token_'));
                $expiresIn = 3600;
                $expirationDate = new \DateTime();
                $expirationDate->modify("+{$expiresIn} seconds");

                $tokens = read_file('./data/token.data');
                $tokens[] = [
                  "token"=> $token,
                  "expirationDate" => $expirationDate->modify('Y-m-d H:m')
                ];
                write_file('./data/token.data', $tokens);

                echo json_encode([
                  "token"=> $token,
                  "expirationDate" => $expiresIn
                ]);
            } else {
                echo "App not Found";
            }
        }
    }
}

function getCode($clientId, $code) {
  $codes = read_file('./data/app.data');
  foreach ($codes as $codeline) {
    if($codeline['client_id'] === $clientId && $codeline['code'] === $code) return $codeline;
  }
  return false;
}