<?php

$variation = $args['variation'];

$thumb = $variation['image_src'];

// Product size
$dimensions = $variation['dimensions'];
$dimensions_render = $dimensions['height'] ? "{$dimensions['length']}x{$dimensions['width']}x{$dimensions['height']}cm" : null;

//Product weight
$weight = $variation['weight'] ? $variation['weight_html'] : null;

$price = $variation['price_html'];


foreach ($variation['attributes'] ?? [] as $key => $attribute):
  if(!strpos($key, 'rozmiar')) { continue; }
  $name = explode('_', $key);
  $attributes_value = $attribute;
endforeach;

?>

<div class="product-info" data-variant="<?= $attributes_value ?>">

    <div class="product-info__desc">

      <?php if ($dimensions_render): ?>
          <div class="product-info__single-info">
              <p>Rozmiar cm</p>
              <small>(szerokość, głębokość, wysokość)</small>

              <div class="product-info__value">
                <?= $dimensions_render ?>
              </div>
          </div>
      <?php endif; ?>

      <?php if ($weight): ?>
          <div class="product-info__single-info">
              <div class="product-info__value">
                <?= __('Waga', 'fotoceramika') . ': ' . $weight ?>
              </div>
          </div>
      <?php endif; ?>


        <div class="product-info__single-info">
            <div class="product-info__value">

            <span> <?=  __('Cena: ', 'fotoceramika') ?> &nbsp </span>
              <b><?= $price ?></b>
            </div>
        </div>


    </div>

    <div class="product-info__thumb">
        <img src="<?= $thumb ?>" alt="">
    </div>
</div>