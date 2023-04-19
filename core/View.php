<?

namespace core;

class View
{

    static private $layout = '';
    static private $default_styles = '';

    static public function layout(string $layout_name)
    {
        self::$layout = $layout_name;
    }

    static public function defaultStyles(array $styles)
    {
        foreach ($styles as $style) {
            if (!file_exists(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'public' . $style)) {
                throw new \Exception('Style file not found: ' . $style);
            }
            self::$default_styles.= '<link rel="stylesheet" href="/public' . $style . '">';
        }
    }

    static public function render($view_name, $data = null)
    {
        $view_name = str_replace('.', DIRECTORY_SEPARATOR, $view_name);

        if ($data != null) {
            extract($data);
        }

        $styles = self::$default_styles;

        if (isset($data['styles']) && is_array($data['styles'])) {
            foreach ($data['styles'] as $style) {
                if (!file_exists(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'public' . $style)) {
                    throw new \Exception('Style file not found: ' . $style);
                }
                $styles .='<link rel="stylesheet" href="/public' . $style . '">';
            }
        }

        if (isset($data['preload_scripts']) && is_array($data['preload_scripts'])) {
            $preload_scripts = '';
            foreach ($data['preload_scripts'] as $script) {
                if (!file_exists(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'public' . $script)) {
                    throw new \Exception('Script file not found: ' . $script);
                }
                $preload_scripts .='<script src="/public' . $script . '"></script>';
            }
        }

        if (isset($data['after_load_scripts']) && is_array($data['after_load_scripts'])) {
            $after_load_scripts = '';
            foreach ($data['after_load_scripts'] as $script) {
                if (!file_exists(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'public' . $script)) {
                    throw new \Exception('Script file not found: ' . $script);
                }
                $after_load_scripts .=  '<script src="/public' . $script . '"></script>';
            }
        }

        $title = $data['title'] ?? 'Some title';

        if (self::$layout != '') {
            $render = self::getPath($view_name);
            extract(
                [
                    'styles' => $styles ?? '',
                    'preload_scripts' => $preload_scripts ?? '',
                    'after_load_scripts' => $after_load_scripts ?? '',
                    'title' => $title,
                ]
            );
            include self::getPath(self::$layout);
        } else {
            include self::getPath($view_name);
        }
    }

    static public function renderPartial($view_name, $data = null)
    {
        $view_name = str_replace('.', DIRECTORY_SEPARATOR, $view_name);
        if ($data != null) {
            extract($data);
        }
        include self::getPath($view_name);
    }

    static public function hasView($view_name)
    {
        $view_name = str_replace('.', DIRECTORY_SEPARATOR, $view_name);
        return file_exists(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $view_name . '.php');
    }

    static public function getPath($view_name)
    {
        $view_name = str_replace('.', DIRECTORY_SEPARATOR, $view_name);
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $view_name . '.php';
    }
}
