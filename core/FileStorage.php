<?

namespace core;

class FileStorage
{
    public static function upload($file, $path)
    {
        if ($_ENV['STORAGE_METHOD'] == 'local') {
            $path = self::normalizePath($path);
            return self::uploadLocal($file, $path);
        } else if ($_ENV['STORAGE_METHOD'] == 'ftp') {
            return self::uploadFtp($file, $path);
        }
    }

    public static function show($path)
    {
        if ($_ENV['STORAGE_METHOD'] == 'local') {
            return self::showLocal($path);
        } else if ($_ENV['STORAGE_METHOD'] == 'ftp') {
            return self::showFtp($path);
        }
    }

    public static function download($path)
    {
        if ($_ENV['STORAGE_METHOD'] == 'local') {
            return self::downloadLocal($path);
        } else if ($_ENV['STORAGE_METHOD'] == 'ftp') {
            return self::downloadFtp($path);
        }
    }

    public static function delete($path)
    {
        if ($_ENV['STORAGE_METHOD'] == 'local') {
            return self::deleteLocal($path);
        } else if ($_ENV['STORAGE_METHOD'] == 'ftp') {
            return self::deleteFtp($path);
        }
    }

    #region Local
    private static function uploadLocal($file, $path)
    {
        $path = $_ENV['STORAGE_LOCAL_PATH'] . $path;
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $path = $path . $file['name'];
        if (move_uploaded_file($file['tmp_name'], $path)) {
            return true;
        }
        return false;
    }

    private static function downloadLocal($path)
    {
        $path = $_ENV['STORAGE_LOCAL_PATH'] . $path;
        if (file_exists($path)) {
            return readfile($path);
        }
        return false;
    }

    private static function deleteLocal($path)
    {
        $path = $_ENV['STORAGE_LOCAL_PATH'] . $path;
        if (!unlink($path)) {
            return false;
        }
        $path = substr($path, 0, strrpos($path, DIRECTORY_SEPARATOR));
        if (file_exists($path)) {
            return rmdir($path);
        }
        return false;
    }

    private static function showLocal($path)
    {
        $path = $_ENV['STORAGE_LOCAL_PATH'] . $path;
        if (file_exists($path)) {
            echo file_get_contents($path);
            return true;
        }
        return false;
    }

    #endregion

    #region FTP

    private static function uploadFtp($file, $path)
    {
        $path = $_ENV['STORAGE_FTP_PATH'] . $path;
        $conn = ftp_connect($_ENV['STORAGE_FTP_HOST'], $_ENV['STORAGE_FTP_PORT']);
        if ($conn) {
            if (ftp_login($conn, $_ENV['STORAGE_FTP_USER'], $_ENV['STORAGE_FTP_PASS'])) {
                if (ftp_put($conn, $path . $file['name'], $file['tmp_name'], FTP_BINARY)) {
                    return true;
                }
            }
        }
        return false;
    }

    private static function downloadFtp($path)
    {
        $path = $_ENV['STORAGE_FTP_PATH'] . $path;
        $conn = ftp_connect($_ENV['STORAGE_FTP_HOST'], $_ENV['STORAGE_FTP_PORT']);
        if ($conn) {
            if (ftp_login($conn, $_ENV['STORAGE_FTP_USER'], $_ENV['STORAGE_FTP_PASS'])) {
                $tmp = tmpfile();
                if (ftp_fget($conn, $tmp, $path, FTP_BINARY, 0)) {
                    return stream_get_contents($tmp);
                }
            }
        }
        return false;
    }

    private static function deleteFtp($path)
    {
        $path = $_ENV['STORAGE_FTP_PATH'] . $path;
        $conn = ftp_connect($_ENV['STORAGE_FTP_HOST'], $_ENV['STORAGE_FTP_PORT']);
        if ($conn) {
            if (ftp_login($conn, $_ENV['STORAGE_FTP_USER'], $_ENV['STORAGE_FTP_PASS'])) {
                if (ftp_delete($conn, $path)) {
                    return true;
                }
            }
        }
        return false;
    }

    private static function showFtp($path)
    {
        $path = $_ENV['STORAGE_FTP_PATH'] . $path;
        $conn = ftp_connect($_ENV['STORAGE_FTP_HOST'], $_ENV['STORAGE_FTP_PORT']);
        if ($conn) {
            if (ftp_login($conn, $_ENV['STORAGE_FTP_USER'], $_ENV['STORAGE_FTP_PASS'])) {
                $tmp = tmpfile();
                if (ftp_fget($conn, $tmp, $path, FTP_BINARY, 0)) {
                    return stream_get_contents($tmp);
                }
            }
        }
        return false;
    }

    #endregion

    private static function normalizePath($path)
    {
        $path = str_replace('/', DIRECTORY_SEPARATOR, $path);
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
        if ($path[0] == DIRECTORY_SEPARATOR) {
            $path = substr($path, 1);
        }
        if ($path[strlen($path) - 1] != DIRECTORY_SEPARATOR) {
            $path = $path . DIRECTORY_SEPARATOR;
        }
        return $path;
    }
}
