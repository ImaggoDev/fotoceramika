document.addEventListener("DOMContentLoaded", function () {


const SidebarLimitElement = () => {
    console.log('re');
}
SidebarLimitElement();


setTimeout( () => {
    setCanvasBgStyle();
    scrollToPersonalize();
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
        const offsetTop = target.offsetTop;
        scroll({
            top: offsetTop + (window.innerWidth * 0.1),
            behavior: "smooth"
          });
    })

}