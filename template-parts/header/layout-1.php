<?php
/**
 * Template part for displaying default header layout
 */
$header_menu    = ef5frame_get_opts('header_menu','');
$show_search    = ef5frame_get_opts('header_search', '0');
$show_cart      = ef5frame_get_opts('header_cart', '0');

$nav_extra_class = [
    'nav-extra',
    ef5frame_get_opts('header_atts_icon_style','icon')
];
if($header_menu === 'none') $nav_extra_class[] = 'no-menu';
if($show_search == '0' && $show_cart === '0') $nav_extra_class[] = 'no-icon';
?>
<header id="ef5-header" <?php ef5frame_header_class(); ?>>
    <div id="ef5-headroom" class="main-header">
        <div class="<?php ef5frame_header_inner_class();?>">
            <div class="row justify-content-between align-items-center">
                <div class="ef5-logo col-auto">
                    <?php get_template_part( 'template-parts/header/header-logo' ); ?>
                </div>
                <div class="ef5-navigation-wrap col">
                    <?php ef5frame_header_helper_menu(); ?>
                    <div class="row align-items-center justify-content-end">
                        <?php ef5frame_header_menu(['class' => 'col-lg-12 col-xl-auto']); ?>
                        <div class="col-auto">
                            <div class="<?php echo trim(implode(' ', $nav_extra_class)); ?>">
                                <?php 
                                    get_template_part('template-parts/header/header-social');
                                    ef5frame_header_contact_plain_text([
                                        'layout'      => '5',
                                        'class'       => 'd-none d-xl-flex',
                                        'inner_class' => 'row gutters-10 align-items-center',
                                        'page_only'   => true,
                                    ]);
                                    ef5frame_header_contact_plain_icon();
                                    ef5frame_header_search(['type' => 'popup']);
                                    ef5frame_header_wishlist();
                                    ef5frame_header_cart();
                                    ef5frame_header_signin_signup();
                                    ef5frame_header_contact();
                                    ef5frame_header_donate_button();
                                    ef5frame_header_popup_nav_icon();
                                    ef5frame_header_mobile_menu_icon();
                                    ef5frame_header_side_nav_icon();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>