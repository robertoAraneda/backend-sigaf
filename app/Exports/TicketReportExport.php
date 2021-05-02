<?php

namespace App\Exports;

use App\Models\TicketReportExcel;
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

class TicketReportExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithEvents
{
    use Exportable;

    private $course;

    public function __construct($course)
    {
        $this->course= $course;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return TicketReportExcel::orderBy('id')->get();
    }

    /**
     * @var TicketReportExcel $ticketReportExcel
     */
    public function map($ticketReportExcel): array
    {
        return [
            $ticketReportExcel->id,
            $ticketReportExcel->ticket_code,
            $ticketReportExcel->rut_student,
            $ticketReportExcel->name_student,
            $ticketReportExcel->lastname_student,
            $ticketReportExcel->classroom_student,
            $ticketReportExcel->last_access_moodle,
            $ticketReportExcel->source_ticket,
            $ticketReportExcel->type_ticket,
            $ticketReportExcel->motive_ticket,
            $ticketReportExcel->priority_ticket,
            $ticketReportExcel->created_user_ticket,
            $ticketReportExcel->assigned_user_ticket,
            $ticketReportExcel->status_ticket,
            $ticketReportExcel->created_at_ticket,
            $ticketReportExcel->clossed_at_ticket,
            $ticketReportExcel->age_ticket,
            $ticketReportExcel->status_ticket_detail,
            $ticketReportExcel->comment_ticket_detail,
            $ticketReportExcel->created_at_ticket_detail,
            $ticketReportExcel->created_user_ticket_detail,
            $ticketReportExcel->historical_ticket_detail,
    ];
    }

    public function headings(): array
    {
        return [
            ['REPORTE HISTÓRICO DE TICKET CURSO '.strtoupper($this->course)],
            [
                'IDENTIFICADOR',
                '',
                'ANTECEDENTES DE ALUMNO',
                '',
                '',
                '',
                '',
                'ANTECEDENTES DE TICKET',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                'ANTECEDENTES DE INTENTOS DE CONTACTO'
            ],
            [
                'N°',
                'CÓDIGO TICKET',
                'RUT',
                'NOMBRE',
                'APELLIDOS',
                'AULA',
                'ÚLTIMO ACCESO',
                'ORIGEN',
                'TIPO',
                'MOTIVO',
                'PRIORIDAD',
                'CREADOR',
                'OPERADOR',
                'ESTADO',
                'FECHA DE CREACIÓN',
                'FECHA DE CIERRE',
                'ANTIGÜEDAD',
                'ESTADO DE ÚLTIMO INTENTO',
                'COMENTARIO',
                'FECHA DE REGISTRO',
                'OPERADOR',
                'HISTÓRICO DE CONTACTOS',
            ],
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


                $cellRangeTitle = 'A1:V1'; // All instructions
                $cellRangeHeaders = 'A2:V2'; // All headers
                $cellRangeData = 'A3:V3'; //all data

                $event->sheet->getDelegate()->mergeCells('A1:V1');
                $event->sheet->getDelegate()->mergeCells('A2:B2');
                $event->sheet->getDelegate()->mergeCells('C2:G2');
                $event->sheet->getDelegate()->mergeCells('H2:Q2');
                $event->sheet->getDelegate()->mergeCells('R2:V2');

       

                $event->sheet->getDelegate()->getStyle($cellRangeTitle)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle($cellRangeHeaders)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle($cellRangeData)->getFont()->setSize(12);

                $event->sheet->getDelegate()->getStyle($cellRangeTitle)
                   ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle($cellRangeTitle)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle($cellRangeHeaders)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle($cellRangeData)->applyFromArray($styleArray);

                $event->sheet->getDelegate()->getStyle('V3:V'.$event->sheet->getDelegate()->getHighestRow())->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle('A4:V'.$event->sheet->getDelegate()->getHighestRow())->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
            },
    ];
    }
}
