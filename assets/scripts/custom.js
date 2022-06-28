document.addEventListener("DOMContentLoaded", function () {
  const SidebarLimitElement = () => {};
  SidebarLimitElement();

  setTimeout(() => {
    setCanvasBgStyle();
    scrollToPersonalize();
    custom_fpd_attr();
  }, 800);
});

function setCanvasBgStyle() {
  let bg_element = document.querySelector(".fpd-main-wrapper");

  if (!bg_element) {
    return false;
  }
  bg_element.classList.add("is-custom");
}

function scrollToPersonalize() {
  let btn = document.querySelector(".button-personalize-fpd ");

  if (!btn) {
    return false;
  }

  btn.addEventListener("click", () => {
    let target = document.querySelector(".custom-product-designer");
    const margin = window.innerWidth * 0.1 < 80 ? window.innerWidth * 0.1 : 80;
    var rect = target.getBoundingClientRect();

    scroll({
      top: rect.top - margin,
      behavior: "smooth",
    });
  });
}

function custom_fpd_attr() {
  let wrapper = document.querySelector(".fpd-product-checkout-form");
  if (!wrapper) {
    return false;
  }

  let buttons = wrapper.querySelectorAll("button");
  let select_variant = wrapper.querySelector('select[name="variant"]');
  let variants_wrappers = wrapper.querySelectorAll("[data-variant]");

  console.log(variants_wrappers);

  buttons.forEach((e) => {
    e.addEventListener("click", (evt) => {
      evt.preventDefault();
      for (let item in e.dataset) {
        let select = document.querySelector('select[name="' + item + '"]');
        if (select) {
          select.value = e.dataset[item];
          select.dispatchEvent(new Event("change", { bubbles: true }));
          // jQuery option: $('select[name="'+item+'"]').val( e.dataset[item] ).change();
        }
      }

      buttons.forEach((btn) => {
        btn.classList.remove("is-active");
      });
      e.classList.add("is-active");
    });
  });

  select_variant.addEventListener("change", (e) => {
    let value = e.target.value;
    let is_active = false;
    let woo_select = document.querySelector('select[name="attribute_rozmiar"]');
    console.log(woo_select);

    variants_wrappers.forEach((item) => {
      const element_data = item.dataset.variant;
      if (element_data == value && !is_active) {
        item.classList.add("active");
        is_active = true;
      } else {
        item.classList.remove("active");
      }
    });

    if (woo_select) {
      woo_select.value = value;
      console.log(woo_select.value);
      woo_select.dispatchEvent(new Event("change", { bubbles: true }));
    }
  });

  function requiredVariations() {
    const variant = document.querySelector('select[name="variant"]');
    const addToCart = document.querySelector(".single_add_to_cart_button");

    if (variant) {
      variant.required = true;
      addToCart.classList.add("wc-variation-selection-needed");

      addToCart.addEventListener("click", (e) => {
        if (!variant.value) {
          alert("Wybierz opcje produktu przed dodaniem go do koszyka.");
        }
      });
    }
  }
  requiredVariations();
}
