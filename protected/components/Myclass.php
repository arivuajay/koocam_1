<?php

class Myclass extends CController {

    public static function encrypt($value) {
        return hash("sha512", $value);
    }

    public static function refencryption($str) {
        return base64_encode($str);
    }

    public static function refdecryption($str) {
        return base64_decode($str);
    }

    public static function t($str = '', $params = array(), $dic = 'app') {
        return Yii::t($dic, $str, $params);
    }

    public static function getRandomString($length = 9) {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; //length:36
        $final_rand = '';
        for ($i = 0; $i < $length; $i++) {
            $final_rand .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $final_rand;
    }

    public static function slugify($text) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        // trim
        $text = trim($text, '-');
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // lowercase
        $text = strtolower($text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public static function rememberMe($username, $check) {
        if ($check > 0) {
            $time = time();     // Gets the current server time
            $cookie = new CHttpCookie('koo_username', $username);

            $cookie->expire = $time + 60 * 60 * 24 * 30;               // 30 days
            Yii::app()->request->cookies['koo_username'] = $cookie;
        } else {
            unset(Yii::app()->request->cookies['koo_username']);
        }
    }

    public static function reArrayFiles($model, $column) {
        $file_ary = array();
        $file_count = count($_FILES[$model]['name'][$column]);
        $file_keys = array_keys($_FILES[$model]);

        for ($i = 0; $i < $file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $_FILES[$model][$key][$column][$i];
            }
        }
        return $file_ary;
    }

    public static function getDatediff($date1, $date2) {
        $d1 = new DateTime($date1);
        $d2 = new DateTime($date2);
        $diff = strtotime($date2) - strtotime($date1);
        $days = ($diff % 604800) / 86400;
        $months = $d1->diff($d2)->m + ($d1->diff($d2)->y * 12);
        $years = $d1->diff($d2)->y;
        $weeks = ($diff - ($days * 86400)) / 604800;

        return array(
            'days' => $days,
            'months' => $months,
            'weeks' => $weeks,
            'years' => $years,
        );
    }

    public static function is_date($str) {
        $stamp = strtotime($str);
        if (!is_numeric($stamp)/* || !preg_match("^\d{1,2}[.-/]\d{2}[.-/]\d{4}^", $str) */)
            return FALSE;
        $month = date('m', $stamp);
        $day = date('d', $stamp);
        $year = date('Y', $stamp);
        return checkdate($month, $day, $year);
    }

    public static function reArrangeArray($array) {
        $lastVal = end($array);
        $lastKey = key($array);

        $arr1 = array($lastKey => $lastVal);
        array_pop($array);

        $arr1 = array_merge($arr1, $array);
        return $arr1;
    }

    public static function cleanData(&$str) {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
    }

    public static function getYesOrNo() {
        return array(
            "N" => "No",
            "Y" => "Yes"
        );
    }

    public static function priceLimitation() {
        /* min. minutes => min. price */
        $limitations = array(
            '00:05' => 5,
            '00:30' => 10,
            '01:00' => 10,
        );
        $limits = array();
        foreach ($limitations as $minute => $price) {
            $limits[strtotime($minute)] = $price;
        }
        return $limits;
    }

    public static function getStatus() {
        return array(
            "0" => "In-Active",
            "1" => "Active",
            "2" => "Delete"
        );
    }

    public static function guid($opt = true) {
        $new_guid = Myclass::create_guid($opt);
        do {
            $exist_count = GigBooking::model()->countByAttributes(array('book_guid' => $new_guid));
            $exist_count += BookingTemp::model()->countByAttributes(array('temp_guid' => $new_guid));
            if ($exist_count > 0) {
                $old_guid = $new_guid;
                $new_guid = Myclass::create_guid($opt);
            } else {
                break;
            }
        } while ($old_guid != $new_guid);
        return $new_guid;
    }

    public static function create_guid($opt = true) {       //  Set to true/false as your default way to do this.
        if (function_exists('com_create_guid')) {
            if ($opt) {
                return com_create_guid();
            } else {
                return trim(com_create_guid(), '{}');
            }
        } else {
            mt_srand((double) microtime() * 10000);    // optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);    // "-"
            $left_curly = $opt ? chr(123) : "";     //  "{"
            $right_curly = $opt ? chr(125) : "";    //  "}"
            $uuid = $left_curly
                    . substr($charid, 0, 8) . $hyphen
                    . substr($charid, 8, 4) . $hyphen
                    . substr($charid, 12, 4) . $hyphen
                    . substr($charid, 16, 4) . $hyphen
                    . substr($charid, 20, 12)
                    . $right_curly;
            return $uuid;
        }
    }

    public static function timeAgo($time) {
        $cur_time = strtotime(Yii::app()->localtime->toLocalDateTime(date("Y-m-d H:i:s"), 'short', 'short'));

        $time = $cur_time - $time; // to get the time since that moment
        $time = ($time < 1) ? 1 : $time;
        $tokens = array(
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'min',
            1 => 'sec'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit)
                continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '').' ago';
        }
    }
    
    

}
