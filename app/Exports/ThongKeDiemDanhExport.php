<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ThongKeDiemDanhExport implements WithEvents, WithStyles
{
    use Exportable;
    private $file = 'danh_sach_lop.xlsx';
    private $data;
    private $sub_data;
    private $headers;
    public function __construct($data, $sub_data)
    {
        $this->file = 'danh_sach_lop.xlsx';
        $this->data = $data;
        $this->sub_data = $sub_data;
        $this->headers = ['Tên giảng viên', 'Mã học phần', 'Tên học phần', 'Mã lớp', 'Loại', 'Tuần học', 'Số lần điểm danh', 'Tuần đóng điểm danh', 'Yêu cầu', 'Lệch'];
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A:J')->getFont()->setSize(14);
        $sheet->getStyle('A:J')->getFont()->setName('Times New Roman');
        $sheet->getStyle('A:J')->getFont()->getColor()->setARGB(Color::COLOR_BLACK);
        // $sheet->getStyle('A1:J1')
        //     ->getFill()
        //     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        //     ->getStartColor()
        //     ->setARGB('ffffff');
        // $sheet->getStyle('I1:J2')
        //     ->getBorders()
        //     ->getRight()
        //     ->setBorderStyle(Border::BORDER_THIN)
        //     ->setColor(new Color('D3D3D3'));
        // $sheet->getStyle('A2:J2')
        //     ->getBorders()
        //     ->getBottom()
        //     ->setBorderStyle(Border::BORDER_THIN)
        //     ->setColor(new Color('D3D3D3'));
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $title_style = [
                    'font' => [
                        'size'      =>  22,
                        'name' => 'Times New Roman',
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],

                ];
                $sub_title_style = [
                    'font' => [
                        'size'      =>  16,
                        'name' => 'Times New Roman',
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    ],
                ];

                // set cao rộng cột,hàng
                $event->sheet->getColumnDimension("A")->setWidth(40);
                $event->sheet->getRowDimension('1')->setRowHeight(60);
                $event->sheet->getColumnDimension("B")->setWidth(25);
                $event->sheet->getColumnDimension("C")->setWidth(30);
                $event->sheet->getColumnDimension("D")->setWidth(20);
                $event->sheet->getColumnDimension("E")->setWidth(15);
                $event->sheet->getColumnDimension("F")->setWidth(20);
                $event->sheet->getColumnDimension("G")->setWidth(30);
                $event->sheet->getColumnDimension("H")->setWidth(30);
                $event->sheet->getColumnDimension("I")->setWidth(15);
                $event->sheet->getColumnDimension("J")->setWidth(15);

                $event->sheet->mergeCells("A1:J1");
                $event->sheet->getDelegate()->getStyle("A1:J1")->applyFromArray($title_style);
                $event->sheet->getDelegate()->getStyle("A2:J2")->applyFromArray(['font' => ['bold' => true]]);

                // set style sub_title
                $dot = $this->sub_data['dot'];
                $ki_hoc = $this->sub_data['ki_hoc'];
                $loai = $this->sub_data['loai'] === true ? 'Đại cương' : 'Chuyên ngành';

                $event->sheet->setCellValue("A1", "Thống kê điểm danh kỳ $ki_hoc lớp $loai đợt $dot");

                for ($i = 1; $i <= 10; $i++) {
                    $col = Coordinate::stringFromColumnIndex($i);
                    $event->sheet->setCellValue("{$col}2", $this->headers[$i - 1]);
                }
                foreach ($this->data as $key => $item) {

                    $idx = $key + 3;
                    foreach ($item['giao_viens'] as $giao_vien) {
                        $event->sheet->setCellValue("A{$idx}", $giao_vien['name']);
                    }
                    $yeu_cau = $item['loai'] === 'LT+BT' || $item['loai'] == 'BT+LT' ? 2 : 1;
                    $lech = $item['count'] - $yeu_cau;
                    $event->sheet->setCellValue("B{$idx}", $item['ma_hp']);
                    $event->sheet->setCellValue("C{$idx}", $item['ten_hp']);
                    $event->sheet->setCellValue("D{$idx}", $item['ma']);
                    $event->sheet->setCellValue("E{$idx}", $item['loai']);
                    $event->sheet->setCellValue("F{$idx}", $item['tuan_hoc']);
                    $event->sheet->setCellValue("G{$idx}", $item['count']);
                    $event->sheet->setCellValue("H{$idx}", $item['tuan_dong']);
                    $event->sheet->setCellValue("I{$idx}", $yeu_cau);
                    $event->sheet->setCellValue("J{$idx}", $lech);
                };
            }
        ];
    }
}
