<?php

use App\Classes\ClassesView;

if (! function_exists("_view"))
{
    function _view(string $template, array $data = [])
    {
        return (string) (new ClassesView($template, $data))
            ->withCleanComment()
            ->withMinifyHTML()
            ->withMinifyJavascript()
            ->withMinifyCSS();
    }
}