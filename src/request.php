<?php

require_once "./inc/RequestHandler.php";

$request_handle = new RequestHandler();

// check for access method
if ($request_handle->checkMethod($_SERVER['REQUEST_METHOD'])) {
    // carry on
    if ($request_handle->verifyFields($_POST)) {
        $request_handle->sendMail();
    } else {
        $request_handle->return(403, "Invalid form data", "Un ou plusieurs champs n'ont pas été remplis correctement.");
    }
} else {
    $request_handle->return(403, "Method not Allowed", "La méthode d'accès au fichier n'est pas correcte.");
}