<?php
/**
 * All Function for Portfolio 
*/
if(!function_exists('overcome_portfolio_info')){
	function overcome_portfolio_info($args = []){
		if(!is_singular('ef5_portfolio')) return;
		$args = wp_parse_args($args, [
			'title' => esc_html__('Project Description','overcome')
		]);
		// Client name
		$client = overcome_get_post_format_value('portfolio_client_name','Magdalen School');
		// Location
		$location = overcome_get_post_format_value('portfolio_location','Oslay, Canada');
		// Surface Area
		$surface_area = overcome_get_post_format_value('portfolio_surface_area','3,000,000 m2');
		// Budget
		$budgets = overcome_get_post_format_value('portfolio_budgets','$5,000,000.00');
		// Date
		$date = overcome_get_post_format_value('portfolio_complete','');
		$date = strtotime($date);
		$date_sever = date_i18n('Y-m-d G:i:s');   
		$gmt_offset = get_option( 'gmt_offset' );
		if(empty($date)) $date = strtotime("-60 days 23 hours 56 minutes 50 seconds");
		$date = date(get_option('date_format'), $date);
	?>
		<div class="pf-sidebar-box detail-box">
			<div class="ef5-heading h3"><?php echo overcome_html($args['title']); ?></div>
			<div class="inner detail-inner ef5-box-shadow ef5-bg-white transition">
				<ul class="pf-details-list ef5-unstyled">
					<li>
						<strong class="ef5-heading"><?php esc_html_e('Client','overcome'); ?>:</strong>
						<?php echo esc_html($client); ?>
					</li>
					<li>
						<strong class="ef5-heading"><?php esc_html_e('Location','overcome'); ?>:</strong>
						<?php echo esc_html($location); ?>
					</li>
					<li>
						<strong class="ef5-heading"><?php esc_html_e('Surface Area','overcome'); ?>:</strong>
						<?php echo esc_html($surface_area); ?>
					</li>
					<li>
						<strong class="ef5-heading"><?php esc_html_e('Budgets','overcome'); ?>:</strong>
						<?php echo esc_html($budgets); ?>
					</li>
					<li>
						<strong class="ef5-heading"><?php esc_html_e('Complete','overcome'); ?>:</strong>
						<?php echo esc_html($date); ?>
					</li>
					<li>
						<strong class="ef5-heading"><?php esc_html_e('Categories','overcome'); ?>:</strong>
						<?php echo get_the_term_list( get_the_ID(), 'portfolio_cat', '', ', ', '' );; ?>
					</li>
				</ul>
			</div>
		</div>
	<?php
	}
}

/**
 * Get Featured Portfolio
 * @param: $posts_per_page  // Number of post to show
*/
if(!function_exists('overcome_portfolio_featured')){
	function overcome_portfolio_featured($args = []){
		$args = wp_parse_args($args, [
			'title'          => esc_html__('Featured Projects','overcome'),
			'posts_per_page' => '3'
		]);
		if($args['posts_per_page'] === '0' || $args['posts_per_page'] === '') return;
		$r = new WP_Query( array(
            'post_type'           => 'ef5_portfolio',
            'posts_per_page'      => $args['posts_per_page'],
            'no_found_rows'       => true,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
            'post__not_in'		  => array( get_the_ID() )	
        ) );
		$thumbnail_size = [86,66];
        if ( $r->have_posts() ) {
        ?>
            <div class="pf-sidebar-box pf-featured-box">
            	<div class="ef5-heading h3"><?php echo overcome_html($args['title']); ?></div>
	        	<div class="inner feature-post-inner ef5-box-shadow ef5-bg-white transition">
		            <?php while ( $r->have_posts() ) {
		                $r->the_post();
		                $thumbnail_url = overcome_get_image_url_by_size( ['size' => implode('x', $thumbnail_size), 'default_thumb' => true,'class'=>'d-block'] );
		                echo '<div class="pf-feature-item ef5-box-shadow-hover-17 transition"><div class="row gutters-20 ">';
			                printf(
			                    '<div class="ef5-featured col-auto">' .
			                        '<a href="%1$s" title="%2$s" class="ef5-thumbnail d-block">' .
			                            '<img src="%3$s" alt="%2$s" />' .
			                        '</a>' .
			                    '</div>',
			                    esc_url( get_permalink() ),
			                    esc_attr( get_the_title() ),
			                    esc_url( $thumbnail_url )
			                );
			                echo '<div class="ef5-brief col" style="max-width: calc(100% - '.((int)$thumbnail_size[0]+20).'px);">';
				                printf(
				                    '<div class="ef5-heading h4"><a href="%1$s" title="%2$s">%3$s</a></div>',
				                    esc_url( get_permalink() ),
				                    esc_attr( get_the_title() ),
				                    get_the_title()
				                );
				                printf(
				                	'<div class="ef5-meta">%s</div>',
				                	get_the_term_list( get_the_ID(), overcome_get_post_taxonomies(), '', ', ', '' )
				                );
			                echo '</div>';
		                echo '</div></div>';
		            } ?>
            	</div>
            </div>
        <?php }
        wp_reset_postdata();
	}
}

/**
 * Get Project Supporter
 * @param $user_ID
*/
if(!function_exists('overcome_portfolio_supporter')){
	function overcome_portfolio_supporter($args = []){
		$args = wp_parse_args($args, [
			'email' => overcome_get_post_format_value('post-support',''),
			'title' => esc_html__('Support','overcome')
		]);
		if(empty($args['email']) || $args['email'] = null) return;
	        $user = get_user_by( 'email', overcome_get_post_format_value('post-support','') );
	        if($user !== false){ 
	            global $wp_roles; 
	            $user_info = get_userdata($user->ID);
	            $user_role = $user_info->roles;
	            $all_meta_for_user = get_user_meta( $user->ID );
	            // get role label
	            $role_label = [];
	            foreach ($user_role as $role) {
	            	$role_label[] = translate_user_role($wp_roles->roles[$role]['name']);
	            }
	    ?>
	        <div class="pf-sidebar-box pf-supported-box">
	        	<div class="ef5-heading h3"><?php echo overcome_html($args['title']); ?></div>
	        	<div class="inner supported-inner text-center ef5-box-shadow ef5-bg-white transition">
		            <?php
		            	echo '<div class="sp-avatar">'.get_avatar($user->ID, 90, '', $user_info->display_name, ['class' => 'circle']).'</div>';
		                echo '<div class="ef3-heading h4 sp-name">' . $user_info->display_name .'</div>';
		                echo '<div class="sp-role text-xsmall">' . implode(' / ', $role_label).'</div>';
		                echo '<div class="sp-bio">'.get_user_meta($user->ID,'description', true).'</div>';
		                echo '<div class="sp-phone ef5-heading h3">'.get_user_meta($user->ID,'ef5_phone_number', true).'</div>';
		            ?>
		        </div>
	        </div>
	    
		<?php }
	}
}
/**
 * Get Project Attachment
 * @param $user_ID
*/
if(!function_exists('overcome_portfolio_attachment')){
	function overcome_portfolio_attachment($args = []){
		$args = wp_parse_args($args, [
			'title' => esc_html__('Download','overcome'),
			'class' => ''
		]);
		$number_of_att = apply_filters('overcome_number_of_portfolio_attachment', 5);
		$files = [];
		for ($i=0; $i <= $number_of_att ; $i++) { 
			$att = overcome_get_post_format_value('post-attachment-'.$i,'');
			if(!empty($att)){
				$files[] = $att;
			}
		}
		if(empty($files)) return;
		?>
		<div class="pf-sidebar-box pf-attachment-box">
	        <div class="ef5-heading h3"><?php echo overcome_html($args['title']); ?></div>
	        <div class="inner attachment-inner">
	        	<?php foreach ($files as $file) {
	        		$_file = get_post($file);
	        		$file_type = wp_check_filetype($_file->guid);
	        		switch ($file_type['ext']) {
	        			case 'pdf':
	        				$icon = 'icon-img pdf';
	        				break;
	        			case 'pptx':
	        				$icon = 'flaticon-pptx-file-format';
	        				break;
	        			case 'ppt':
	        				$icon = 'flaticon-pptx-file-format';
	        				break;
	        			case 'xlsx':
	        				$icon = 'flaticon-xlsx-file-format';
	        				break;
	        			case 'xls':
	        				$icon = 'flaticon-xlsx-file-format';
	        				break;
	        			case 'docx':
	        				$icon = 'flaticon-docx-file-format';
	        				break;
	        			case 'doc':
	        				$icon = 'flaticon-document';
	        				break;
	        			case 'txt':
	        				$icon = 'flaticon-txt-file-symbol';
	        				break;
	        			case 'html':
	        				$icon = 'flaticon-html-file-extension-interface-symbol';
	        				break;
	        			case 'ai':
	        				$icon = 'flaticon-ai-file-format';
	        				break;
	        			case 'psd':
	        				$icon = 'flaticon-photoshop-file-format';
	        				break;
	        			case 'zip':
	        				$icon = 'icon-img pdf';
	        				break;
	        			default:
	        				$icon = 'flaticon-layers';
	        				break;
	        		}
					echo '<div class="pf-attachment-item ef5-box-shadow transition bg-white"><a class="ef5-heading text-uppercase row gutters-15 align-items-center" href="'.esc_url($_file->guid).'" target="_blank"><span class="att-icon '.esc_attr($icon).' col-auto"></span><span class="title col">'.esc_html($_file->post_title).'</span></a></div>'; 
	        	} ?>
	        </div>
	    </div>
		<?php
	}
}