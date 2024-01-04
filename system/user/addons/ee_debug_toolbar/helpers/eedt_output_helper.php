<?php

if (!function_exists('eedt_output_array')) {
    /**
     * Formats $arr for use in Panels with Array data
     * @param array $arr
     * @param string $default
     * @param string $pair_delim
     * @param string $tail_delim
     * @return string
     */
    function eedt_output_array($arr, $default = 'nothing_found', $pair_delim = ' =&gt; ', $tail_delim = '<br />')
    {
        if (!is_array($arr) || count($arr) == '0') {
            return lang($default);
        }

        $return = '';
        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                $return .= $key . $pair_delim . '<pre>' . print_r($value, TRUE) . '</pre>';
            } else {
                $return .= $key . $pair_delim . $value . $tail_delim;
            }
        }

        return $return;
    }
}

if (!function_exists('eedt_theme_url')) {
    /**
     * Sets up the third party theme URL
     * @return string
     */
    function eedt_theme_url()
    {
        if (defined('URL_THIRD_THEMES')) {
            $url = URL_THIRD_THEMES;
        } else {
            $url = rtrim(ee()->config->config['theme_folder_url'], '/') . '/third_party/';
        }

        return $url;
    }
}

if (!function_exists('eedt_theme_path')) {
    /**
     * Sets up the third party themes path
     * @return string
     */
    function eedt_theme_path()
    {
        $path = '';
        if (defined('PATH_THIRD_THEMES')) {
            $path = PATH_THIRD_THEMES;
        } else {
            $path = rtrim(ee()->config->config['theme_folder_path'], '/') . '/third_party/';
        }

        return $path;
    }
}

if (!function_exists('eedt_third_party_path')) {
    /**
     * Sets up the third party add-ons path
     * @return string
     */
    function eedt_third_party_path()
    {
        $path = '';
        if (defined('PATH_THIRD')) {
            $path = PATH_THIRD;
        } else {
            $path = APPPATH . 'third_party/';
        }

        return $path;
    }
}

if (!function_exists('eedt_highlight_code')) {
    function eedt_highlight_code($str)
    {
        // The highlight string function encodes and highlights
        // brackets so we need them to start raw
        $str = str_replace(array('&lt;', '&gt;'), array('<', '>'), $str);

        // Replace any existing PHP tags to temporary markers so they don't accidentally
        // break the string out of PHP, and thus, thwart the highlighting.

        $str = str_replace(
            array('<?', '?>', '<%', '%>', '\\', '</script>'),
            array('phptagopen', 'phptagclose', 'asptagopen', 'asptagclose', 'backslashtmp', 'scriptclose'),
            $str
        );

        // The highlight_string function requires that the text be surrounded
        // by PHP tags, which we will remove later
        $str = '<?php ' . $str . ' ?>'; // <?

        // All the magic happens here, baby!
        $str = highlight_string($str, true);

        // Remove our artificially added PHP, and the syntax highlighting that came with it
        $str = preg_replace('/<span style="color: #([A-Z0-9]+)">&lt;\?php(&nbsp;| )/i', '<span style="color: #$1">', $str);
        $str = preg_replace('/(<span style="color: #[A-Z0-9]+">.*?)\?&gt;<\/span>\n<\/span>\n<\/code>/is', "$1</span>\n</span>\n</code>", $str);
        $str = preg_replace('/<span style="color: #[A-Z0-9]+"\><\/span>/i', '', $str);

        // Replace our markers back to PHP tags.
        $str = str_replace(
            array('phptagopen', 'phptagclose', 'asptagopen', 'asptagclose', 'backslashtmp', 'scriptclose'),
            array('&lt;?', '?&gt;', '&lt;%', '%&gt;', '\\', '&lt;/script&gt;'),
            $str
        );

        return $str;
    }

}