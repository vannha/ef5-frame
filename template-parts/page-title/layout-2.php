<?php
if(isset($args)){
    $titles = [
        'title' => $args['title'],
        'desc'  => $args['desc']
    ];
    $show_breadcrumb = $args['show_breadcrumb'];
    $ptitle_layout = $args['ptitle_layout'];
} else {
   $titles = overcome_get_page_titles();
   $show_breadcrumb = overcome_get_opts( 'breadcrumb_on', '1' );
   $ptitle_layout = overcome_get_opts('ptitle_layout','1');
}


$pt_cls = array(
    'ef5-pagetitle',
    'ptitle-layout-'.$ptitle_layout
);
$title_css_class = ['col-12'];


if(!$show_breadcrumb) {
    $pt_cls[] = 'no-breadcrumb';
} 
if($show_breadcrumb && (!is_home() || !is_front_page())) {
    $title_css_class[] = 'col-lg-6';
}

ob_start();
    if ( $titles['title'] )
    {
        printf( '<div class="page-title h1">%s</div>', $titles['title']);
    }

    if ( $titles['desc'] )
    {
        printf( '<div class="page-desc">%s</div>', $titles['desc']);
    }

$titles_html = ob_get_clean();

if ( ! $titles_html )
{
    return;
}
?>
<div class="ef5-pagetitle-wrap">
    <div class="<?php echo implode(' ', $pt_cls);?>">
        <?php overcome_ptitle_parallax_image(); ?>
        <div class="<?php overcome_ptitle_inner_class();?>">
            <div class="row align-items-center">
                <div class="<?php echo trim(implode(' ', $title_css_class));?>">
                    <?php printf( '%s', $titles_html); ?>
                </div>
                <?php if($show_breadcrumb && (!is_home() || !is_front_page())) { ?>
                <div class="ef5-breadcrumb col-lg-6 text-lg-end">
                    <?php overcome_breadcrumb(['class'=>'h5']); ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>