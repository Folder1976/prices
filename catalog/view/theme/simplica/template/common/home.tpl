<?php echo $header; ?>

<main role="main">
    <div class="l-home-page js-homepage-main">
        <div class="l-hp-slot-5 js-section">

<?php
$i_l = 0;
$i_m = 0;
$count_l = count($large_banners);
$count_m = count($medium_banners);

while ( $i_l < $count_l || $i_m < $count_m ) {
    
    if ( isset($large_banners[$i_l]) ) { ?>
    <?php $banner = $large_banners[$i_l]; ?>
            <!-- большой баннер. START -->
            <div class="l-homepage-hero_banner varying_block-container">
                <a href="<?php echo $banner['baner_url']; ?>">
                    <img alt="" src="/image/banners/mainpage_large/<?php echo $banner['baner_pic']; ?>" title="">
                </a>
                <?php
                    $class_baner_place = '';

                    switch ($banner['baner_place']) {
                    case 'text_right':
                        $class_baner_place = 'varying_block varying_block-padding varying_block-middle varying_block-1x3 varying_block-left_content varying_block-right ';
                        break;
                    case 'text_left':
                        $class_baner_place = 'varying_block varying_block-padding varying_block-middle varying_block-1x3 varying_block-left_content varying_block-left ';
                        break;
                    case 'text_bottom':
                        $class_baner_place = 'varying_block-padding ';
                        break;
                    case 'text_inside':
                        $class_baner_place = 'varying_block varying_block-padding varying_block-middle ';
                        break;
                    }

                    if ( !isset($banner['baner_text_color']) ) { $banner['baner_text_color'] = '#FFF'; };

                ?>
                <div class="l-homepage-hero_banner-info <?php echo $class_baner_place; ?>" style="color: <?php echo $banner['baner_text_color']?>">
                    <div class="l-homepage-hero_banner-info_title"><?php echo $banner['baner_header']?></div>
                    <div class="l-homepage-hero_banner-info_subtitle"><?php echo $banner['baner_text']?></div>
                    <a href="<?php echo $banner['baner_url']; ?>" class="l-homepage-link varying_block-btn_black"><?php echo $banner['baner_title']?></a>
                </div>
            </div>
            <!-- большой баннер. END -->
<?php
    }

    if ( isset($medium_banners[$i_m]) || isset($medium_banners[$i_m + 1])) { ?>
            <!-- два баннера. START -->
            <div class="l-homepage-hero_banner">
            <?php if ( isset($medium_banners[$i_m]) ) { ?>

                <?php
                    $class_baner_place = '';
                    $banner = $medium_banners[$i_m];

                    switch ($banner['baner_place']) {
                    case 'text_right':
                        $class_baner_place .= 'varying_block varying_block-padding varying_block-middle varying_block-1x2 varying_block-center_content varying_block-left ';
                        break;
                    case 'text_left':
                        $class_baner_place .= 'varying_block varying_block-padding varying_block-middle varying_block-1x2 varying_block-center_content varying_block-left ';
                        break;
                    case 'text_bottom':
                        $class_baner_place .= 'varying_block-padding ';
                        break;
                    case 'text_inside':
                        $class_baner_place .= 'varying_block varying_block-padding_mood_left varying_block-middle varying_block-left varying_block-1x2 varying_block-center_content ';
                        break;
                    }

                    if ( !isset($banner['baner_text_color']) ) { $banner['baner_text_color'] = '#FFF'; };

                ?>
                <div class="l-homepage-mood_banner">
                    <a href="<?php echo $banner['baner_url']; ?>">
                        <img alt="" src="/image/banners/mainpage_medium/<?php echo $banner['baner_pic']; ?>" title="">
                    </a>
                    <div class="l-homepage-hero_banner-info <?php echo $class_baner_place; ?>" style="color: <?php echo $banner['baner_text_color']?>">
                        <div class="l-homepage-title font_mood_title_left"><?php echo $banner['baner_header']?></div>
                        <div class="l-homepage-subtitle font_mood_subtitle_left"><?php echo $banner['baner_text']?></div>
                        <a href="<?php echo $banner['baner_url']; ?>" class="l-homepage-link l-homepage-link_mood_left"><?php echo $banner['baner_title']?></a>
                    </div>
                </div>
            <?php } ?>
            <?php $i_m++; ?>
            <?php if ( isset($medium_banners[$i_m]) ) { ?>
                <?php
                    $class_baner_place = '';
                    $banner = $medium_banners[$i_m];

                    switch ($banner['baner_place']) {
                    case 'text_right':
                        $class_baner_place .= 'varying_block varying_block-padding varying_block-middle varying_block-1x2 varying_block-center_content varying_block-right ';
                        break;
                    case 'text_left':
                        $class_baner_place .= 'varying_block varying_block-padding varying_block-middle varying_block-1x2 varying_block-center_content varying_block-right ';
                        break;
                    case 'text_bottom':
                        $class_baner_place .= 'varying_block-padding ';
                        break;
                    case 'text_inside':
                        $class_baner_place .= 'varying_block varying_block-padding_mood_right varying_block-middle varying_block-right varying_block-1x2 varying_block-center_content ';
                        break;
                    }

                    if ( !isset($banner['baner_text_color']) ) { $banner['baner_text_color'] = '#FFF'; };
                ?>
                <div class="l-homepage-mood_banner">
                    <a href="<?php echo $banner['baner_url']; ?>" target="_blank">
                        <img alt="" src="/image/banners/mainpage_medium/<?php echo $banner['baner_pic']; ?>" title="">
                    </a>
                    <div class="l-homepage-hero_banner-info <?php echo $class_baner_place; ?>" style="color: <?php echo $banner['baner_text_color']?>">
                        <div class="l-homepage-title font_mood_title_left"><?php echo $banner['baner_header']?></div>
                        <div class="l-homepage-subtitle font_mood_subtitle_left"><?php echo $banner['baner_text']?></div>
                        <a href="<?php echo $banner['baner_url']; ?>" class="l-homepage-link l-homepage-link_mood_left"><?php echo $banner['baner_title']?></a>
                    </div>
                </div>
            <?php } ?>
            </div>
            <!-- два баннера. END -->
<?php
    }
    $i_l++;
    $i_m++;
}
?>


        </div>
    </div>
</main>

<?php echo $footer; ?>