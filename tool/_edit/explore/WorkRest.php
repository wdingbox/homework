<?
$url = "http://www.google.com";
$response = file_get_contents($url);
echo "<br>file_get_contents> ".$url . $response;


////////////
//
function get_content($URL){
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_URL, $URL);
          $data = curl_exec($ch);
          curl_close($ch);
          return $data;
}



////////////////////////////
//
function httpRequest($host, $port, $method, $path, $params) {
  // Params are a map from names to values
  $paramStr = "";
  foreach ($params as $name => $val) {
    $paramStr .= $name . "=";
    $paramStr .= urlencode($val);
    $paramStr .= "&";
  }

  // Assign defaults to $method and $port, if needed
  if (empty($method)) {
    $method = 'GET';
  }
  $method = strtoupper($method);
  if (empty($port)) {
    $port = 80; // Default HTTP port
  }

  // Create the connection
  $sock = fsockopen($host, $port);
  if ($method == "GET") {
    $path .= "?" . $paramStr;
  }
  fputs($sock, "$method $path HTTP/1.1\r\n");
  fputs($sock, "Host: $host\r\n");
  fputs($sock, "Content-type: " .
               "application/x-www-form-urlencoded\r\n");
  if ($method == "POST") {
    fputs($sock, "Content-length: " . 
                 strlen($paramStr) . "\r\n");
  }
  fputs($sock, "Connection: close\r\n\r\n");
  if ($method == "POST") {
    fputs($sock, $paramStr);
  }

  // Buffer the result
  $result = "";
  while (!feof($sock)) {
    $result .= fgets($sock,1024);
	if( strstr($result, "Warning")>=0 ) break;
  }

  fclose($sock);
  return $result;
}


$ret = httpRequest($url,"", "", "","");
echo "<br>httpRequest> ". $ret;
$ret = get_content($url);
echo "<br>get_content> " . $ret;

?>

<!DOCTYPE html>
<html>
<body>

<iframe src="http://www.google.com">
  <p>Your browser does not support iframes.</p>
</iframe>

</body>
</html>
