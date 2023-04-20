<?
$_ENV['STORAGE_METHOD'] = 'local'; // local or ftp

// The path to the storage folder. This is used when the storage method is set to local.
$_ENV['STORAGE_LOCAL_PATH'] = $_ENV['ROOT_PATH'].'storage'.DIRECTORY_SEPARATOR; 

// The FTP host. This is used when the storage method is set to ftp.
$_ENV['STORAGE_FTP_HOST'] = 'localhost';
$_ENV['STORAGE_FTP_PORT'] = 21;
$_ENV['STORAGE_FTP_USER'] = 'user';
$_ENV['STORAGE_FTP_PASS'] = 'pass';
$_ENV['STORAGE_FTP_PATH'] = '/';
$_ENV['STORAGE_FTP_SSL'] = false;