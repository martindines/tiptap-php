<?php

namespace Tiptap\Utils;

class HTML
{
    public static function mergeAttributes()
    {
        $args = func_get_args();

        $attributes = array_shift($args);

        foreach ($args as $moreAttributes) {
            foreach ($moreAttributes as $key => $value) {
                // class="foo bar"
                if ($key === 'class') {
                    $attributes['class'] = trim($attributes['class'] ?? '' . ' ' . $value);

                    continue;
                }

                // style="color: red;"
                if ($key === 'style') {
                    $style = rtrim($attributes['style'] ?? '', '; ') . '; ' . rtrim($value, ';') . '; ';
                    $attributes['style'] = ltrim(trim($style), '; ');

                    continue;
                }

                $attributes[$key] = $value;
            }
        }

        return $attributes;
    }

    public static function renderAttributes(array $attrs)
    {
        // Make boolean values a string, so they can be rendered in HTML
        $attrs = array_map(function ($attribute) {
            if ($attribute === true) {
                return 'true';
            }

            if ($attribute === false) {
                return 'false';
            }

            return $attribute;
        }, $attrs);

        $attributes = [];

        foreach (array_filter($attrs) as $name => $value) {
            $attributes[] = " {$name}=\"{$value}\"";
        }

        return join($attributes);
    }
}
