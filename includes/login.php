<?php
require_once __DIR__."/discord.php";
require_once __DIR__."/lib.php";
require_once "../config.php";

$mute = DB::query("SELECT * FROM mute_ip WHERE ip = '".$_SERVER["REMOTE_ADDR"]."';")->fetchALL();
if($mute[0]) return print("アクセスが許可されていません");

Oauth($redirect_url,$client_id,$secret_id);
getUser();

header("Location: ../");
exit;