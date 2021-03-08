//lam tron
function intelliRound(num) {
    var len = (num + '').length;
    var fac = Math.pow(10, len - 1);
    return Math.ceil(num / fac) * fac;
}

//bankinh
$(function () {
    var url_string = window.location.href;
    var url = new URL(url_string);
    var bankinh = url.searchParams.get("bankinh");
    if (bankinh == "" || bankinh == null) bankinh = 100;

    $("#slider_bankinh").slider({
        range: "max",
        max: 100,
        value: bankinh,
        slide: function (event, ui) {
            $("#bankinh").val("0 -  " + ui.value + " km");
            $("#get_bankinh").val(ui.value);
        },
    });
    $("#bankinh").val(
        "0 - " + $("#slider_bankinh").slider("value") + " km"
    );
});
//gia
$(function () {
    if (typeof maxPrice == "undefined") maxPrice = 8000;
    else maxPrice = intelliRound(maxPrice)
    var url_string = window.location.href;
    var url = new URL(url_string);
    var gia1 = url.searchParams.get("gia1");
    var gia2 = url.searchParams.get("gia2");

    if ((gia2 === "" && gia1 === "") || (gia2 == null && gia1 == null)) {
        gia1 = 0;
        gia2 = maxPrice;
    }

    $("#slider_gia").slider({
        range: true,
        min: 0,
        max: maxPrice,
        values: [gia1, gia2],
        slide: function (event, ui) {
            $("#gia").val("Giá từ: $" + ui.values[0] + " - $" + ui.values[1]);
            $("#get_gia_1").val(ui.values[0]);

            $("#get_gia_2").val(ui.values[1]);
        },
    });
    $("#gia").val(
        "Giá từ: $" +
        $("#slider_gia").slider("values", 0) +
        " - $" +
        $("#slider_gia").slider("values", 1)
    );
});

//dien tich
$(function () {
    if (typeof maxSqrt == "undefined") maxSqrt = 5000;
    else maxSqrt =  intelliRound(maxSqrt)
    var url_string = window.location.href;
    var url = new URL(url_string);
    var dientich1 = url.searchParams.get("dientich1");
    var dientich2 = url.searchParams.get("dientich2");
    if (
        (dientich2 == "" && dientich1 == "") ||
        (dientich2 == null && dientich1 == null)
    ) {
        dientich1 = 0;
        dientich2 = maxSqrt;
    }
    $("#slider_dientich").slider({
        range: true,
        min: 0,
        max: maxSqrt,
        values: [dientich1, dientich2],
        slide: function (event, ui) {
            $("#dientich").val(
                "Diện tích từ: " + ui.values[0] + " - " + ui.values[1]
            );
            $("#get_dientich_1").val(ui.values[0]);

            $("#get_dientich_2").val(ui.values[1]);
        },
    });
    $("#dientich").val(
        "Diện tích từ: " +
        $("#slider_dientich").slider("values", 0) +
        " - " +
        $("#slider_dientich").slider("values", 1)
    );
});
