<?php
header('Content-Type: text/plain');
if(!isset($args[0])){
    echo "Paste not found.";
} else {
    $stuff = $handler->get($args[0], $args[1]);
    echo $stuff['text'];
}
