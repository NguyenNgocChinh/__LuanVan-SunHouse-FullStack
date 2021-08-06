<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body style="max-width: 600px; margin: 25px auto; font-family: sans-serif">
    <span>Xin chào, <b>{{$name}}</b></span>
    <p>Hệ thống bất động sản SUNHOUSE tìm thấy tin đăng phù hợp với nhu cầu tìm kiếm của bạn.</p>
    <p>Dưới đây là một vài mô tả:</p>
    <ul>
        <li>Người đăng tin: {{$baidang->users->name}}</li>
        <li>Tiêu đề: {{$baidang->tieude}}</li>
        <li>Giá: {{$baidang->gia}} triệu đồng</li>
        <li>Diện tích: {{$baidang->dientich}} m²</li>
        <li>Phòng ngủ: {{$baidang->sophongngu}} phòng</li>
        <li>Phòng tắm: {{$baidang->sophongtam}} phòng</li>
        <li>Hướng nhà: {{$baidang->huong}}</li>
        <li>Loại nhà: {{$baidang->loai->ten_loai}}</li>
        <li>Hình thức: {{$baidang->isChoThue ? 'Cho thuê' : 'Rao bán'}}</li>
        <li>Địa chỉ: {{$baidang->diachi}}</li>
    </ul>
    <div class="">
        <a target="_blank" href="{{ env('CLIENT_BASE_URL'), 'http://localhost:3000'}}baidang/{{$baidang->id}} "><button>Nhấn để chuyển đến tin đăng</button></a>
    </div>
</body>

<style>
    body{
        font-size: 16px;
        font-family: sans-serif;
    }
    .main {
        background-color: white;
    }
    a{
        outline: #ffffff;
        text-decoration: none;
        cursor: pointer;
    }
    a:hover {
        border-left-width: 1em;
        min-height: 2em;
    }
    ul li::marker{
        color: #43A047;
        font-size: 24px;
    }
    button{
        padding: 10px;
        outline: none;
        background-color: #43A047;
        color: #ffffff;
        border: 1px solid #ffffff;
        border-radius: 8px;
        cursor: pointer;
    }
    .items-center{
        display: flex;
        flex-flow: row;
        justify-content: center;
    }
</style>
</html>

