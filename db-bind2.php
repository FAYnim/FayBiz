<?php
	define ("dbhost", "localhost");
	define ("dbuser", "YOUR_DATABASE_USERNAME");
	define ("dbpass", "YOUR_DATABASE_PASSWORD");
	define ("dbname", "YOUR_DATABASE_NAME");

  function db_cektabel($tbl){
    $db1 = mysqli_connect(dbhost, dbuser, dbpass, dbname);
    $tabel = mysqli_query($db1, "select * from ".$tbl);
    $row= true;
    if ($tabel){
      mysqli_free_result($tabel);
    }
    else {
      $row= false;
    }
    
    mysqli_close($db1);
    
    return $row;
  }
  
/* DB Bind, DB Fetch, DB Query updated by FAY - 2025-03-25*/
/**
 * Fungsi untuk mengambil SATU baris data (otomatis LIMIT 1)
 * 
 * @param string $sql Query SQL dengan placeholder (?)
 * @param array $params Parameter untuk query
 * @return array|false Array hasil atau false jika gagal/tidak ada data
 */
 /* Contoh Penggunaan 
     ==== Cari Data ====
     $sql = "SELECT * FROM nama_tabel WHERE kondisi = ? AND kondisi2 = ?;"
     $param = [Param_Kondisi1, Param Kondisi2];
     $table = db_bind($sql, $param);
     
     parameter pada $sql selalu diganti dengan "?"
 */
function db_bind($sql, $params = []) {
    // Tambahkan LIMIT 1 jika belum ada
    if (stripos($sql, 'LIMIT') === false) {
        $sql = rtrim($sql, ';') . ' LIMIT 1';
    }
    
    $db = mysqli_connect(dbhost, dbuser, dbpass, dbname);
    if (!$db) return false;

    $stmt = mysqli_prepare($db, $sql);
    if (!$stmt) {
        mysqli_close($db);
        return false;
    }

    if (!empty($params)) {
        $types = str_repeat('s', count($params));
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($db);
        return false;
    }

    $result = mysqli_stmt_get_result($stmt);
    $row = $result ? mysqli_fetch_assoc($result) : false;

    mysqli_stmt_close($stmt);
    mysqli_close($db);
    
    return $row;
}

/**
 * Fungsi untuk mengambil SEMUA baris data
 * 
 * @param string $sql Query SQL dengan placeholder (?)
 * @param array $params Parameter untuk query
 * @return array|false Array of rows atau false jika gagal
 */
function db_fetch($sql, $params = []) {
    $db = mysqli_connect(dbhost, dbuser, dbpass, dbname);
    if (!$db) return false;

    $stmt = mysqli_prepare($db, $sql);
    if (!$stmt) {
        mysqli_close($db);
        return false;
    }

    if (!empty($params)) {
        $types = str_repeat('s', count($params));
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($db);
        return false;
    }

    $result = mysqli_stmt_get_result($stmt);
    $rows = [];
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($db);
    
    return !empty($rows) ? $rows : false;
}

function setDate($date){
	$date_arr = explode("-", $date);
	$date_yy = $date_arr[0];
	$date_mm = $date_arr[1];
	$date_dd = $date_arr[2];

	$setDate = $date_dd + 1;
	$date_dd = $setDate;
	return $date_yy."-".$date_mm."-".$date_dd;
}

function convertTgl($tgl){
	$tgl_arr= explode(" ", $tgl);
	$tgl_dt= $tgl_arr[0];
	$tgl_tm= $tgl_arr[1];
	$tgl_arr= explode("-", $tgl_dt);
	$tgl_yy= $tgl_arr[0];
	$tgl_mm= $tgl_arr[1];
	$tgl_dd= $tgl_arr[2];
	$tgl_arr= explode(":", $tgl_tm);
	$tgl_hh= $tgl_arr[0];
	$tgl_mi= $tgl_arr[1];

	$mon= "";

	if($tgl_mm=="01"){$mon= "Jan";}
	elseif($tgl_mm=="02"){$mon= "Feb";}
	elseif($tgl_mm=="03"){$mon= "Mar";}
	elseif($tgl_mm=="04"){$mon= "Apr";}
	elseif($tgl_mm=="05"){$mon= "Mei";}
	elseif($tgl_mm=="06"){$mon= "Jun";}
	elseif($tgl_mm=="07"){$mon= "Jul";}
	elseif($tgl_mm=="08"){$mon= "Ags";}
	elseif($tgl_mm=="09"){$mon= "Sep";}
	elseif($tgl_mm=="10"){$mon= "Okt";}
	elseif($tgl_mm=="11"){$mon= "Nop";}
	elseif($tgl_mm=="12"){$mon= "Des";}

	return $tgl_dd." ".$mon." ".$tgl_yy." ".$tgl_hh.":".$tgl_mi;
}

function getDateNow() {
	$tz_object = new DateTimeZone('Asia/Jakarta');
	//date_default_timezone_set('Brazil/East');

	$datetime = new DateTime();
	$datetime->setTimezone($tz_object);
	return $datetime->format('Y\-m\-d');
}

function getWaktuNow() {
	$tz_object = new DateTimeZone('Asia/Jakarta');
	//date_default_timezone_set('Brazil/East');

	$datetime = new DateTime();
	$datetime->setTimezone($tz_object);
	$yy = $datetime->format('Y');
	$mm = $datetime->format('m');
	$dd = $datetime->format('d');
	$hh = $datetime->format('H');
	$mi = $datetime->format('i');
	$ss = $datetime->format('s');

	$tgl = $yy . "-" . $mm . "-" . $dd . " ".$hh.":".$mi.":".$ss;

	return $tgl;
}

function getWaktuNowWithoutDate() {
	$tz_object = new DateTimeZone('Asia/Jakarta');
	//date_default_timezone_set('Brazil/East');

	$datetime = new DateTime();
	$datetime->setTimezone($tz_object);
	$yy = $datetime->format('Y');
	$mm = $datetime->format('m');
	$dd = $datetime->format('d');
	$hh = $datetime->format('H');
	$mi = $datetime->format('i');
	$ss = $datetime->format('s');

	$tgl = $hh.":".$mi.":".$ss;

	return $tgl;
}

function getWaktuNowAdd($add) {
	$tz_object = new DateTimeZone('Asia/Jakarta');
	//date_default_timezone_set('Brazil/East');

	$datetime = new DateTime();
	$datetime->setTimezone($tz_object);
	$datetime->modify($add);
	$yy = $datetime->format('Y');
	$mm = $datetime->format('m');
	$dd = $datetime->format('d');
	$hh = $datetime->format('H');
	$mi = $datetime->format('i');
	$ss = $datetime->format('s');

	$tgl = $yy . "-" . $mm . "-" . $dd . " ".$hh.":".$mi.":".$ss;

	return $tgl;
}

function getTglNow() {
	$tz_object = new DateTimeZone('Asia/Jakarta');
	//date_default_timezone_set('Brazil/East');

	$datetime = new DateTime();
	$datetime->setTimezone($tz_object);
	$yy = $datetime->format('Y');
	$mm = $datetime->format('m');
	$dd = $datetime->format('d');

	if ($mm==1){$mon = "Januari";}
	else if ($mm==2){$mon = "Februari";}
	else if ($mm==3){$mon = "Maret";}
	else if ($mm==4){$mon = "April";}
	else if ($mm==5){$mon = "Mei";}
	else if ($mm==6){$mon = "Juni";}
	else if ($mm==7){$mon = "Juli";}
	else if ($mm==8){$mon = "Agustus";}
	else if ($mm==9){$mon = "September";}
	else if ($mm==10){$mon = "Oktober";}
	else if ($mm==11){$mon = "Nopember";}
	else if ($mm==12){$mon = "Desember";}

	$tgl = $dd . " " . $mon . " " . $yy;

	return $tgl;
}

function getperm() {
	$tz_object = new DateTimeZone('Asia/Jakarta');
	//date_default_timezone_set('Brazil/East');

	$datetime = new DateTime();
	$datetime->setTimezone($tz_object);
	$yy = $datetime->format('Y');
	$mm = $datetime->format('m');
	$dd = $datetime->format('d');

	$tgl = $yy . "/" . $mm . "/";

	return $tgl;
}

function getyymmdd() {
	$tz_object = new DateTimeZone('Asia/Jakarta');
	//date_default_timezone_set('Brazil/East');

	$datetime = new DateTime();
	$datetime->setTimezone($tz_object);
	$yy = $datetime->format('Y');
	$mm = $datetime->format('m');
	$dd = $datetime->format('d');

	$tgl = $yy . $mm . $dd;

	return $tgl;
}

//resize_image("uploads/20230113/149324kodepos-vol1.png", 800, 500, 700, 435, 110, 110, true);
function resize_image($file, $ext, $w, $h, $w2, $h2, $w3, $h3) {
	$filearr= array();
	if($ext=="png"){
		$filearr= explode(".png", $file);
	}
	else if($ext=="jpg"){
		$filearr= explode(".jpg", $file);
	}
	else if($ext=="jpeg"){
		$filearr= explode(".jpeg", $file);
	}
	$cnt= count($filearr);
	$filen= "";
	if($cnt==2){
		$filen= $filearr[0];
	}
	//echo "file n: ".$filen."\n";
    list($width, $height) = getimagesize($file);
	//echo "ori w: ".$width."\n";
	//echo "ori h: ".$height."\n";
    $r = $width / $height;
	$oldwidth= $width;
	$oldheight= $height;
	$r1 = $w / $h;
	$rw1 = $w / $width;
	$rh1 = $h / $height;
	$rw2 = $w2 / $width;
	$rh2 = $h2 / $height;
	$rw3 = $w3 / $width;
	$rh3 = $h3 / $height;
	//echo "ori r: ".$r."\n";
	//echo "target rw1: ".$rw1."\n";
	//echo "target rh1: ".$rh1."\n";
	//echo "target rw2: ".$rw2."\n";
	//echo "target rh2: ".$rh2."\n";
	//echo "target rw3: ".$rw3."\n";
	//echo "target rh3: ".$rh3."\n";

	if($h>$height){
		$neww= abs($width*$rh1);
		$newh= abs($height*$rh1);
	}
	//echo "new w1: ".$neww."\n";
	//echo "new h1: ".$newh."\n";

	$neww2= abs($width*$rh2);
	$newh2= abs($height*$rh2);

	$neww3= abs($width*$rh3);
	$newh3= abs($height*$rh3);

	if($ext=="png"){
	    $src = imagecreatefrompng($file);
	}
	else{
		$src = imagecreatefromjpeg($file);
	}
    $dst = imagecreatetruecolor($w, $h);
    $dst2 = imagecreatetruecolor($w2, $h2);
    $dst3 = imagecreatetruecolor($w3, $h3);

	imagecopyresampled($dst, $src, 0, 0, 0, 0, $neww, $newh, $width, $height);
	imagecopyresampled($dst2, $src, 0, 0, 0, 0, $neww2, $newh2, $width, $height);
	imagecopyresampled($dst3, $src, 0, 0, 0, 0, $neww3, $newh3, $width, $height);

	$returncode= 100;
	if($ext=="png"){
		$returncode= 301;
		imagepng($dst,  $filen."-800x500.".$ext);
		imagepng($dst2, $filen."-700x435.".$ext);
		imagepng($dst3, $filen."-110x110.".$ext);
	}
	else{
		$returncode= 302;
		imagejpeg($dst,  $filen."-800x500.".$ext);
		imagejpeg($dst2, $filen."-700x435.".$ext);
		imagejpeg($dst3, $filen."-110x110.".$ext);
	}

	imagedestroy($dst);
	imagedestroy($dst2);
	imagedestroy($dst3);
  	return $returncode;
}

function resize_image2($srcfile, $targetw1, $targeth1, $targetw2, $targeth2, $targetw3, $targeth3){
	/*
	ori 1000 x 500
	target 800 x 200
	2   1000(a)   800(c)
	- = ------- = ---
	1    500(b)   (d)
	d= cxb / a
	c= axd / b
	*/
	$fshowlog= 0;

	$filearr= array();
	$filearr= pathinfo($srcfile);

	$filen= $filearr["dirname"]."/".$filearr["filename"];
	$ext= $filearr["extension"];
	if($fshowlog){
		print_r($filearr);
	}

//    list($srcw, $srch)
	$hasil = getimagesize($srcfile);
	$srcw= $hasil[0];
	$srch= $hasil[1];

	if($fshowlog){
		echo "Ori Width: ".$srcw."\n";
		echo "Ori Height: ".$srch."\n";
		echo "\n";
	}

	$newtargetw1= $targetw1;
	$newtargeth1= $targetw1 * $srch / $srcw;
	if($newtargeth1<=$targeth1){
		$newtargeth1= $targeth1;
		$newtargetw1= $targeth1 * $srcw / $srch;
	}
	else{
	}

	if($fshowlog){
		echo "Target 1 Width: ".$targetw1."\n";
		echo "Target 1 Height: ".$targeth1."\n";
		echo "\n";
		echo "New Width: ".$newtargetw1."\n";
		echo "New Height: ".$newtargeth1."\n";
		echo "\n";
	}

	$newtargetw2= $targetw2;
	$newtargeth2= $targetw2 * $srch / $srcw;
	if($newtargeth2<=$targeth2){
		$newtargeth2= $targeth2;
		$newtargetw2= $targeth2 * $srcw / $srch;
	}

	if($fshowlog){
		echo "Target 2 Width: ".$targetw2."\n";
		echo "Target 2 Height: ".$targeth2."\n";
		echo "\n";
		echo "New Width: ".$newtargetw2."\n";
		echo "New Height: ".$newtargeth2."\n";
		echo "\n";
	}

	$newtargetw3= $targetw3;
	$newtargeth3= $targetw3 * $srch / $srcw;
	if($newtargeth3<=$targeth3){
		$newtargeth3= $targeth3;
		$newtargetw3= $targeth3 * $srcw / $srch;
	}

	if($fshowlog){
		echo "Target 3 Width: ".$targetw3."\n";
		echo "Target 3 Height: ".$targeth3."\n";
		echo "\n";
		echo "New Width: ".$newtargetw3."\n";
		echo "New Height: ".$newtargeth3."\n";
		echo "\n";
	}

	if($ext=="png"){
	    $src = imagecreatefrompng($srcfile);
	}
	else{
		$src = imagecreatefromjpeg($srcfile);
	}
    $dst1 = imagecreatetruecolor($targetw1, $targeth1);
    $dst2 = imagecreatetruecolor($targetw2, $targeth2);
    $dst3 = imagecreatetruecolor($newtargetw3, $newtargeth3);
    $dst3a = imagecreatetruecolor($targetw3, $targeth3);

	imagecopyresampled($dst1, $src, 0, 0, 0, 0, $targetw1, $targeth1, $srcw, $srch);
	imagecopyresampled($dst2, $src, 0, 0, 0, 0, $targetw2, $targeth2, $srcw, $srch);
	imagecopyresampled($dst3, $src, 0, 0, 0, 0, $newtargetw3, $newtargeth3, $srcw, $srch);
	imagecopyresampled($dst3a, $dst3, 0, 0, 0, 0, $targetw3, $targeth3, $targetw3, $targeth3);

	if($fshowlog){
		echo $filen."\n";
	}
	if($ext=="png"){
		imagepng($dst1, $filen."-800x500.".$ext);
		imagepng($dst2, $filen."-700x435.".$ext);
		imagepng($dst3a, $filen."-110x110.".$ext);
	}
	else{
		imagejpeg($dst1, $filen."-800x500.".$ext);
		imagejpeg($dst2, $filen."-700x435.".$ext);
		imagejpeg($dst3a, $filen."-110x110.".$ext);
	}

	imagedestroy($dst1);
	imagedestroy($dst2);
	imagedestroy($dst3);
	imagedestroy($dst3a);

	$returncode= 200;
}
//
function cekdiff($dstart){
	$tz_object = new DateTimeZone('Asia/Jakarta');
	$dcurr = new DateTime();
	$dcurr->setTimezone($tz_object);

	$start_date = new DateTime($dstart);
	//$since_start = $start_date->diff(new DateTime('2007-09-01 04:25:00'));
	$since_start = $start_date->diff($dcurr);
	if(0){
		echo $since_start->days." days total \n";
		echo $since_start->y." years \n";
		echo $since_start->m." months \n";
		echo $since_start->d." days \n";
		echo $since_start->h." hours \n";
		echo $since_start->i." minutes \n";
		echo $since_start->s." seconds \n";
	}

	//$minutes = $since_start->days * 24 * 60;
	//$minutes += $since_start->h * 60;
	$minutes = $since_start->i;
	//$minutes += $since_start->s;

	//	echo $minutes." detik \n";
	return $minutes;
}

function cekdiff2($dstart){
	$tz_object = new DateTimeZone('Asia/Jakarta');
	$dcurr = new DateTime();
	$dcurr->setTimezone($tz_object);

	$start_date = new DateTime($dstart);
	//$since_start = $start_date->diff(new DateTime('2007-09-01 04:25:00'));
	$since_start = $start_date->diff($dcurr);
	if(1){
		echo $since_start->days." days total \n";
		echo $since_start->y." years \n";
		echo $since_start->m." months \n";
		echo $since_start->d." days \n";
		echo $since_start->h." hours \n";
		echo $since_start->i." minutes \n";
		echo $since_start->s." seconds \n";
	}

	//$minutes = $since_start->days * 24 * 60;
	//$minutes += $since_start->h * 60;
	//$minutes = $since_start->i;
	//$minutes += $since_start->s;

	//	echo $minutes." detik \n";

	return $since_start->h;
}

function cekdiff_jam($dstart, &$p_trace){
	$tz_object = new DateTimeZone('Asia/Jakarta');
	$dcurr = new DateTime();
	$dcurr->setTimezone($tz_object);

	$start_date = new DateTime($dstart);
	//$since_start = $start_date->diff(new DateTime('2007-09-01 04:25:00'));
	$since_start = $start_date->diff($dcurr);
	if(1){
		$p_trace.= $since_start->days." days total \n";
		$p_trace.= $since_start->y." years \n";
		$p_trace.= $since_start->m." months \n";
		$p_trace.= $since_start->d." days \n";
		$p_trace.= $since_start->h." hours \n";
		$p_trace.= $since_start->i." minutes \n";
		$p_trace.= $since_start->s." seconds \n\n";
	}

	$minutes = $since_start->days * 24;
	$minutes += $since_start->h;
	//$minutes += $since_start->s;

	//	echo $minutes." detik \n";
	return $minutes;
}

function cekdiff_menit($dstart, &$p_trace){
	$tz_object = new DateTimeZone('Asia/Jakarta');
	$dcurr = new DateTime();
	$dcurr->setTimezone($tz_object);

	$start_date = new DateTime($dstart);
	//$since_start = $start_date->diff(new DateTime('2007-09-01 04:25:00'));
	$since_start = $start_date->diff($dcurr);
	if(1){
		$p_trace.= $since_start->days." days total \n";
		$p_trace.= $since_start->y." years \n";
		$p_trace.= $since_start->m." months \n";
		$p_trace.= $since_start->d." days \n";
		$p_trace.= $since_start->h." hours \n";
		$p_trace.= $since_start->i." minutes \n";
		$p_trace.= $since_start->s." seconds \n\n";
	}

	$minutes = $since_start->days * 24 * 60;
	$minutes+= $since_start->h * 60;
	$minutes+= $since_start->i;
	//$minutes += $since_start->s;

	//	echo $minutes." detik \n";
	return $minutes;
}

function cekdiff_sec($dstart){
	$tz_object = new DateTimeZone('Asia/Jakarta');
	$dcurr = new DateTime();
	$dcurr->setTimezone($tz_object);

	$start_date = new DateTime($dstart);
	//$since_start = $start_date->diff(new DateTime('2007-09-01 04:25:00'));
	$since_start = $start_date->diff($dcurr);
	if(0){
		echo $since_start->days." days total \n";
		echo $since_start->y." years \n";
		echo $since_start->m." months \n";
		echo $since_start->d." days \n";
		echo $since_start->h." hours \n";
		echo $since_start->i." minutes \n";
		echo $since_start->s." seconds \n";
	}

	//$minutes = $since_start->days * 24 * 60;
	$detik = $since_start->h * 60;
	$detik += $since_start->i * 60;
	$detik += $since_start->s;

	//	echo $minutes." detik \n";

	return $detik;
}

function myconverthtml($str){
	$html= str_replace("[sup]", "<sup>", $str);
	$html= str_replace("[/sup]", "</sup>", $html);
	$html= str_replace("\n", "<br>", $html);

	return $html;
}
?>
