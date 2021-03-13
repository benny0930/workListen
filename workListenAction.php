<?php

$type = $_GET['type'];

switch ($type) {
    case 'read':
        $file_path = $_GET['filename'];
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
        $broadcast = 'broadcast.txt';
        $str = file_get_contents($broadcast);
        $aDate = json_decode($str, true);
        $saveDate = Null;
        $aNewDate = [];
        $iNewDateIndex = -1;
        if ($admin == "admin") {
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
        } else {
            $aNewDate = $aDate;
        }

        $history = 'history.txt';
        $str = file_get_contents($history);
        $aDate2 = json_decode($str, true);
        $aNewDate2 = [];
        if ($admin == "admin") {
            if (count($aNewDate) == 0) {
                $iNewDateIndex = rand(0, (count($aDate2) - 1));
            }
            $aDate2[] = $saveDate;
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
        }
        $sDate1 = json_encode(array_filter($aNewDate));
        fileWrite($broadcast, $sDate1);
        $sDate2 = json_encode(array_filter($aNewDate2));
        fileWrite($history, $sDate2);
        echo json_encode([$sDate1, $sDate2]);
        break;
    default:
        break;
}


function fileWrite($path, $string)
{
    $fp = fopen($path, "w+"); //w是寫入模式,檔案不存在則建立檔案寫入。
    fwrite($fp, $string);
    fclose($fp);
}

