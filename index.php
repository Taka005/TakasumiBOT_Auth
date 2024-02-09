<?php
require_once __DIR__."/includes/discord.php";
require_once __DIR__."/config.php";
?>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>TakasumiBOT Auth</title>

		<link rel="apple-touch-icon" type="image/png" sizes="180x180" href="./assets/img/apple-touch-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="16x16" href="./assets/img/favicon-16x16.png">
		<link rel="icon" type="image/png" sizes="32x32" href="./assets/img/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="180x180" href="./assets/img/apple-touch-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192" href="./assets/img/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="1024x1024" href="./assets/img/takasumibot.png">

		<head prefix="og: https://ogp.me/ns# fb: https://ogp.me/ns/ fb# prefix属性: https://ogp.me/ns/ prefix属性#">
		<meta property="og:url" content="https://auth.takasumibot.com/" />
		<meta property="og:type" content="website" />
		<meta property="og:title" content="トップページ" />
		<meta property="og:description" content="TakasumiBOT Web認証システム" />
		<meta property="og:site_name" content="TakasumiBOT Auth" />
		<meta property="og:image" content="https://auth.takasumibot.com/assets/img/takasumibot.png" />

		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="TakasumiBOT Web認証システム">
		<meta name="keywords" content="Discord,TakasumiBOT Auth,TakasumiBOT,Taka005">

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<link rel="stylesheet" href="./assets/css/style.css">
	</head>
	<body>
		<header>
			<nav class="navbar navbar-expand-md navbar-light bg-light fixed-top">
				<div class="container-fluid">
					<a class="navbar-brand text-darl mb-0 h1" href="/">TakasumiBOT Auth</a>
				</div>
			</nav>
		</header>
		<main>
            <?php if(isset($_SESSION["user"])){ ?>
				<div class="User card text-center">
					<div>
						<img class="Icon" src="<?=$_SESSION["avatar"]?>" width="150" height="150" alt="アイコン">
					</div>
					<div class="card-body">
						<h1 class="card-title"><?=$_SESSION["name"]?></h1>
						<p class="card-text"><small class="text-muted"><?=$_SESSION["id"]?></small></p>
						<a href="./includes/logout" class="UserButton btn btn-lg btn-outline-danger">ログアウト</a>
					</div>
				</div>
            <?php }else{ ?>
				<div class="Top card text-center">
					<div class="card-body">
						<h1 class="card-title">TakasumiBOT Auth</h1>
						<p class="card-text"><small>TakasumiBOT Web認証システム</small></p>
						<a href="<?=OauthURL($client_id,$redirect_url,$scopes)?>" class="TopButton btn btn-lg btn-outline-success">ログイン</a>
					</div>
				</div>
            <?php } ?>
			</div>
		</main>
	</body>
</html>