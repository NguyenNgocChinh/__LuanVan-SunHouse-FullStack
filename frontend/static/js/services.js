$(document).ready(async function () {
    // let address = document.getElementById('address').text;
    let address = $('#address').text();
    const postLocate = await getPostLocation(address);
    getTruongHoc(address, postLocate);
    getBenhVien(address, postLocate);
    getNganHang(address, postLocate);
})
// Add remove loading class on body element based on Ajax request status
$(document).on({
    ajaxStart: function () {

    },
    ajaxStop: function () {
        $(".loading").parent().hide("slow");
        $(".loading").parent().remove();

    }
});


async function getTruongHoc(address, postLocate) {
    $.ajax({
        url: "https://nominatim.openstreetmap.org/?q=" + address + "[school]&addressdetails=1&format=json&limit=15&countrycodes=vn",
        method: "GET",
        type: "json",
        success: async function (data) {
            processAddNewItem(data, "truongHoc", postLocate)
        }
    });
}

async function getBenhVien(address, postLocate) {
    $.ajax({
        url: "https://nominatim.openstreetmap.org/?q=" + address + "[hospitals]&addressdetails=1&format=json&limit=15&countrycodes=vn",
        method: "GET",
        type: "json",
        success: async function (data) {
            processAddNewItem(data, "benhVien", postLocate)
        }
    });
}

async function getNganHang(address, postLocate) {
    $.ajax({
        url: "https://nominatim.openstreetmap.org/?q=" + address + "[bank]&addressdetails=1&format=json&limit=15&countrycodes=vn",
        method: "GET",
        type: "json",
        success: async function (data) {
            processAddNewItem(data, "nganHang", postLocate)
        }
    });
}

async function processAddNewItem(data, parentID, postLocate) {
    let parent = document.getElementById(parentID);

    if (data.length > 0) {
        var top10 = data.sort(function (a, b) {
            return a.importance > b.importance ? 1 : -1;
        }).slice(0, 10);

        top10.forEach(async function (item) {
            if (typeof item.address.amenity != "undefined") {
                let tr = document.createElement('tr');
                let td = document.createElement('td');
                td.innerHTML = item.address.amenity;
                let td2 = document.createElement("td");
                let schoolLocation = item.lon + "," + item.lat;
                let distance = await getDistance(postLocate, schoolLocation);
                if (distance == -1) return;
                td2.innerHTML = distance;
                tr.appendChild(td);
                tr.appendChild(td2)
                parent.appendChild(tr);
            }

        })
    } else {
        parent.setAttribute("style","text-align:center")
        parent.append("Không có Trung Tâm nào gần địa điểm này!");
    }
}

////
///////

async function getPostLocation(address) {
    let url = 'https://nominatim.openstreetmap.org/?q=' + address + '&addressdetails=1&format=json&limit=1&countrycodes=vn';
    try {
        let result = await $.ajax({
            url: url,
            method: "GET",
            type: "json",
            success: function (data) {
                return data;
            }
        })

        let x = result[0].lat;
        let y = result[0].lon;
        let lngLat = y + "," + x;
        return lngLat;
    } catch (e) {

    }
}

async function getDistance(p1, p2) {

    let url = "https://router.project-osrm.org/route/v1/driving/" + p1 + ";" + p2 + "?exclude=motorway";
    let result = await makeRequest("GET", url);
    console.log(result)
    //result = JSON.parse(result);
    console.log(typeof result)
    let distance = (result.distance / 1000).toFixed(2);
    if (distance > 10) {
        return -1;
    }
    let duration = secondsToHms(result.duration);
    let kq = distance + " km " + ", " + duration;
    return kq;
}

//LIB
async function makeRequest(method, url) {
    return new Promise(function (resolve, reject) {
        try {
            $.ajax({
                url: url,
                method: method,
                type: "json",
                success: function (data) {
                    resolve(data.routes[0]);
                }
            })
        } catch (e) {
            reject(e);
        }
    });
}

function secondsToHms(d) {
    d = Number(d);
    var h = Math.floor(d / 3600);
    var m = Math.floor(d % 3600 / 60);
    var s = Math.floor(d % 3600 % 60);

    var hDisplay = h > 0 ? h + (h == 1 ? " giờ, " : " giờ, ") : "";
    var mDisplay = m > 0 ? m + (m == 1 ? " phút, " : " phút, ") : "";
    var sDisplay = s > 0 ? s + (s == 1 ? " giây" : " giây") : "";
    return hDisplay + mDisplay + sDisplay;
}
