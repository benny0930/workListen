<?php
$type = $_GET['type'];
if ($type == "read") {
    $file_path = $_GET['filename'];
    $fp = fopen($file_path, "a"); //w是寫入模式,檔案不存在則建立檔案寫入。
    fclose($fp);
    $str = file_get_contents($file_path);
    if ($str == "") {
        $fp = fopen($file_path, "a"); //w是寫入模式,檔案不存在則建立檔案寫入。
        fwrite($fp, "{}");
        fclose($fp);
        echo "{}";
    } else
        echo $str;
} else if ($type == "add") {
    $id = $_GET['id'];
    $title = $_GET['title'];
    $file_path = $_GET['filename'];
    $str = file_get_contents($file_path);
    $aDate = json_decode($str, true);
    $length = count($aDate);
    $aDate[$length] = [
        'id' => $id,
        'title' => $title,
        'timestamp'=>'',
    ];
    $sDate = json_encode($aDate);
    $fp = fopen($file_path, "w+"); //w是寫入模式,檔案不存在則建立檔案寫入。
    fwrite($fp, $sDate);
    fclose($fp);
    echo $sDate;
} else if ($type == "end") {
    $id = $_GET['id'];
    $admin = empty($_GET['admin'])? "":$_GET['admin'];
    $broadcast = 'broadcast.txt';
    $str = file_get_contents($broadcast);
    $aDate = json_decode($str, true);
    $saveDate = Null;
    $aNewDate = [];
    if($admin=="admin"){
        foreach ($aDate as $key => $oDate) {
            if ($key > 0) {
                if ($key == 1) {
                    $oDate['timestamp'] =  strtotime("now");
                }
                $aNewDate[] = $oDate;
            }
            else {
                $saveDate = $oDate;
            }
        }
    }
    else{
        $aNewDate = $aDate;
    }

    $sDate1 = json_encode($aNewDate);
    $fp = fopen($broadcast, "w+"); //w是寫入模式,檔案不存在則建立檔案寫入。
    fwrite($fp, $sDate1);
    fclose($fp);


    $history = 'history.txt';
    $str = file_get_contents($history);
    $aDate2 = json_decode($str, true);
    if($admin=="admin"){
        $aDate2[] = $saveDate;
        if (count($aDate2) > 50) {
            array_splice($aDate2,0,1);
        }
    }
    $sDate2 = json_encode($aDate2);
    $fp = fopen($history, "w+"); //w是寫入模式,檔案不存在則建立檔案寫入。
    fwrite($fp, $sDate2);
    fclose($fp);
    echo json_encode([$sDate1, $sDate2]);
//    echo json_encode($sDate2);
}


?>