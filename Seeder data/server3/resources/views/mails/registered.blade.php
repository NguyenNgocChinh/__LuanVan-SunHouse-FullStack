
<body style="font-family: sans-serif;">
<div style="display: block; margin: auto; max-width: 600px;" class="main">
    <h1 style="font-size: 18px; font-weight: bold; margin-top: 20px">
        Xin chào {{ $name }}!</h1>
    <p>Chào mừng bạn đã trở thành thành viên của website bất động sản <b>SUNHOUSE</b>. </p>
    <img alt="Get Started" src="https://lh3.googleusercontent.com/oAplksnsLGvxhMYt7zj_eKm4hJ6xGFjJqWRhWcSaoNBahl3wLfPSMnmp53jLkdz-v3Ws6neN3nuBdMP5ho-QUyHu-vcXtrYEddXZNC8KJL5S_Ps678VF3VhJmdyEiU8IvT-VbyHsILTRphwRYGts9tMYGI093uRN1kbXlGVif-E3aqUV-kfBjZ85lS-N79I8Zuc9z68KoWuzBO3LhwHIiv6oyCu8BuRdHppw75j0ev14-1NkT_ONLXwSwXW0mToLXSQQqmsPl5tIm_ic_19-IQBSI0o09FDjF4mKA6kRKagDAnnUvwwdlQ2gCo0sTP_PzxWIiEM4ne-xPQg2xwu6n0H8mbNzcmlm6ut3NvX2NDuzyv43EWImqKohuMIQaxsOOWkG9lFcWlTVjn6LjZHdwp4kR-JmuPB84ype13PHDt-DXi1mHYNyZ-xvATRnI_jC7Z38AO0p3gkikQFekZ0CdWDkw09hobENyZEyEks_DRB1u9NZgsHUFwPX6giJBx37Mz3Q4lG5QHVtpAqAG5sWpYt7DMCu5xX-pmq6xxByr_mkEBqsnf8zfTZwvZR6HBMBXK-1kIHgeGkQaFBXL1vchO_0bv786dIYTtXtWi4rCyY3AplkeQJvim5R-mN9__uYtW47v8NfqE36IfLc2RRIVha-TEeFrvIrBjd_YuvSf7DGyHvsdTm-fV887CfdxrQ8rRe5RWKG1kuceTS7YgTk7Kob=w1104-h524-no?authuser=0"
         style="width: 100%;">
    <p>Bạn có thể nhận được thông báo qua Email nếu để lại cho hệ thống tiêu chí tìm kiếm của bạn!</p>
    <p>Cảm ơn và chúc bạn làm việc thuận lợi.</p>
    <div class="items-center">
        <a href="{{ env('CLIENT_BASE_URL'), 'http://localhost:3000'}}"><button>Nhấn để chuyển đến SUNHOUSE</button></a>
    </div>
</div>
<style>
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
</body>
