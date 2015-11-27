<?php
/*
Plugin Name: Lightbox Images
Description: Set all images to open with fancybox lightbox
Version: 1.0
Author: John Verity
Author URI: http://realjv3.com
*/

class jv3_lighbox_img {

    public $deps;

    public function __construct($deps) {
        $this->deps = json_decode($deps, true);

        add_action('wp_enqueue_scripts', array($this, 'enqueue_js_css'));

        //using add_filter priority 12 because img shortcodes are rendered with add_filter priority 11
        add_filter('the_content', array($this, 'add_a_tag_and_id_to_img'), 12);
    }

    /**
     * Register & enqueue all necessary js & css for lightbox, this plugin, and social share buttons
     */
    public function enqueue_js_css() {

        foreach ($this->deps['js'] as $js_script => $scriptinfo ) {
            $path = $scriptinfo[0];
            if (count($scriptinfo) > 1) {
                $dep = $scriptinfo[1];
                wp_register_script($js_script, plugins_url($path, __DIR__), array($dep));
                wp_enqueue_script($js_script);
            } else {
                wp_register_script($js_script, plugins_url($path));
                wp_enqueue_script($js_script);
            }
        }
        foreach ($this->deps['css'] as $css_script => $path ) {
            wp_register_style($css_script, plugins_url($path[0], __DIR__));
            wp_enqueue_style($css_script);
        }
    }
    /**
     * Grabs the content via 'the_content' filter and wraps img elements in <a id="single_image" ></a>
     * @param string $html
     * @return string
     */
    public function add_a_tag_and_id_to_img($html) {

        //turns <a href="image.jpg"> <img src="image.jpg"> </a>
        //into <a href="image.jpg" id="single_image"> <img src="image.jpg"> </a>
        $pattern = '/(<a.+href="[\w\/\+%\.:\-_\[\]]+[\.png|\.jpg|\.jpeg|\.JPG|\.PNG|\.JPEG]".*)(>)(?=<img)/';
        $replacement = '$1 id="single_image" $2';

        $html = preg_replace($pattern, $replacement, $html);

        //turns <img src="image.jpg">
        //into <a href="image.jpg" id="single_image"> <img src="image.jpg"> </a>
        $pattern = '/(<img.+src=("[\w\/\+%\.:\-_\[\]]+[\.png|\.jpg|\.jpeg|\.JPG|\.PNG|\.JPEG]").+\/>)(?!<\/a>)/';
        $replacement = '<a id="single_image" href=$2>$1</a>';

        $html = preg_replace($pattern, $replacement, $html);

        //sets <a>'s href to <img>'s src
        $pattern = '/(<a.+href=")([\w\/\+%\.:\-_\[\]]+[\.png|\.jpg|\.jpeg|\.JPG|\.PNG|\.JPEG])(".*><img.+src=")([\w\/\.:-]+)(".+"\s*\/>)/';
        $replacement = '$1$4$3$4$5';

        $html = preg_replace($pattern, $replacement, $html);

        return $html;
    }

}

$jv3_lightbox_img = new jv3_lighbox_img(file_get_contents(plugins_url('lightbox_img/etc/deps.json', __DIR__)));

/**
 * Visual Composer 4.7 supports presets for content elements
 * TODO: If using VC 4.7> to edit posts/pages, comment out above regex based content filter and develop this one
 * Above code will work regardless of editor used
 */
/*function jv3_change_agni_image_link_preset() {

    $attributes = array(
        'param_name' => 'el_class',
        'value' => 'Hi'
    );
    vc_add_param( 'agni_image', $attributes );
}
add_action('vc_before_init', 'jv3_change_agni_image_link_preset');*/
