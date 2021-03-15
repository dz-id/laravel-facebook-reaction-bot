<?php

/*
* AUTO MINIFY HTML,CSS,JS by DulLah
*/

namespace App\Classes;

class ClassesView
{
    protected $html;
    protected $jsExcept = [
        "/application\/(.*json)/"
    ];
    protected $cssExcept = [];

    public function __toString()
    {
        return $this->html;
    }

    public function __construct(string $template, array $data = [])
    {
        $this->html = view($template, $data);
    }

    public function withCleanComment()
    {
        $this->html = preg_replace("#\s*<!--(?!\[if\s).*?-->\s*|(?<!\>)\n+(?=\<[^!])#s", "", $this->html);

        return $this;
    }

    public function withMinifyHTML()
    {
        $dom = new \DOMDocument;
        @$dom->loadHTML($this->html);

        $javascript = [];
        $css = [];

        foreach ($dom->getElementsByTagName("script") as $el) {
            if (count($this->jsExcept) === 0 && trim($el->nodeValue)) {
                $javascript[] = $el->nodeValue;
                continue;
            }

            $type = strtolower($el->getAttribute("type"));
            foreach ($this->jsExcept as $regExc) {
                if (!preg_match($regExc, $type) && trim($el->nodeValue)) {
                    $javascript[] = $el->nodeValue;
                }
            }
        }

        foreach ($dom->getElementsByTagName("style") as $el) {
            if (count($this->cssExcept) === 0 && trim($el->nodeValue)) {
                $css[] = $el->nodeValue;
                continue;
            }

            $type = strtolower($el->getAttribute("type"));
            foreach ($this->cssExcept as $regExc) {
                if (!preg_match($regExc, $type) && trim($el->nodeValue)) {
                    $css[] = $el->nodeValue;
                }
            }
        }

        $this->html = minify_html($this->html);

        $dom = new \DOMDocument;
        @$dom->loadHTML($this->html);
        $index = 0;

        foreach ($dom->getElementsByTagName("script") as $el) {
            if (count($javascript) === 0) continue;
            if (count($this->jsExcept) === 0 && trim($el->nodeValue)) {
                $el->nodeValue = "";
                $el->appendChild($dom->createTextNode($javascript[$index]));
                $index++;
                continue;
            }

            $type = strtolower($el->getAttribute("type"));
            foreach ($this->jsExcept as $regExc) {
                if (!preg_match($regExc, $type) && trim($el->nodeValue)) {
                    $el->nodeValue = "";
                    $el->appendChild($dom->createTextNode($javascript[$index]));
                    $index++;
                }
            }
        }

        $index = 0;

        foreach ($dom->getElementsByTagName("style") as $el) {
            if (count($css) === 0) continue;
            if (count($this->cssExcept) === 0 && trim($el->nodeValue)) {
                $el->nodeValue = "";
                $el->appendChild($dom->createTextNode($css[$index]));
                $index++;
                continue;
            }

            $type = strtolower($el->getAttribute("type"));
            foreach ($this->cssExcept as $regExc) {
                if (!preg_match($regExc, $type) && trim($el->nodeValue)) {
                    $el->nodeValue = "";
                    $el->appendChild($dom->createTextNode($css[$index]));
                    $index++;
                }
            }
        }

        $this->html = $dom->saveHTML();
        return $this;
    }

    public function withMinifyJavascript()
    {
        $dom = new \DOMDocument;
        @$dom->loadHTML($this->html);

        foreach ($dom->getElementsByTagName("script") as $el) {
            if (count($this->jsExcept) === 0 && trim($el->nodeValue)) {
                $js = minify_js($el->nodeValue);
                $el->nodeValue = "";
                $el->appendChild($dom->createTextNode($js));
                continue;
            }

            $type = strtolower($el->getAttribute("type"));
            foreach ($this->jsExcept as $regExc) {
                if (!preg_match($regExc, $type) && trim($el->nodeValue)) {
                    $js = minify_js($el->nodeValue);
                    $el->nodeValue = "";
                    $el->appendChild($dom->createTextNode($js));
                }
            }
        }

        $this->html = $dom->saveHTML();
        return $this;
    }

    public function withMinifyCSS()
    {
        $dom = new \DOMDocument;
        @$dom->loadHTML($this->html);

        foreach ($dom->getElementsByTagName("style") as $el) {
            if (count($this->cssExcept) === 0 && trim($el->nodeValue)) {
                $css = minify_css($el->nodeValue);
                $el->nodeValue = "";
                $el->appendChild($dom->createTextNode($css));
                continue;
            }

            $type = strtolower($el->getAttribute("type"));
            foreach ($this->cssExcept as $regExc) {
                if (!preg_match($regExc, $type) && trim($el->nodeValue)) {
                    $css = minify_css($el->nodeValue);
                    $el->nodeValue = "";
                    $el->appendChild($dom->createTextNode($css));
                }
            }
        }

        $this->html = $dom->saveHTML();
        return $this;
    }
}