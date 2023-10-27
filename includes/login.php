<?php
require_once __DIR__ . "/discord.php";
require_once "../config.php";

Oauth($redirect_url,$client_id,$secret_id);
getUser();

header("Location: ../");
exit;