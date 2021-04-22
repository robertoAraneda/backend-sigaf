<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Http\Resources\Json\SourceTicket as JsonSourceTicket;
use App\Http\Resources\Json\Ticket as JsonTicket;
use App\Http\Resources\SourceTicketCollection;
use App\Models\Ticket;
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
        ->join('users', 'ticket_details.user_created_id', 'users.id')
        ->where('course_registered_users.course_id', $id_course)
        ->select(
            'users.name as operator',
            'status_tickets.description as status',
            'ticket_details.created_at as detail_created',
            '*'
        )
        ->get();

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
                'attemps' => $total
            ];
        })->values();

        return $this->response->success($data);
    }
}
