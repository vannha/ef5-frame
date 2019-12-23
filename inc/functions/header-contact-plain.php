<?php
/**
 * Header Contact Button
 * @since 1.0.0 
*/
if(!function_exists('overcome_header_contact_plain_text')){
	function overcome_header_contact_plain_text($args = []){
		$args = wp_parse_args($args, [
			'before'      => '',
			'after'       => '',
			'layout'	  => '1',	
			'class'       => 'justify-content-end',
			'item_class'  => 'col-auto',
			'inner_class' => 'row gutters-20 align-items-center',
			'page_only'	  => false
		]);

		switch ($args['layout']) {
			case '4':
				$args['class'] .= ' gutters-60';
				break;
			
			default:
				$args['class'] .= ' gutters-80';
				break;
		}

		$header_contact_plain = overcome_get_opts('header_contact_plain', '0');
		if($header_contact_plain !== '1') return;

		$header_contact_plain_icon1 = overcome_get_opts('header_contact_plain_icon1', '');
		$header_contact_plain_icon2 = overcome_get_opts('header_contact_plain_icon2', '');
		$header_contact_plain_icon3 = overcome_get_opts('header_contact_plain_icon3', '');

		$header_contact_plain_text1 = overcome_get_opts('header_contact_plain_text1', '');
		$header_contact_plain_sub_text1 = overcome_get_opts('header_contact_plain_sub_text1', '');
		$header_contact_plain_text2 = overcome_get_opts('header_contact_plain_text2', '');
		$header_contact_plain_sub_text2 = overcome_get_opts('header_contact_plain_sub_text2', '');
		$header_contact_plain_text3 = overcome_get_opts('header_contact_plain_text3', '');
		$header_contact_plain_sub_text3 = overcome_get_opts('header_contact_plain_sub_text3', '');

		$header_contact_plain_subtext1 = overcome_get_opts('header_contact_plain_subtext1', '');
		$header_contact_plain_sub_subtext1 = overcome_get_opts('header_contact_plain_sub_subtext1', '');
		$header_contact_plain_subtext2 = overcome_get_opts('header_contact_plain_subtext2', '');
		$header_contact_plain_sub_subtext2 = overcome_get_opts('header_contact_plain_sub_subtext2', '');
		$header_contact_plain_subtext3 = overcome_get_opts('header_contact_plain_subtext3', '');
		$header_contact_plain_sub_subtext3 = overcome_get_opts('header_contact_plain_sub_subtext3', '');

		printf('%1$s<div class="ef5-qc ef5-qc-%2$s row %3$s">', $args['before'], $args['layout'], $args['class']);
		for ($i=1; $i < 4 ; $i++) {
			if(!empty(${'header_contact_plain_icon'.$i}) || !empty(${'header_contact_plain_text'.$i}) || !empty(${'header_contact_plain_subtext'.$i})) :
				switch ($args['layout']) {
					case '4':
					?>
					<div class="qc-item <?php echo esc_attr($args['item_class']);?>">
						<div class="<?php echo esc_attr($args['inner_class']);?>">
							<?php if(!empty(${'header_contact_plain_icon'.$i})) : ?>
								<div class="col-auto">
									<span class="qc-icon accent-color <?php echo esc_attr(${'header_contact_plain_icon'.$i});?>"></span>
								</div>
							<?php endif; ?>
							<div class="col">
								<span class="qc-heading"><?php echo esc_html(${'header_contact_plain_text'.$i});?></span>
								<span class="qc-text"><?php echo esc_html(${'header_contact_plain_subtext'.$i});?></span>
								<?php if( !empty(${'header_contact_plain_sub_text'.$i}) || !empty('header_contact_plain_sub_subtext'.$i) ) : ?>
									<span class="divider"></span>
									<span class="qc-heading"><?php echo esc_html(${'header_contact_plain_sub_text'.$i});?></span>
									<span class="qc-text"><?php echo esc_html(${'header_contact_plain_sub_subtext'.$i});?></span>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php
					break;
					default:
				?>
					<div class="qc-item <?php echo esc_attr($args['item_class']);?>">
						<div class="<?php echo esc_attr($args['inner_class']);?>">
							<?php if(!empty(${'header_contact_plain_icon'.$i})) : ?>
								<div class="col-auto">
									<span class="qc-icon accent-color <?php echo esc_attr(${'header_contact_plain_icon'.$i});?>"></span>
								</div>
							<?php endif; ?>
							<div class="col">
								<?php if( !empty(${'header_contact_plain_sub_text'.$i}) && !empty('header_contact_plain_sub_subtext'.$i) ) { ?>
									<div class="ef5-heading qc-heading font-style-500"><span class="qc-heading"><?php echo esc_html(${'header_contact_plain_text'.$i});?></span> <span class="qc-text"><?php echo esc_html(${'header_contact_plain_subtext'.$i});?></span></div>
									<?php if( !empty(${'header_contact_plain_sub_text'.$i}) || !empty('header_contact_plain_sub_subtext'.$i) ) : ?>
										<div class="ef5-heading qc-heading font-style-500"><span class="qc-heading"><?php echo esc_html(${'header_contact_plain_sub_text'.$i});?></span> <span class="qc-text"><?php echo esc_html(${'header_contact_plain_sub_subtext'.$i});?></span></div>
									<?php endif; ?>
								<?php } else { ?>
									<div class="ef5-heading qc-heading font-style-500"><span class="qc-heading"><?php echo esc_html(${'header_contact_plain_text'.$i});?></span></div>
									<div class="qc-text"><?php echo esc_html(${'header_contact_plain_subtext'.$i});?></div>
									<?php if( !empty(${'header_contact_plain_sub_text'.$i}) || !empty('header_contact_plain_sub_subtext'.$i) ) : ?>
										<div class="ef5-heading qc-heading font-style-500"><span class="qc-heading"><?php echo esc_html(${'header_contact_plain_sub_text'.$i});?></span> </div>
										<div class="qc-text"><?php echo esc_html(${'header_contact_plain_sub_subtext'.$i});?></div>
									<?php endif; ?>
								<?php } ?>
							</div>
						</div>
					</div>
			<?php
					break;
				}
			endif;
		}
		printf('</div>%s', $args['after']);
	}
}

function overcome_header_contact_plain_icon($args = []){
	$args = wp_parse_args($args, [
		'before' => '',
		'after'  => '',
		'icon'	 => 'flaticon-telephone'
	]);
	$show_contact = overcome_get_opts('header_contact_plain', '0');
	if($show_contact !== '1') return;

	printf('%s', $args['before']);
?>
	<a href="#ef5-header-contact-plain" class="header-icon ef5-header-popup d-xl-none"><span class="icon <?php echo esc_attr($args['icon']);?>"></span></a>
<?php
	printf('%s', $args['after']);
}

function overcome_header_contact_plain_popup_html(){
	$show_contact = overcome_get_opts('header_contact_plain', '0');
	if($show_contact !== '1') return;
?>
	<div id="ef5-header-contact-plain" class="mfp-hide container"><div class="row justify-content-center"><div class="col-auto">
		<?php overcome_header_contact_plain_text([
			'layout'      => '1', 
			'class'       => 'gutters-80', 
			'inner_class' => 'row gutters-20 align-items-center',
		]); ?>
	</div></div></div>
<?php
}
add_action('wp_footer','overcome_header_contact_plain_popup_html');