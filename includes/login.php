<?php
require_once __DIR__ . "/discord.php";
require_once "../config.php";

init($redirect_url, $client_id, $secret_id);
get_user();

header("Location: ../");
exit;