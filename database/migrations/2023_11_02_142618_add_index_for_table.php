<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexForTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE INDEX IF NOT EXISTS ph_lop_giao_viens_lop_id ON ph_lop_giao_viens (lop_id)");
        DB::statement("CREATE INDEX IF NOT EXISTS ph_lop_giao_viens_giao_vien_id ON ph_lop_giao_viens (giao_vien_id)");

        DB::statement("CREATE INDEX IF NOT EXISTS ph_lop_sinh_viens_lop_id ON ph_lop_sinh_viens (lop_id)");
        DB::statement("CREATE INDEX IF NOT EXISTS ph_lop_sinh_viens_sinh_vien_id ON ph_lop_sinh_viens (sinh_vien_id)");

        DB::statement("CREATE INDEX IF NOT EXISTS ph_diem_danhs_lan_diem_danh_id ON ph_diem_danhs (lan_diem_danh_id)");
        DB::statement("CREATE INDEX IF NOT EXISTS ph_diem_danhs_sinh_vien_id ON ph_diem_danhs (sinh_vien_id)");
        DB::statement("CREATE INDEX IF NOT EXISTS ph_diem_danhs_lop_id ON ph_diem_danhs (lop_id)");
        DB::statement("CREATE INDEX IF NOT EXISTS ph_diem_danhs_lop_id_sinh_vien_id ON ph_diem_danhs (lop_id,sinh_vien_id)");

        DB::statement("CREATE INDEX IF NOT EXISTS ph_lop_this_lop_id ON ph_lop_this (lop_id)");

        DB::statement("CREATE INDEX IF NOT EXISTS ph_lop_thi_giao_viens_lop_thi_id ON ph_lop_thi_giao_viens (lop_thi_id)");
        DB::statement("CREATE INDEX IF NOT EXISTS ph_lop_thi_giao_viens_lop_thi_id ON ph_lop_thi_giao_viens (giao_vien_id)");

        DB::statement("CREATE INDEX IF NOT EXISTS ph_diems_lop_thi_id ON ph_diems (lop_thi_id)");
        DB::statement("CREATE INDEX IF NOT EXISTS ph_diems_sinh_vien_id ON ph_diems (sinh_vien_id)");
        DB::statement("CREATE INDEX IF NOT EXISTS ph_diems_bang_diem_id ON ph_diems (bang_diem_id)");

        DB::statement("CREATE INDEX IF NOT EXISTS d_diem_nhan_diens_bang_diem_id ON d_diem_nhan_diens (bang_diem_id)");
        DB::statement("CREATE INDEX IF NOT EXISTS d_diem_nhan_dien_lop_this_bang_diem_id ON d_diem_nhan_dien_lop_this (bang_diem_id)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
