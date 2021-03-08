function distance(lat1, lon1, lat2, lon2, unit) {
    var radlat1 = Math.PI * lat1 / 180
    var radlat2 = Math.PI * lat2 / 180
    var theta = lon1 - lon2
    var radtheta = Math.PI * theta / 180
    var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
    if (dist > 1) {
        dist = 1;
    }
    dist = Math.acos(dist)
    dist = dist * 180 / Math.PI
    dist = dist * 60 * 1.1515
    if (unit == "K") {
        dist = dist * 1.609344
    }
    if (unit == "N") {
        dist = dist * 0.8684
    }
    return dist
}

var data = $.ajax({
    url: "/api/HomeApi",
    type: "json",
    method: "GET",
    success: function (data) {

        var html = "";
        var poslat = 20;
        var poslng = 20;
        var R = 4981;
        for (var i = 0; i < data.length; i++) {
            // if this location is within (R)KM of the user, add it to the list
            if (distance(poslat, poslng, data[i].toadoX, data[i].toadoY, "K") <= R) {
                html += '<p>' + data[i].diachi + ' - ' + data[i].id + '</p>';
                //console.log(data[i])
            }
        }
        //$('#nearbystops').append(html);

    },
    error: function (data) {
        console.log(data)
    }
})

///////////SHOW BAN KINH

function toggleBanKinh() {
    var frmselectThanhPho = document.getElementById('selectThanhPho');
    var selectThanhPho = frmselectThanhPho.getElementsByTagName('select')[0];
    if ($('#switch').is(":checked")) {

        var getBanKinh = document.getElementById('get_bankinh');
        getBanKinh.setAttribute('name', 'bankinh');
        $("#get_bankinh").val($("#slider_bankinh").slider("value"));

        var banKinhWith = document.getElementById('withAddress');
        banKinhWith.setAttribute('name', 'banKinhWith');
        var banKinhWith = document.getElementById('withLocation');
        banKinhWith.setAttribute('name', 'banKinhWith');
        //Disable ComboBox Thanh Pho
        $('#selectThanhPho').hide("slow");
        selectThanhPho.setAttribute('name', '');

        $("#detailBanKinh").show("slow");

        banKinhwithMethod();
    } else {

        $("#detailBanKinh").hide("slow");
        var getBanKinh = document.getElementById('get_bankinh');
        getBanKinh.setAttribute('name', '');

        var banKinhWith = document.getElementById('withAddress');
        banKinhWith.setAttribute('name', '');
        var banKinhWith = document.getElementById('withLocation');
        banKinhWith.setAttribute('name', '');

        //Enable ComboBox Thanh Pho
        $('#selectThanhPho').show("slow");
        selectThanhPho.setAttribute('name', 'vitri[]');

        //Disable XY
        let x = document.getElementById("showLatLngAddress");
        x.innerHTML = "";
        let x2 = document.getElementById("showLatLng");
        x.innerHTML = "";
    }
}

$(document).ready(function () {
    toggleBanKinh();
})


//SELECT Theo vi tri
function banKinhwithMethod() {
    var frmselectThanhPho = document.getElementById('selectThanhPho');
    var selectThanhPho = frmselectThanhPho.getElementsByTagName('select')[0];
    //select Tim Theo Dia Diem
    if ($('#withLocation').is(":checked")) {
        //Tim theo vi tri hien tai
        $('#showLatLng').show("slow");
        $('#inputAdressR').hide("slow")
        document.getElementById('inputAdressR').removeAttribute('required')
        let x = document.getElementById("showLatLngAddress");
        x.innerHTML = "";
        getLocation();
    } else {
        //Tim theo dia chi
        $('#showLatLng').hide("slow");
        let x = document.getElementById("showLatLng");
        x.innerHTML = "";
        $('#inputAdressR').show("slow")
        //Tao o input nhap dia chi
        createElementInput('', 'inputAdressR', 'Nhập địa chỉ để tìm theo bán kính', 'showLatLngAddress')
        let inputAddress = document.getElementById('inputAdressR');
        inputAddress.setAttribute('required','required')
        let oldDiaChi = localStorage.getItem("diachi") == null ? "" : localStorage.getItem("diachi");
        inputAddress.setAttribute('placeholder',oldDiaChi);
        //get Value Input
        let timeout = null;
        inputAdressR.addEventListener('keyup', function (e) {
            let str = e.target.value;
            if (str.length > 5) {
                clearTimeout(timeout);
                timeout = setTimeout(function () {
                    $.ajax({
                        url: "https://nominatim.openstreetmap.org/?q=" + inputAdressR.value + "&addressdetails=1&format=json&limit=1&countrycodes=vn",
                        method: "GET",
                        type: "json",
                        success: function (data) {
                            try {
                                let x = data[0].lat;
                                let y = data[0].lon;
                                let display_name = data[0].display_name;

                                createInputToaDo(display_name, x, y, 'showLatLngAddress')
                            }catch (e){
                                document.getElementById('showLatLngAddress').innerHTML = "Địa chỉ nhập chưa được nhận diện"
                            }
                        },
                    })
                }, 400)
            }else{
                document.getElementById('showLatLngAddress').innerHTML = "Độ dài chuỗi quá ngắn"
            }
        })


    }
}

function getLocation() {

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        showLatLng.innerHTML = "<p>Trình duyệt không được hỗ trợ vui lòng mở trang web bằng trình duyệt khác.</p>";
    }
}

function showPosition(position) {
    try {
        let x = position.coords.latitude;
        let y = position.coords.longitude;
        $.ajax({
            url: "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat="+x+"&lon="+y,
            method: "GET",
            type: "json",
            success: function (data){
                let displayName = data.display_name;
                let x = data.lat;
                let y = data.lon;
                createInputToaDo(displayName,x,y,'showLatLng');
            }
        })
    }catch (e) {
        showLatLng.innerHTML = "Gặp sự cố trong quá trình xác định vị trí của bạn, Vui lòng thử lại"
    }
}

//LIB
function createElementInput(nameAtt, idAtt, placeholder, beforeNode) {
    if (($('#' + idAtt).length) == 0) {
        let newElementInput = document.createElement('input');
        newElementInput.setAttribute('name', nameAtt);
        newElementInput.setAttribute('id', idAtt);
        newElementInput.setAttribute('placeholder', placeholder);
        newElementInput.setAttribute('class', 'form-control');
        newElementInput.setAttribute('required', 'required')

        //Form-Group
        let formGroup = document.createElement('div');
        formGroup.setAttribute('class', 'form-group');
        //Link element
        formGroup.appendChild(newElementInput);
        //Insert to BeforeNode
        let parent = document.getElementById(beforeNode);
        parent.parentNode.insertBefore(formGroup, parent.nextSibling);
    }
}
function createInputToaDo(display_name,x,y, parentNode){
    var showLatLng = document.getElementById(parentNode);
    showLatLng.innerHTML = `<p>${display_name}</p>`;

    let inputX =  document.createElement('input');
    inputX.setAttribute('hidden','hidden');
    inputX.setAttribute('readonly','readonly');
    inputX.setAttribute('value',`${x}`);
    inputX.setAttribute('name','X');
    let inputY = document.createElement('input');
    inputY.setAttribute('hidden','hidden');
    inputY.setAttribute('readonly','readonly');
    inputY.setAttribute('value',`${y}`);
    inputY.setAttribute('name','Y');

    showLatLng.appendChild(inputX);
    showLatLng.appendChild(inputY);
}
