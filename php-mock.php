<?php
namespace mockserver;
class MockServer {

  private $responses = NUll;
  private $querryArray = NULL;
  private $querryHeaders = NULL;
  private $answerArray = NULL;
  private $settings = NULL;
  private $countFolders = 2;
          
  function __construct($callback = NULL) {
    $this->responses = include 'responses.php';
    $this->setSettings();
    $this->querryArray = $this->queryToArray();
    $this->querryHeaders = getallheaders();
  }
  
  public function run() {
    $this->setResponse();
    $this->setResponseHeaders();
    print_r($this->answerArray['response']);
  }
  
  public function setSettings() {
    $this->settings = include 'config.php';
    $headers = $this->settings['headers'];
    foreach ($headers as $header)
    {
      header($header); 
    }
  }
  
  public function setResponseHeaders() {
    header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
    $responsesArray = $this->responses;
    if (!array_key_exists($_SERVER['REQUEST_METHOD'], $responsesArray))
    {
      http_response_code(404);
      exit();
    }
    if (array_key_exists('headers', $this->answerArray))
    {
      $response_code = array_key_exists('response_code', $this->answerArray['headers'])? $this->answerArray['headers']['response_code'] : 200;
      http_response_code($response_code);
    }
  }
  
  public function setResponse() {
    $qer = $this->querryArray;
    $qer = $qer[0][$this->countFolders]; 
    $responsesArray = $this->responses;
    if (!array_key_exists($_SERVER['REQUEST_METHOD'], $responsesArray))
    {
      http_response_code(404);
      exit();
    }
    $responsesArray = $responsesArray[$_SERVER['REQUEST_METHOD']];
    
    if (array_key_exists($qer, $responsesArray))
    {
      $this->answerArray = $responsesArray[$qer];
    }
    else
    {
      http_response_code(404);
      exit();
    }
  }
  
  public function queryToArray()
  {
    $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    $querystring = parse_url($url, PHP_URL_QUERY);
    $ans[] = array_values(array_filter(explode('/',$url)));
    $a = explode("&", $querystring);
    if (!(count($a) == 1 && $a[0] == "")) {
      foreach ($a as $key => $value) {
        $b = explode("=", $value);
        $a[$b[0]] = $b[1];
        unset ($a[$key]);
      }
      $ans[] = $a;
    } 
    return $ans;
  }

}
?>