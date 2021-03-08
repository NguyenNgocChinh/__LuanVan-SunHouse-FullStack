//BACK_TO_TOP
window.onscroll = function () {
    scrollFunction();
};

function scrollFunction() {
    if (
        document.body.scrollTop > 30 ||
        document.documentElement.scrollTop > 30
    ) {
        document.getElementById("back__to__top__btn").style.display = "block";
    } else {
        document.getElementById("back__to__top__btn").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}
$(document).ready(function () {
    var away = false;
    $("#back__to__top__btn").click(function () {
        $("html, body").animate({ scrollTop: 0 }, 500);
    });
});
