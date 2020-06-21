<?php

namespace App\Exports;


use App\Models\CourseRegisteredUser;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
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

class CourseRegisteredUserExport implements FromCollection, WithMapping, WithHeadings, WithColumnFormatting, ShouldAutoSize, WithEvents
{

  use Exportable;

  private $course;

  public function __construct(string $course)
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
    ])->get();
  }

  /**
   * @var CourseRegisteredUser $courseRegisteredUser
   */
  public function map($courseRegisteredUser): array
  {
    return [
      $courseRegisteredUser->classroom->description,
      $courseRegisteredUser->registeredUser->rut,
      $courseRegisteredUser->registeredUser->name,
      $courseRegisteredUser->registeredUser->last_name,
      $courseRegisteredUser->registeredUser->mother_last_name,
      $courseRegisteredUser->registeredUser->email,
      $courseRegisteredUser->registeredUser->phone,
      $courseRegisteredUser->registeredUser->mobile,
      $courseRegisteredUser->registeredUser->address,
      $courseRegisteredUser->registeredUser->city,
      $courseRegisteredUser->registeredUser->region,
      $courseRegisteredUser->registeredUser->rbd_school,
      $courseRegisteredUser->registeredUser->name_school,
      $courseRegisteredUser->registeredUser->city_school,
      $courseRegisteredUser->registeredUser->region_school,
      $courseRegisteredUser->registeredUser->phone_school,
      Date::dateTimeToExcel($courseRegisteredUser->created_at),
    ];
  }

  public function headings(): array
  {


    return [
      [$this->course],
      [
        'AULA',
        'RUT',
        'NOMBRE',
        'APELLIDO PATERNO',
        'APELLIDO MATERNO',
        'CORREO ELECTRONICO',
        'TELEFONO',
        'CELULAR',
        'DIRECCION',
        'CIUDAD',
        'REGION',
        'RBD COLEGIOl',
        'NOMBRE COLEGIO',
        'CIUDAD COLEGIO',
        'REGION COLEGIO',
        'TELEFONO COLEGIO',
        'FECHA DE CREACIÓN'
      ],

    ];
  }

  public function columnFormats(): array
  {
    return [
      'Q' => NumberFormat::FORMAT_DATE_DDMMYYYY
    ];
  }

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




        $cellRange = 'A1:W1'; // All headers
        $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
        $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
        $event->sheet->getDelegate()->getStyle('A2:W2')->getFont()->setSize(12);
        $event->sheet->getDelegate()->getStyle($cellRange)
          ->getFont()->getColor()->setARGB(Color::COLOR_RED);
        $event->sheet->getDelegate()->mergeCells('A1:Q1');
        $event->sheet->getDelegate()->getStyle('A1')
          ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $event->sheet->getDelegate()->getStyle('A2:W2')
          ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $event->sheet->getDelegate()->getStyle('A2:W2')->applyFromArray($styleArray);
      },
    ];
  }
}
