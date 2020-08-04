<?php

namespace App\Exports;


use App\Models\CourseRegisteredUser;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class CourseRegisteredUserExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithEvents
{

  use Exportable;

  private $course;

  public function __construct($course)
  {
    $this->course = $course;
  }

  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return CourseRegisteredUser::with([
      'course',
      'classroom',
      'registeredUser',
      'profile',
      'finalStatus'
    ])->where('course_id', $this->course['id'])->get();
  }

  /**
   * @var CourseRegisteredUser $courseRegisteredUser
   */
  public function map($courseRegisteredUser): array
  {
    return [

      $courseRegisteredUser->registeredUser->rut,
      $courseRegisteredUser->registeredUser->name,
      $courseRegisteredUser->registeredUser->last_name,
      $courseRegisteredUser->registeredUser->mother_last_name,
      $courseRegisteredUser->registeredUser->email,
      $courseRegisteredUser->classroom->description,
      $courseRegisteredUser->profile->description,
      $courseRegisteredUser->course->description
    ];
  }

  public function headings(): array
  {
    return [
      [
        'RUT',
        'NOMBRE',
        'APELLIDO PATERNO',
        'APELLIDO MATERNO',
        'CORREO ELECTRONICO',
        'AULA',
        'ROL',
        'CURSO'
      ],
    ];
  }

  // public function columnFormats(): array
  // {
  //   return [
  //     'Q' => NumberFormat::FORMAT_DATE_DDMMYYYY
  //   ];
  // }

  /**
   * @return array
   */
  public function registerEvents(): array
  {
    return [
      AfterSheet::class    => function (AfterSheet $event) {

        $styleArray = [
          'font' => [
            'bold' => true,
            'color' => ['argb' => 'FFFFFF']
          ],
          'borders' => [
            'top' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
            'bottom' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],

          'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
            'rotation' => 90,
            'startColor' => [
              'argb' => '027087',
            ],
            'endColor' => [
              'argb' => '027087',
            ],
          ],
        ];




        $cellRange = 'A1:H1'; // All headers
        // $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
        // $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
        $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
        // $event->sheet->getDelegate()->getStyle($cellRange)
        //   ->getFont()->getColor()->setARGB(Color::COLOR_RED);
        // $event->sheet->getDelegate()->mergeCells('A1:Q1');
        // $event->sheet->getDelegate()->getStyle('A1')
        //   ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $event->sheet->getDelegate()->getStyle($cellRange)
          ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
      },
    ];
  }
}
