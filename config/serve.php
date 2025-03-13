<?php

# Server settings
$serv = (object)[
    'host' => 'localhost', # The IP address where the server will run
    'port' => '8181' # The port number for the server
];

# Construct the command to start the PHP built-in server
$command = sprintf("php -S %s:%d", $serv->host, $serv->port);

# Execute the command
try {
    exec($command, $output, $returnVar);
    # Check the result of the command execution

    if ($returnVar === 0) {
        # If the command was successful, output the server URL
        echo "Server started at http://{$serv->host}:{$serv->port}\n";
    } else {
        # If the command failed, output the error messages
        throw new Exception("Failed to start server : http://{$serv->host}:{$serv->port}\n");
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
