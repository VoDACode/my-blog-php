<?

namespace core;

class Locale
{
    static private $defaultLang = 'en';
    static private $data;

    static public function get(string $key)
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

        $value = self::$data;

        foreach (explode('.', $key) as $keyPer) {
            if (isset($value[$keyPer])) {
                $value = $value[$keyPer];
            } else {
                return $key;
            }
        }
        
        return $value;
    }

    static public function changeLang(string $lang)
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

    static public function getLang()
    {
        return $_SESSION['lang'];
    }

    static public function getDefLang()
    {
        return self::$defaultLang;
    }
    
    static public function Router(Request $request)
    {
        if (isset($request->params['lang'])) {
            self::changeLang($request->params['lang']);
        }
        $request->goToBack();
    }
}