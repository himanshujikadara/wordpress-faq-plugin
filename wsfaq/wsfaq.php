<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$wsfaqsettingdata = get_option('wsfaq_wsf_cat_settings'); ?>

<style type="text/css">
    button.accordion {
        background-color:  <?php
        if (isset($wsfaqsettingdata['wsfaq_wsf_cat_text_field_0']) && $wsfaqsettingdata['wsfaq_wsf_cat_text_field_0'] != "") {
            echo $wsfaqsettingdata['wsfaq_wsf_cat_text_field_0'];
        } else {
            echo '#ff3738';
        }
        ?>;
        color: <?php
        if (isset($wsfaqsettingdata['wsfaq_wsf_cat_text_field_2']) && $wsfaqsettingdata['wsfaq_wsf_cat_text_field_2'] != "") {
            echo $wsfaqsettingdata['wsfaq_wsf_cat_text_field_2'];
        } else {
            echo '#000000';
        }
        ?>;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        transition: 0.4s;
    }

    button.accordion.active, button.accordion:hover {
        opacity:0.90;
    }

    button.accordion:after {
        content: '\02795';
        font-size: 13px;
        color: #777;
        float: right;
        margin-left: 5px;
    }

    button.accordion.active:after {
        content: "\2796";
        opacity:0.90;
    }

    div.panel {
        padding: 0 18px;
        color: <?php echo $wsfaqsettingdata['wsfaq_wsf_cat_text_field_2']; ?>
            background-color: <?php echo $wsfaqsettingdata['wsfaq_wsf_cat_text_field_0']; ?>;
        max-height: 0;
        overflow: hidden;
        transition: 0.6s ease-in-out;
        opacity: 0;
    }

    div.panel.show {
        opacity: 5;
        max-height: 100%; 
        padding-top:10px;
    }

    button.accordion1 {
        background-color: <?php
        if (isset($wsfaqsettingdata['wsfaq_wsf_cat_text_field_1']) && $wsfaqsettingdata['wsfaq_wsf_cat_text_field_1'] != "") {
            echo $wsfaqsettingdata['wsfaq_wsf_cat_text_field_1'];
        } else {
            echo '#808080';
        }
        ?>;
        color:<?php
        if (isset($wsfaqsettingdata['wsfaq_wsf_cat_text_field_3']) && $wsfaqsettingdata['wsfaq_wsf_cat_text_field_3'] != "") {
            echo $wsfaqsettingdata['wsfaq_wsf_cat_text_field_3'];
        } else {
            echo '#ffffff';
        }
        ?>;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        transition: 0.4s;
        margin-top:15px;
    }

    button.accordion1.active, button.accordion:hover {
        opacity:0.90;
    }

    button.accordion1:after {
        content: '\02795';
        font-size: 13px;
        color: #777;
        float: right;
        margin-left: 5px;
    }

    button.accordion1.active:after {
        content: "\2796";
        opacity:0.90;
    }


    .bold
    {
        font-weight:bold;
        text-transform: none;

    }

    .italic
    {
        font-style:italic;
        text-transform: none;

    }

    .upper
    {
        text-transform: uppercase;
        font-weight: none;
    }

    .bold_upper
    {
        font-weight:bold;
        text-transform: uppercase;
    }
    .italic_upper
    {
        font-style:italic;
        text-transform: uppercase;
    }






</style>
<div id="container">
    <div id="content">

<?php
$i = 0;
$count = 0;

$post_type = 'wsfaq_wsf_cat';
//$tax = 'faqcategory';

if ($faqcat == "") {
    $tax_args = array(
        'order' => $ord
    );
} else {
    $tax_args = array(
        'order' => $ord,
        'name' => $faqcat
    );
}



$tax_terms = get_terms($tax, $tax_args);

if ($tax_terms) {

    foreach ($tax_terms as $tax_term) {
        $args = array(
            'post_type' => $post_type,
            'faqcategory' => $tax_term->slug,
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'order' => $ord,
            'caller_get_posts' => 1
        );

        $my_query = null;
        $my_query = new WP_Query($args);
        if ($my_query->have_posts()) {
            $options = get_option('wsfaq_wsf_cat_settings');
            $wsfaq_tab_text = $options['wsfaq_wsf_cat_radio_field_4'];
            $style = "";
            switch ($wsfaq_tab_text) {
                case "bold":
                    $style = "bold";
                    break;

                case "italic":
                    $style = "italic";
                    break;

                case "uppercase":
                    $style = "upper";
                    break;

                case "bold-uppercase":
                    $style = "bold_upper";
                    break;

                case "italic-uppercase":
                    $style = "italic_upper";
                    break;

                default:
                    $style = "bold";
                    break;
            }
            ?>

                    <div class="col-md-12 no-padding">
                        <button id="expand" class="accordion bgcolor_cat  <?php echo $style ?>"> 
                    <?php
                    echo $tax_term->name;
                    ?>
                        </button>


                        <div class="panel">
                    <?php
                    while ($my_query->have_posts()) : $my_query->the_post();

                        $options = get_option('wsfaq_wsf_cat_settings');
                        $wsfaq_tab_text = $options['wsfaq_wsf_cat_radio_field_5'];
                        $style_faq = "";
                        switch ($wsfaq_tab_text) {
                            case "bold":
                                $style_faq = "bold";
                                break;

                            case "italic":
                                $style_faq = "italic";
                                break;

                            case "uppercase":
                                $style_faq = "upper";
                                break;

                            case "bold-uppercase":
                                $style_faq = "bold_upper";
                                break;

                            case "italic-uppercase":
                                $style_faq = "italic_upper";
                                break;

                            default:
                                $style_faq = "italic";
                                break;
                        }
                        ?>

                                <button class="accordion1 <?php echo $style_faq ?>">
                                <?php
                                echo the_title();
                                ?>
                                </button>


                                <div class="panel">

                                <?php
                                echo the_content();

                                $options = get_option('wsfaq_wsf_cat_settings');
                                $wsfaq_tab_author = $options['wsfaq_wsf_cat_radio_field_6'];
                                if ($wsfaq_tab_author == "true") {
                                    echo "Author Name:";
                                    the_author();
                                } else {
                                    $wsfaq_tab_author = $wsfaq_tab_author;
                                }
                                ?>
                                </div>

                                <?php endwhile; ?>

                        </div>		
                    </div>


            <?php
        }
        wp_reset_query();
    }
}
?> 
    </div>
</div>