<?php
require_once __DIR__."/lib.php";

session_start();

$GLOBALS["base_url"] = "https://discord.com";

function gen_state(){
    $_SESSION["state"] = bin2hex(openssl_random_pseudo_bytes(12));
    return $_SESSION["state"];
}

function url($clientid,$redirect,$scope){
    $state = gen_state();
    return "https://discordapp.com/oauth2/authorize?response_type=code&client_id=".$clientid."&redirect_uri=".$redirect."&scope=".$scope."&state=".$state;
}

function init($redirect_url, $client_id, $client_secret){
    $code = $_GET["code"];
    $url = $GLOBALS["base_url"]."/api/oauth2/token";
    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL, $url);
    curl_setopt($curl,CURLOPT_POST, true);
    curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query(array(
        "client_id" => $client_id,
        "client_secret" => $client_secret,
        "grant_type" => "authorization_code",
        "code" => $code,
        "redirect_uri" => $redirect_url
    )));
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    $response = curl_exec($curl);
    curl_close($curl);
    $results = json_decode($response,true);
    $_SESSION["access_token"] = $results["access_token"];
}

function get_user(){
    $url = $GLOBALS["base_url"]."/api/users/@me";
    $headers = array("Content-Type: application/x-www-form-urlencoded", "Authorization: Bearer " . $_SESSION["access_token"]);
    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL,$url);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl,CURLOPT_HTTPHEADER,array(
        "Content-Type: application/x-www-form-urlencoded",
        "Authorization: Bearer ".$_SESSION["access_token"]
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $results = json_decode($response,true);
    $_SESSION["user"] = $results;
    $_SESSION["username"] = $results["username"];
    $_SESSION["discrim"] = $results["discriminator"];
    $_SESSION["user_id"] = $results["id"];
    $_SESSION["user_avatar"] = $results["avatar"];
    if($results["banner"]) $_SESSION["user_banner"] = $results["banner"];
    if($results["accent_color"]) $_SESSION["accent_color"] = $results["accent_color"];
    $_SESSION["user_flags"] = $results["public_flags"];
    $_SESSION["user_premium"] = $results["premium_type"];

    if(!empty($results["id"])){
        sql("INSERT INTO account (id, ip, time) VALUES(".$results["id"].",'".$_SERVER["REMOTE_ADDR"]."',NOW()) ON DUPLICATE KEY UPDATE id = VALUES (id),ip = VALUES (ip),time = VALUES (time);"); 
    }
}