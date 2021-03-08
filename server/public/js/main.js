// LOADING body
$(window).on("load", function (event) {
    $(".load")
        .delay(500)
        .fadeOut("slow")
        .delay(1000)
        .queue(function () {
            $(this).remove();
        });
});
// //NAVBAR
// $(function () {
//     $(window).scroll(function () {
//         if ($(window).scrollTop() > 55) $('#navbar').addClass('navbarFixed');

//         if ($(window).scrollTop() < 56) $('#navbar').removeClass('navbarFixed');
//     });
// });
//ADVANCED SEARCH
$("#advanced__search__btn").click(function () {
    // $('#advanced__search').toggle('400');
});

// LAZYLOADING
$(function () {
    $(".lazy").Lazy({
        scrollDirection: "vertical",
        effect: "fadeIn",
        visibleOnly: true,
        onError: function (element) {
            console.log("error loading " + element.data("src"));
        },
        afterLoad: function (element) {
            console.log("loaded " + element.data("src"));
        },
        onFinishedAll: function () {
            console.log("FINISH LOAD");
        },
    });
});

//CAROUSEL BS4
$(".carousel").carousel({
    interval: false,
});

//GLIDE
try {
    const sliders = document.querySelectorAll(".glide");
    const conf = {
        type: "slider",
        autoplay: 4500,
        startAt: 0,
        perView: 3,
        gap: 40,
        forcusAt: "center",
        hoverpause: true,

        peek: {
            before: 20,
            after: 20,
        },
        breakpoints: {
            1200: {
                perView: 2,
            },
            800: {
                perView: 2,
            },
            600: {
                perView: 1,
            },
        },
    };
    sliders.forEach((item) => {
        new Glide(item, conf).mount();
    });
} catch (e) {

}

try {
    const sliders_2 = document.querySelector(".glide_2");
    const conf_2 = {
        type: "slider",
        autoplay: 4500,
        perView: 4,
        gap: 40,
        forcusAt: "center",
        hoverpause: true,

        peek: {
            before: 20,
            after: 20,
        },
        breakpoints: {
            1200: {
                perView: 3,
            },
            800: {
                perView: 2,
            },
            600: {
                perView: 1,
            },
        },
    };
    new Glide(sliders_2, conf_2).mount();
} catch (e) {
}


var count = 0;
//OUTSIDE to close modal
$(document).mouseup(function (e) {
    var container = $("#advanced__search__btn");
    var dialog = $("#advanced__search");
    var btn_submit = $("#btn-search");
    // if the target of the click isn't the container nor a descendant of the container
    if (
        !container.is(e.target) &&
        container.has(e.target).length === 0 &&
        !dialog.is(e.target) &&
        dialog.has(e.target).length === 0 &&
        !btn_submit.is(e.target) &&
        btn_submit.has(e.target).length === 0
    ) {
        dialog.hide("400");
        count = 0;
    } else {
        if (container.is(e.target)) {
            if (count % 2 == 0) {
                dialog.show("400");
            } else {
                dialog.hide("400");
            }
            count++;
        }
    }
});
/* Placeholder Typewriter */
var placeholderText = [
    "Bạn muốn tìm nhà ?",
    "TP HCM ?",
    "Căn hộ ?",
    "Chung cư ?",
    "Hà Nội ?",
];

$("#search").placeholderTypewriter({
    text: placeholderText,
});
