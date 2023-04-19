<?

namespace core;

class URL
{

    public static function redirect(string $path)
    {
        header('Location: ' . $path);
    }

    public static function back()
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public static function asset(string $path)
    {
        if($path[0] != '/')
            $path = '/' . $path;
        return '/public' . $path;
    }
}
