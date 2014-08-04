<?php
include('../system/Config.php');
if(isset($_POST['text']) && isset($_POST['syntax'])){
    $hash = $handler->save($_POST['syntax'], $_POST['text']);
    header('Location: /v/' . $hash);
} else {
    header('Location: /');
}
