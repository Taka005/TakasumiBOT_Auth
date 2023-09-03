<?php
require_once __DIR__ . "/includes/discord.php";
require_once __DIR__ . "/config.php";

function is_animated($image){
	$ext = substr($image, 0, 2);
	if($ext == "a_"){
		return ".gif";
	}else{
		return ".png";
	}
}
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TakasumiBOT Auth</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="apple-touch-icon" type="image/png" sizes="180x180" href="./assets/img/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/img/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="180x180" href="./assets/img/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="./assets/img/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="1024x1024" href="./assets/img/takasumibot.png">

    <head prefix="og: https://ogp.me/ns# fb: https://ogp.me/ns/ fb# prefix属性: https://ogp.me/ns/ prefix属性#">
    <meta property="og:url" content="https://auth.taka.cf/" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="トップページ" />
    <meta property="og:description" content="TakasumiBOT Web認証システム" />
    <meta property="og:site_name" content="TakasumiBOT Auth" />
    <meta property="og:image" content="https://auth.taka.cf/assets/img/takasumibot.png" />

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="TakasumiBOT Web認証システム">
    <meta name="keywords" content="Discord,TakasumiBOT Auth,TakasumiBOT,Taka005">

</head>
<body>
	<main class="p-0 base">
		<h1 class="text-center text-light">TakasumiBOT Auth</h1>
	<?php
	if(isset($_SESSION["user"])){
		$avatar_url = !is_null($_SESSION["user_avatar"])?"https://cdn.discordapp.com/avatars/".$_SESSION["user_id"]."/".$_SESSION["user_avatar"].is_animated($_SESSION["user_avatar"]):"https://cdn.discordapp.com/embed/avatars/0.png";
		if(isset($_SESSION["user_banner"])) $banner_url = "https://cdn.discordapp.com/banners/".$_SESSION["user_id"]."/".$_SESSION["user_banner"].is_animated($_SESSION["user_banner"]);
	?>
		<div class="user-card">
			<div class="header-banner" style="background:#<?=str_pad(dechex($_SESSION['accent_color']),4,"0",STR_PAD_LEFT)?>">
				<?php echo (isset($banner_url)?'<img src="'.$banner_url.'?size=300">':"");?>
			</div>
			<div class="header-top">
				<div class="header-avatar">
					<img src="<?=$avatar_url?>" height="94" />
				</div>
				<div class="header-text">
					<?php if($_SESSION["discrim"]==0){ ?>
						<span class="header-username">
							@<?=$_SESSION["username"]?>
						</span>
					<?php }else{ ?>
						<span class="header-username">
							<?=$_SESSION["username"]?>
						</span>
						<span class="header-discrim">
							#<?=$_SESSION["discrim"]?> 
						</span>
					<?php } ?>
				</div>
				<p class="text-muted"><small><?=$_SESSION["user_id"]?></small></p>
				<div class="header-badges">
					<?php
						for($i=0;$i<20;$i++){
							if($_SESSION["user_flags"] & (1 << $i))
								echo '<img src="./assets/img/badges/'.$i.'.svg" height="22"/>';
						}
						if($_SESSION['user_premium'] > 0) echo '<img src="./assets/img/badges/nitro.svg" height="22"/>';
						if($_SESSION['user_premium'] > 1) echo '<img src="./assets/img/badges/boost.svg" height="22"/>';
					?>
				</div>
			</div>
			<div class="body-wrapper">
				<div class="body">
					<a class="btn btn-lg btn-danger btn-block" href="./includes/logout">ログアウト</a>
				</div>
			</div>

		</div>
	<?php }else{ ?>
		<a class="btn btn-lg btn-discord btn-block" href="<?=$auth_url = url($client_id,$redirect_url,$scopes)?>">ログイン</a>
    <?php } ?>
	</main>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js" integrity="sha384-BOsAfwzjNJHrJ8cZidOg56tcQWfp6y72vEJ8xQ9w6Quywb24iOsW913URv1IS4GD" crossorigin="anonymous"></script>
</body>
