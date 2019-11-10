<?php
$g_db = "db/";
$g_urs = $_SERVER["QUERY_STRING"];
if ($g_urs <> "") {
    $g_urr = explode('/', $g_urs. '/////');
    $g_u0 = intval($g_urr[0]);
    $g_u1 = intval($g_urr[1]);
    $g_u2 = intval($g_urr[2]);
};
if ($g_u1==8) {//添加
    $poststr=file_get_contents('php://input');
    if (file_exists($g_db.$g_u0.".txt")) {
        $chatkey = file_get_contents($g_db.$g_u0.".txt");
    } else {
        $chatkey=0;
    }
    $chatkey=$chatkey+1;
		if($chatkey>100){$chatkey=1;}
    file_put_contents($g_db.$g_u0.".txt", $chatkey);
    $poststr='"'.$chatkey.'":'.$poststr;
    if (file_exists($g_db.$g_u0.".json")&&substr($chatkey, -2)<>"00") {
        file_put_contents($g_db.$g_u0.".json", ",".$poststr, FILE_APPEND | LOCK_EX);
    } else {
        file_put_contents($g_db.$g_u0.".json", $poststr);
    }
        
    exit(urldecode($chatkey));
} elseif ($g_u1==0) {//获取
    if (file_exists($g_db.$g_u0.".txt")) {
        $chatkey = file_get_contents($g_db.$g_u0.".txt");
    } else {
        $chatkey=0;
    }
    if ($chatkey!=$g_u2) {
        if (file_exists($g_db.$g_u0.".json")) {
            if ($g_u2==0) {
                $g_u2=1;
            } elseif ($g_u2>$chatkey) {
                $g_u2=1;
            }
            $chatjson = json_decode('{'.file_get_contents($g_db.$g_u0.".json").'}', true);
            for ($i=$g_u2+1; $i<=$chatkey; $i++) {
                if ($i==$g_u2+1) {
                    $outval= '"'.$i.'":'.json_encode($chatjson[$i]);
                } else {
                    $outval= $outval.',"'.$i.'":'.json_encode($chatjson[$i]);
                }
            }
            $outval='{"key":'.$chatkey.',"obj":{'.$outval.'}}';
            exit(urldecode(json_encode(json_decode($outval, true))));
        }
    } else {
        exit(urldecode($chatkey));
    }
}
