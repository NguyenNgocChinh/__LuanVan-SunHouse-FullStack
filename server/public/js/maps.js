var map = L.map("map").setView([21.02533, 105.84947], 3); //18
L.tileLayer(
    "https://api.maptiler.com/maps/streets/{z}/{x}/{y}@2x.png?key=uXpXh7cCekRxZCcvL34I",
    {
        attribution:
            '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',
        tileSize: 512,
        zoomOffset: -1,
        circlePadding: [0, 0],
        minZoom: 3,
        crossOrigin: true,
    }
).addTo(map);

// mylocate
var lc = L.control
    .locate({
        position: "topleft",
        strings: {
            title: "Cho tôi biết tôi đang ở đâu!",
        },
        flyTo: true,
        cacheLocation: true,
        locateOptions: {
            maxZoom: 19,
            enableHighAccuracy: true,
        },
    })
    .addTo(map);

//scale
L.control
    .scale({
        metric: true,
        imperial: false,
        position: "bottomleft",
    })
    .addTo(map);

//watermark
L.Control.Watermark = L.Control.extend({
    onAdd: function (map) {
        var img = L.DomUtil.create("img");
        img.src = "./favicon.svg";
        img.style.width = "150px";
        img.style.margin = "-32px -22px 0 0";
        return img;
    },
});
L.control.watermark = function (opts) {
    return new L.Control.Watermark(opts);
};
L.control.watermark({ position: "topright" }).addTo(map);

//lc.start();

//DHCNSG

// var marker = L.marker([10.7379, 106.67826]).addTo(map);
// var marker = L.marker([21.02533, 105.84947]).addTo(map);
// var marker = L.marker([10.73913, 106.67718]).addTo(map);
// var marker = L.marker([10.73708, 106.67606]).addTo(map);
var svg_red = `<svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" aria-labelledby="title"
aria-describedby="desc" role="img" xmlns:xlink="http://www.w3.org/1999/xlink">
        <path stroke-width="2"
        stroke-miterlimit="10" stroke="none" fill="#F96F5D" d="M32 2a20 20 0 0 0-20 20c0 18 20 39 20 39s20-21 20-39A20 20 0 0 0 32 2z"
        data-name="layer2" stroke-linejoin="round" stroke-linecap="round"></path>
        <circle stroke-width="2" stroke-miterlimit="10" stroke="#fff"
        fill="#fff" r="8" cy="22" cx="32" data-name="layer1" stroke-linejoin="round"
        stroke-linecap="round"></circle>
        </svg>
        `;
var iconUrl_red = "data:image/svg+xml;base64," + btoa(svg_red);
var icon_red = L.icon({
    iconUrl: iconUrl_red,
    shadowUrl: "css/images/marker-shadow.png",
    iconSize: [38, 95],
    shadowAnchor: [13, 24],
});
var svg_blue = `<svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" aria-labelledby="title"
aria-describedby="desc" role="img" xmlns:xlink="http://www.w3.org/1999/xlink">
        <path stroke-width="2"
        stroke-miterlimit="10" stroke="none" fill="#5995ED" d="M32 2a20 20 0 0 0-20 20c0 18 20 39 20 39s20-21 20-39A20 20 0 0 0 32 2z"
        data-name="layer2" stroke-linejoin="round" stroke-linecap="round"></path>
        <circle stroke-width="2" stroke-miterlimit="10" stroke="#fff"
        fill="#fff" r="8" cy="22" cx="32" data-name="layer1" stroke-linejoin="round"
        stroke-linecap="round"></circle>
        </svg>
        `;
var iconUrl_blue = "data:image/svg+xml;base64," + btoa(svg_blue);
var icon_blue = L.icon({
    iconUrl: iconUrl_blue,
    shadowUrl: "css/images/marker-shadow.png",
    iconSize: [38, 95],
    shadowAnchor: [13, 24],
});

function make_list_maker(baidangs) {
    baidangs.forEach((baidang) => {
        const isChoThue = baidang["isChoThue"];
        const link_type = isChoThue ? "thue" : "ban";
        const loai = isChoThue ? "Cho thuê" : "Rao bán";
        var popup_content = `
            <div class='info_marker'>
                <img src='../img/slide/nhabanmoi_2/h1.jpg'>
            </div>
            <a class='type_house pb-0' href='/search?type=${link_type}'><b>${baidang["ten_loai"]} - ${loai}</b></a>
            <a class='name_house' href='/baidang/${baidang["id"]}'>${baidang["tieude"]}</a>
            <a href='/baidang/${baidang["id"]}' class='address_house'>${baidang["diachi"]}</a>
            <p class='ml-0'>Phòng ngủ: ${baidang["sophongngu"]}</p>
            <p>Phòng tắm: ${baidang["sophongtam"]}</p>
            <p>Diện tích: ${baidang["dientich"]}</p>
            `;
        if (isChoThue == 1) {
            var marker = L.marker([baidang["toadoX"], baidang["toadoY"]], {
                icon: icon_blue,
            })
                .addTo(map)
                .bindPopup(popup_content);
        } else {
            var marker = L.marker([baidang["toadoX"], baidang["toadoY"]], {
                icon: icon_red,
            })
                .addTo(map)
                .bindPopup(popup_content);
        }
    });
}

function getBaiDang() {
    $.ajax({
        url: "api/HomeApi",
        success: function (data) {
            make_list_maker(data);
        },
        dataType: "JSON",
    });
}

getBaiDang();
map.scrollWheelZoom.disable();
