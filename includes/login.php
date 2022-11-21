<?php
require __DIR__ . "/discord.php";
require "../config.php";

init($redirect_url, $client_id, $secret_id);
get_user();

header('Location: ../');
exit;