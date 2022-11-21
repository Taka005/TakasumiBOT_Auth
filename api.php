<?php
    header('Content-Type: application/json; charset=UTF-8');
    
    if(isset($_GET["search"])){
        $search = htmlspecialchars($_GET["search"]);
        $user = json_decode(file_get_contents("./data/user.json"),JSON_BIGINT_AS_STRING);

        if($search === "all"){
            $res["success"] = true;
            $res["message"] = null;
            $res["data"] = array_keys($user);
        }else if($search === "info"){
            $res["success"] = true;
            $res["message"] = null;
            $res["data"] = (object)[
                'members'=> count(array_keys($user))
            ];
        }else if(isset($user[$search])){
            $res["success"] = true;
            $res["message"] = null;
            $res["data"] = $user[$search];
        }else{
            $res["success"] = false;
            $res["message"] = "There's no result found";
            $res["data"] = null;
        }
    }else{
        $res["success"] = false;
        $res["message"] = "Parameter not found";
        $res["data"] = null;
    }
    
    print json_encode($res,JSON_UNESCAPED_SLASHES|JSON_PARTIAL_OUTPUT_ON_ERROR);
?>