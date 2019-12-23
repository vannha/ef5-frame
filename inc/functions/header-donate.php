<?php
function ef5frame_header_donate_button(){
	if(!class_exists('EF5Payments') || ef5frame_get_opts('header_donate', '0') === '0') return;
    wp_enqueue_script('bootstrap');
    if(is_singular('ef5_donation')){
      $post_id = get_the_ID();
    } else {
      $post_id = ef5payments_default_donation(ef5frame_get_id_by_slug(ef5frame_get_opts('header_donate_item',''),'ef5_donation'));
    }
    $data = apply_filters('ef5payments_get_payment_form_data',[
        'class'        => 'ef5-btn ef5-btn-sm accent fill',
        'data-options' => '',
        'data-target'  => '',
        'title'        => ef5frame_get_opts('header_donate_label', esc_html__('Donate Now','ef5-frame')),	
        'url'          => '#',
        'target'       => '_self'	
    ],$post_id);
    ?>
    <span class="header-icon ef5-header-donate">
    	<a class="<?php echo esc_attr($data['class']); ?>"
       data-options="<?php echo esc_attr($data['data-options']) ?>"
       data-target="<?php echo esc_attr($data['data-target']) ?>"
       href="<?php echo esc_attr($data['url']); ?>" target="<?php echo esc_attr($data['target']); ?>" ><?php echo ef5frame_html($data['title']) ?></a>
   </span>
    <?php
}