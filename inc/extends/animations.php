<?php
function overcome_html_animation($args = []){
	$args = wp_parse_args($args, [
		'anim'     => 'wave1',
		'echo'     => false,
		'shape'    => 'circle',
		'infinite' => true,
		'size'	   => ''
	]);
	if(!empty($args['size'])) $args['size'] = 'size-'.$args['size'];
	$wave_wrap_class = ['ef5-wave-wrap', 'ef5-'.$args['anim'], $args['size']];
	$wave_class = [$args['shape'], 'ef5-wave', $args['anim']];
	if($args['infinite'] === true) $wave_class[] = 'infinite';

	switch ($args['anim']) {
		case 'wave4':
			$html = '<div class="'.implode(' ', $wave_wrap_class).'">
				<div class="delay1 '.implode(' ', $wave_class).'"></div>
				<div class="delay2 '.implode(' ', $wave_class).'"></div>
				<div class="delay3 '.implode(' ', $wave_class).'"></div>
				<div class="delay4 '.implode(' ', $wave_class).'"></div>
			</div>';
			break;
		case 'wave3':
			$html = '<div class="'.implode(' ', $wave_wrap_class).'">
				<div class="delay1 '.implode(' ', $wave_class).'"></div>
				<div class="delay2 '.implode(' ', $wave_class).'"></div>
				
			</div>';
			break;
		case 'wave2':
			$html = '<div class="'.implode(' ', $wave_wrap_class).'">
				<div class="delay1 '.implode(' ', $wave_class).'"></div>
				<div class="delay2 '.implode(' ', $wave_class).'"></div>
				<div class="delay3 '.implode(' ', $wave_class).'"></div>
				<div class="delay4 '.implode(' ', $wave_class).'"></div>
			</div>';
			break;
		case 'wave1':
			$html = '<div class="'.implode(' ', $wave_wrap_class).'">
				<div class="delay1 '.implode(' ', $wave_class).'"></div>
				<div class="delay2 '.implode(' ', $wave_class).'"></div>
				<div class="delay3 '.implode(' ', $wave_class).'"></div>
				<div class="delay4 '.implode(' ', $wave_class).'"></div>
			</div>';
			break;
		default : 
			$html = '';
			break;
	}
	if($args['echo'])
		echo overcome_html($html);
	else 
		return $html;
}