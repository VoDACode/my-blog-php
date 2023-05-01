<?

namespace core;

class Locale
{
    static private $defaultLang = 'en';
    static private $data;

    static public function get($key)
    {
        if (!isset($_SESSION['lang'])) {
            $_SESSION['lang'] = self::$defaultLang;
        }

        if (!isset(self::$data)) {
            self::$data = json_decode(
                file_get_contents(
                    $_ENV['ROOT_PATH'] . 'langs' . DIRECTORY_SEPARATOR . $_SESSION['lang'] . '.json'
                ),
                true
            );
        }

        return self::$data[$key];
    }

    static public function changeLang($lang)
    {
        if ($lang != $_SESSION['lang'] && file_exists($_ENV['ROOT_PATH'] . 'langs' . DIRECTORY_SEPARATOR . $lang . '.json')) {
            $_SESSION['lang'] = $lang;
            self::$data = json_decode(
                file_get_contents(
                    $_ENV['ROOT_PATH'] . 'langs' . DIRECTORY_SEPARATOR . $_SESSION['lang'] . '.json'
                ),
                true
            );
        }
    }
}