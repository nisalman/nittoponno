<?php

use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $districts = array(
            array('district_id' => '1', 'division_id' => '1', 'en_name' => 'Comilla', 'bn_name' => 'কুমিল্লা', 'lat' => '23.4682747', 'lon' => '91.1788135', 'url' => 'www.comilla.gov.bd'),
            array('district_id' => '2', 'division_id' => '1', 'en_name' => 'Feni', 'bn_name' => 'ফেনী', 'lat' => '23.023231', 'lon' => '91.3840844', 'url' => 'www.feni.gov.bd'),
            array('district_id' => '3', 'division_id' => '1', 'en_name' => 'Brahmanbaria', 'bn_name' => 'ব্রাহ্মণবাড়িয়া', 'lat' => '23.9570904', 'lon' => '91.1119286', 'url' => 'www.brahmanbaria.gov.bd'),
            array('district_id' => '4', 'division_id' => '1', 'en_name' => 'Rangamati', 'bn_name' => 'রাঙ্গামাটি', 'lat' => NULL, 'lon' => NULL, 'url' => 'www.rangamati.gov.bd'),
            array('district_id' => '5', 'division_id' => '1', 'en_name' => 'Noakhali', 'bn_name' => 'নোয়াখালী', 'lat' => '22.869563', 'lon' => '91.099398', 'url' => 'www.noakhali.gov.bd'),
            array('district_id' => '6', 'division_id' => '1', 'en_name' => 'Chandpur', 'bn_name' => 'চাঁদপুর', 'lat' => '23.2332585', 'lon' => '90.6712912', 'url' => 'www.chandpur.gov.bd'),
            array('district_id' => '7', 'division_id' => '1', 'en_name' => 'Lakshmipur', 'bn_name' => 'লক্ষ্মীপুর', 'lat' => '22.942477', 'lon' => '90.841184', 'url' => 'www.lakshmipur.gov.bd'),
            array('district_id' => '8', 'division_id' => '1', 'en_name' => 'Chattogram', 'bn_name' => 'চট্টগ্রাম', 'lat' => '22.335109', 'lon' => '91.834073', 'url' => 'www.chittagong.gov.bd'),
            array('district_id' => '9', 'division_id' => '1', 'en_name' => 'Coxsbazar', 'bn_name' => 'কক্সবাজার', 'lat' => NULL, 'lon' => NULL, 'url' => 'www.coxsbazar.gov.bd'),
            array('district_id' => '10', 'division_id' => '1', 'en_name' => 'Khagrachhari', 'bn_name' => 'খাগড়াছড়ি', 'lat' => '23.119285', 'lon' => '91.984663', 'url' => 'www.khagrachhari.gov.bd'),
            array('district_id' => '11', 'division_id' => '1', 'en_name' => 'Bandarban', 'bn_name' => 'বান্দরবান', 'lat' => '22.1953275', 'lon' => '92.2183773', 'url' => 'www.bandarban.gov.bd'),
            array('district_id' => '12', 'division_id' => '2', 'en_name' => 'Sirajganj', 'bn_name' => 'সিরাজগঞ্জ', 'lat' => '24.4533978', 'lon' => '89.7006815', 'url' => 'www.sirajganj.gov.bd'),
            array('district_id' => '13', 'division_id' => '2', 'en_name' => 'Pabna', 'bn_name' => 'পাবনা', 'lat' => '23.998524', 'lon' => '89.233645', 'url' => 'www.pabna.gov.bd'),
            array('district_id' => '14', 'division_id' => '2', 'en_name' => 'Bogura', 'bn_name' => 'বগুড়া', 'lat' => '24.8465228', 'lon' => '89.377755', 'url' => 'www.bogra.gov.bd'),
            array('district_id' => '15', 'division_id' => '2', 'en_name' => 'Rajshahi', 'bn_name' => 'রাজশাহী', 'lat' => NULL, 'lon' => NULL, 'url' => 'www.rajshahi.gov.bd'),
            array('district_id' => '16', 'division_id' => '2', 'en_name' => 'Natore', 'bn_name' => 'নাটোর', 'lat' => '24.420556', 'lon' => '89.000282', 'url' => 'www.natore.gov.bd'),
            array('district_id' => '17', 'division_id' => '2', 'en_name' => 'Joypurhat', 'bn_name' => 'জয়পুরহাট', 'lat' => NULL, 'lon' => NULL, 'url' => 'www.joypurhat.gov.bd'),
            array('district_id' => '18', 'division_id' => '2', 'en_name' => 'Chapainawabganj', 'bn_name' => 'চাঁপাইনবাবগঞ্জ', 'lat' => '24.5965034', 'lon' => '88.2775122', 'url' => 'www.chapainawabganj.gov.bd'),
            array('district_id' => '19', 'division_id' => '2', 'en_name' => 'Naogaon', 'bn_name' => 'নওগাঁ', 'lat' => NULL, 'lon' => NULL, 'url' => 'www.naogaon.gov.bd'),
            array('district_id' => '20', 'division_id' => '3', 'en_name' => 'Jashore', 'bn_name' => 'যশোর', 'lat' => '23.16643', 'lon' => '89.2081126', 'url' => 'www.jessore.gov.bd'),
            array('district_id' => '21', 'division_id' => '3', 'en_name' => 'Satkhira', 'bn_name' => 'সাতক্ষীরা', 'lat' => NULL, 'lon' => NULL, 'url' => 'www.satkhira.gov.bd'),
            array('district_id' => '22', 'division_id' => '3', 'en_name' => 'Meherpur', 'bn_name' => 'মেহেরপুর', 'lat' => '23.762213', 'lon' => '88.631821', 'url' => 'www.meherpur.gov.bd'),
            array('district_id' => '23', 'division_id' => '3', 'en_name' => 'Narail', 'bn_name' => 'নড়াইল', 'lat' => '23.172534', 'lon' => '89.512672', 'url' => 'www.narail.gov.bd'),
            array('district_id' => '24', 'division_id' => '3', 'en_name' => 'Chuadanga', 'bn_name' => 'চুয়াডাঙ্গা', 'lat' => '23.6401961', 'lon' => '88.841841', 'url' => 'www.chuadanga.gov.bd'),
            array('district_id' => '25', 'division_id' => '3', 'en_name' => 'Kushtia', 'bn_name' => 'কুষ্টিয়া', 'lat' => '23.901258', 'lon' => '89.120482', 'url' => 'www.kushtia.gov.bd'),
            array('district_id' => '26', 'division_id' => '3', 'en_name' => 'Magura', 'bn_name' => 'মাগুরা', 'lat' => '23.487337', 'lon' => '89.419956', 'url' => 'www.magura.gov.bd'),
            array('district_id' => '27', 'division_id' => '3', 'en_name' => 'Khulna', 'bn_name' => 'খুলনা', 'lat' => '22.815774', 'lon' => '89.568679', 'url' => 'www.khulna.gov.bd'),
            array('district_id' => '28', 'division_id' => '3', 'en_name' => 'Bagerhat', 'bn_name' => 'বাগেরহাট', 'lat' => '22.651568', 'lon' => '89.785938', 'url' => 'www.bagerhat.gov.bd'),
            array('district_id' => '29', 'division_id' => '3', 'en_name' => 'Jhenaidah', 'bn_name' => 'ঝিনাইদহ', 'lat' => '23.5448176', 'lon' => '89.1539213', 'url' => 'www.jhenaidah.gov.bd'),
            array('district_id' => '30', 'division_id' => '4', 'en_name' => 'Jhalakathi', 'bn_name' => 'ঝালকাঠি', 'lat' => NULL, 'lon' => NULL, 'url' => 'www.jhalakathi.gov.bd'),
            array('district_id' => '31', 'division_id' => '4', 'en_name' => 'Patuakhali', 'bn_name' => 'পটুয়াখালী', 'lat' => '22.3596316', 'lon' => '90.3298712', 'url' => 'www.patuakhali.gov.bd'),
            array('district_id' => '32', 'division_id' => '4', 'en_name' => 'Pirojpur', 'bn_name' => 'পিরোজপুর', 'lat' => NULL, 'lon' => NULL, 'url' => 'www.pirojpur.gov.bd'),
            array('district_id' => '33', 'division_id' => '4', 'en_name' => 'Barisal', 'bn_name' => 'বরিশাল', 'lat' => NULL, 'lon' => NULL, 'url' => 'www.barisal.gov.bd'),
            array('district_id' => '34', 'division_id' => '4', 'en_name' => 'Bhola', 'bn_name' => 'ভোলা', 'lat' => '22.685923', 'lon' => '90.648179', 'url' => 'www.bhola.gov.bd'),
            array('district_id' => '35', 'division_id' => '4', 'en_name' => 'Barguna', 'bn_name' => 'বরগুনা', 'lat' => NULL, 'lon' => NULL, 'url' => 'www.barguna.gov.bd'),
            array('district_id' => '36', 'division_id' => '5', 'en_name' => 'Sylhet', 'bn_name' => 'সিলেট', 'lat' => '24.8897956', 'lon' => '91.8697894', 'url' => 'www.sylhet.gov.bd'),
            array('district_id' => '37', 'division_id' => '5', 'en_name' => 'Moulvibazar', 'bn_name' => 'মৌলভীবাজার', 'lat' => '24.482934', 'lon' => '91.777417', 'url' => 'www.moulvibazar.gov.bd'),
            array('district_id' => '38', 'division_id' => '5', 'en_name' => 'Habiganj', 'bn_name' => 'হবিগঞ্জ', 'lat' => '24.374945', 'lon' => '91.41553', 'url' => 'www.habiganj.gov.bd'),
            array('district_id' => '39', 'division_id' => '5', 'en_name' => 'Sunamganj', 'bn_name' => 'সুনামগঞ্জ', 'lat' => '25.0658042', 'lon' => '91.3950115', 'url' => 'www.sunamganj.gov.bd'),
            array('district_id' => '40', 'division_id' => '6', 'en_name' => 'Narsingdi', 'bn_name' => 'নরসিংদী', 'lat' => '23.932233', 'lon' => '90.71541', 'url' => 'www.narsingdi.gov.bd'),
            array('district_id' => '41', 'division_id' => '6', 'en_name' => 'Gazipur', 'bn_name' => 'গাজীপুর', 'lat' => '24.0022858', 'lon' => '90.4264283', 'url' => 'www.gazipur.gov.bd'),
            array('district_id' => '42', 'division_id' => '6', 'en_name' => 'Shariatpur', 'bn_name' => 'শরীয়তপুর', 'lat' => NULL, 'lon' => NULL, 'url' => 'www.shariatpur.gov.bd'),
            array('district_id' => '43', 'division_id' => '6', 'en_name' => 'Narayanganj', 'bn_name' => 'নারায়ণগঞ্জ', 'lat' => '23.63366', 'lon' => '90.496482', 'url' => 'www.narayanganj.gov.bd'),
            array('district_id' => '44', 'division_id' => '6', 'en_name' => 'Tangail', 'bn_name' => 'টাঙ্গাইল', 'lat' => NULL, 'lon' => NULL, 'url' => 'www.tangail.gov.bd'),
            array('district_id' => '45', 'division_id' => '6', 'en_name' => 'Kishoreganj', 'bn_name' => 'কিশোরগঞ্জ', 'lat' => '24.444937', 'lon' => '90.776575', 'url' => 'www.kishoreganj.gov.bd'),
            array('district_id' => '46', 'division_id' => '6', 'en_name' => 'Manikganj', 'bn_name' => 'মানিকগঞ্জ', 'lat' => NULL, 'lon' => NULL, 'url' => 'www.manikganj.gov.bd'),
            array('district_id' => '47', 'division_id' => '6', 'en_name' => 'Dhaka', 'bn_name' => 'ঢাকা', 'lat' => '23.7115253', 'lon' => '90.4111451', 'url' => 'www.dhaka.gov.bd'),
            array('district_id' => '48', 'division_id' => '6', 'en_name' => 'Munshiganj', 'bn_name' => 'মুন্সিগঞ্জ', 'lat' => NULL, 'lon' => NULL, 'url' => 'www.munshiganj.gov.bd'),
            array('district_id' => '49', 'division_id' => '6', 'en_name' => 'Rajbari', 'bn_name' => 'রাজবাড়ী', 'lat' => '23.7574305', 'lon' => '89.6444665', 'url' => 'www.rajbari.gov.bd'),
            array('district_id' => '50', 'division_id' => '6', 'en_name' => 'Madaripur', 'bn_name' => 'মাদারীপুর', 'lat' => '23.164102', 'lon' => '90.1896805', 'url' => 'www.madaripur.gov.bd'),
            array('district_id' => '51', 'division_id' => '6', 'en_name' => 'Gopalganj', 'bn_name' => 'গোপালগঞ্জ', 'lat' => '23.0050857', 'lon' => '89.8266059', 'url' => 'www.gopalganj.gov.bd'),
            array('district_id' => '52', 'division_id' => '6', 'en_name' => 'Faridpur', 'bn_name' => 'ফরিদপুর', 'lat' => '23.6070822', 'lon' => '89.8429406', 'url' => 'www.faridpur.gov.bd'),
            array('district_id' => '53', 'division_id' => '7', 'en_name' => 'Panchagarh', 'bn_name' => 'পঞ্চগড়', 'lat' => '26.3411', 'lon' => '88.5541606', 'url' => 'www.panchagarh.gov.bd'),
            array('district_id' => '54', 'division_id' => '7', 'en_name' => 'Dinajpur', 'bn_name' => 'দিনাজপুর', 'lat' => '25.6217061', 'lon' => '88.6354504', 'url' => 'www.dinajpur.gov.bd'),
            array('district_id' => '55', 'division_id' => '7', 'en_name' => 'Lalmonirhat', 'bn_name' => 'লালমনিরহাট', 'lat' => NULL, 'lon' => NULL, 'url' => 'www.lalmonirhat.gov.bd'),
            array('district_id' => '56', 'division_id' => '7', 'en_name' => 'Nilphamari', 'bn_name' => 'নীলফামারী', 'lat' => '25.931794', 'lon' => '88.856006', 'url' => 'www.nilphamari.gov.bd'),
            array('district_id' => '57', 'division_id' => '7', 'en_name' => 'Gaibandha', 'bn_name' => 'গাইবান্ধা', 'lat' => '25.328751', 'lon' => '89.528088', 'url' => 'www.gaibandha.gov.bd'),
            array('district_id' => '58', 'division_id' => '7', 'en_name' => 'Thakurgaon', 'bn_name' => 'ঠাকুরগাঁও', 'lat' => '26.0336945', 'lon' => '88.4616834', 'url' => 'www.thakurgaon.gov.bd'),
            array('district_id' => '59', 'division_id' => '7', 'en_name' => 'Rangpur', 'bn_name' => 'রংপুর', 'lat' => '25.7558096', 'lon' => '89.244462', 'url' => 'www.rangpur.gov.bd'),
            array('district_id' => '60', 'division_id' => '7', 'en_name' => 'Kurigram', 'bn_name' => 'কুড়িগ্রাম', 'lat' => '25.805445', 'lon' => '89.636174', 'url' => 'www.kurigram.gov.bd'),
            array('district_id' => '61', 'division_id' => '8', 'en_name' => 'Sherpur', 'bn_name' => 'শেরপুর', 'lat' => '25.0204933', 'lon' => '90.0152966', 'url' => 'www.sherpur.gov.bd'),
            array('district_id' => '62', 'division_id' => '8', 'en_name' => 'Mymensingh', 'bn_name' => 'ময়মনসিংহ', 'lat' => NULL, 'lon' => NULL, 'url' => 'www.mymensingh.gov.bd'),
            array('district_id' => '63', 'division_id' => '8', 'en_name' => 'Jamalpur', 'bn_name' => 'জামালপুর', 'lat' => '24.937533', 'lon' => '89.937775', 'url' => 'www.jamalpur.gov.bd'),
            array('district_id' => '64', 'division_id' => '8', 'en_name' => 'Netrokona', 'bn_name' => 'নেত্রকোণা', 'lat' => '24.870955', 'lon' => '90.727887', 'url' => 'www.netrokona.gov.bd')
        );

        \App\District::insert($districts);
    }
}
