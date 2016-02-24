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
    
    public static function getPurchaseID($length = 6) {
        $new_guid = strtoupper(Myclass::getRandomString($length));
        do {
            $exist_count = Purchase::model()->countByAttributes(array('order_id' => $new_guid));
            if ($exist_count > 0) {
                $old_guid = $new_guid;
                $new_guid = Myclass::getRandomString($length);
            } else {
                break;
            }
        } while ($old_guid != $new_guid);
        return $new_guid;
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
            $exist_count = CamBooking::model()->countByAttributes(array('book_guid' => $new_guid));
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
            return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '') . ' ago';
        }
    }

    public static function getTimezone() {
        $ip = CHttpRequest::getUserHostAddress();
        $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));
        if ($query && $query['status'] == 'success') {
            return $query;
        } else {
            return null;
        }
    }

    public static function is_url_exist($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($code == 200) {
            $status = true;
        } else {
            $status = false;
        }
        curl_close($ch);
        return $status;
    }

    public static function dashBoardResults() {
        $criteria = new CDbCriteria;
        $date = date('Y-m-d');
        $criteria->condition = " date(created_at) = '$date'";

        $tot_users = User::model()->current()->count();
        $new_users_per_day = User::model()->current()->count($criteria);
        $sql = "SELECT a.cam_id, b.cam_title, COUNT(a.cam_id) AS most_cam
                FROM {{cam_booking}} a
                JOIN {{cam}} b
                ON b.cam_id = a.cam_id
                WHERE a.book_payment_status = 'C'
                AND a.book_approve = '1'
                GROUP BY a.cam_id
                ORDER BY most_cam DESC
                LIMIT 0,1";
        $most_cam = Yii::app()->db->createCommand($sql)->queryAll();

        $sql = "SELECT b.country_name, COUNT(b.country_Id) AS user_count
                FROM {{user}} a
                JOIN {{country}} b
                ON a.country_id = b.country_Id
                WHERE a.status IN ('1', '0')
                GROUP BY b.country_Id";
        $user_country = CHtml::listData(Yii::app()->db->createCommand($sql)->queryAll(), 'country_name', 'user_count');

        $new_cams_per_day = Cam::model()->exceptDelete()->count($criteria);
        $deleted_cams_per_day = Cam::model()->deleted()->count($criteria);
        $cams_sold_per_day = Purchase::model()->count($criteria);
        $cam_categories = CamCategory::model()->findAll();

        //All Booking
        $admin_process = Yii::app()->db->createCommand()
                ->select('SUM(book_processing_fees) as total_process_amt')
                ->from('{{cam_booking}}')
                ->andWhere(' book_approve = "1" And book_payment_status = "C"')
                ->queryRow();
        $admin_process = (!empty($admin_process['total_process_amt'])) ? $admin_process['total_process_amt'] : 0;

        //Booking Today
        $admin_process_per_day = Yii::app()->db->createCommand()
                ->select('SUM(book_processing_fees) as total_process_amt')
                ->from('{{cam_booking}}')
                ->andWhere(' book_approve = "1" And book_payment_status = "C" And date(book_date) = "' . $date . '"')
                ->queryRow();
        $admin_process_per_day = (!empty($admin_process_per_day['total_process_amt'])) ? $admin_process_per_day['total_process_amt'] : 0;

        //All Service
        $admin_service = Yii::app()->db->createCommand()
                ->select('SUM(book_service_tax) as total_service_amt')
                ->from('{{cam_booking}}')
                ->andWhere(' book_approve = "1" And book_payment_status = "C"')
                ->queryRow();
        $admin_service = (!empty($admin_service['total_service_amt'])) ? (float) $admin_service['total_service_amt'] : 0;

        //Service Today
        $admin_service_per_day = Yii::app()->db->createCommand()
                ->select('SUM(book_service_tax) as total_service_amt')
                ->from('{{cam_booking}}')
                ->andWhere(' book_approve = "1" And book_payment_status = "C" And date(book_date) = "' . $date . '"')
                ->queryRow();
        $admin_service_per_day = (!empty($admin_service_per_day['total_service_amt'])) ? (float) $admin_service_per_day['total_service_amt'] : 0;

        $type_revenue = Transaction::TYPE_REVENUE;
        //Transaction
        $total_revenue = Yii::app()->db->createCommand()
                ->select('SUM(`trans_admin_amount`) as total_revenue_amt')
                ->from('{{transaction}}')
                ->andWhere(' trans_type = "' . $type_revenue . '"')
                ->queryRow();
        $total_revenue = (!empty($total_revenue['total_revenue_amt'])) ? $total_revenue['total_revenue_amt'] : 0;

        //Transaction Today
        $total_revenue_per_day = Yii::app()->db->createCommand()
                ->select('SUM(`trans_admin_amount`) as total_revenue_amt')
                ->from('{{transaction}}')
                ->andWhere(' trans_type = "' . $type_revenue . '" And date(created_at) = "' . $date . '"')
                ->queryRow();
        $total_revenue_per_day = (!empty($total_revenue_per_day['total_revenue_amt'])) ? $total_revenue_per_day['total_revenue_amt'] : 0;

        $admin_earnings = (float) ($admin_process + $total_revenue);
        $admin_earnings_today = (float) ($admin_process_per_day + $total_revenue_per_day);

        $return['tot_users'] = $tot_users;
        $return['new_users_per_day'] = $new_users_per_day;
        $return['most_cam'] = !empty($most_cam) ? $most_cam[0]['cam_title'] : '';
        $return['most_cam_id'] = !empty($most_cam) ? $most_cam[0]['cam_id'] : '';
        $return['most_cam_count'] = !empty($most_cam) ? $most_cam[0]['most_cam'] : '';
        $return['new_cams_per_day'] = $new_cams_per_day;
        $return['deleted_cams_per_day'] = $deleted_cams_per_day;
        $return['cam_categories'] = $cam_categories;
        $return['user_country'] = $user_country;
        $return['cams_sold_per_day'] = $cams_sold_per_day;
        $return['total_earnings'] = $admin_earnings;
        $return['total_service'] = $admin_service;
        $return['total_earning_per_day'] = $admin_earnings_today;
        $return['total_service_per_day'] = $admin_service_per_day;

        return $return;
    }

    public static function adminFinancialInformation($from, $to) {
        $return = array();
        
        $criteria = new CDbCriteria;
        $criteria->condition = " DATE(created_at) >= '$from' and DATE(created_at) <= '$to'";
        $no_of_cams_sold = Purchase::model()->count($criteria);

        //Booking between from and to
        $admin_process_per_day = Yii::app()->db->createCommand()
                ->select('SUM(book_processing_fees) as total_process_amt')
                ->from('{{cam_booking}}')
                ->andWhere(' book_approve = "1" And book_payment_status = "C" And date(book_date) >= "' . $from . '" And date(book_date) <= "' . $to . '"')
                ->queryRow();
        $admin_process_per_day = (!empty($admin_process_per_day['total_process_amt'])) ? $admin_process_per_day['total_process_amt'] : 0;

        //Service between from and to
        $admin_service_per_day = Yii::app()->db->createCommand()
                ->select('SUM(book_service_tax) as total_service_amt')
                ->from('{{cam_booking}}')
                ->andWhere(' book_approve = "1" And book_payment_status = "C"  And date(book_date) >= "' . $from . '" And date(book_date) <= "' . $to . '"')
                ->queryRow();
        $admin_service_per_day = (!empty($admin_service_per_day['total_service_amt'])) ? (float) $admin_service_per_day['total_service_amt'] : 0;

        $type_revenue = Transaction::TYPE_REVENUE;
        //Transaction between from and to
        $total_revenue_per_day = Yii::app()->db->createCommand()
                ->select('SUM(`trans_admin_amount`) as total_revenue_amt')
                ->from('{{transaction}}')
                ->andWhere(' trans_type = "' . $type_revenue . '" And date(created_at) >= "' . $from . '" And date(created_at) <= "' . $to . '"')
                ->queryRow();
        $total_revenue_per_day = (!empty($total_revenue_per_day['total_revenue_amt'])) ? $total_revenue_per_day['total_revenue_amt'] : 0;

        $admin_earnings_today = (float) ($admin_process_per_day + $total_revenue_per_day);

        $return['no_of_cams_sold'] = $no_of_cams_sold;
        $return['total_earning_per_day'] = $admin_earnings_today;
        $return['total_service_per_day'] = $admin_service_per_day;

        return $return;
    }

    public static function getSystemAlert($tone = 1) {
        switch ($tone) {
            case 1:
                $audio = Yii::app()->controller->themeUrl . '/sounds/Bell_Notification.wav';
                break;
            case 2:
                $audio = Yii::app()->controller->themeUrl . '/sounds/Incoming_Message.wav';
                break;
        }
        return '<audio controls="controls" autoplay>
        <source src="' . $audio . '" type="audio/wav">
            <embed src="' . $audio . '">
            Your browser is not supporting audio
        </audio>';
    }

    //echo sum_the_time('01:45:22', '17:27:03');
    public static function sum_the_time($time1, $time2) {
        $times = array($time1, $time2);
        $seconds = 0;
        foreach ($times as $time) {
            list($hour, $minute, $second) = explode(':', $time);
            $seconds += $hour * 3600;
            $seconds += $minute * 60;
            $seconds += $second;
        }
        $hours = floor($seconds / 3600);
        $seconds -= $hours * 3600;
        $minutes = floor($seconds / 60);
        $seconds -= $minutes * 60;
        return "{$hours}:{$minutes}:{$seconds}";
        //return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

}
