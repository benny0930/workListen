<?php

function fileWrite($path, $string)
{
    $fp = fopen($path, "w+"); //w是寫入模式,檔案不存在則建立檔案寫入。
    fwrite($fp, $string);
    fclose($fp);
}

$type = $_GET['type'];

function GetMyConnection()
{
    $servername = "34.80.17.96";
    $username = "homestead";
    $password = "e6teNX28AWcFy5hC";
    $dbname = "homestead";

    $dbms = 'mysql';     //数据库类型
    $host = '34.80.17.96'; //数据库主机名
    $dbName = 'homestead';    //使用的数据库
    $user = 'homestead';      //数据库连接用户名
    $pass = 'e6teNX28AWcFy5hC';          //对应的密码
    $dsn = "$dbms:host=$host;dbname=$dbName";
    $db = new PDO($dsn, $user, $pass);
    return $db;

}


switch ($type) {
    case 'read':
        $file_path = $_GET['filename'];
        switch ($file_path) {
            case 'chatroom.txt':
                $connection = GetMyConnection();
                $sql = "SELECT * FROM fa_chatroom";
                $result = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($result);
                break;
            default:

                $fp = fopen($file_path, "a"); //w是寫入模式,檔案不存在則建立檔案寫入。
                fclose($fp);
                $str = file_get_contents($file_path);
                if ($str == "") {
                    $fp = fopen($file_path, "a"); //w是寫入模式,檔案不存在則建立檔案寫入。
                    fwrite($fp, "[]");
                    fclose($fp);
                    echo "[]";
                } else {
                    echo $str;
                }
                break;
        }
        break;
    case 'add':
        $id = $_GET['id'];
        $title = empty($_GET['title']) ? "" : $_GET['title'];
        $file_path = $_GET['filename'];
        $str = file_get_contents($file_path);
        $aDate = json_decode($str, true);
        if (!empty($id) && $id != "" && $id != null) {
            $aDate[] = [
                'id' => $id,
                'title' => $title,
                'timestamp' => '',
            ];
        }
        $sDate = json_encode(array_filter($aDate));
        fileWrite($file_path, $sDate);
        echo $sDate;
        break;
    case 'interstitial':
        $id = $_GET['id'];
        $title = empty($_GET['title']) ? "" : $_GET['title'];

        $file_path = $_GET['filename'];
        $str = file_get_contents($file_path);
        $aDate = json_decode($str, true);

        if (!empty($id) && $id != "" && $id != null) {
            $aNewDate = [];
            $index = count($aDate); // 0 1 2 3 ..
            if ($index == 0) {
                $aNewDate[] = [
                    'id' => $id,
                    'title' => $title,
                    'timestamp' => '',
                ];
            } else {
                foreach ($aDate as $key => $oDate) {
                    $aNewDate[] = $oDate;
                    if ($key == 0) {
                        $aNewDate[] = [
                            'id' => $id,
                            'title' => $title,
                            'timestamp' => '',
                        ];
                    }
                }
            }
            $sDate = json_encode(array_filter($aNewDate));
        } else {
            $sDate = $str;
        }

        fileWrite($file_path, $sDate);
        echo $sDate;
        break;
    case 'del':
        $id = $_GET['id'];
        $file_path = $_GET['filename'];
        $str = file_get_contents($file_path);
        $aDate = json_decode($str, true);
        $aNewDate = [];
        foreach ($aDate as $key => $oDate) {
            if ($oDate['id'] != $id)
                $aNewDate[] = $oDate;
        }
        $sDate = json_encode(array_filter($aNewDate));
        fileWrite($file_path, $sDate);
        echo $sDate;
        break;
    case 'end':
        $id = $_GET['id'];
        $admin = empty($_GET['admin']) ? "" : $_GET['admin'];
        $videoType = empty($_GET['videoType']) ? "" : $_GET['videoType'];
        $sDate1 = "[]";
        $sDate2 = "[]";
        if ($admin == "admin") {
            $broadcast = 'broadcast.txt';
            $str = file_get_contents($broadcast);
            $aDate = json_decode($str, true);
            $saveDate = Null;
            $aNewDate = [];
            $iNewDateIndex = -1;
            foreach ($aDate as $key => $oDate) {
                if ($key > 0) {
                    if ($key == 1) {
                        $oDate['timestamp'] = strtotime("now");
                    }
                    $aNewDate[] = $oDate;
                } else {
                    $saveDate = $oDate;
                }
            }

            $history = 'history.txt';
            $str = file_get_contents($history);
            $aDate2 = json_decode($str, true);
            $aNewDate2 = [];
            if (count($aNewDate) == 0) {
                $iNewDateIndex = rand(0, (count($aDate2) - 1));
            }
            if ($videoType != '-1') {
                $aDate2[] = $saveDate;
            }
            if (count($aDate2) > 50) {
                array_splice($aDate2, 0, 1);
            }
            $aIds = [];
            foreach ($aDate2 as $key2 => $oDate2) {
                if ($iNewDateIndex != -1) {
                    if ($key2 == $iNewDateIndex) {
                        $aNewDate[] = [
                            'id' => $oDate2['id'],
                            'title' => $oDate2['title'],
                            'timestamp' => strtotime("now"),
                        ];
                    }
                }

                if (!in_array($oDate2['id'], $aIds)) {
                    $aNewDate2[] = $oDate2;
                    $aIds[] = $oDate2['id'];
                }
            }
            $sDate1 = json_encode(array_filter($aNewDate));
            fileWrite($broadcast, $sDate1);
            $sDate2 = json_encode(array_filter($aNewDate2));
            fileWrite($history, $sDate2);
        } else {
            $broadcast = 'broadcast.txt';
            $sDate1 = file_get_contents($broadcast);

            $history = 'history.txt';
            $sDate2 = file_get_contents($history);
        }


        echo json_encode([$sDate1, $sDate2]);
        break;
    case 'sendMsg':
        $name = $_GET['name'];
        $msg = $_GET['msg'];
        $connection = GetMyConnection();

        $sql = "INSERT INTO `fa_chatroom` (`name`, `msg`, `timestamp`) VALUES ('" . $name . "', '" . $msg . "', '" . strtotime("now") . "');";
        $result = $connection->exec($sql);

        $sql = "SELECT * FROM fa_chatroom";
        $result = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
        break;
    default:
        break;
}




