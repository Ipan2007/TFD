<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Staff::create([
            'staff_id' => '#TFD-P001',
            'name' => 'Budi Santoso',
            'email' => 'budi_p.ratamajaya@gmail.com',
            'phone' => '081234567890',
            'position' => 'Kasir',
            'status' => 'Aktif',
            'address' => 'Jl. Merdeka No. 123, Depok'
        ]);

        Staff::create([
            'staff_id' => '#TFD-P002',
            'name' => 'Rizal Starboy',
            'email' => 'rizal.bowa@gmail.com',
            'phone' => '082345678901',
            'position' => 'Gudang',
            'status' => 'Aktif',
            'address' => 'Jl. Ahmad Yani No. 45, Depok'
        ]);

        Staff::create([
            'staff_id' => '#TFD-P003',
            'name' => 'Budi Santoso',
            'email' => 'budi_p.ratamajaya@gmail.com',
            'phone' => '081234567890',
            'position' => 'Kurir',
            'status' => 'Non-Aktif',
            'address' => 'Jl. Merdeka No. 123, Depok'
        ]);
    }
}
