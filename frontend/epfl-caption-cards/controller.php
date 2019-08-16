<?php

namespace EPFL\Plugins\Gutenberg\CaptionCards;

function epfl_caption_cards_block( $data ) {
    if (!$data) return true;

    for ($i = 1; $i <= 10; $i++) {
        if (array_key_exists('title'.$i, $data)) {
            $data['title'.$i]    = sanitize_text_field($data['title'.$i]);
            $data['subtitle'.$i] = isset( $data['subtitle'.$i] ) ? sanitize_text_field( $data['subtitle'.$i] ) : '';
            $data['link'.$i]     = isset( $data['link'.$i] ) ? sanitize_text_field( $data['link'.$i] ) : '';

            if (!array_key_exists('imageId'.$i, $data)) {
                $data['imageId'.$i] = '';
            }
        }
    }

    ob_start();
?>

    <div class="container-full p-lg-5">
        <div class="row">
            <?php for($i = 1; $i <= 10; $i++): ?>
            <?php if (!empty($data['title'.$i])) : ?>
                <div class="col-sm-6 col-xl-4">
                <a href="<?php echo $data['link'.$i]; ?>" class="card card-overlay link-trapeze-horizontal">
                    <?php if (!empty($data['imageId'.$i])):
                        $image = get_post($data['imageId'.$i]);
                    ?>
                    <picture class="card-img">
                    <?php echo wp_get_attachment_image($data['imageId'.$i], 'thumbnail_16_9_large_40p', '', ['class' => 'img-fluid']) ?>
                    </picture>
                    <?php endif; ?>
                    <div class="card-img-overlay">
                    <h3 class="h4 card-title">
                        <span class="text-padded"><?php echo $data['title'.$i]; ?></span>
                    </h3>
                    <p class="h4">
                        <strong class="text-padded"><?php echo $data['subtitle'.$i]; ?></strong>
                    </p>
                    </div>
                </a>
                </div>
            <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>

<?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}