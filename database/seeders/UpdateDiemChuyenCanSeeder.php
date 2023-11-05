<?php

namespace Database\Seeders;

use App\Helpers\DiemChuyenCanHelper;
use App\Models\Lop\Lop;
use Illuminate\Database\Seeder;

class UpdateDiemChuyenCanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lops = Lop::where('ki_hoc', '20231')->with('sinhViens')->get();
        $count = $lops->count();
        foreach ($lops as $index => $lop) {
            $sync = [];
            foreach ($lop->sinhViens as $key => $sinh_vien) {
                $diem_chuyen_can = DiemChuyenCanHelper::tinhDiemChuyenCan($sinh_vien->id, $lop->id);
                $sync[$sinh_vien->getKey()] = ['diem' => $diem_chuyen_can];
            }
            $lop->sinhViens()->syncWithoutDetaching($sync);
            print("sll sv:" . count($sync) . "\n ");
            $index++;
            print("$index/$count update done - lop:" . $lop->ma . "\n ");
        }
    }
}
