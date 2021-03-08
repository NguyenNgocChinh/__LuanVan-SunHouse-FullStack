$(function () {
    $("#slider-range").slider({
        range: true,
        min: 0,
        max: 8000,
        values: [0, 8000],
        slide: function (event, ui) {
            $("#amount").val(
                "Giá từ: $" + ui.values[0] + " - $" + ui.values[1]
            );
            $("#get_gia_1").val(ui.values[0]);
            $("#get_gia_2").val(ui.values[1]);
        },
    });
    $("#amount").val(
        "Giá từ: $" +
            $("#slider-range").slider("values", 0) +
            " - $" +
            $("#slider-range").slider("values", 1)
    );
});
$(function () {
    $("#slider-range_sqft").slider({
        range: true,
        min: 0,
        max: 5000,
        values: [0, 5000],
        slide: function (event, ui) {
            $("#sqft").val(
                "Diện tích từ: " + ui.values[0] + " - " + ui.values[1]
            );
            $("#get_dientich_1").val(ui.values[0]);
            $("#get_dientich_2").val(ui.values[1]);
        },
    });
    $("#sqft").val(
        "Diện tích từ: " +
            $("#slider-range_sqft").slider("values", 0) +
            " - " +
            $("#slider-range_sqft").slider("values", 1)
    );
});
