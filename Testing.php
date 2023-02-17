// Set up a socket server on port 8000
$server = stream_socket_server("tcp://localhost:8000", $errno, $errstr);
if (!$server) {
    die("Error creating server: $errstr ($errno)");
}

// Accept incoming connections and read data from the client
$client = stream_socket_accept($server);
$data = fread($client, 1024);
list($target_host, $target_port) = explode(':', $data);

// Connect to the target host
$target_socket = stream_socket_client("tcp://$target_host:$target_port", $errno, $errstr, 30);
if (!$target_socket) {
    die("Error connecting to target: $errstr ($errno)");
}

// Send data to the target host
$message = "Hello, target!";
fwrite($target_socket, $message);

// Close the sockets
fclose($client);
fclose($target_socket);
fclose($server);
