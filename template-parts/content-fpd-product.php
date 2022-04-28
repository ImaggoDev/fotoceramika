<?php
    $id = $args['id'];
    $addon_btn = get_field('addon-btn', $id);
    $delivery = get_field('delivery-time', $id);
?>

<div class="fpd-addons">

    <button class="button button-personalize-fpd" data-open-personalize>
        <?= __('Personalizuj', 'fotoceramika') ?>
    </button>

    <div class="fpd-addons__wrapper">
    <?php
        if( have_rows('product-checklist', $id) ):
            echo "<ul class='fpd-addons__list'>";
            while ( have_rows('product-checklist', $id) ) : the_row();
                $text = get_sub_field('text');
                echo "<li>$text</li>";
            endwhile;
            echo "</ul>";
        endif;
    ?>

    <div class="fpd-addons__bottom">
        <?php if($addon_btn && is_array($addon_btn)): ?>
            <a href="<?= $addon_btn['link'] ?>" class="button"><?= $addon_btn['title'] ?></a>
        <?php endif; ?>

        <?php if($delivery): ?>
            <div class="delivery-time">
                <img src="<?= get_stylesheet_directory_uri() ?>/assets/icons/truck.svg" alt="<?= __('Dostawa', 'fotoceramika') ?>">
                <div class="delivery-time__text">
                    <?= __('Wysyłka', 'fotoceramika') ?>
                    <span>
                        <?=  $delivery ?>
                    </span>
                </div>
            </div>
        <?php endif; ?>
    </div>
    </div>

</div>
