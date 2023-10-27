<?php
require_once __DIR__."/lib.php";

session_start();

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
   
    $_SESSION["token"] = $res["access_token"];
}

function getUser(){
    if(!$_SESSION["token"]) return;

    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL,"https://discord.com/api/users/@me");
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl,CURLOPT_HTTPHEADER,array(
        "Content-Type: application/x-www-form-urlencoded",
        "Authorization: Bearer ".$_SESSION["token"]
    ));
    $res = json_decode(curl_exec($curl),true);
    curl_close($curl);
   
    $_SESSION["user"] = $res;
    $_SESSION["name"] = $res["discriminator"] !== 0 ? $res["username"] : $res["username"]."#".$res["discriminator"];
    $_SESSION["id"] = $res["id"];
    $_SESSION["avatar"] = !empty($res["avatar"]) ? "https://cdn.discordapp.com/avatars/".$res["id"]."/".$res["avatar"].animate($res["avatar"]) : "https://cdn.discordapp.com/embed/avatars/0.png";

    if(!empty($res["id"])){
        DB::query("INSERT INTO account (id, ip, time) VALUES('".$res["id"]."','".$_SERVER["REMOTE_ADDR"]."',NOW()) ON DUPLICATE KEY UPDATE id = VALUES (id),ip = VALUES (ip),time = VALUES (time);"); 
    }
}