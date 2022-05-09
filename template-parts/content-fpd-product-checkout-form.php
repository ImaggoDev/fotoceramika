<?php
    $product = wc_get_product( $args['id']);
    $type = $product->get_type();
    $attr = $product->get_attribute( 'rozmiar' );
    if($type === 'variable') {
        $variations = $product->get_available_variations();
    }
?>

<div class="fpd-product-checkout-form">

    <?php
        if($type === 'variable' && !empty($variations)):
            $index = 0;
            foreach($variations ?? [] as $variation):
                $thumb = $variation['image_src'];
                $attributes_text_data = '';
                $attributes_button_value = '';
                foreach($variation['attributes'] ?? [] as $key => $attribute):
                    $name = explode('_', $key);
                    $attributes_text_data .= '<span>'. ucwords($name[1] ?? '') . ' ' . $attribute . '</span>';
                    $attributes_button_value .= 'data-' . $key . '=' . $attribute;
                endforeach;
                $css_class = ($index == 0) ? 'is-active' : '';
                echo "<button class='$css_class' $attributes_button_value><div class='square-ratio-wrapper'><span>$attributes_text_data</span><img src='$thumb' /></div></button>";

                $index++;
            endforeach;
        endif;
    ?>

</div>