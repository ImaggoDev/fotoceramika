document.addEventListener("DOMContentLoaded", function () {


const SidebarLimitElement = () => {

}
SidebarLimitElement();


setTimeout( () => {
    setCanvasBgStyle();
    scrollToPersonalize();
    custom_fpd_attr();
}, 800);


});



function setCanvasBgStyle() {
    let bg_element = document.querySelector('.fpd-main-wrapper');

    if(!bg_element) {
        return false;
    }
    bg_element.classList.add('is-custom');
}

function scrollToPersonalize() {
    let btn = document.querySelector('.button-personalize-fpd ');

    if(!btn) {
        return false;
    }

    btn.addEventListener('click',  () => {
        let target = document.querySelector('.custom-product-designer');
        const margin = window.innerWidth * 0.1 < 80 ? window.innerWidth * 0.1 : 80;
        var rect = target.getBoundingClientRect();

        scroll({
            top: rect.top - margin,
            behavior: "smooth"
          });
    })

}

function custom_fpd_attr() {
    let wrapper = document.querySelector('.fpd-product-checkout-form');
    if(!wrapper) {
        return false;
    }

    let buttons = wrapper.querySelectorAll('button');

    buttons.forEach((e)=>{
        e.addEventListener('click', (evt) => {
            evt.preventDefault();
            for(let item in e.dataset) {
                let select = document.querySelector('select[name="'+item+'"]');
                if(select) {
                    select.value = e.dataset[item];
                    select.dispatchEvent(new Event('change',{"bubbles": true}));
                    // jQuery option: $('select[name="'+item+'"]').val( e.dataset[item] ).change();
                }
            }

            buttons.forEach((btn)=>{
                btn.classList.remove('is-active');
            })
            e.classList.add('is-active');
        })
    })
}
