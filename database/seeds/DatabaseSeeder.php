<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

       /* $statuses = array(
            array('status_name'=>'Pending'),
            array('status_name'=>'Accept'),
            array('status_name'=>'Cancel'),
            array('status_name'=>'Delivered'),
            array('status_name'=>"Can\'t Deliver"),
        );

        \App\StatusList::insert($statuses);*/


        \App\User::create([
                'name' => "Motiur",
                'user_name' => "memotiur",
                'phone' => "01717849968",
                'email' => "memotiur@gmail.com",
                'user_type' => "1",
                'profile_pic' => 'user.jpg',
                'password' => Hash::make('123456'),
            ]
        );






/*
        $divisions = array(
            array('division_id' => '1','en_name' => 'Chattagram','bn_name' => 'চট্টগ্রাম','url' => 'www.chittagongdiv.gov.bd'),
            array('division_id' => '2','en_name' => 'Rajshahi','bn_name' => 'রাজশাহী','url' => 'www.rajshahdivision_idiv.gov.bd'),
            array('division_id' => '3','en_name' => 'Khulna','bn_name' => 'খুলনা','url' => 'www.khulnadiv.gov.bd'),
            array('division_id' => '4','en_name' => 'Barisal','bn_name' => 'বরিশাল','url' => 'www.barisaldiv.gov.bd'),
            array('division_id' => '5','en_name' => 'Sylhet','bn_name' => 'সিলেট','url' => 'www.sylhetdiv.gov.bd'),
            array('division_id' => '6','en_name' => 'Dhaka','bn_name' => 'ঢাকা','url' => 'www.dhakadiv.gov.bd'),
            array('division_id' => '7','en_name' => 'Rangpur','bn_name' => 'রংপুর','url' => 'www.rangpurdiv.gov.bd'),
            array('division_id' => '8','en_name' => 'Mymensingh','bn_name' => 'ময়মনসিংহ','url' => 'www.mymensinghdiv.gov.bd')
        );
        \App\Division::insert($divisions);

        $this->call(DistrictSeeder::class);
        $this->call(UpazilaSeeder::class);
        $this->call(UnionSeeder::class);*/
    }
}
