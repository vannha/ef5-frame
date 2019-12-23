<?php
/**
 * Page loading style 
*/
function ef5frame_page_loading_styles($default){
  $loading = array(
      'flip-box'         => esc_html__('Flip Box','ef5-frame'),
      'double-bounce'    => esc_html__('Double Bounce','ef5-frame'),
      'wave'             => esc_html__('Wave','ef5-frame'),
      'double-cube'      => esc_html__('Double Cube','ef5-frame'),
      'scaleout'         => esc_html__('Scale Out','ef5-frame'),
      'double-dots'      => esc_html__('Double Dots','ef5-frame'),
      'three-dot-bounce' => esc_html__('Three Circle Bounce','ef5-frame'),
      'circle-loading'   => esc_html__('Circle Loading','ef5-frame'),
      'cube-grid'        => esc_html__('Cube Grid','ef5-frame'),
      'fading-circle'    => esc_html__('Fading Circle','ef5-frame'),
      'folding-cube'     => esc_html__('Folding Cube','ef5-frame')
  );
  if($default) 
    $loading['-1'] = esc_html__('Default','ef5-frame');

  return $loading; 
}
/**
 * Get Page Loading
*/
if(!function_exists('ef5frame_page_loading')){
    function ef5frame_page_loading(){
        $show_page_loading = ef5frame_get_opts('show_page_loading', '0');
        $page_loading_style = ef5frame_get_opts('page_loading_style','fading-circle');
        if($show_page_loading === '1'){
            echo '<div id="ef5-loading">';
                switch ($page_loading_style) {
                    case 'flip-box':
                        ef5frame_spin_flip_box();
                        break;
                    case 'double-bounce':
                        ef5frame_spin_double_bounce();
                        break;
                    case 'wave':
                        ef5frame_spin_wave();
                        break;
                    case 'double-cube':
                        ef5frame_spin_double_cube();
                        break;
                    case 'scaleout':
                        ef5frame_spin_scaleout();
                        break;
                    case 'double-dots':
                        ef5frame_spin_double_dots();
                        break;
                    case 'three-dot-bounce':
                        ef5frame_spin_three_dot_bounce();
                        break;
                    case 'circle-loading':
                        ef5frame_spin_circle_loading();
                        break;
                    case 'cube-grid':
                        ef5frame_spin_cube_grid();
                        break;
                    case 'fading-circle':
                        ef5frame_spin_fading_circle();
                        break;
                    case 'folding-cube':
                        ef5frame_spin_folding_cube();
                        break;
                    default:
                        ef5frame_spin_fading_circle();
                        break;
                }
            echo '</div>';
        }  
    }
}
function ef5frame_spin_flip_box(){
    ?>
        <div class="spinner rotateplane"></div>
    <?php
}
function ef5frame_spin_double_bounce(){
    ?>
        <div class="spinner double-bounce">
          <div class="double-bounce1"></div>
          <div class="double-bounce2"></div>
        </div>
    <?php
}
function ef5frame_spin_wave(){
    ?>
        <div class="spinner wave">
          <div class="rect1"></div>
          <div class="rect2"></div>
          <div class="rect3"></div>
          <div class="rect4"></div>
          <div class="rect5"></div>
        </div>
    <?php
}
function ef5frame_spin_double_cube(){
    ?>
        <div class="spinner">
          <div class="cube1"></div>
          <div class="cube2"></div>
        </div>
    <?php
}
function ef5frame_spin_scaleout(){
    ?>
        <div class="spinner scaleout"></div>
    <?php
}
function ef5frame_spin_double_dots(){
    ?>
        <div class="spinner double-dots">
          <div class="dot1"></div>
          <div class="dot2"></div>
        </div>
    <?php
}
function ef5frame_spin_three_dot_bounce(){
    ?>
        <div class="spinner three-circle-bounce">
          <div class="bounce1"></div>
          <div class="bounce2"></div>
          <div class="bounce3"></div>
        </div>
    <?php
}
function ef5frame_spin_circle_loading(){
    ?>
        <div class="spinner sk-circle">
          <div class="sk-circle1 sk-child"></div>
          <div class="sk-circle2 sk-child"></div>
          <div class="sk-circle3 sk-child"></div>
          <div class="sk-circle4 sk-child"></div>
          <div class="sk-circle5 sk-child"></div>
          <div class="sk-circle6 sk-child"></div>
          <div class="sk-circle7 sk-child"></div>
          <div class="sk-circle8 sk-child"></div>
          <div class="sk-circle9 sk-child"></div>
          <div class="sk-circle10 sk-child"></div>
          <div class="sk-circle11 sk-child"></div>
          <div class="sk-circle12 sk-child"></div>
        </div>
    <?php
}
function ef5frame_spin_cube_grid(){
    ?>
        <div class="spinner sk-cube-grid">
          <div class="sk-cube sk-cube1"></div>
          <div class="sk-cube sk-cube2"></div>
          <div class="sk-cube sk-cube3"></div>
          <div class="sk-cube sk-cube4"></div>
          <div class="sk-cube sk-cube5"></div>
          <div class="sk-cube sk-cube6"></div>
          <div class="sk-cube sk-cube7"></div>
          <div class="sk-cube sk-cube8"></div>
          <div class="sk-cube sk-cube9"></div>
        </div>
    <?php
}
function ef5frame_spin_fading_circle(){
    ?>
        <div class="spinner sk-fading-circle">
          <div class="sk-circle1 sk-circle"></div>
          <div class="sk-circle2 sk-circle"></div>
          <div class="sk-circle3 sk-circle"></div>
          <div class="sk-circle4 sk-circle"></div>
          <div class="sk-circle5 sk-circle"></div>
          <div class="sk-circle6 sk-circle"></div>
          <div class="sk-circle7 sk-circle"></div>
          <div class="sk-circle8 sk-circle"></div>
          <div class="sk-circle9 sk-circle"></div>
          <div class="sk-circle10 sk-circle"></div>
          <div class="sk-circle11 sk-circle"></div>
          <div class="sk-circle12 sk-circle"></div>
        </div>
    <?php
}
function ef5frame_spin_folding_cube(){
    ?>
        <div class="spinner sk-folding-cube">
          <div class="sk-cube1 sk-cube"></div>
          <div class="sk-cube2 sk-cube"></div>
          <div class="sk-cube4 sk-cube"></div>
          <div class="sk-cube3 sk-cube"></div>
        </div>
    <?php
}

/**
 * loading animation
 *
*/
if(!function_exists('ef5frame_loading_animation')){
  function ef5frame_loading_animation($style = 'circle-loading'){
    echo '<div class="loader d-flex align-items-center justify-content-center">';
      switch ($style) {
                case 'flip-box':
                    ef5frame_spin_flip_box();
                    break;
                case 'double-bounce':
                    ef5frame_spin_double_bounce();
                    break;
                case 'wave':
                    ef5frame_spin_wave();
                    break;
                case 'double-cube':
                    ef5frame_spin_double_cube();
                    break;
                case 'scaleout':
                    ef5frame_spin_scaleout();
                    break;
                case 'double-dots':
                    ef5frame_spin_double_dots();
                    break;
                case 'three-dot-bounce':
                    ef5frame_spin_three_dot_bounce();
                    break;
                case 'circle-loading':
                    ef5frame_spin_circle_loading();
                    break;
                case 'cube-grid':
                    ef5frame_spin_cube_grid();
                    break;
                case 'fading-circle':
                    ef5frame_spin_fading_circle();
                    break;
                case 'folding-cube':
                    ef5frame_spin_folding_cube();
                    break;
                default:
                    ef5frame_spin_fading_circle();
                    break;
            }
    echo '</div>';
  }
}