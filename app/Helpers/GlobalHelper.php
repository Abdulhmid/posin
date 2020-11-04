<?php

use App\Models;

class GlobalHelper {

    public static function url() {
        return explode('/', \Request::url());
    }

    public static function indexUrl() {
        return Request::segment(1);
    }

    public static function lastUrl() {
        return last(self::url());
    }

    public static function actionUrl() {
        return Request::segment(2);
    }

    public static function checkImage(
        $pathImage, 
        $user = true
    )
    {
        if (file_exists(public_path() . "/" . $pathImage) && 
            !empty($pathImage)) 
        {
            return asset($pathImage);
        } else {
            if ($user == true)
                return asset("/photos/not_found.gif");
            else
                return asset("/photos/not_found.gif");
        }
    }

    public static function messages(
        $msg = "", 
        $error = false, 
        $warning = false, 
        $dissmiss = true
    )
    {
        $type = ((($error == true) ? 'danger' : (($warning == true) 
                                              ? 'warning' : 'success')));
        $autoHide = ($dissmiss == true ? 'autohide' : '');
        $icon = ($warning == true ? "fa-warning" : "fa-info");

        return '<div class="no-print alert alert-dismissable ' . $autoHide . ' full-alert">
					<div class="callout callout-' . $type . '">					
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				    	<h4><i class="fa ' . $icon . '"></i> ' . $msg . '</h4>
					</div>
				  </div>';
    }

    public static function formatDate($date, $format = 'd F Y \a\t H:i') {
        return (!is_null($date)) ? (new DateTime($date))->format($format) : "-";
    }

     public static function formatShortDate($date, $format = 'd M Y') {
        return (!is_null($date)) ? (new DateTime($date))->format($format) : "-";
    }

    public static function formatCurrency($amount) {
        return 'Rp ' . number_format($amount, 0, ',', '.') . ',-';
    }

    public static function encrypt($sData) {
        $id = (double) $sData * 432.234;
        return strtr(rtrim(base64_encode($id), '='), '+/', '-_');
    }

    public static function decrypt($sData) {
        $url = base64_decode(strtr($sData, '-_', '+/'));
        $id = (double) $url / 432.234;
        return intval($id);
    }

    public static function encrypt_decrypt_string($action, $string) {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = 'This is my secret key';
        $secret_iv = 'This is my secret iv';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

    public static function convertDate($dataConvert, $format = "Y-m-d") {
        $date = date_create($dataConvert);

        return date_format($date, $format);
    }

    public static function idrFormat($number, $prefix = 0) {
        return !is_null($number) ? number_format($number, $prefix, ",", ".") : "-";
    }

    /* Word Helper */
    public static function softTrim($text, $count, $wrapText='...'){

        if(strlen($text)>$count){
            preg_match('/^.{0,' . $count . '}(?:.*?)\b/siu', $text, $matches);
            $text = $matches[0];
        }else{
            $wrapText = '';
        }
        return $text . $wrapText;
    }

    public static function limitWord($string, $word_limit) 
    {
        $words = explode(" ", $string);
        return implode(" ", array_splice($words, 0, $word_limit));
    }

    public static function calDayInMonth($year, $month){
        $dt = \Carbon\Carbon::createFromDate($year, $month);
        return $dt->daysInMonth;
    }

    public static function getDays()
    {
        return [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu'
        ];
    }

    public static function getMonth()
    {
        return [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];
    }

    /* Hourly Looping Data */ 
    public static function timeNol2To24(){
        $hour = 0;
        $lst = [];
        while($hour++ < 24)
        {
            $timetoprint = date('H:i',mktime($hour,0,0,1,1,2011));
            array_push($lst, $timetoprint);
        }sort($lst);

        return $lst;
    }

    public static function listDayThisWeeks($format='d/m/Y'){
        $row = [];$year = date('Y');$week = date('W');
        for($i = 1; $i <= 7; $i++) {
            $date = strtotime($year.'W'.$week.$i);
            $day  = date("Y-m-d", $date);
            array_push($row, $day);
        }
        return $row;
    } 

    public static function listDayByRange($start, $end, $format='m-d-Y'){
      $start = strtotime($start);
      $end = strtotime($end);

      $diff = ($end - $start) / 86400; 
      $rowDate = [];

      for ($i = 0; $i <= $diff; $i++) {
          $date = $start + ($i * 86400); 
          array_push($rowDate, date($format, $date));
      }
      return $rowDate;
    }

    /* Hourly Data */ 
    public static function hoursLimit(){
        $hour = 0;
        $lst = [];
        while($hour++ < 24)
        {
            $timetoprint = date('H:i',mktime($hour,0,0,1,1,2011));
            array_push($lst, $timetoprint);
        }sort($lst);

        return $lst;
    }

    public static function weekDays()
    {
        return [
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'sunday' => 'Sunday'
        ];
    }
}