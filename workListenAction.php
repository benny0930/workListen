<?php

function fileWrite($path, $string)
{
    $fp = fopen($path, "w+"); //w是寫入模式,檔案不存在則建立檔案寫入。
    fwrite($fp, $string);
    fclose($fp);
}

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


$type = $_GET['type'];
$connection = GetMyConnection();
switch ($type) {
    case 'read':
        $file_path = $_GET['filename'];
        $userName = $_GET['userName'];
        switch ($file_path) {
            case 'chatroom.txt':
                $sDate1 = "[]";
                $sql = "SELECT * FROM fa_chatroom";
                $result = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                if ($result) {
                    $sDate1 = json_encode($result);
                }

                $sql = "INSERT INTO `fa_user_online` (`name`, `timestamp`) VALUES ('" . $userName . "', '" . strtotime("now") . "') ON DUPLICATE KEY UPDATE `timestamp` = '" . strtotime("now") . "'";
                $result = $connection->exec($sql);

                $sql = "SELECT * FROM fa_user_online where `timestamp` > " . (strtotime("now") - 30);
                $result = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                $sData2 = json_encode($result);

                echo json_encode([$sDate1, $sData2]);

                break;
            case 'broadcast.txt':
                if ($userName === "admin") {
                    $sql = "SELECT * FROM fa_broadcast order by interstitial desc , id asc";
                    $result = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                    if (!$result) {
                        $sql = "SELECT * FROM fa_history";
                        $result = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);

                        $historyOne = $result[array_rand($result, 1)];
                        //UPDATE `fa_history` SET `timestamp`='6666' WHERE  `id`='555';
                        $sql = "UPDATE `fa_history` SET `timestamp`='" . strtotime("now") . "' WHERE  `id`=" . $historyOne['id'] . " AND timestamp = '';";
                        $result = $connection->exec($sql);

                        $sql = "INSERT INTO `fa_broadcast` (`youtube_id`, `title`, `timestamp`) VALUES ('" . $historyOne['id'] . "', '" . $historyOne['title'] . "','" . strtotime("now") . "');";
                        $result = $connection->exec($sql);
                    } else {
                        $sql = "UPDATE `fa_broadcast` SET `timestamp`='" . strtotime("now") . "' WHERE  `id`=" . $result[0]['id'] . "  AND timestamp = '';";
                        $result = $connection->exec($sql);
                        $sql = "SELECT * FROM fa_broadcast order by interstitial desc , id asc";
                        $result = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                    }
                }
                $sql = "SELECT * FROM fa_broadcast order by interstitial desc , id asc";
                $result = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($result);
                break;
            case 'history.txt':
                $sql = "SELECT * FROM fa_history order by timestamp desc";
                $result = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                if ($result) {
                    echo json_encode($result);
                } else {
                    echo "[]";
                }
                break;
            default:
                break;
        }
        break;
    case 'add':
        $id = $_GET['id'];
        $title = empty($_GET['title']) ? "" : $_GET['title'];

        $sql = "INSERT INTO `fa_broadcast` (`youtube_id`, `title`) VALUES ('" . $id . "', '" . $title . "');";
        $result = $connection->exec($sql);
        $sql = "SELECT * FROM fa_broadcast order by interstitial desc , id asc";
        $result = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
        break;
    case 'interstitial':
        $id = $_GET['id'];
        $title = empty($_GET['title']) ? "" : $_GET['title'];

        $sql = "INSERT INTO `fa_broadcast` (`youtube_id`, `title`, `interstitial`) VALUES ('" . $id . "', '" . $title . "','1');";
        $result = $connection->exec($sql);
        $sql = "SELECT * FROM fa_broadcast order by interstitial desc , id asc";
        $result = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
        break;
    case 'del':
        $id = $_GET['id'];
        $sql = "DELETE FROM `fa_broadcast` WHERE  `id`='" . $id . "';";
        $result = $connection->exec($sql);
        $sql = "SELECT * FROM fa_broadcast order by interstitial desc , id asc";
        $result = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
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
    case 'end':
        $id = $_GET['id'];
        $admin = empty($_GET['admin']) ? "" : $_GET['admin'];
        $videoType = empty($_GET['videoType']) ? "" : $_GET['videoType'];

        if ($admin == "admin") {
            $id = $_GET['id'];

            $sql = "SELECT * FROM `fa_broadcast` WHERE  `id`='" . $id . "';";
            $result = $connection->query($sql)->fetch(PDO::FETCH_ASSOC);

            $sql = "INSERT INTO `fa_history` (`id`, `title`, `timestamp`) 
                    VALUES ('" . $result['youtube_id'] . "', '" . $result['title'] . "', '" . $result['timestamp'] . "') 
                    ON DUPLICATE KEY UPDATE timestamp='" . $result['timestamp'] . "';";
            $result = $connection->exec($sql);

            $sql = "DELETE FROM `fa_broadcast` WHERE  `id`='" . $id . "';";
            $result = $connection->exec($sql);

            $sql = "SELECT * FROM fa_broadcast order by interstitial desc , id asc";
            $result = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            if (!$result) {
                $sql = "SELECT * FROM fa_history where `timestamp` < " . (strtotime("now") - 4800) ." ORDER BY RAND() LIMIT 1;";
                $result = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                $historyOne = $result[0];

                $sql = "UPDATE `fa_history` SET `timestamp`='" . strtotime("now") . " , `times` =  times + 1 ' WHERE  `id`=" . $historyOne['id'] . ";";
                $result = $connection->exec($sql);

                $sql = "INSERT INTO `fa_broadcast` (`youtube_id`, `title`, `timestamp`) VALUES ('" . $historyOne['id'] . "', '" . $historyOne['title'] . "','" . strtotime("now") . "');";
                $result = $connection->exec($sql);

                $historyOne['timestamp'] = strtotime("now");

            } else {
                //
                $sql = "UPDATE `fa_broadcast` SET `timestamp`='" . strtotime("now") . "' WHERE  `id`=" . $result[0]['id'] . ";";
                $result = $connection->exec($sql);
            }
        }
        $sql = "SELECT * FROM fa_broadcast order by interstitial desc , id asc";
        $sDate1 = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT * FROM fa_history order by timestamp desc ";
        $sDate2 = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([json_encode($sDate1), json_encode($sDate2)]);
        break;
    default:
        break;
}




