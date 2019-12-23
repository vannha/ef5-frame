<?php
/**
 * Get size information for all currently-registered image sizes.
 *
 * @global $_wp_additional_image_sizes
 * @uses   get_intermediate_image_sizes()
 * @return array $sizes Data for all currently-registered image sizes.
 */
function overcome_get_image_sizes() {
    global $_wp_additional_image_sizes;
    $sizes = array();
    foreach ( get_intermediate_image_sizes() as $_size ) {
        if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
            $sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
            $sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
            $sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
        } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
            $sizes[ $_size ] = array(
                'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
                'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
            );
        }
    }
    return $sizes;
}

/**
 * Get size information for a specific image size.
 *
 * @uses   overcome_get_image_sizes()
 * @param  string $size The image size for which to retrieve data.
 * @return bool|array $size Size data about an image size or false if the size doesn't exist.
 */
function overcome_get_image_size( $size ) {
    $sizes = overcome_get_image_sizes();

    if ( isset( $sizes[ $size ] ) ) {
        return $sizes[ $size ];
    }
    return false;
}

/**
 * Get the width of a specific image size.
 *
 * @uses   overcome_get_image_size()
 * @param  string $size The image size for which to retrieve data.
 * @return bool|string $size Width of an image size or false if the size doesn't exist.
 */
function overcome_get_image_width( $size ) {
    if ( ! $size = overcome_get_image_size( $size ) ) {
        return false;
    }
    if ( isset( $size['width'] ) ) {
        return $size['width'];
    }
    return false;
}

/**
 * Get the height of a specific image size.
 *
 * @uses   overcome_get_image_size()
 * @param  string $size The image size for which to retrieve data.
 * @return bool|string $size Height of an image size or false if the size doesn't exist.
 */
function overcome_get_image_height( $size ) {
    if ( ! $size = overcome_get_image_size( $size ) ) {
        return false;
    }
    if ( isset( $size['height'] ) ) {
        return $size['height'];
    }
    return false;
}

/**
 * Default thumbnail url
*/
if (!function_exists('overcome_default_image_thumbnail_url')) {
    function overcome_default_image_thumbnail_url($args = array())
    {
        $args = wp_parse_args($args, array(
            'size'        => 'large',
            'default_img' => '/wp-content/themes/' . get_template() . '/assets/images/placeholder/no-image.jpg',
            'class'       => ''
        ));
        extract($args);
        /* use overcome_resize_thumbnail( $attach_id = null, $img_url = null, $width, $height, $crop = false ) */
        global $_wp_additional_image_sizes;
        $image_sizes = overcome_get_image_sizes();
        $size = explode('x', $size);
        $size_use = $size[0];
        if (!is_numeric($size_use)) {
            if (!empty($image_sizes[$size_use]) && is_array($image_sizes[$size_use])) {
                $width = $image_sizes[$size_use]['width'];
                $height = $image_sizes[$size_use]['height'];

            } else {
                $width = '1170';
                $height = '770';
            }
        } else {
            $width = $size[0];
            $height = isset($size[1]) ? $size[1] : $size[0];
        }

        $default_img = overcome_resize_thumbnail('', $default_img, $width, $height, true);

        return site_url() . $default_img['url'];
    }
}
/**
 * Default Image thumbnail 
*/
if (!function_exists('overcome_default_image_thumbnail')) {
    function overcome_default_image_thumbnail($args = array())
    {
        $args = wp_parse_args($args, array(
            'size'        => 'large',
            'default_img' => '/wp-content/themes/' . get_template() . '/assets/images/placeholder/no-image.jpg',
            'class'       => '',
            'echo'        => false  
        ));
        extract($args);
        /* use overcome_resize_thumbnail( $attach_id = null, $img_url = null, $width, $height, $crop = false ) */
        global $_wp_additional_image_sizes;
        $image_sizes = overcome_get_image_sizes();
        $size = explode('x', $size);
        $size_use = $size[0];
        if (!is_numeric($size_use)) {
            if (!empty($image_sizes[$size_use]) && is_array($image_sizes[$size_use])) {
                $width = $image_sizes[$size_use]['width'];
                $height = $image_sizes[$size_use]['height'];

            } else {
                $width = '1170';
                $height = '770';
            }
        } else {
            $width = $size[0];
            $height = isset($size[1]) ? $size[1] : $size[0];
        }

        $default_img = overcome_resize_thumbnail('', $default_img, $width, $height, true);
        $thumbnail = '<img class="' . trim(implode(' ', array('default-thumb', $class))) . '" src="' . site_url() . $default_img['url'] . '" width="' . $default_img['width'] . '" height="' . $default_img['height'] . '" alt="' . esc_attr(get_option('blogname')) . '" />';
        if($echo)
            echo overcome_html($thumbnail);
        else 
            return $thumbnail;
    }
}

/*
* Resize images dynamically using wp built in functions
*
* php 5.2+
* 
*/
if ( ! function_exists( 'overcome_resize_thumbnail' ) ) {
    /**
     * @param int $attach_id
     * @param string $img_url
     * @param int $width
     * @param int $height
     * @param bool $crop
     *
     * @since 1.0
     * @return array
     */
    function overcome_resize_thumbnail( $attach_id = null, $img_url = null, $width, $height, $crop = false ) {
        // this is an attachment, so we have the ID
        if($attach_id === null) $attach_id = get_post_thumbnail_id(get_the_ID());
        $image_src = array();

        $attr = ['srcset'=>'','sizes'=>''];
        if ( $attach_id ) {
            $image_src = wp_get_attachment_image_src( $attach_id, 'full' );
            $actual_file_path = get_attached_file( $attach_id );
            // add scrset and sizes for device and retina
            if(function_exists('wp_ef5_calculate_image_srcset')){
                $image_meta = wp_get_attachment_metadata( $attach_id );
                if ( is_array( $image_meta ) ) {
                    $size_array = array( absint( $width ), absint( $height ) );
                    $srcset     = wp_ef5_calculate_image_srcset( $size_array, $image_src['0'], $image_meta, $attach_id );
                    $sizes      = wp_ef5_calculate_image_sizes( $size_array, $image_src['0'], $image_meta, $attach_id );
                    if ( $srcset && ( $sizes || ! empty( $attr['sizes'] ) ) ) {
                        $attr['srcset'] = $srcset;
                        if ( empty( $attr['sizes'] ) ) {
                            $attr['sizes'] = $sizes;
                        }
                    }
                }
            }
            // this is not an attachment, let's use the image url
        } elseif ( $img_url ) {
            $file_path = parse_url( $img_url );
            $actual_file_path = rtrim( ABSPATH, '/' ) . $file_path['path'];
            $orig_size = getimagesize( $actual_file_path );

            $image_src[0] = $img_url;
            $image_src[1] = $orig_size[0];
            $image_src[2] = $orig_size[1];
        }
        if ( ! empty( $actual_file_path ) ) {
            $file_info = pathinfo( $actual_file_path );
            $extension = '.' . $file_info['extension'];

            // the image path without the extension
            $no_ext_path = $file_info['dirname'] . '/' . $file_info['filename'];

            $cropped_img_path = $no_ext_path . '-' . $width . 'x' . $height . $extension;

            // checking if the file size is larger than the target size
            // if it is smaller or the same size, stop right here and return
            if ( $image_src[1] > $width || $image_src[2] > $height ) {

                // the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
                if ( file_exists( $cropped_img_path ) ) {
                    $cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );
                    $vt_image = array(
                        'url'    => $cropped_img_url,
                        'width'  => $width,
                        'height' => $height,
                    );
                    return array_merge($vt_image, $attr);
                }

                if ( false == $crop ) {
                    // calculate the size proportionaly
                    $proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
                    $resized_img_path = $no_ext_path . '-' . $proportional_size[0] . 'x' . $proportional_size[1] . $extension;

                    // checking if the file already exists
                    if ( file_exists( $resized_img_path ) ) {
                        $resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );

                        $vt_image = array(
                            'url'    => $resized_img_url,
                            'width'  => $proportional_size[0],
                            'height' => $proportional_size[1],
                        );
                        
                        return array_merge($vt_image, $attr);
                    }
                }

                // no cache files - let's finally resize it
                $img_editor = wp_get_image_editor( $actual_file_path );

                if ( is_wp_error( $img_editor ) || is_wp_error( $img_editor->resize( $width, $height, $crop ) ) ) {
                    $vt_image =  array(
                        'url'    => '',
                        'width'  => '',
                        'height' => '',
                    );
                    return array_merge($vt_image, $attr);
                }

                $new_img_path = $img_editor->generate_filename();

                if ( is_wp_error( $img_editor->save( $new_img_path ) ) ) {
                    $vt_image =  array(
                        'url'    => '',
                        'width'  => '',
                        'height' => '',
                    );
                    return array_merge($vt_image, $attr);
                }
                if ( ! is_string( $new_img_path ) ) {
                    $vt_image =  array(
                        'url'    => '',
                        'width'  => '',
                        'height' => '',
                    );
                    return array_merge($vt_image, $attr);
                }

                $new_img_size = getimagesize( $new_img_path );
                $new_img = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );

                // resized output
                $vt_image = array(
                    'url'    => $new_img,
                    'width'  => $new_img_size[0],
                    'height' => $new_img_size[1],
                );
                return array_merge($vt_image, $attr);
            }

            // default output - without resizing
            $vt_image = array(
                'url' => $image_src[0],
                'width' => $image_src[1],
                'height' => $image_src[2],
            );

            return array_merge($vt_image, $attr);
        }

        return false;
    }
}

if(!function_exists('overcome_image_by_size')){
    function overcome_image_by_size( $args = []) {
        $default = [
            'id'      => null , 
            'size'    => 'medium', 
            'class'   => '', 
            'echo'    => true , 
            'default' => false,
            'before'  => '',
            'after'   => '',
            'show_image' => true
        ];
        $args = wp_parse_args($args, $default);
        extract($args);

        if(empty($size)) $size = 'medium';
        global $_wp_additional_image_sizes;
        if($id === null) $id = get_post_thumbnail_id();
        $class .= ' ef5-img';
        $mime_type  = get_post_mime_type($id);
        if($mime_type === 'image/svg+xml') $class .= ' svg';

        if(empty($id) ){
            $overcome_image_by_size = overcome_default_image_thumbnail(['size' => $size, 'class' => $class]);
        } elseif ( is_string( $size ) && ( ( ! empty( $_wp_additional_image_sizes[ $size ] ) && is_array( $_wp_additional_image_sizes[ $size ] ) ) || in_array( $size, array(
                    'thumbnail',
                    'thumb',
                    'medium',
                    'medium_large',
                    'large',
                    'post-thumbnail',
                    'post-thumbnails',
                    'full',
                ) ) )
        ) {
            $overcome_image_by_size =  wp_get_attachment_image( $id, $size, '', array('class' => $class) );
        } else {
            if ( is_string( $size ) ) {
                preg_match_all( '/\d+/', $size, $thumb_matches );
                if ( isset( $thumb_matches[0] ) ) {
                    $size = array();
                    $count = count( $thumb_matches[0] );
                    if ( $count > 1 ) {
                        $size[] = $thumb_matches[0][0]; // width
                        $size[] = $thumb_matches[0][1]; // height
                    } elseif ( 1 === $count ) {
                        $size[] = $thumb_matches[0][0]; // width
                        $size[] = $thumb_matches[0][0]; // height
                    } else {
                        $size = false;
                    }
                }
            }
            if ( is_array( $size ) ) {
                // Resize image to custom size
                $p_img = overcome_resize_thumbnail( $id, null, $size[0], $size[1], true );
                $alt = trim( strip_tags( get_post_meta( $id, '_wp_attachment_image_alt', true ) ) );
                $attachment = get_post( $id );
                if ( ! empty( $attachment ) ) {
                    $title = trim( strip_tags( $attachment->post_title ) );

                    if ( empty( $alt ) ) {
                        $alt = trim( strip_tags( $attachment->post_excerpt ) ); // If not, Use the Caption
                    }
                    if ( empty( $alt ) ) {
                        $alt = $title;
                    } // Finally, use the title
                } else {
                    $title = $alt = get_bloginfo('name');
                }
                $img_atts = [
                    'class'  => $class,
                    'src'    => $p_img['url'],
                    'width'  => $p_img['width'],
                    'height' => $p_img['height'],
                    'alt'    => $alt,
                    'title'  => $title
                ];
                if(isset($p_img['srcset']) && !empty($p_img['srcset'])) $img_atts['srcset'] = $p_img['srcset'];
                if(isset($p_img['sizes']) && !empty($p_img['sizes'])) $img_atts['sizes'] = $p_img['sizes'];
                $attributes = overcome_stringify_attributes( $img_atts );
                if($show_image){
                    $overcome_image_by_size = '<img ' . $attributes . ' />';
                } else {
                    $overcome_image_by_size = '<div style="width:'.$p_img['width'].'px;height:'.$p_img['height'].'px;max-width:100%;"></div>';
                }
            }
        }

        if($echo)
            echo overcome_html($args['before'].$overcome_image_by_size.$args['after']);
        else 
            return $args['before'].$overcome_image_by_size.$args['after'];
    }
}

if(!function_exists('overcome_get_image_url_by_size')){
    function overcome_get_image_url_by_size($args = []) {
        $args = wp_parse_args($args,[
            'id'            => null, 
            'size'          => 'thumbnail', 
            'default_thumb' => false,
            'class'         => ''
        ]);
        extract($args);
        global $_wp_additional_image_sizes;
        if($id === null) $id = get_post_thumbnail_id();
        if(empty($id) && $default_thumb){
            $img_url = overcome_default_image_thumbnail_url(['size' => $size, 'class' => $args['class']]);
        } elseif ( is_string( $size ) && ( ( ! empty( $_wp_additional_image_sizes[ $size ] ) && is_array( $_wp_additional_image_sizes[ $size ] ) ) || in_array( $size, array(
                    'thumbnail',
                    'thumb',
                    'medium',
                    'medium_large',
                    'large',
                    'post-thumbnails',
                    'post-thumbnail',
                    'full',
                ) ) )
        ) {
            $p_img = wp_get_attachment_image_src( $id, $size );
            $img_url = $p_img[0];
        } else {
            if ( is_string( $size ) ) {
                preg_match_all( '/\d+/', $size, $thumb_matches );
                if ( isset( $thumb_matches[0] ) ) {
                    $size = array();
                    $count = count( $thumb_matches[0] );
                    if ( $count > 1 ) {
                        $size[] = $thumb_matches[0][0]; // width
                        $size[] = $thumb_matches[0][1]; // height
                    } elseif ( 1 === $count ) {
                        $size[] = $thumb_matches[0][0]; // width
                        $size[] = $thumb_matches[0][0]; // height
                    } else {
                        $size = false;
                    }
                }
            }
            if ( is_array( $size ) ) {
                // Resize image to custom size
                $p_img = overcome_resize_thumbnail( $id, null, $size[0], $size[1], true );

                $img_url = $p_img['url'];
            }
        }
        return $img_url;
    }
}

/**
 * Convert array of named params to string version
 * All values will be escaped
 *
 * E.g. f(array('name' => 'foo', 'id' => 'bar')) -> 'name="foo" id="bar"'
 *
 * @param $attributes
 *
 * @return string
 */
function overcome_stringify_attributes( $attributes ) {
    $atts = array();
    foreach ( $attributes as $name => $value ) {
        $atts[] = $name . '="' . esc_attr( $value ) . '"';
    }

    return implode( ' ', $atts );
}

/*
 * get image dimensions
 * return image dimensions width or height
 *
*/
if(!function_exists('overcome_image_dimensions')){
    function overcome_image_dimensions( $id = null , $size = 'medium', $dimensions = 'height', $echo = false ) {
        global $_wp_additional_image_sizes;
        if(empty($dimensions)) $dimensions = 'height';
        $unit = 'px';
        if($id === null) $id = get_post_thumbnail_id();

        if ( is_string( $size ) && ( ( ! empty( $_wp_additional_image_sizes[ $size ] ) && is_array( $_wp_additional_image_sizes[ $size ] ) ) || in_array( $size, array(
                    'thumbnail',
                    'thumb',
                    'medium',
                    'medium_large',
                    'large',
                    'full',
                ) ) )
        ) {
            $p_img = wp_get_attachment_image_src( $id, $size );
            if($dimensions === 'height'){
                $_dimensions = $p_img[2].$unit;
            }
            elseif ($dimensions === 'width'){
                $_dimensions = $p_img[1].$unit; 
            }

        } else {
            if ( is_string( $size ) ) {
                preg_match_all( '/\d+/', $size, $thumb_matches );
                if ( isset( $thumb_matches[0] ) ) {
                    $size = array();
                    $count = count( $thumb_matches[0] );
                    if ( $count > 1 ) {
                        $size[] = $thumb_matches[0][0]; // width
                        $size[] = $thumb_matches[0][1]; // height
                    } elseif ( 1 === $count ) {
                        $size[] = $thumb_matches[0][0]; // width
                        $size[] = $thumb_matches[0][0]; // height
                    } else {
                        $size = false;
                    }
                }
            }
            if ( is_array( $size ) ) {
                if($dimensions === 'height'){
                    $_dimensions = $size[1].$unit;
                }
                elseif ($dimensions === 'width'){
                    $_dimensions = $size[0].$unit; 
                }
            }
        }
        if($echo)
            echo esc_attr($_dimensions);
        else 
            return $_dimensions;
    }
}