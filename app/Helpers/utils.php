<?php

if (! function_exists("parse_cookie"))
{
    function parse_cookie(string $cookie, string $key = null)
    {
        $array = explode(";", $cookie);

        $ret = [];

        foreach($array as $item){
            $item_array=explode("=",trim($item));
            $it_key=trim(reset($item_array));
            $it_value=trim(end($item_array));
            $ret[$it_key]=$it_value;
        }
        
        return ($key == null ? $ret : ($ret[$key] ?? null));
    }
}

if (! function_exists("array_to_object")) {
    function array_to_object(array $data)
    {
        $object = new stdClass();
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = array_to_object($value);
            }
            $object->$key = $value;
        }
        return $object;
    }
}

if (! function_exists("get_activity_icon_class"))
{
    function get_activity_icon_class(string $name, string $default = "fas fa-history")
    {
        $list = [
            "fas fa-sign-in-alt" => [
                "logged-in"
            ],
            "fas fa-running" => [
                "logged-out"
            ],
            "fas fa-history" => [
                "history"
            ],
            "fas fa-smile" => [
                "reactions"
            ]
        ];

        foreach ($list as $key => $value) {
            if (in_array($name, $value)) {
                return $key;
            }
        }
        
        return $default;
    }
}

if (! function_exists("get_activity_color_class"))
{
    function get_activity_color_class(string $name, string $default = "primary")
    {
        $list = [
            "success" => [
                "logged-in"
            ],
            "danger" => [
                "logged-out"
            ],
            "primary" => [
                "history"
            ],
            "warning" => [
                "reactions"
            ]
        ];

        foreach ($list as $key => $value) {
            if (in_array($name, $value)) {
                return $key;
            }
        }

        return $default;
    }
}

if (! function_exists("os_process_is_running")) {
    function os_process_is_running($needle)
    {
        exec("ps aux -ww", $process_status);

        $result = array_filter($process_status, function($var) use ($needle) {
            return strpos($var, $needle);
        });

        return !($result === []);
    }
}

if (! function_exists("minify_js"))
{
    function minify_js(string $value)
    {
        return trim(preg_replace([
            '#\s*("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')\s*|\s*\/\*(?!\!|@cc_on)(?>[\s\S]*?\*\/)\s*|\s*(?<![\:\=])\/\/.*(?=[\n\r]|$)|^\s*|\s*$#',
            // Remove white-space(s) outside the string and regex
            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/)|\/(?!\/)[^\n\r]*?\/(?=[\s.,;]|[gimuy]|$))|\s*([!%&*\(\)\-=+\[\]\{\}|;:,.<>?\/])\s*#s',
            // Remove the last semicolon
            '#;+\}#',
            // Minify object attribute(s) except JSON attribute(s). From `{'foo':'bar'}` to `{foo:'bar'}`
            '#([\{,])([\'])(\d+|[a-z_][a-z0-9_]*)\2(?=\:)#i',
            // --ibid. From `foo['bar']` to `foo.bar`
            '#([a-z0-9_\)\]])\[([\'"])([a-z_][a-z0-9_]*)\2\]#i'
        ],[
            '$1',
            '$1$2',
            '}',
            '$1$3',
            '$1.$3'
        ], $value));
    }
}

if (! function_exists("minify_html"))
{
    function minify_html(string $value)
    {
        return trim(preg_replace([
            // t = text
            // o = tag open
            // c = tag close
            // Keep important white-space(s) after self-closing HTML tag(s)
            '#<(img|input)(>| .*?>)#s',
            // Remove a line break and two or more white-space(s) between tag(s)
            '#(<!--.*?-->)|(>)(?:\n*|\s{2,})(<)|^\s*|\s*$#s',
            '#(<!--.*?-->)|(?<!\>)\s+(<\/.*?>)|(<[^\/]*?>)\s+(?!\<)#s',
            // t+c || o+t
            '#(<!--.*?-->)|(<[^\/]*?>)\s+(<[^\/]*?>)|(<\/.*?>)\s+(<\/.*?>)#s',
            // o+o || c+c
            '#(<!--.*?-->)|(<\/.*?>)\s+(\s)(?!\<)|(?<!\>)\s+(\s)(<[^\/]*?\/?>)|(<[^\/]*?\/?>)\s+(\s)(?!\<)#s',
            // c+t || t+o || o+t -- separated by long white-space(s)
            '#(<!--.*?-->)|(<[^\/]*?>)\s+(<\/.*?>)#s',
            // empty tag
            '#<(img|input)(>| .*?>)<\/\1>#s',
            // reset previous fix
            '#(&nbsp;)&nbsp;(?![<\s])#',
            // clean up ...
            '#(?<=\>)(&nbsp;)(?=\<)#',
            // --ibid
            '/\s+/'
        ],[
            '<$1$2</$1>',
            '$1$2$3',
            '$1$2$3',
            '$1$2$3$4$5',
            '$1$2$3$4$5$6$7',
            '$1$2$3',
            '<$1$2',
            '$1 ',
            '$1',
            " "
        ], $value));
    }
}

if (! function_exists("minify_css"))
{
    function minify_css(string $value)
    {
        return trim(preg_replace([
            // Remove comment(s)
            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',
            // Remove unused white-space(s)
            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~]|\s(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',
            // Replace `0(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)` with `0`
            '#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si',
            // Replace `:0 0 0 0` with `:0`
            '#:(0\s+0|0\s+0\s+0\s+0)(?=[;\}]|\!important)#i',
            // Replace `background-position:0` with `background-position:0 0`
            '#(background-position):0(?=[;\}])#si',
            // Replace `0.6` with `.6`, but only when preceded by `:`, `,`, `-` or a white-space
            '#(?<=[\s:,\-])0+\.(\d+)#s',
            // Minify string value
            '#(\/\*(?>.*?\*\/))|(?<!content\:)([\'"])([a-z_][a-z0-9\-_]*?)\2(?=[\s\{\}\];,])#si',
            '#(\/\*(?>.*?\*\/))|(\burl\()([\'"])([^\s]+?)\3(\))#si',
            // Minify HEX color code
            '#(?<=[\s:,\-]\#)([a-f0-6]+)\1([a-f0-6]+)\2([a-f0-6]+)\3#i',
            // Replace `(border|outline):none` with `(border|outline):0`
            '#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
            // Remove empty selector(s)
            '#(\/\*(?>.*?\*\/))|(^|[\{\}])(?:[^\s\{\}]+)\{\}#s'
        ],[
            '$1',
            '$1$2$3$4$5$6$7',
            '$1',
            ':0',
            '$1:0 0',
            '.$1',
            '$1$3',
            '$1$2$4$5',
            '$1$2$3',
            '$1:0',
            '$1$2'
        ], $value));
    }
}