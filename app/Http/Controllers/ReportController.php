<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Exports\TicketReportExport;
use App\Http\Resources\Json\SourceTicket as JsonSourceTicket;
use App\Http\Resources\Json\Ticket as JsonTicket;
use App\Http\Resources\SourceTicketCollection;
use App\Models\Ticket;
use App\Models\TicketDetail;
use App\Models\TicketReportExcel;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Property for make a response.
     *
     * @var  App\Helpers\MakeResponse  $response
     */
    protected $response;

    public function __construct(MakeResponse $makeResponse = null)
    {
        $this->response = $makeResponse;
    }

    public function sideCardReportData($id_course, $initialDate, $finalDate = null)
    {
        $carbonDate = Carbon::createFromFormat('d-m-Y', $initialDate)->format('Y-m-d');

        $ticketsAccumulate = Ticket::join('course_registered_users', 'tickets.course_registered_user_id', 'course_registered_users.id')
        ->join('status_tickets', 'tickets.status_ticket_id', 'status_tickets.id')
        ->where('course_registered_users.course_id', $id_course)
        ->where('tickets.created_at', '<', $carbonDate." 23:59:59")
        ->select(DB::raw('count(tickets.id) as count, status_tickets.description as status'))
        ->groupBy('status_tickets.description')
        ->get();

        $total = array_reduce($ticketsAccumulate->all(), function ($accumulator, $item) {
            $accumulator += $item['count'];
            return $accumulator;
        }, 0);

        $newTickets = Ticket::join('course_registered_users', 'tickets.course_registered_user_id', 'course_registered_users.id')
        ->join('status_tickets', 'tickets.status_ticket_id', 'status_tickets.id')
        ->where('course_registered_users.course_id', $id_course)
        ->whereBetween('tickets.created_at', [$carbonDate." 00:00:00", $carbonDate." 23:59:59"])
        ->count();

        $openObject = $ticketsAccumulate->filter(function ($item) {
            return $item->status == 'Abierto';
        })->values();

        $open = count($openObject) > 0 ? $openObject[0]['count'] : 0;

        $closeObject = $ticketsAccumulate->filter(function ($item) {
            return $item->status == 'Cerrado';
        })->values();

        $close = count($closeObject) > 0 ? $closeObject[0]['count'] : 0;

        $data = [
            'newTicket' => $newTickets,
            'total' => $total,
            'open' => $open,
            'close' => $close
        ];

        return $this->response->success($data);
    }

    //charts
    //*Encontrar tickets para pie chart
    public function typeTicketsReportChart($id_course, $initialDate, $finalDate = null)
    {
        $carbonDate = Carbon::createFromFormat('d-m-Y', $initialDate)->format('Y-m-d');

        $tickets = Ticket::join('course_registered_users', 'tickets.course_registered_user_id', 'course_registered_users.id')
        ->join('type_tickets', 'tickets.type_ticket_id', 'type_tickets.id')
        ->join('motive_tickets', 'tickets.motive_ticket_id', 'motive_tickets.id')
        ->join('source_tickets', 'tickets.source_ticket_id', 'source_tickets.id')
        ->join('status_tickets', 'tickets.status_ticket_id', 'status_tickets.id')
        ->join('priority_tickets', 'tickets.priority_ticket_id', 'priority_tickets.id')
        ->where('course_registered_users.course_id', $id_course)
        ->whereBetween('tickets.created_at', [$carbonDate." 00:00:00", $carbonDate." 23:59:59"])
        ->select(
            'priority_tickets.description as priority',
            'type_tickets.description as type',
            'motive_tickets.description as motive',
            'source_tickets.description as source',
            'status_tickets.description as status'
        )
        ->get();

        $priority =  $tickets->groupBy('priority')->map(function ($item, $key) {
            return [
                'label' => $key,
                'value' => count($item)
            ] ;
        })->values();
        $type =  $tickets->groupBy('type')->map(function ($item, $key) {
            return [
                'label' => $key,
                'value' => count($item)
            ] ;
        })->values();
        $motive =  $tickets->groupBy('motive')->map(function ($item, $key) {
            return [
                'label' => $key,
                'value' => count($item)
            ] ;
        })->values();

        $source =  $tickets->groupBy('source')->map(function ($item, $key) {
            return [
                'label' => $key,
                'value' => count($item)
            ] ;
        })->values();

        $status =  $tickets->groupBy('status')->map(function ($item, $key) {
            return [
                'label' => $key,
                'value' => count($item)
            ] ;
        })->values();

        $chartData =  [
            'priority' => [
                'chartData' => [
                    'datasets' => [
                    [
                        'data' => $priority->map(function ($item, $key) {
                            return $item['value'];
                        }),
                        'backgroundColor' => ['#5cb85c', '#d9534f', '#d9834f']]
                    ],
                    'labels' => $priority->map(function ($item, $key) {
                        return $item['label'];
                    })
                ]
            ],
            'type' => [
                'chartData' => [
                    'datasets' => [
                    [
                        'data' => $type->map(function ($item, $key) {
                            return $item['value'];
                        }),
                        'backgroundColor' => ['#5cb85c', '#d9534f', '#d9834f']]
                    ],
                    'labels' => $type->map(function ($item, $key) {
                        return $item['label'];
                    })
                ]
            ],
            'motive' => [
                'chartData' => [
                    'datasets' => [
                    [
                        'data' => $motive->map(function ($item, $key) {
                            return $item['value'];
                        }),
                        'backgroundColor' => ['#5cb85c', '#d9534f', '#d9834f']]
                    ],
                    'labels' => $motive->map(function ($item, $key) {
                        return $item['label'];
                    })
                ]
            ],
            'source' => [
                'chartData' => [
                    'datasets' => [
                    [
                        'data' => $source->map(function ($item, $key) {
                            return $item['value'];
                        }),
                        'backgroundColor' => ['#5cb85c', '#d9534f', '#d9834f']]
                    ],
                    'labels' => $source->map(function ($item, $key) {
                        return $item['label'];
                    })
                ]
            ],
            'status' => [
                'chartData' => [
                    'datasets' => [
                    [
                        'data' => $status->map(function ($item, $key) {
                            return $item['value'];
                        }),
                        'backgroundColor' => ['#5cb85c', '#d9534f', '#d9834f']]
                    ],
                    'labels' => $status->map(function ($item, $key) {
                        return $item['label'];
                    })
                ]
            ],

        ];
        return $this->response->success($chartData);
    }

    //table
    //*
    public function tableReport($id_course, $initialDate, $finalDate = null)
    {
        $carbonDate = Carbon::createFromFormat('d-m-Y', $initialDate)->format('Y-m-d');

        $tickets = Ticket::join('course_registered_users', 'tickets.course_registered_user_id', 'course_registered_users.id')
        ->join('status_tickets', 'tickets.status_ticket_id', 'status_tickets.id')
        ->join('ticket_details', function ($join) use ($carbonDate) {
            $join->on('tickets.id', '=', 'ticket_details.ticket_id')
                ->whereBetween('ticket_details.created_at', [$carbonDate." 00:00:00", $carbonDate." 23:59:59"]);
        })
        ->join('status_detail_tickets', 'ticket_details.status_detail_ticket_id', 'status_detail_tickets.id')
        ->join('users', 'ticket_details.user_created_id', 'users.id')
        ->where('course_registered_users.course_id', $id_course)
        ->select(
            'users.name as operator',
            'status_tickets.description as status',
            'ticket_details.created_at as detail_created',
            'status_detail_tickets.description as status_detail',
            '*'
        )
        ->get();

        $detailTickets =  $tickets->groupBy('status_detail')->map(function ($item, $key) {
            return [
                'label' => $key,
                'value' => count($item)
            ] ;
        })->values();

        $data =  $tickets->groupBy('operator')->map(function ($item, $key) {
            $collect = collect($item);

            $groupped = $collect->groupBy('ticket_code')->map(
                function ($item, $key) {
                    $status = $item->filter(function ($item) {
                        return $item->status == 'Cerrado';
                    });

                    return [
                    'value' => count($item),
                    'close' => $status->count() != 0 ? 1 : 0,
                ];
                }
            )->values();

            // dd($groupped);
        
            $total = array_reduce($groupped->all(), function ($accumulator, $item) {
                $accumulator += $item['value'];
                return $accumulator;
            }, 0);

            $close = array_reduce($groupped->all(), function ($accumulator, $item) {
                $accumulator += $item['close'];
                return $accumulator;
            }, 0);


            return [
                'operator' => $key,
                'tickets' =>count($collect->groupBy('ticket_code')->values()),
                'close' => $close,
                'attemps' => $total,
            ];
        })->values();

        return $this->response->success([
            'table' => $data,
            'chartData' => [
                'datasets' => [
                    [
                    'data' => $detailTickets->map(function ($item, $key) {
                        return $item['value'];
                    }),
                    'backgroundColor' => ['#5cb85c', '#d9534f']
                    ]
                ],
                'labels' => $detailTickets->map(function ($item, $key) {
                    return $item['label'];
                })
            ]
         ]);
    }

    public function excelTicketReport($id_course)
    {
        $current_date = Carbon::now();
        $collection = Ticket::join('course_registered_users', 'tickets.course_registered_user_id', 'course_registered_users.id')
        ->join('registered_users', 'course_registered_users.registered_user_id', 'registered_users.id')
        ->join('classrooms', 'course_registered_users.classroom_id', 'classrooms.id')
        ->join('source_tickets', 'tickets.source_ticket_id', 'source_tickets.id')
        ->join('type_tickets', 'tickets.type_ticket_id', 'type_tickets.id')
        ->join('motive_tickets', 'tickets.motive_ticket_id', 'motive_tickets.id')
        ->join('priority_tickets', 'tickets.priority_ticket_id', 'priority_tickets.id')
        ->join('users as created_users', 'tickets.user_create_id', 'created_users.id')
        ->join('users as assigned_users', 'tickets.user_assigned_id', 'assigned_users.id')
        ->join('status_tickets', 'tickets.status_ticket_id', 'status_tickets.id')
        ->where('course_registered_users.course_id', $id_course)
        ->select(
            'tickets.id as id',
            'tickets.ticket_code as ticket_code',
            'registered_users.rut as rut_student',
            'registered_users.name as name',
            'registered_users.last_name as last_name',
            'registered_users.mother_last_name as mother_last_name',
            'classrooms.description as classroom_student',
            'course_registered_users.last_access_registered_moodle as last_access_moodle',
            'source_tickets.description as source_ticket',
            'type_tickets.description as type_ticket',
            'motive_tickets.description as motive_ticket',
            'priority_tickets.description as priority_ticket',
            'created_users.name as created_user_ticket',
            'assigned_users.name as assigned_user_ticket',
            'status_tickets.description as status_ticket',
            'tickets.created_at as created_at_ticket',
            'tickets.closing_date as clossed_at_ticket'
        )
        ->orderBy('tickets.id')
        ->get();

        DB::table('ticket_report_excels')->truncate();

        foreach ($collection as $key => $value) {
            $ticket_detail = TicketDetail::join('users as created_users', 'ticket_details.user_created_id', 'created_users.id')
            ->join('status_detail_tickets', 'ticket_details.status_detail_ticket_id', 'status_detail_tickets.id')
            ->where('ticket_id', $value->id)
            ->orderByDesc('ticket_details.id')
            ->select(
                'status_detail_tickets.description as status_ticket_detail',
                'ticket_details.comment as comment_ticket_detail',
                'ticket_details.created_at as created_at_ticket_detail',
                'created_users.name as created_user_ticket_detail'
            )
            ->get();

            $ticket_detail_lenght = $ticket_detail->count();

            $clossed_date = $value->clossed_at_ticket == null ? $current_date: Carbon::createFromFormat('Y-m-d H:i:s', $value->clossed_at_ticket) ;

            $model = new TicketReportExcel();

            $model->ticket_code = $value->ticket_code;
            $model->rut_student = $value->rut_student;
            $model->name_student = $value->name;
            $model->lastname_student = $value->last_name." ".$value->mother_last_name;
            $model->classroom_student = $value->classroom_student;
            $model->source_ticket = $value->source_ticket;
            $model->type_ticket = $value->type_ticket;
            $model->motive_ticket = $value->motive_ticket;
            $model->priority_ticket = $value->priority_ticket;
            $model->last_access_moodle = $value->last_access_moodle;
            $model->created_user_ticket = $value->created_user_ticket;
            $model->assigned_user_ticket = $value->assigned_user_ticket;
            $model->status_ticket = $value->status_ticket;
            $model->created_at_ticket = $value->created_at_ticket;
            $model->clossed_at_ticket = $value->clossed_at_ticket;
            $model->age_ticket = $clossed_date->diffInDays(Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at_ticket));


            if ($ticket_detail_lenght == 0) {
                $model->status_ticket_detail = null;
                $model->comment_ticket_detail = null;
                $model->created_at_ticket_detail = null;
                $model->created_user_ticket_detail = null;
                $model->historical_ticket_detail = null;
            } elseif ($ticket_detail_lenght == 1) {
                $model->status_ticket_detail = $ticket_detail[0]->status_ticket_detail;
                $model->comment_ticket_detail = $ticket_detail[0]->comment_ticket_detail;
                $model->created_at_ticket_detail = $ticket_detail[0]->created_at_ticket_detail;
                $model->created_user_ticket_detail = $ticket_detail[0]->created_user_ticket_detail;
                $model->historical_ticket_detail = null;
            } else {
                $model->status_ticket_detail = $ticket_detail[0]->status_ticket_detail;
                $model->comment_ticket_detail = $ticket_detail[0]->comment_ticket_detail;
                $model->created_at_ticket_detail = $ticket_detail[0]->created_at_ticket_detail;
                $model->created_user_ticket_detail = $ticket_detail[0]->created_user_ticket_detail;
                $historical = '';

                foreach ($ticket_detail as $key => $value) {
                    if ($key != 0) {
                        if ($key != $ticket_detail_lenght -1) {
                            $historical .= $key.".- Estado: ".$value->status_ticket_detail.". Comentario: ". $value->comment_ticket_detail.". Operador: ".$value->created_user_ticket_detail.". Fecha: ".$value->created_at_ticket_detail.".\r\n";
                        } else {
                            $historical .= $key.".- Estado: ".$value->status_ticket_detail.". Comentario: ". $value->comment_ticket_detail.". Operador: ".$value->created_user_ticket_detail.". Fecha: ".$value->created_at_ticket_detail.".";
                        }
                    }
                }

                $model->historical_ticket_detail = $historical;
            }

            $model->save();
        }

        return response()->json(['success'=> true]);
    }

    public function downloadExcelTicketReport($course_id)
    {
        $course = Course::find($course_id);

        return (new TicketReportExport($course->description))->download('test.csv', \Maatwebsite\Excel\Excel::XLSX, [
      'Content-Type' => 'application/vnd.ms-excel',
    ]);
    }
}
