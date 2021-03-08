//ADD LIST THANH PHO
var thanhpho = $.ajax({
    url: "/api/ThanhPho",
    success: function (data) {
        var thanhpho = document.getElementById('thanhpho');
        data.forEach(item => {
            var option = document.createElement("option");
            option.innerHTML = item['name'];
            option.setAttribute('data-id', item['matp']);
            option.setAttribute('value', item['matp']);
            thanhpho.append(option);
        })
    }
})
//ADD LIST QUAN
var flag = false
var thanhpho = document.getElementById('thanhpho');
thanhpho.addEventListener('change', function () {
    if (typeof thanhpho.value != 'undefined' && flag) {
        let selectQuan = document.getElementById('quan');
        selectQuan.parentNode.remove();
        let selectXa = document.getElementById('xa');
        selectXa.parentNode.remove();
    }
    if (!isNaN(thanhpho.value)) {
        $.ajax({
            url: "/api/QuanHuyen/" + thanhpho.value,
            success: function (data) {
                var selectThanhPho = document.getElementById('selectThanhPho');
                //FORM_GROUP
                var formGroup = document.createElement('div');
                formGroup.setAttribute('class', 'form-group');
                formGroup.setAttribute('id', 'selectQuan');
                //SELECT
                var selectQuan = document.createElement('select');
                selectQuan.setAttribute('class', 'form-control');
                selectQuan.setAttribute('id', 'quan');
                selectQuan.setAttribute('name', 'vitri[]');
                selectQuan.setAttribute('style', 'background-image: none');

                var firstItem = data[0]['maqh'];
                data.forEach(item => {
                    var option = document.createElement("option");
                    option.innerHTML = item['name'];
                    option.setAttribute('data-id', item['maqh']);
                    option.setAttribute('value', item['maqh']);
                    selectQuan.append(option);
                })
                formGroup.appendChild(selectQuan)

                selectThanhPho.parentNode.insertBefore(formGroup, selectThanhPho.nextSibling);
                flag = true;
                return firstItem;
            },
            error: function () {

            }
        }).then(firstItem => {
            getXa(firstItem[0]['maqh']);
            //Tạo tọa độ X,Y
            setTimeout(async function () {
                let totalAddress = $('#xa option:selected').text() + " - " + $('#quan option:selected').text() + " - " + $('#thanhpho option:selected').text();
                let addressObject = await getAdressByAddress(totalAddress);
                if (typeof addressObject == "undefined") return;
                let address = await processAddress(addressObject);
                processToaDo(addressObject)
                $('#diachi').attr('value', address)
            }, 500)
        })
    }
});


//ADD XA
thanhpho.addEventListener('blur', function () {
    if (!isNaN(thanhpho.value)) {
        var quan = document.getElementById('quan');
        quan.addEventListener('change', function () {
            let selectXa = document.getElementById('xa');
            if (selectXa == "undefined" || selectXa != null) {
                selectXa.parentNode.remove();
            }
        })
        quan.addEventListener('change', function () {
            getXa(quan.value)
        });
    }
})


//FUNC GET XA
function getXa(id) {
    $.ajax({
        url: "/api/XaPhuong/" + id,
        success: function (data) {
            var selectQuan = document.getElementById('selectQuan');
            //FORM_GROUP
            var formGroup = document.createElement('div');
            formGroup.setAttribute('class', 'form-group');
            //SELECT
            var selectXa = document.createElement('select');
            selectXa.setAttribute('class', 'form-control');
            selectXa.setAttribute('id', 'xa');
            selectXa.setAttribute('name', 'vitri[]');
            selectXa.setAttribute('style', 'background-image: none');

            data.forEach(item => {
                var option = document.createElement("option");
                option.innerHTML = item['name'];
                option.setAttribute('data-id', item['xaid']);
                option.setAttribute('value', item['xaid']);
                selectXa.append(option);
            });

            formGroup.appendChild(selectXa);

            //INPUT SO NHA
            let checkSoNha = document.getElementById('sonha');
            if (!checkSoNha) {
                var formGroupHouse = document.createElement('div');
                formGroupHouse.setAttribute('class', 'form-group');
                var house_number = document.createElement('input');
                house_number.setAttribute('placeholder', "Số nhà");
                house_number.setAttribute('class', 'form-control');
                house_number.setAttribute('type', 'number');
                house_number.setAttribute('id', 'sonha');
                house_number.setAttribute('name', 'house_number');
                house_number.setAttribute('onkeyup', 'houseNumberChange(this.value)');

                formGroupHouse.appendChild(house_number)
                selectQuan.parentNode.insertBefore(formGroupHouse, selectQuan.nextSibling);
            }

            selectQuan.parentNode.insertBefore(formGroup, selectQuan.nextSibling);
        },
        error: function () {

        }
    })
}

///SONHA CHANGE
function houseNumberChange(data) {
    let timeout = null;
    if (timeout) clearTimeout(timeout);
    timeout = setTimeout(async function () {
        let totalAddress = $('#xa option:selected').text() + " - " + $('#quan option:selected').text() + " - " + $('#thanhpho option:selected').text();
        let addressObject = await getAdressByAddress(totalAddress);
        if (typeof addressObject == "undefined") return;
        let address = await processAddress(addressObject);
        address = data + " " + address;
        console.log(address)
        processToaDo(addressObject)
        $('#diachi').attr('value', address)
        return data;
    }, 400)
}


function deleteAllElement() {
    if ($('#quan').is(function (){
        $('#quan').remove();
    }));
    if ($('#xa').is(function (){
        $('#xa').remove();
    }));
    if ($('#sonha').is(function (){
        $('#sonha').remove();
    }));
}

function resetFormSelectOptions(){
    deleteAllElement();
    $('#thanhpho').append("<option selected hidden>Chọn thành phố</option>")
}
