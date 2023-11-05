<?php

namespace Database\Seeders;

use App\Mail\MailNotify;
use App\Mail\SendMail;
use App\Models\User\SinhVien;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Log;
use Mail;

class SendMaiSinhVienLopThiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sinh_viens = SinhVien::whereHas('lopThis', function ($query) {
            $query->where('ngay_thi', '2023-11-05');
        })->whereNotNull('email')->orderBy('mssv');
        // $sinh_viens = SinhVien::whereNotNull('email');
        $count = $sinh_viens->count();
        $current = 0;
        $sinh_viens->chunk(10, function ($items) use (&$current, $count) {
            try {
                $info_email =
                    "SEND MAIL NOTIFY - MSSV: " .  $items->pluck('mssv')->join(',') .  "  - DATE: " . Carbon::now()->format('Y-m-d-hh-mm-ss');

                Log::channel('email')->debug($info_email);
                Mail::to($items)
                    ->send(new MailNotify([
                        "title" => "<<khẩn>>Yêu cầu đối với sinh viên không có giấy tờ khi thi",
                        "subtitle" => "Yêu cầu đối với sinh viên không có giấy tờ khi thi",
                        "content" => "Các bạn sinh viên thi ngày 5/11 nếu không có giấy tờ thì cần có mặt tại D3-106 trước kíp thi 25 phút để làm các thủ tục xác nhận thi"
                    ]));
            } catch (\Throwable $th) {
                print("error:" . $items->pluck('mssv')->join(','));
            }
            $current += $items->count();
            print("$current/$count\n");
            sleep(1);
        });
        print("end\n");
    }
}
