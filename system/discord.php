<?php
require_once __DIR__."/lib.php";

session_start();

$GLOBALS["base_url"] = "https://discord.com";

function OauthURL($clientid,$redirect,$scope){
    return "https://discordapp.com/oauth2/authorize?response_type=code&client_id=".$clientid."&redirect_uri=".$redirect."&scope=".$scope;
}

function Oauth($redirect_url,$client_id,$client_secret){
    if(!$_GET["code"]) return;

    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL,"https://discord.com/api/oauth2/token");
    curl_setopt($curl,CURLOPT_POST,true);
    curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query(array(
        "client_id"=>$client_id,
        "client_secret"=>$client_secret,
        "grant_type"=>"authorization_code",
        "code"=>$_GET["code"],
        "redirect_uri"=>$redirect_url
    )));
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    $res = json_decode(curl_exec($curl),true);
    curl_close($curl);
   
    $_SESSION["access_token"] = $res["access_token"];
}

function getUser(){
    if(!$_SESSION["access_token"]) return;

    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL,"https://discord.com/api/users/@me");
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl,CURLOPT_HTTPHEADER,array(
        "Content-Type: application/x-www-form-urlencoded",
        "Authorization: Bearer ".$_SESSION["access_token"]
    ));
    $res = json_decode(curl_exec($curl),true);
    curl_close($curl);
   
    $_SESSION["user"] = $res;
    $_SESSION["username"] = $res["username"];
    $_SESSION["discrim"] = $res["discriminator"];
    $_SESSION["user_id"] = $res["id"];
    $_SESSION["avatar"] = $_SESSION["avatar"] = !empty($res["avatar"]) ? "https://cdn.discordapp.com/avatars/".$res["id"]."/".$res["avatar"].animate($res["avatar"]) : "https://cdn.discordapp.com/embed/avatars/0.png";
    if($res["banner"]) $_SESSION["user_banner"] = $res["banner"];
    if($res["accent_color"]) $_SESSION["accent_color"] = $res["accent_color"];


    if(!empty($res["id"])){
        DB::query("INSERT INTO account (id, ip, time) VALUES(".$res["id"].",'".$_SERVER["REMOTE_ADDR"]."',NOW()) ON DUPLICATE KEY UPDATE id = VALUES (id),ip = VALUES (ip),time = VALUES (time);"); 
    }
}