<?php
$product = wc_get_product($args['id']);
$type = $product->get_type();
$attr = $product->get_attribute('rozmiar');
if ($type === 'variable') {
  $variations = $product->get_available_variations();
}

$bg_desktop = get_field('bg-desktop', $args['id']);
$mobile_desktop = false;

if (get_field('is_fpd_mobile', $args['id'])) {
  $mobile_desktop = get_field('bg-mobile', $args['id']);
}
?>

<style>
    .fpd-container .fpd-main-wrapper {
        background: url(<?= $bg_desktop ?>) !important;
    }

    <?php if($mobile_desktop): ?>
    @media all and (max-width: 768px) {
        .fpd-container .fpd-main-wrapper {
            background: url(<?= $mobile_desktop ?>) !important;
            aspect-ratio: 1 / 1;
        }
    }

    <?php endif; ?>

</style>

<div class="fpd-product-checkout-form">

<div class="fpd-product-checkout-form__select">
<?php
  if ($type === 'variable' && !empty($variations)):
  $index = 0;
  $select_default_option_title = __('Wybierz rozmiar', 'fotoceramika');
  echo "<div class='select-wrapper'><select name='variant'>";
  echo "<option value='' disabled selected>{$select_default_option_title}</option>";
  foreach ($variations ?? [] as $variation):
    $attributes_text_data = '';
    $attributes_value = '';

    foreach ($variation['attributes'] ?? [] as $key => $attribute):
      if(!strpos($key, 'rozmiar')) { continue; }
      $name = explode('_', $key);
      // $attributes_text_data .= $attribute;
      $attributes_value = $attribute;
      $attributes_text_data .= ucwords($name[1] ?? '') . ' ' . $attribute;
    endforeach;

    echo "<option value='{$attributes_value}'>{$attributes_text_data}</option>";

  endforeach;
  echo "</select></div>";
  endif;
  ?>
</div>

  <div class="fpd-product-checkout-form__products">
    <?php
    if ($type === 'variable' && !empty($variations)):
      $index = 0;
      foreach ($variations ?? [] as $variation):
        ob_start();
        get_template_part('template-parts/component', 'fpd-product-variation', array('variation' => $variation));
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
      endforeach;
    endif;
    ?>

  </div>


</div>



<?php
//if ($type === 'variable' && !empty($variations)):
//  $index = 0;
//  foreach ($variations ?? [] as $variation):
//    $thumb = $variation['image_src'];
//    $attributes_text_data = '';
//    $attributes_button_value = '';
//
//    foreach ($variation['attributes'] ?? [] as $key => $attribute):
//      $name = explode('_', $key);
//      $attributes_text_data .= '<span>' . ucwords($name[1] ?? '') . ' ' . $attribute . '</span>';
//      $attributes_button_value .= 'data-' . $key . '=' . $attribute;
//    endforeach;
//
//    $css_class = ($index == 0) ? 'is-active' : '';
//    echo "<button class='$css_class' $attributes_button_value><div class='square-ratio-wrapper'><span>$attributes_text_data</span><img src='$thumb' /></div></button>";
//
//    $index++;
//  endforeach;
//endif;
//?>