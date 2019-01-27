<?php
require_once('protect-this.php');
error_reporting(1);
ob_start();
session_start();
$actual_link = $_SERVER['HTTP_HOST'];

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Easync Backup</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>


	<div class="container-contact100" style="background-image: url('images/bg-01.jpg');">
		<div class="wrap-contact100">
			<form class="contact100-form validate-form" action="" method="post">
				<span class="contact100-form-title">
					Easync BACKUP
				</span>
				<center>Yedeklenecek dizin: <span style="color:#229954;"><?php echo $actual_link; ?></span></center><br><br>
				<center><span style="color:#C70039">--> Eğer veritabanı kullanmıyorsanız aşağıdaki alanları boş bırakabilirsiniz.</span></center><br><br>
				<div class="wrap-input100 rs1-wrap-input100" data-validate="Zorunlu Alan">
					<span class="label-input100">Database sunucusu</span>
					<input class="input100" type="text" name="host" placeholder="Veritabanı sunucusunu giriniz">
				</div>

				<div class="wrap-input100 rs1-wrap-input100" data-validate="Zorunlu Alan">
					<span class="label-input100">Veritabanı adı</span>
					<input class="input100" type="text" name="database" placeholder="Veritabanı adını giriniz">
				</div>

				<div class="wrap-input100 rs1-wrap-input100" data-validate="Zorunlu Alan">
					<span class="label-input100">Veritabanı kullanıcı adı</span>
					<input class="input100" type="text" name="username" placeholder="Veritabanı kullanıcı adını giriniz">
				</div>

				<div class="wrap-input100 rs1-wrap-input100" data-validate="Zorunlu Alan">
					<span class="label-input100">Veritabanı parola</span>
					<input class="input100" type="password" name="password" placeholder="Veritabanı parolasını giriniz">
				</div>
				<span style="color:#C70039;padding-bottom:32px;">--> Eğer yedeğinizi uzak ftp sunucusuna kaydetmek İSTİYORSANIZ aşağıdaki alanları doldurunuz, uzak ftp sunucusuna kaydetmek İSTEMİYORSANIZ dosya otomatik olarak bilgisayarınıza indirilecektir.</span><br><br>
				<span class="contact100-form-title">
					Uzak FTP Sunucusu Ayarları <br>
				</span>
				<div class="wrap-input100 rs1-wrap-input100" data-validate="Zorunlu Alan">
					<span class="label-input100">FTP sunucusu</span>
					<input class="input100" type="text" name="ftpserver" placeholder="FTP sunucusunu giriniz">
				</div>

				<div class="wrap-input100 rs1-wrap-input100" data-validate="Zorunlu Alan">
					<span class="label-input100">FTP kullanıcı adı</span>
					<input class="input100" type="text" name="ftpusername" placeholder="FTP kullanıcı adını giriniz">
				</div>

				<div class="wrap-input100 rs1-wrap-input100" data-validate="Zorunlu Alan">
					<span class="label-input100">FTP parolası</span>
					<input class="input100" type="password" name="ftppassword" placeholder="FTP parolasını giriniz">
				</div>

				<span class="contact100-form-title">
					Zip Ayarları <br>
				</span>

				<div class="wrap-input100 rs1-wrap-input100" data-validate="Zorunlu Alan">
					<span class="label-input100">Zip parolası</span>
					<input class="input100" type="password" required="required" name="zippassword" placeholder="Parolayı giriniz">
				</div>

				<div class="container-contact100-form-btn">
					<div class="wrap-contact100-form-btn">
						<div class="contact100-form-bgbtn"></div>
						<button class="contact100-form-btn" type="submit" name="connect">
							YEDEKLE
						</button>
					</div>
				</div>
			</form>
		</div>

		<span class="contact100-more">
				easync backup tool by muhammedmertpolat.com
		</span>
	</div>

<?php
if(isset($_POST['connect'])){
$host = $_POST['host'];
$database = $_POST['database'];
$username = $_POST['username'];
$password = $_POST['password'];
$ftpserver = $_POST['ftpserver'];
$ftpusername = $_POST['ftpusername'];
$ftppassword = $_POST['ftppassword'];
$zippassword = $_POST['zippassword'];
// start action
date_default_timezone_set('Europe/Istanbul');
function EXPORT_DATABASE($host,$user,$pass,$name,       $tables=false, $backup_name=false)
{ 
    set_time_limit(3000); $mysqli = new mysqli($host,$user,$pass,$name); $mysqli->select_db($name); $mysqli->query("SET NAMES 'utf8'");
    $queryTables = $mysqli->query('SHOW TABLES'); while($row = $queryTables->fetch_row()) { $target_tables[] = $row[0]; }   if($tables !== false) { $target_tables = array_intersect( $target_tables, $tables); } 
    $content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `".$name."`\r\n--\r\n\r\n\r\n";
    foreach($target_tables as $table){
        if (empty($table)){ continue; } 
        $result = $mysqli->query('SELECT * FROM `'.$table.'`');     $fields_amount=$result->field_count;  $rows_num=$mysqli->affected_rows;     $res = $mysqli->query('SHOW CREATE TABLE '.$table); $TableMLine=$res->fetch_row(); 
        $content .= "\n\n".$TableMLine[1].";\n\n";   $TableMLine[1]=str_ireplace('CREATE TABLE `','CREATE TABLE IF NOT EXISTS `',$TableMLine[1]);
        for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) {
            while($row = $result->fetch_row())  { //when started (and every after 100 command cycle):
                if ($st_counter%100 == 0 || $st_counter == 0 )  {$content .= "\nINSERT INTO ".$table." VALUES";}
                    $content .= "\n(";    for($j=0; $j<$fields_amount; $j++){ $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); if (isset($row[$j])){$content .= '"'.$row[$j].'"' ;}  else{$content .= '""';}     if ($j<($fields_amount-1)){$content.= ',';}   }        $content .=")";
                //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) {$content .= ";";} else {$content .= ",";} $st_counter=$st_counter+1;
            }
        } $content .="\n\n\n";
    }
    $content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
    $backup_name = 'mysql_backup('.date('d-m-Y').'_'.date('H-i-s').').sql';
    touch($backup_name);
    $dosya = fopen($backup_name, 'w');
    fwrite($dosya, $content);
    fclose($dosya);
    
}
$rootPath = realpath($_SERVER['DOCUMENT_ROOT']); // important variable 1
$zipname = 'full_backup('.date('d-m-Y').'_'.date('H-i-s').').zip';
$zip = new ZipArchive();
$zip->open($zipname, ZipArchive::CREATE | ZipArchive::OVERWRITE);
if(!empty($host) && (!empty($database)) && (!empty($username)) && (!empty($password))){
EXPORT_DATABASE($host, $username, $password, $database); // important variable 2
$backup_name = 'mysql_backup('.date('d-m-Y').'_'.date('H-i-s').').sql';
$zip->setPassword($zippassword);
$zip->addFile($backup_name);
$zip->setEncryptionName($backup_name, ZipArchive::EM_AES_256);
}
/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);
foreach ($files as $name => $file)
{
    if (!$file->isDir())
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);
        // Add current file to archive
        $zip->setPassword($zippassword);
        $zip->addFile($filePath, $relativePath);
        $zip->setEncryptionName($relativePath, ZipArchive::EM_AES_256);
    }
}
$zip->close(); // ftp yedek aldık

// end action

if(empty($ftpserver) && (empty($ftpusername)) && (empty($ftppassword))){

		rename($zipname, 'drive/files/'.$zipname.'');
		header("Location: drive/files/".$zipname.'');

	} else {

		$yerel = $zipname;
		$uzak = $zipname;

	// FTP sunucusuna bağlanalım
	$conn = ftp_connect($ftpserver);
	$ftp_user_name = $ftpusername;
	$ftp_user_pass = $ftppassword;
	if (!$conn){
		echo '<script type="text/javascript">alert("FTP Baglanti hatasi, bilgileri kontrol ediniz");</script>';
		exit;
	}

	// kullanıcı adı ve parola ile oturum açalım
	$login_result = ftp_login($conn, $ftp_user_name, $ftp_user_pass);

	// karşıya bir dosya yükleyelim
	if (ftp_put($conn, $uzak, $yerel, FTP_BINARY)) {
	 echo '<script type="text/javascript">alert("Backup FTP sunucusuna upload edildi!");</script>';
	 unlink($zipname);
	 unlink($backup_name);
	} else {
	 echo '<script type="text/javascript">alert("Upload hatasi, bilgileri kontrol ediniz");</script>';
	}

	// bağlantıyı kapatalım
	ftp_close($conn);

	}

}
 ?>

	<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>