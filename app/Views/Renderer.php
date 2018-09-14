<?php

namespace App\Views;

class Renderer
{
    public static function render(string $file, array $data): string
    {
        $loader = new \Twig_Loader_Filesystem('./views');
        $twig = new \Twig_Environment($loader, []);

        $template = $twig->load($file);
        return $template->render($data);
    }
}
