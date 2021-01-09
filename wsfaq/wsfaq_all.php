<?php
/*
 * Plugin Name: WSFAQ
 * Description: Create your responsive frequently asked questions(FAQ) page quickly. Install plugin. Active plugin. Go to admin WSFAQ section. Add new frequently asked questions(FAQ). Simple paste this shortcode [wsfaq] in your page or in post. Please use [wsfaq] to display all frequently asked questions(FAQ). Please use [wsfaq faqcategory="categoryname"] to display specific category's frequently asked questions(FAQ).  
 * Version: 1.0.0
 * Author: Web Sanskruti
 * Plugin URI: http://www.websanskruti.com/
 * Author URI: http://websanskruti.com/
 * License: GPLv2 or later
 */

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2016 Web Sanskruti.
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if (!function_exists('wsfaq_wsf_cat')) {

    // Register Custom Post Type for FAQ
    function wsfaq_wsf_cat() {

        //label for add quetion,listing,editing 
        $quetion_labels = array(
            'name' => _x('WSFAQ', 'Post Type General Name', 'text_domain'),
            'singular_name' => _x('WSFAQ', 'Post Type Singular Name', 'text_domain'),
            'menu_name' => __('WSFAQ', 'text_domain'),
            'name_admin_bar' => __('WSFAQ', 'text_domain'),
            'parent_item_colon' => __('Parent Question:', 'text_domain'),
            'all_items' => __('All Questions', 'text_domain'),
            'add_new_item' => __('Add New Question', 'text_domain'),
            'add_new' => __('Add Question', 'text_domain'),
            'new_item' => __('New Question', 'text_domain'),
            'edit_item' => __('Edit Question', 'text_domain'),
            'update_item' => __('Update Question', 'text_domain'),
            'view_item' => __('View Question', 'text_domain'),
            'search_items' => __('Search Question', 'text_domain'),
            'not_found' => __('Not found', 'text_domain'),
            'not_found_in_trash' => __('Not found in Trash', 'text_domain'),
        );

        //argument for quetions
        $args_questions = array(
            'label' => __('wsfaq_wsf_cat', 'text_domain'),
            'description' => __('Create Your FAQ', 'text_domain'),
            'labels' => $quetion_labels,
            'supports' => array('title', 'editor', 'author', 'page-attributes', 'post-formats',),
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 20,
            'menu_icon' => 'dashicons-welcome-view-site',
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'capability_type' => 'page',
        );
        register_post_type('wsfaq_wsf_cat', $args_questions);

        //label for category
        $cat_labels = array(
            'name' => _x('Category', 'taxonomy general name'),
            'singular_name' => _x('Category', 'taxonomy singular name'),
            'search_items' => __('Search Category'),
            'all_items' => __('All Category'),
            'parent_item' => __('Parent Category'),
            'parent_item_colon' => __('Parent Category:'),
            'edit_item' => __('Edit Category'),
            'update_item' => __('Update Category'),
            'add_new_item' => __('Add New Category'),
            'new_item_name' => __('New Category Name'),
            'menu_name' => __('Add Category'),
        );

        //args for category
        $args_category = array(
            'hierarchical' => true,
            'labels' => $cat_labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'faqcategory'),
        );
        register_taxonomy('faqcategory', array('wsfaq_wsf_cat'), $args_category);
    }

    add_action('init', 'wsfaq_wsf_cat', 0);
}

//this fuction is used for color picker in setting page
add_action('admin_enqueue_scripts', 'wsfaq_wsf_enqueue_color_picker');

function wsfaq_wsf_enqueue_color_picker($hook_suffix) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wsfaq-script-handle', plugins_url('js/wp-color-picker.js', __FILE__), array('wp-color-picker'), false, true);
}
?>
<?php
add_action('admin_menu', 'wsfaq_wsf_cat_add_admin_menu');
add_action('admin_init', 'wsfaq_wsf_cat_settings_init');

//add  menu faq settings in admin bar
function wsfaq_wsf_cat_add_admin_menu() {
    add_submenu_page('edit.php?post_type=wsfaq_wsf_cat', 'Settings of FAQs', 'FAQs Settings', 'manage_options', 'wsfaq_wsf_cat', 'wsfaq_wsf_cat_options_page');
}

//background color,authername, font-style all settings function
function wsfaq_wsf_cat_settings_init() {
    register_setting('pluginPage', 'wsfaq_wsf_cat_settings');
    add_settings_section(
            'wsfaq_wsf_cat_pluginPage_section', __('FAQs Settings', 'text_domain'), 'wsfaq_wsf_cat_settings_section_callback', 'pluginPage'
    );
    add_settings_field(
            'wsfaq_wsf_cat_text_field_0', __('Background Color of Category Title', 'text_domain'), 'wsfaq_wsf_cat_text_field_0_render', 'pluginPage', 'wsfaq_wsf_cat_pluginPage_section'
    );

    add_settings_field(
            'wsfaq_wsf_cat_text_field_2', __('Font Color of Category Title (Text Color)', 'text_domain'), 'wsfaq_wsf_cat_text_field_2_render', 'pluginPage', 'wsfaq_wsf_cat_pluginPage_section'
    );
    
    add_settings_field(
            'wsfaq_wsf_cat_select_field_4', __('Font Style of Category Title', 'text_domain'), 'wsfaq_wsf_cat_select_field_4_render', 'pluginPage', 'wsfaq_wsf_cat_pluginPage_section'
    );

     add_settings_field(
            'wsfaq_wsf_cat_text_field_1', __('Background Color of Question Title', 'text_domain'), 'wsfaq_wsf_cat_text_field_1_render', 'pluginPage', 'wsfaq_wsf_cat_pluginPage_section'
    );

    add_settings_field(
            'wsfaq_wsf_cat_text_field_3', __('Font Color of Question Title (Text Color)', 'text_domain'), 'wsfaq_wsf_cat_text_field_3_render', 'pluginPage', 'wsfaq_wsf_cat_pluginPage_section'
    );

    add_settings_field(
            'wsfaq_wsf_cat_select_field_5', __('Font Style of FAQ Title', 'text_domain'), 'wsfaq_wsf_cat_select_field_5_render', 'pluginPage', 'wsfaq_wsf_cat_pluginPage_section'
    );
    
    add_settings_field(
            'wsfaq_wsf_cat_radio_field_6', __('Display Author Name', 'text_domain'), 'wsfaq_wsf_cat_radio_field_6_render', 'pluginPage', 'wsfaq_wsf_cat_pluginPage_section'
    );
}

function wsfaq_wsf_cat_text_field_0_render() {
    $options = get_option('wsfaq_wsf_cat_settings');

    $wsfaq_tab_bg = $options['wsfaq_wsf_cat_text_field_0'];
    ?> 
    <input type='text' name='wsfaq_wsf_cat_settings[wsfaq_wsf_cat_text_field_0]' class="my-color-field" value='<?php echo $wsfaq_tab_bg; ?>'>
    <?php
}

function wsfaq_wsf_cat_text_field_1_render() {
    $options = get_option('wsfaq_wsf_cat_settings');

    $wsfaq_tab_bg = $options['wsfaq_wsf_cat_text_field_1'];
    ?> 
    <input type='text' name='wsfaq_wsf_cat_settings[wsfaq_wsf_cat_text_field_1]' class="my-color-field" value='<?php echo $wsfaq_tab_bg; ?>'>
    <?php
}

function wsfaq_wsf_cat_text_field_2_render() {

    $options = get_option('wsfaq_wsf_cat_settings');

    $wsfaq_tab_text = $options['wsfaq_wsf_cat_text_field_2'];
    ?>
    <input type='text' name='wsfaq_wsf_cat_settings[wsfaq_wsf_cat_text_field_2]' class="my-color-field" value='<?php echo $wsfaq_tab_text; ?>'>
    <?php
}

function wsfaq_wsf_cat_text_field_3_render() {

    $options = get_option('wsfaq_wsf_cat_settings');

    $wsfaq_tab_text = $options['wsfaq_wsf_cat_text_field_3'];
    ?>
    <input type='text' name='wsfaq_wsf_cat_settings[wsfaq_wsf_cat_text_field_3]' class="my-color-field" value='<?php echo $wsfaq_tab_text; ?>'>
    <?php
}

function wsfaq_wsf_cat_select_field_4_render() {

    $options = get_option('wsfaq_wsf_cat_settings');
    $wsfaq_tab_text = $options['wsfaq_wsf_cat_radio_field_4'];
    ?>
    <input type='radio' name='wsfaq_wsf_cat_settings[wsfaq_wsf_cat_radio_field_4]' <?php checked($wsfaq_tab_text, 'bold'); ?>  value='bold'/>Bold </br>
    <input type='radio' name='wsfaq_wsf_cat_settings[wsfaq_wsf_cat_radio_field_4]' <?php checked($wsfaq_tab_text, 'italic'); ?> value='italic'/>Italic</br>
    <input type='radio' name='wsfaq_wsf_cat_settings[wsfaq_wsf_cat_radio_field_4]'<?php checked($wsfaq_tab_text, 'uppercase'); ?> value='uppercase'/>UpperCase</br>
    <input type='radio' name='wsfaq_wsf_cat_settings[wsfaq_wsf_cat_radio_field_4]'<?php checked($wsfaq_tab_text, 'bold-uppercase'); ?> value='bold-uppercase'/>Bold-UpperCase</br>
    <input type='radio' name='wsfaq_wsf_cat_settings[wsfaq_wsf_cat_radio_field_4]'<?php checked($wsfaq_tab_text, 'italic-uppercase'); ?> value='italic-uppercase'/>Italic-UpperCase
    <?php
}

function wsfaq_wsf_cat_select_field_5_render() {

    $options = get_option('wsfaq_wsf_cat_settings');
    $wsfaq_tab_text = $options['wsfaq_wsf_cat_radio_field_5'];
    ?>
    <input type='radio' name='wsfaq_wsf_cat_settings[wsfaq_wsf_cat_radio_field_5]' <?php checked($wsfaq_tab_text, 'bold'); ?>  value='bold'/>Bold </br>
    <input type='radio' name='wsfaq_wsf_cat_settings[wsfaq_wsf_cat_radio_field_5]' <?php checked($wsfaq_tab_text, 'italic'); ?> value='italic'/>Italic</br>
    <input type='radio' name='wsfaq_wsf_cat_settings[wsfaq_wsf_cat_radio_field_5]'<?php checked($wsfaq_tab_text, 'uppercase'); ?> value='uppercase'/>UpperCase</br>
    <input type='radio' name='wsfaq_wsf_cat_settings[wsfaq_wsf_cat_radio_field_5]'<?php checked($wsfaq_tab_text, 'bold-uppercase'); ?> value='bold-uppercase'/>Bold-UpperCase</br>
    <input type='radio' name='wsfaq_wsf_cat_settings[wsfaq_wsf_cat_radio_field_5]'<?php checked($wsfaq_tab_text, 'italic-uppercase'); ?> value='italic-uppercase'/>Italic-UpperCase
    <?php
}

function wsfaq_wsf_cat_radio_field_6_render() {

    $options = get_option('wsfaq_wsf_cat_settings');
    $wsfaq_tab_author = $options['wsfaq_wsf_cat_radio_field_6'];
    ?>
    <input type='radio' name='wsfaq_wsf_cat_settings[wsfaq_wsf_cat_radio_field_6]' checked="checked" value='true'>Yes</br>
    <input type='radio' name='wsfaq_wsf_cat_settings[wsfaq_wsf_cat_radio_field_6]' value='Display Author name is not selected'>No 
    <?php
}

// display in backend setting page
function wsfaq_wsf_cat_settings_section_callback() {
    echo __("To display your FAQs in WordPress, Simple paste this shortcode [wsfaq] in your page or in post. From here you can change settings of your FAQ's Background-Color, Text-Color, Font-Style & Author Name. ", 'text_domain');
}

function wsfaq_wsf_cat_options_page() {
    ?>
    <form action='options.php' method='post'>
    <?php
    settings_fields('pluginPage');
    do_settings_sections('pluginPage');
    submit_button();
    ?>
    </form>
    <?php
}

//for shortcode
function wsfaq_shortcut($atts) {

    $_SESSION['path'] = ABSPATH;

    extract(shortcode_atts(array(
        "limit" => '',
        "faqcategory" => '',
        "order" => '',
                    ), $atts));

    // Define limit
    if ($limit) {
        $posts_per_page = $limit;
    } else {
        $posts_per_page = '-1';
    }

    if ($order) {
        $ord = $order;
    } else {
        $ord = 'ASC';
    }

    if ($faqcategory) {
        $faqcat = $faqcategory;
    } else {
        $faqcat = '';
    }

    include('wsfaq.php');
}

add_shortcode('wsfaq', 'wsfaq_shortcut');

function wsfaq_im_scripts() {


    wp_register_style('bootstrapmin', plugin_dir_url(__FILE__) . 'css/bootstrapmin.css');

    wp_enqueue_style('bootstrapmin');

    wp_enqueue_script('wsfaqjs', plugins_url('js/bootstrap.min.js', __FILE__), array('jquery'), true);
}

add_action('wp_enqueue_scripts', 'wsfaq_im_scripts');

// js for front-end side slide up or down
function wsfaq_script() {
    ?>
    <script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].onclick = function() {
            var opencat;
                opencat = false;
            if (this.classList) { 
                if(!this.classList.contains("active"))
                    opencat = true;
            } else {
                temp = this.className;
                if(temp.indexOf("active") === -1)
                    opencat = true; // For IE9 and earlier
            }
            
            hideAll();
            hideAllAcc1();

            if(opencat === true){
                if (this.classList) { 
                    this.classList.add("active");
                } else {
                    var temp1 = this.className;
                    this.className = temp1+ " active"; // For IE9 and earlier
                }
                if (this.nextElementSibling.classList) { 
                    this.nextElementSibling.classList.add("show");
                } else {
                    var temp2 = this.nextElementSibling.className;
                    this.nextElementSibling.className = temp2+ " show"; // For IE9 and earlier
                }
            }
            //this.classList.add("active");
            //this.nextElementSibling.classList.add("show");
        };
    }

    function hideAll() {
        for (i = 0; i < acc.length; i++) {
            
            if (acc[i].classList) { 
                acc[i].classList.remove("active");
            } else {
                acc[i].className = acc[i].className.replace(/\bactive\b/g, ""); // For IE9 and earlier
            }
            
            if (acc[i].nextElementSibling.classList) { 
                acc[i].nextElementSibling.classList.remove("show");
            } else {
                acc[i].nextElementSibling.className = acc[i].nextElementSibling.className.replace(/\bshow\b/g, ""); // For IE9 and earlier
            }
            
            //acc[i].classList.remove("active");
            //acc[i].nextElementSibling.classList.remove("show");
        }
    }

    var acc1 = document.getElementsByClassName("accordion1");
    var i;

    for (i = 0; i < acc1.length; i++) {
        acc1[i].onclick = function() {
            
            var openfaq;
                openfaq = false;
            if (this.classList) { 
                if(!this.classList.contains("active"))
                    openfaq = true;
            } else {
                temp = this.className;
                if(temp.indexOf("active") === -1)
                    openfaq = true; // For IE9 and earlier
            }
            
            hideAllAcc1();

            if(openfaq === true){
                if (this.classList) { 
                    this.classList.add("active");
                } else {
                    var temp1 = this.className;
                    this.className = temp1+ " active"; // For IE9 and earlier
                }
                if (this.nextElementSibling.classList) { 
                    this.nextElementSibling.classList.add("show");
                } else {
                    var temp2 = this.nextElementSibling.className;
                    this.nextElementSibling.className = temp2+ " show"; // For IE9 and earlier
                }
            }
            //this.classList.add("active");
            //this.nextElementSibling.classList.add("show");
        };
    }

    function hideAllAcc1() {
        for (i = 0; i < acc1.length; i++) {
            if (acc1[i].classList) { 
                acc1[i].classList.remove("active");
            } else {
                acc1[i].className = acc1[i].className.replace(/\bactive\b/g, ""); // For IE9 and earlier
            }
            
            if (acc1[i].nextElementSibling.classList) { 
                acc1[i].nextElementSibling.classList.remove("show");
            } else {
                acc1[i].nextElementSibling.className = acc1[i].nextElementSibling.className.replace(/\bshow\b/g, ""); // For IE9 and earlier
            }
            
            //acc1[i].classList.remove("active");
            //acc1[i].nextElementSibling.classList.remove("show");
        }
    }

    </script>

    <?php
}

add_action('wp_footer', 'wsfaq_script');