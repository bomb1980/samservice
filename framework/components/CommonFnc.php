<?php

namespace app\components;

use Yii;

class CommonFnc
{

	public static function getAuthorizationHeader()
	{

		$headers = null;

		if (function_exists('apache_request_headers')) {
			$requestHeaders = apache_request_headers();

			$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));

			if (isset($requestHeaders['Authorization'])) {
				$headers = trim($requestHeaders['Authorization']);
			}
		}
		return $headers;
	}

	public  static function getEncrypter($string = NULL, $type = 'encrtyp', $ciphering = 'AES-256-CBC', $encryption_iv = '1234567891011121', $encryption_key = 'GeeksforGeeks' )
	{
		$options = 0;

		if ($type != 'encrtyp') {

			return openssl_decrypt(
				$string,
				$ciphering,
				$encryption_key,
				$options,
				$encryption_iv
			);
		}

		return openssl_encrypt(
			$string,
			$ciphering,
			$encryption_key,
			$options,
			$encryption_iv
		);
	}


	//Common Function /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Common Function /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Common Function /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Common Function /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	//Common Function /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	

	public  static function write_log($log_filename, $log_msg)
	{
		// if you don't add `FILE_APPEND`, the file will be erased each time you add a log
		file_put_contents($log_filename, $log_msg . "\n", FILE_APPEND);
	}

	public static function delTree($dir)
	{
		$files = array_diff(scandir($dir), array('.', '..'));
		foreach ($files as $file) {
			(is_dir("$dir/$file")) ? self::delTree("$dir/$file") : unlink("$dir/$file");
		}
		return rmdir($dir);
	}

	public function getGUID()
	{
		if (function_exists('com_create_guid') === true) {
			return trim(com_create_guid(), '{}');
		}

		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}

	public function addbg_img($fg, $bg = null, $string = null,  $width = 240, $height = 200, $fontsize = 18)
	{
		if (!file_exists($fg)) {
			return '';
		}

		if ($bg == null) {
			$image = new Imagick();
			$image->newImage($width, $height, new ImagickPixel('transparent'));
			$image->setImageFormat('png');
		} else {
			$image = new Imagick();
			$image->setBackgroundColor(new ImagickPixel('transparent'));
			$image->readImage($bg);
			$image->setImageFormat('png32');
			$image->setImageAlpha(0.5);
		}

		if ($string != null) {
			$draw = new ImagickDraw();
			$draw->setFont($_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER["PHP_SELF"]) . '/css/fonts/Prompt-Regular.ttf');
			$draw->setFontSize($fontsize); //use a large font-size
			$draw->setStrokeAntialias(true);  //try with and without
			$draw->setTextAntialias(true);  //try with and without

			//Create text  
			//$draw->setFillColor('#fff');
			$draw->setFillColor('#37474f');
			$draw->setTextAlignment(\Imagick::ALIGN_CENTER);
			//$draw->annotation(120(ซ้าย), 50(บน), "คลิกเพื่อดาวน์โหลด");

			$image->annotateImage($draw, $width / 2, 30, 0, $string);
			//$image->drawImage($draw);
		}

		$im = new Imagick($fg);

		$image->compositeImage($im, Imagick::COMPOSITE_DEFAULT, (((($image->getImageWidth()) - ($im->getImageWidth()))) / 2), (((($image->getImageHeight()) - ($im->getImageHeight()))) / 2));

		return  'data:image/png;base64,' . base64_encode($image);
	}

	public function addbg($fg, $bg = null)
	{
		// Create image instances
		$imgsrc = strtolower($fg);
		//$imgsrc = str_replace("https", "http",$fg);

		$imgdest = strtolower($bg);

		//Create destination image.
		if (!$imgdest) $dest = imagecreatetruecolor(240, 200);
		else  $dest = imagecreatefrompng($imgdest);
		//$dest = imagecreatetruecolor(200, 170);
		imagealphablending($dest, false);
		imagesavealpha($dest, true);
		//Make destination image be all transparent.
		$color = imagecolorallocatealpha($dest, 255, 255, 255, 127);
		imagefill($dest, 0, 0, $color);

		//Load source image.
		if (!file_exists($fg)) {
			return '';
		}
		$mim = mime_content_type($imgsrc);
		if ($mim == "image/png") {
			$src = imagecreatefrompng($imgsrc);
		} else if ($mim = "image/jpg" || $mim = "image/jpeg") {
			$src = imagecreatefromjpeg($imgsrc);
		}



		$xxx =  imagesx($dest) / 2 - imagesx($src) / 2;
		$yyy =   imagesy($dest) / 2 - imagesy($src) / 2;
		imagecopy($dest, $src, $xxx, $yyy, 0,  0,  imagesx($src),  imagesy($src));

		//output แบบ html ไปเลย
		//header('Content-Type: image/png');
		//imagepng($dest);

		return $this->gdImgToHTML($dest, 'png'); //แสดงเบสหกสิบสี่
		imagedestroy($dest);
		imagedestroy($src);
	}

	function gdImgToHTML($gdImg, $format = 'jpg')
	{

		// Validate Format
		if (in_array($format, array('jpg', 'jpeg', 'png', 'gif'))) {
			ob_start();
			if ($format == 'jpg' || $format == 'jpeg') {
				imagejpeg($gdImg);
			} elseif ($format == 'png') {
				imagepng($gdImg);
			} elseif ($format == 'gif') {
				imagegif($gdImg);
			}

			$data = ob_get_contents();
			ob_end_clean();

			// Check for gd errors / buffer errors
			if (!empty($data)) {
				$data = base64_encode($data);
				// Check for base64 errors
				if ($data !== false) {
					// Success
					return "data:image/$format;base64,$data";
				}
			}
		}

		// Failure
		return '';
	}

	function thumbnailImage($imagePath, $width = null, $height = null)
	{
		if (!file_exists($imagePath)) {
			return '';
		}
		if (!exif_imagetype($imagePath)) {
			return '';
		}

		$imagick = new \Imagick($imagePath);
		$imagick->setbackgroundcolor('rgb(64, 64, 64)');
		//$imagick->setBackgroundColor(new ImagickPixel('transparent'));

		$_width = $width == null ? $imagick->getImageWidth() : $width;
		$_height = $height == null ? $imagick->getImageHeight() : $height;
		//$imagick->thumbnailImage($_width-5, $_height-5, true, true);
		$imagick->thumbnailImage($_width, $_height, true, true);

		$imgBuff = $imagick->getimageblob();

		return 'data:image/png;base64,' . base64_encode($imgBuff);

		//header("Content-Type: image/jpg");
		//echo $imagick->getImageBlob();
	}

	function thumbnailPDF($pdfPath, $width, $height)
	{
		if (!file_exists($pdfPath)) {
			return '';
		}
		/*
		$im = new imagick();
		$im->setResolution(200, 200);
		$im->readimage($pdfPath . '[0]');
		$im->setImageResolution(200, 200);
		$im->setImageBackgroundColor('#ffffff');
		$im = $im->flattenImages();
		$im->setImageFormat('jpeg');
		$im->setImageCompression(Imagick::COMPRESSION_JPEG); 
		$im->setImageCompressionQuality(100);
		$im->resizeImage(600, 0,  Imagick::FILTER_LANCZOS, 1);
		$im->thumbnailImage($width, $height, true, true);
		foreach ($im as $auxiliaryvalue) {
			$return = 'data:image/png;base64,' .  base64_encode($auxiliaryvalue->getimageblob());
		}
		*/

		$imagick = new \Imagick($pdfPath . '[0]');
		$imagick->setResolution(595, 842);
		//$imagick->readImageblob($blob);
		$imagick->setImageFormat("png32");
		$imagick->setImageCompression(Imagick::COMPRESSION_ZIP);
		$imagick->setImageCompressionQuality(100);
		$imagick->thumbnailImage($width, $height, true, true);
		foreach ($imagick as $auxiliaryvalue) {
			$return = 'data:image/png;base64,' .  base64_encode($auxiliaryvalue->getimageblob());
		}

		return $return;

		//header("Content-Type: image/jpg");
		//echo $imagick->getImageBlob();
	}


	function imageResizer($fs, $width, $height)
	{

		//header('Content-type: image/jpeg');

		if (!file_exists($fs)) {
			return '';
		}

		$mim = mime_content_type($fs);

		list($width_orig, $height_orig) = getimagesize($fs);

		$ratio_orig = $width_orig / $height_orig;

		if ($width / $height > $ratio_orig) {
			$width = $height * $ratio_orig;
		} else {
			$height = $width / $ratio_orig;
		}

		// This resamples the image
		$image_p = imagecreatetruecolor($width, $height);

		if ($mim == "image/png") {
			$image = imagecreatefrompng($fs);
		} else if ($mim == "image/jpg" || $mim == "image/jpeg") {
			$image = imagecreatefromjpeg($fs);
		} else if ($mim == "image/gif") {
			$image = imagecreatefromgif($fs);
		} else if ($mim == "image/svg+xml") {
			return '';
		}

		//$image = imagecreatefromjpeg($url);
		//$image = imagecreatefrompng($fs);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

		// Output the image
		//imagejpeg($image_p, null, 100);


		ob_start();
		//imagejpeg($image_p, NULL, 100);   // best quality
		switch ($mim) {
			case 'image/jpg':
			case 'image/jpeg':
				imagejpeg($image_p, NULL, 100); //100 is the quality settings, values range from 0-100.
				break;
			case 'image/gif':
				imagegif($image_p, NULL, 100); //100 is the quality settings, values range from 0-100.
				break;
			case 'image/png':
				imagepng($image_p, NULL, 9); //100 is the quality settings, values range from 0-100.
				break;
		}

		$final_image = ob_get_contents();

		ob_end_clean();

		return 'data:' . $mim . ';base64,' . base64_encode($final_image);

		//return $this->gdImgToHTML($image_p, 'png'); //แสดงเบสหกสิบสี่
		//return $this->gdImgToHTML($final_image, 'jpg'); //แสดงเบสหกสิบสี่

	}



	public function geticonext($filename)
	{
		// Get filename.
		$filename = explode(".", $filename);
		// Get extension. You must include fileinfo PHP extension.
		$extension = strtolower(end($filename));

		$arricon = array(
			"doc" => "doc.png",
			"docx" => "docx.png",
			"gif" => "gif.png",
			"jpg" => "jpg.png",
			"jpeg" => "jpg.png",
			"pdf" => "pdf.png",
			"png" => "png.png",
			"ppt" => "ppt.png",
			"pptx" => "pptx.png",
			"rar" => "rar.png",
			"gz" => "tgz.png",
			"txt" => "txt.png",
			"xls" => "xls.png",
			"xlsx" => "xlsx.png",
			"zip" => "zip.png",
			"7z" => "7z.png",
			"htm" => "html.png",
			"html" => "html.png",
		);
		$icon = $arricon[strtolower($extension)];
		if (is_null($icon) || empty($icon)) {
			return "unknown.png";
		} else {
			return $icon;
		}
	}

	public static function DateThai($strDate, $showtime = true, $monthname = false)
	{
		$strYear = date("Y", strtotime($strDate)) + 543;
		$strMonth = date("n", strtotime($strDate));
		$strDay = date("j", strtotime($strDate));
		$strHour = date("H", strtotime($strDate));
		$strMinute = date("i", strtotime($strDate));
		$strSeconds = date("s", strtotime($strDate));
		if ($monthname) {
			$strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
		} else {
			$strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
		}

		$strMonthThai = $strMonthCut[$strMonth];
		if ($showtime) return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
		else return "$strDay $strMonthThai $strYear";
	}

	public static function calctime($seconds = 0)
	{
		$interval = date_diff(date_create("@0"), date_create("@$seconds"));

		foreach (array('y' => 'year', 'm' => 'month', 'd' => 'day', 'h' => 'hour', 'i' => 'minute', 's' => 'second') as $format => $desc) {
			if ($interval->$format >= 1) $thetime[] = $interval->$format . ($interval->$format == 1 ? " $desc" : " {$desc}s");
		}

		return $thetime ? implode(' ', $thetime) . ($interval->invert ? ' ago' : '') : NULL;
	}
	public function genstring($length = 10)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	public function gendocumentno($length = 6)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	public function file_get_contents_curl($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		//curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}


	public function get_image_url($url, $serverpath)
	{
		try {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$sourcefile = curl_exec($ch);
			curl_close($ch);

			$savefile = fopen($serverpath, 'w');
			fwrite($savefile, $sourcefile);
			fclose($savefile);

			return true;
		} catch (Exception $e) {
			return false;
		}
	}

	public function file_exists_url($url)
	{
		try {
			$ch = curl_init($url);

			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_exec($ch);
			$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			// $retcode >= 400 -> not found, $retcode = 200, found.
			curl_close($ch);

			if ($retcode == 200) {
				return true;
			} else {
				return false;
			}
		} catch (Exception $e) {
			return false;
		}
	}

	public function get_user_ip2long()
	{
		return ip2long($this->get_user_ip_address(true));
	}


	/**
	 * Get the IP address of the client accessing the website
	 * @param bool $force_string Force the return of a single address as a string, even if more than one address is found
		True: Always return a string with a single value
		False: Always return an array
		Null (empty): Return a string if a single value, array for multiple values
	 *
	 * @return bool|string|array
	 */
	public function get_user_ip_address($force_string = NULL)
	{
		// Consider: http://stackoverflow.com/questions/4581789/how-do-i-get-user-ip-address-in-django
		// Consider: http://networkengineering.stackexchange.com/questions/2283/how-to-to-determine-if-an-address-is-a-public-ip-address

		$ip_addresses = array();
		$ip_elements = array(
			'HTTP_X_FORWARDED_FOR', 'HTTP_FORWARDED_FOR',
			'HTTP_X_FORWARDED', 'HTTP_FORWARDED',
			'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_CLUSTER_CLIENT_IP',
			'HTTP_X_CLIENT_IP', 'HTTP_CLIENT_IP',
			'REMOTE_ADDR'
		);

		foreach ($ip_elements as $element) {
			if (isset($_SERVER[$element])) {
				if (!is_string($_SERVER[$element])) {
					// Log the value somehow, to improve the script!
					continue;
				}

				$address_list = explode(',', $_SERVER[$element]);
				$address_list = array_map('trim', $address_list);

				// Not using array_merge in order to preserve order
				foreach ($address_list as $x) {
					$ip_addresses[] = $x;
				}
			}
		}

		if (count($ip_addresses) == 0) {
			return FALSE;
		} elseif ($force_string === TRUE || ($force_string === NULL && count($ip_addresses) == 1)) {
			return $ip_addresses[0];
		} else {
			return $ip_addresses;
		}
	}


	public function rand_string($length)
	{
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		return substr(str_shuffle($chars), 0, $length);
	}

	//The latitude must be a number between -90 and 90
	public function check_latitude($latitude)
	{
		if (is_numeric($latitude) && $latitude >= -90 && $latitude <= 90) {
			return true;
		} else {
			return false;
		}
	}

	//The longitude must be a number between -180 and 180
	public function check_longitude($longitude)
	{
		if (is_numeric($longitude) && $longitude >= -180 && $longitude <= 180) {
			return true;
		} else {
			return false;
		}
	}

	public function convert_timeago($dt)
	{
		try {
			$t = time() + (60 * 60 * Yii::app()->params['prg_ctrl']['diffsvtime']);  //เวลาปัจจุบันบวก จำนวน ชม ที่ต่างกันของ webserver กะ dbserver
			$date1 = new DateTime(date("Y-m-d H:i:s", $t));
			$date2 = new DateTime($dt);
			$diff = $date1->diff($date2);

			if ($diff->y > 1) {
				$timeago = $diff->y . ' ' . Yii::t('common', 'years_ago');
			} elseif ($diff->y > 0) {
				$timeago = Yii::t('common', 'a_year_ago');
			} elseif ($diff->m > 1) {
				$timeago = $diff->m . ' ' . Yii::t('common', 'months_ago');
			} elseif ($diff->m > 0) {
				$timeago = Yii::t('common', 'a_month_ago');
			} elseif ($diff->d > 1) {
				$timeago = $diff->d . ' ' . Yii::t('common', 'days_ago');
			} elseif ($diff->d > 0) {
				$timeago = Yii::t('common', 'a_day_ago');
			} elseif ($diff->h > 1) {
				$timeago = $diff->h . ' ' . Yii::t('common', 'hours_ago');
			} elseif ($diff->h > 0) {
				$timeago = Yii::t('common', 'a_hour_ago');
			} elseif ($diff->i > 1) {
				$timeago = $diff->i . ' ' . Yii::t('common', 'minutes_ago');
			} elseif ($diff->i > 0) {
				$timeago = Yii::t('common', 'a_minute_ago');
			} else {
				$timeago = Yii::t('common', 'just_now');
			}
			return $timeago;
		} catch (Exception $e) {
			return '';
		}
	}

	public function convert_cntnumber($cnt)
	{
		try {
			return number_format($cnt);
		} catch (Exception $e) {
			return '0';
		}
	}


	public function url_to_domain($url)
	{
		$host = @parse_url($url, PHP_URL_HOST);

		// If the URL can't be parsed, use the original URL
		// Change to "return false" if you don't want that
		if (!$host)
			$host = $url;

		// The "www." prefix isn't really needed if you're just using
		// this to display the domain to the user
		if (substr($host, 0, 4) == "www.")
			$host = substr($host, 4);

		// You might also want to limit the length if screen space is limited
		if (strlen($host) > 50)
			$host = substr($host, 0, 47) . '...';

		return $host;
	}


	public function consolelog($data)
	{
		if (is_array($data))
			$output = "<script>console.log( '" . implode(',', $data) . "' );</script>";
		else
			$output = "<script>console.log( '" . $data . "' );</script>";

		echo $output;
	}

	public function set_cookie($cookie_name, $cookie_value)
	{
		$cookie = new CHttpCookie($cookie_name, $cookie_value);
		$cookie->expire = time() + 3600 * 24 * Yii::app()->params['prg_ctrl']['authCookieDuration'];
		$cookie->domain = Yii::app()->params['prg_ctrl']['domain'];
		Yii::app()->request->cookies[$cookie_name] = $cookie;
		return true;
	}


	public function get_cookie($cookie_name)
	{
		$cookie_value = isset(Yii::app()->request->cookies[$cookie_name]) ? Yii::app()->request->cookies[$cookie_name]->value : '';
		return $cookie_value;
	}


	public function get_token()
	{
		//$token_value = uniqid('', true);
		$token_value = $this->rand_string(23);
		return $token_value;
	}


	public function removespecialchars($raw)
	{
		return preg_replace('#[^-ก-๙a-zA-Z0-9]#u', '', $raw);
	}


	public function seotitle($raw)
	{
		$raw = preg_replace('#[^-ก-๙a-zA-Z0-9]#u', '', $raw);
		$raw =  preg_replace('/-+/i', '-', $raw);
		if (substr($raw, 0, 1) == '-')
			$raw = substr($raw, 1);
		if (substr($game_url, -1) == '-')
			$raw = substr($raw, 0, -1);
		return urlencode($raw);
	}

	public function set_jsscript($js_name)
	{
		if ($js_name == 'tinymce') {
			$sc = '<script src="' . Yii::app()->request->baseUrl . '/vendor/tinymce/4.0.22/tinymce.min.js"></script>';
		} else {
			$sc = '';
		}
		return $sc;
	}

	public function ex_pad($txt1, $txtlen)
	{
		$n1 = mb_strlen($txt1, "UTF-8");
		$n2 = $txtlen - $n1;
		if ($n2 > 0) {
			return $txt1 . str_pad("", $n2, ' ', STR_PAD_RIGHT);
		} else {
			return $txt1;
		}
	}
}
