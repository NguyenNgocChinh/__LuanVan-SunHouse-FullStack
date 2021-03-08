<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TinhThanhPhoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tinhthanhpho = array(
            array('matp' => '01','name' => 'Thành phố Hà Nội','type' => 'Thành phố Trung ương'),
            array('matp' => '02','name' => 'Tỉnh Hà Giang','type' => 'Tỉnh'),
            array('matp' => '04','name' => 'Tỉnh Cao Bằng','type' => 'Tỉnh'),
            array('matp' => '06','name' => 'Tỉnh Bắc Kạn','type' => 'Tỉnh'),
            array('matp' => '08','name' => 'Tỉnh Tuyên Quang','type' => 'Tỉnh'),
            array('matp' => '10','name' => 'Tỉnh Lào Cai','type' => 'Tỉnh'),
            array('matp' => '11','name' => 'Tỉnh Điện Biên','type' => 'Tỉnh'),
            array('matp' => '12','name' => 'Tỉnh Lai Châu','type' => 'Tỉnh'),
            array('matp' => '14','name' => 'Tỉnh Sơn La','type' => 'Tỉnh'),
            array('matp' => '15','name' => 'Tỉnh Yên Bái','type' => 'Tỉnh'),
            array('matp' => '17','name' => 'Tỉnh Hoà Bình','type' => 'Tỉnh'),
            array('matp' => '19','name' => 'Tỉnh Thái Nguyên','type' => 'Tỉnh'),
            array('matp' => '20','name' => 'Tỉnh Lạng Sơn','type' => 'Tỉnh'),
            array('matp' => '22','name' => 'Tỉnh Quảng Ninh','type' => 'Tỉnh'),
            array('matp' => '24','name' => 'Tỉnh Bắc Giang','type' => 'Tỉnh'),
            array('matp' => '25','name' => 'Tỉnh Phú Thọ','type' => 'Tỉnh'),
            array('matp' => '26','name' => 'Tỉnh Vĩnh Phúc','type' => 'Tỉnh'),
            array('matp' => '27','name' => 'Tỉnh Bắc Ninh','type' => 'Tỉnh'),
            array('matp' => '30','name' => 'Tỉnh Hải Dương','type' => 'Tỉnh'),
            array('matp' => '31','name' => 'Thành phố Hải Phòng','type' => 'Thành phố Trung ương'),
            array('matp' => '33','name' => 'Tỉnh Hưng Yên','type' => 'Tỉnh'),
            array('matp' => '34','name' => 'Tỉnh Thái Bình','type' => 'Tỉnh'),
            array('matp' => '35','name' => 'Tỉnh Hà Nam','type' => 'Tỉnh'),
            array('matp' => '36','name' => 'Tỉnh Nam Định','type' => 'Tỉnh'),
            array('matp' => '37','name' => 'Tỉnh Ninh Bình','type' => 'Tỉnh'),
            array('matp' => '38','name' => 'Tỉnh Thanh Hóa','type' => 'Tỉnh'),
            array('matp' => '40','name' => 'Tỉnh Nghệ An','type' => 'Tỉnh'),
            array('matp' => '42','name' => 'Tỉnh Hà Tĩnh','type' => 'Tỉnh'),
            array('matp' => '44','name' => 'Tỉnh Quảng Bình','type' => 'Tỉnh'),
            array('matp' => '45','name' => 'Tỉnh Quảng Trị','type' => 'Tỉnh'),
            array('matp' => '46','name' => 'Tỉnh Thừa Thiên Huế','type' => 'Tỉnh'),
            array('matp' => '48','name' => 'Thành phố Đà Nẵng','type' => 'Thành phố Trung ương'),
            array('matp' => '49','name' => 'Tỉnh Quảng Nam','type' => 'Tỉnh'),
            array('matp' => '51','name' => 'Tỉnh Quảng Ngãi','type' => 'Tỉnh'),
            array('matp' => '52','name' => 'Tỉnh Bình Định','type' => 'Tỉnh'),
            array('matp' => '54','name' => 'Tỉnh Phú Yên','type' => 'Tỉnh'),
            array('matp' => '56','name' => 'Tỉnh Khánh Hòa','type' => 'Tỉnh'),
            array('matp' => '58','name' => 'Tỉnh Ninh Thuận','type' => 'Tỉnh'),
            array('matp' => '60','name' => 'Tỉnh Bình Thuận','type' => 'Tỉnh'),
            array('matp' => '62','name' => 'Tỉnh Kon Tum','type' => 'Tỉnh'),
            array('matp' => '64','name' => 'Tỉnh Gia Lai','type' => 'Tỉnh'),
            array('matp' => '66','name' => 'Tỉnh Đắk Lắk','type' => 'Tỉnh'),
            array('matp' => '67','name' => 'Tỉnh Đắk Nông','type' => 'Tỉnh'),
            array('matp' => '68','name' => 'Tỉnh Lâm Đồng','type' => 'Tỉnh'),
            array('matp' => '70','name' => 'Tỉnh Bình Phước','type' => 'Tỉnh'),
            array('matp' => '72','name' => 'Tỉnh Tây Ninh','type' => 'Tỉnh'),
            array('matp' => '74','name' => 'Tỉnh Bình Dương','type' => 'Tỉnh'),
            array('matp' => '75','name' => 'Tỉnh Đồng Nai','type' => 'Tỉnh'),
            array('matp' => '77','name' => 'Tỉnh Bà Rịa - Vũng Tàu','type' => 'Tỉnh'),
            array('matp' => '79','name' => 'Thành phố Hồ Chí Minh','type' => 'Thành phố Trung ương'),
            array('matp' => '80','name' => 'Tỉnh Long An','type' => 'Tỉnh'),
            array('matp' => '82','name' => 'Tỉnh Tiền Giang','type' => 'Tỉnh'),
            array('matp' => '83','name' => 'Tỉnh Bến Tre','type' => 'Tỉnh'),
            array('matp' => '84','name' => 'Tỉnh Trà Vinh','type' => 'Tỉnh'),
            array('matp' => '86','name' => 'Tỉnh Vĩnh Long','type' => 'Tỉnh'),
            array('matp' => '87','name' => 'Tỉnh Đồng Tháp','type' => 'Tỉnh'),
            array('matp' => '89','name' => 'Tỉnh An Giang','type' => 'Tỉnh'),
            array('matp' => '91','name' => 'Tỉnh Kiên Giang','type' => 'Tỉnh'),
            array('matp' => '92','name' => 'Thành phố Cần Thơ','type' => 'Thành phố Trung ương'),
            array('matp' => '93','name' => 'Tỉnh Hậu Giang','type' => 'Tỉnh'),
            array('matp' => '94','name' => 'Tỉnh Sóc Trăng','type' => 'Tỉnh'),
            array('matp' => '95','name' => 'Tỉnh Bạc Liêu','type' => 'Tỉnh'),
            array('matp' => '96','name' => 'Tỉnh Cà Mau','type' => 'Tỉnh')
        );
        foreach($tinhthanhpho as $tinh)
        {
            DB::table('tinhthanhpho')->insert([
            'matp' => $tinh['matp'],
            'name' => $tinh['name'],
            'type' => $tinh['type'],
            ]);
        }
    }
}
