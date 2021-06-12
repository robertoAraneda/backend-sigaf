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
use App\Models\Classroom;
use App\Models\CourseRegisteredUser;
use App\Models\ActivityCourseRegisteredUser;
use App\Models\Activity;
use App\Models\Section;

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

    public function statusUsersClassroomChart($course_id, $classroom)
    {
        $classroom = Classroom::where('description', $classroom)->first();
        $courseRegisteredUsers = CourseRegisteredUser::join('activity_course_users', 'course_registered_users.id', 'activity_course_users.course_registered_user_id')
        ->join('activities', 'activities.id', 'activity_course_users.activity_id')
        ->join('sections', 'sections.id', 'activities.section_id')
        ->where('course_registered_users.course_id', $course_id)
        ->where('classroom_id', $classroom->id)
        ->where('sections.description', 'Renuncia')
        ->select(DB::raw('count(course_registered_users.id) as count, activity_course_users.status_moodle as status'))
        ->groupBy('activity_course_users.status_moodle')
        ->get();


        $data = $courseRegisteredUsers->map(function ($item) {
            return $item->count;
        });
        $labels = $courseRegisteredUsers->map(function ($item) {
            if ($item->status == '-') {
                return 'Activo';
            } elseif ($item->status == 'En curso') {
                return 'Renuncia en curso';
            } else {
                return 'Renunciado';
            }
        });
        $chartData  =   [
            'chartData' => [
                'datasets' => [
                 [   'data' => $data ,
                     'backgroundColor' => ['#5cb85c', '#F9A825', '#D32F2F']],
                ],
                'labels' => $labels
             ]
        ];
        return $this->response->success($chartData);
    }

    public function progressUserClassroomBySection($course_id, $classroom)
    {
        $classroom = Classroom::where('description', $classroom)->first();

        $courseRegisteredUsersGlobal = CourseRegisteredUser::where('course_id', $course_id)
        ->join('registered_users', 'course_registered_users.registered_user_id', 'registered_users.id')
        ->where('classroom_id', $classroom->id)
        ->where('is_sincronized', 1)
        ->select('course_registered_users.id', 'last_access_registered_moodle', 'rut')
        ->orderBy('course_registered_users.id')
        ->get();


        $resignActivity = Activity::join('sections', 'activities.section_id', 'sections.id')
        ->where('sections.description', 'Renuncia')
        ->where('activities.course_id', $course_id)
        ->select(
            'activities.id as activity_id',
            'activities.description as activity_description',
            'sections.description as section_description'
        )
        ->first();

        $courseRegisteredUsers = $courseRegisteredUsersGlobal->filter(function ($courseRegisteredUser, $key) use ($resignActivity) {
            $activityUser = ActivityCourseRegisteredUser::where('course_registered_user_id', $courseRegisteredUser->id)
            ->where('activity_id', $resignActivity->activity_id)
            ->first();

            return $activityUser->status_moodle != 'Finalizado';
        })->values();


        $activities = Activity::join('sections', 'activities.section_id', 'sections.id')
        ->orWhere('sections.description', 'Encuesta')
        ->orWhere('sections.description', 'Pre Test A')
        ->orWhere('sections.description', 'Pre Test B')
        ->orWhere('sections.description', 'Post Test A')
        ->orWhere('sections.description', 'Post Test B')
        ->orWhere('weighing', '>', 0)
        ->select(
            'activities.id as activity_id',
            'activities.description as activity_description',
            'sections.description as section_description',
            'activities.course_id as course_id'
        )
        ->orderBy('sections.description')
        ->get()->filter(function ($item, $key) use ($course_id) {
            return $item->course_id == $course_id;
        })->values();

        $mapped = $activities->map(function ($activity, $key) use ($courseRegisteredUsers) {
            $gradedEvaluation = 0;
            $notGradedEvaluation = 0;
            $total =0;
            $totalFormB =0;
            $totalFormA =0;

            foreach ($courseRegisteredUsers as $key => $courseRegisteredUser) {
                $activityUser = ActivityCourseRegisteredUser::where('course_registered_user_id', $courseRegisteredUser->id)
                    ->where('activity_id', $activity->activity_id)
                    ->first();

                if (is_numeric($activityUser->qualification_moodle)) {
                    $gradedEvaluation ++;
                } else {
                    $dv = explode('-', $courseRegisteredUser->rut);

                    switch ($activity->section_description) {
                         case 'Post Test B':
                            if ($dv[1] != '0') {
                                if ($dv[1] == 'K') {
                                    if ($activityUser->status_moodle == 'Finalizado') {
                                        $gradedEvaluation ++;
                                    } else {
                                        $notGradedEvaluation++;
                                    }
                                    $totalFormB++;
                                } elseif ($dv[1] % 2 != 0) {
                                    if ($activityUser->status_moodle == 'Finalizado') {
                                        $gradedEvaluation ++;
                                    } else {
                                        $notGradedEvaluation++;
                                    }
                                    $totalFormB++;
                                }
                            }
                             break;
                        case 'Pre Test B':
                            if ($dv[1] != '0') {
                                if ($dv[1] == 'K') {
                                    if ($activityUser->status_moodle == 'Finalizado') {
                                        $gradedEvaluation ++;
                                    } else {
                                        $notGradedEvaluation++;
                                    }
                                    $totalFormB++;
                                } elseif ($dv[1] % 2 != 0) {
                                    if ($activityUser->status_moodle == 'Finalizado') {
                                        $gradedEvaluation ++;
                                    } else {
                                        $notGradedEvaluation++;
                                    }
                                    $totalFormB++;
                                }
                            }
                             break;
                        case 'Post Test A':
                             if ($dv[1] != 'K') {
                                 if ($dv[1] % 2 == 0) {
                                     if ($activityUser->status_moodle == 'Finalizado') {
                                         $gradedEvaluation ++;
                                     } else {
                                         $notGradedEvaluation++;
                                     }
                                     $totalFormA++;
                                 }
                             }
                             break;
                        case 'Pre Test A':
                             if ($dv[1] != 'K') {
                                 if ($dv[1] % 2 == 0) {
                                     if ($activityUser->status_moodle == 'Finalizado') {
                                         $gradedEvaluation ++;
                                     } else {
                                         $notGradedEvaluation++;
                                     }
                                     $totalFormA++;
                                 }
                             }
                             break;
                        case 'Encuesta':
                                 if ($activity->status_moodle == 'Finalizado') {
                                     $gradedEvaluation ++;
                                 } else {
                                     $notGradedEvaluation++;
                                 }
                             break;

                        default:
                            $notGradedEvaluation++;
                            break;

                     }
                }
                $total++;
            }
            return [
                'section'   => $activity->section_description,
                'graded'    => $gradedEvaluation,
                'notGraded' => $notGradedEvaluation,
                'formA'     => $totalFormA,
                'formB'     => $totalFormB,
                'total'     => $total
            ];
        });
        $collectionMapped = collect($mapped);
        $groupedBySection = $collectionMapped->groupBy('section')->map(function ($sections, $key) {
            return [
                'total'         => array_reduce($sections->all(), function ($accumulator, $item) {
                    $accumulator += $item['total'];
                    return $accumulator;
                }, 0),
                'graded'        => array_reduce($sections->all(), function ($accumulator, $item) {
                    $accumulator += $item['graded'];
                    return $accumulator;
                }, 0),
                'notGraded'     => array_reduce($sections->all(), function ($accumulator, $item) {
                    $accumulator += $item['notGraded'];
                    return $accumulator;
                }, 0),
                'totalFormA'    => array_reduce($sections->all(), function ($accumulator, $item) {
                    $accumulator += $item['formA'];
                    return $accumulator;
                }, 0),
                'totalFormB'    => array_reduce($sections->all(), function ($accumulator, $item) {
                    $accumulator += $item['formB'];
                    return $accumulator;
                }, 0),
                'section'       => $sections[0]['section'],
            ];
        })->values();

      

        $mappedArray =  $groupedBySection->map(function ($item, $key) {
            if ($item['totalFormA'] == 0 && $item['totalFormB']== 0) {
                return  [
                    'gradedRatio' => round($item['graded'] / $item['total'] * 100, 1),
                    'notGradedRatio' => round($item['notGraded'] / $item['total'] * 100, 1),
                    'section' => $item['section']
                ];
            } else {
                if ($item['totalFormA'] > 0) {
                    return  [
                    'gradedRatio' => round($item['graded'] / $item['totalFormA'] * 100, 1),
                    'notGradedRatio' => round($item['notGraded'] / $item['totalFormA'] * 100, 1),
                       'section' => $item['section']
                    ];
                }

                if ($item['totalFormB'] > 0) {
                    return  [
                    'gradedRatio' => round($item['graded'] / $item['totalFormB'] * 100, 1),
                    'notGradedRatio' => round($item['notGraded'] / $item['totalFormB'] * 100, 1),
                    'section' => $item['section']
                    ];
                }
            }
        })->values();

        $graded = $mappedArray->map(function ($item, $key) {
            return $item['gradedRatio'];
        });

        $notGraded = $mappedArray->map(function ($item, $key) {
            return $item['notGradedRatio'];
        });

        $labels = $mappedArray->map(function ($item, $key) {
            return $item['section'];
        });

        $chartData = [
                    'chartData' => [
                            'datasets' => [
                            [   'data' => $graded ,
                                'backgroundColor' => '#5cb85c',
                                'label' => 'Realizado'
                            ],
                            [   'data' => $notGraded ,
                                'backgroundColor' => '#d32f2f',
                                'label' => 'No realizado'
                            ],
                        ],
                        'labels' => $labels
                     ]
         ];
        return $this->response->success($chartData);
    }

    public function exportConsolidateStudentReport($course_id)
    {
        $courseRegisteredUsersGlobal = CourseRegisteredUser::where('course_id', $course_id)
        ->where('is_sincronized', 1)
        ->orderBy('course_registered_users.id')
        ->with(['course', 'registeredUser', 'profile','classroom', 'activityCourseUsers.activity.section'])
        ->get();

        $courseRegisteredGrouppedByClassroom =  $courseRegisteredUsersGlobal->groupBy(function ($item, $key) {
            return $item->classroom->description;
        });

        return $courseRegisteredGrouppedByClassroom->map(function ($item, $key) {
            $tutor = $item->filter(function ($item, $key) {
                return $item->profile->description == 'Tutor';
            })->values();

            $initialEnrollment = $item->filter(function ($item, $key) {
                return $item->profile->description != 'Tutor';
            });

            $notParticipating = $initialEnrollment->filter(function ($item, $key) {
                return $item->last_access_registered_moodle == 'Nunca';
            });

            $active = 0;
            $quit = 0;
            $preTest = 0;
            $total = 0;
            $unit1 = 0;
       
            foreach ($initialEnrollment as $key => $value) {
                //return $value;

                foreach ($initialEnrollment as $key => $value) {
                    $test =  $value->activityCourseUsers->map(function ($item, $value) {
                        // return $item;
                        return [
                        'section'=> $item->activity->section->description,
                        'activity' => $item->activity->description,
                    ] ;
                    });
                    return $value;
                }

            
                foreach ($value->activityCourseUsers as $key => $value) {
                    if ($value->activity->section->description == 'Renuncia' && $value->status_moodle != 'Finalizado') {
                        $active += 1;
                    }

                    if ($value->activity->section->description == 'Renuncia' && $value->status_moodle == 'Finalizado') {
                        $quit += 1;
                    }

                    if ($value->activity->section->description == 'Pre Test A'  && $value->status_moodle == 'Finalizado') {
                        // return $value;
                        $preTest += 1;
                    }

                    if ($value->activity->section->description == 'Pre Test B'  && $value->status_moodle == 'Finalizado') {
                        $preTest += 1;
                    }
                }
                $total += 1;
            }



            return [
                'classroom' => $key,
                'tutor' => $tutor[0]->registeredUser->name. " ".$tutor[0]->registeredUser->last_name." ".$tutor[0]->registeredUser->mother_last_name,
                'initialEnrollment' =>  $initialEnrollment->count(),
                'notParticipating' => $notParticipating->count(),
                'updatedEnrollment' => $initialEnrollment->count() - $notParticipating->count(),
                'active' => $active,
                'quit' => $quit,
                'preTestCount' => $preTest,
                'preTestPercent' => round($preTest/$total * 100, 1)."%",
                'total' => $total,
                'unit1' => $unit1,
                'test' => $test
        
            ];
        });
    }

    public function progressUserClassroomByActivity($course_id, $classroom, $section)
    {
        $classroom = Classroom::where('description', $classroom)->first();
        $section = Section::where('description', $section)->first();

        $courseRegisteredUsersGlobal = CourseRegisteredUser::where('course_id', $course_id)
        ->join('registered_users', 'course_registered_users.registered_user_id', 'registered_users.id')
        ->where('classroom_id', $classroom->id)
        ->where('is_sincronized', 1)
        ->select('course_registered_users.id', 'last_access_registered_moodle', 'rut')
        ->orderBy('course_registered_users.id')
        ->get();


        $resignActivity = Activity::join('sections', 'activities.section_id', 'sections.id')
        ->where('sections.description', 'Renuncia')
        ->where('activities.course_id', $course_id)
        ->select(
            'activities.id as activity_id',
            'activities.description as activity_description',
            'sections.description as section_description'
        )
        ->first();

        $courseRegisteredUsers = $courseRegisteredUsersGlobal->filter(function ($courseRegisteredUser, $key) use ($resignActivity) {
            $activityUser = ActivityCourseRegisteredUser::where('course_registered_user_id', $courseRegisteredUser->id)
            ->where('activity_id', $resignActivity->activity_id)
            ->first();

            return $activityUser->status_moodle != 'Finalizado';
        })->values();

        $activities = Activity::join('sections', 'activities.section_id', 'sections.id')
        ->where('sections.id', $section->id)
        ->select(
            'activities.id as activity_id',
            'activities.description as activity_description',
            'sections.description as section_description',
            'activities.course_id as course_id'
        )
        ->orderBy('sections.description')
        ->get()->filter(function ($item, $key) use ($course_id) {
            return $item->course_id == $course_id;
        })->values();

        $mapped = $activities->map(function ($activity, $key) use ($courseRegisteredUsers) {
            $gradedEvaluation = 0;
            $notGradedEvaluation = 0;
            $total =0;
            $totalFormB =0;
            $totalFormA =0;

            foreach ($courseRegisteredUsers as $key => $courseRegisteredUser) {
                $activityUser = ActivityCourseRegisteredUser::where('course_registered_user_id', $courseRegisteredUser->id)
                    ->where('activity_id', $activity->activity_id)
                    ->first();

                if (is_numeric($activityUser->qualification_moodle)) {
                    $gradedEvaluation ++;
                } else {
                    $dv = explode('-', $courseRegisteredUser->rut);

                    switch ($activity->section_description) {
                         case 'Post Test B':
                            if ($dv[1] != '0') {
                                if ($dv[1] == 'K') {
                                    if ($activityUser->status_moodle == 'Finalizado') {
                                        $gradedEvaluation ++;
                                    } else {
                                        $notGradedEvaluation++;
                                    }
                                    $totalFormB++;
                                } elseif ($dv[1] % 2 != 0) {
                                    if ($activityUser->status_moodle == 'Finalizado') {
                                        $gradedEvaluation ++;
                                    } else {
                                        $notGradedEvaluation++;
                                    }
                                    $totalFormB++;
                                }
                            }
                             break;
                        case 'Pre Test B':
                            if ($dv[1] != '0') {
                                if ($dv[1] == 'K') {
                                    if ($activityUser->status_moodle == 'Finalizado') {
                                        $gradedEvaluation ++;
                                    } else {
                                        $notGradedEvaluation++;
                                    }
                                    $totalFormB++;
                                } elseif ($dv[1] % 2 != 0) {
                                    if ($activityUser->status_moodle == 'Finalizado') {
                                        $gradedEvaluation ++;
                                    } else {
                                        $notGradedEvaluation++;
                                    }
                                    $totalFormB++;
                                }
                            }
                             break;
                        case 'Post Test A':
                             if ($dv[1] != 'K') {
                                 if ($dv[1] % 2 == 0) {
                                     if ($activityUser->status_moodle == 'Finalizado') {
                                         $gradedEvaluation ++;
                                     } else {
                                         $notGradedEvaluation++;
                                     }
                                     $totalFormA++;
                                 }
                             }
                             break;
                        case 'Pre Test A':
                             if ($dv[1] != 'K') {
                                 if ($dv[1] % 2 == 0) {
                                     if ($activityUser->status_moodle == 'Finalizado') {
                                         $gradedEvaluation ++;
                                     } else {
                                         $notGradedEvaluation++;
                                     }
                                     $totalFormA++;
                                 }
                             }
                             break;
                        case 'Encuesta':
                                 if ($activity->status_moodle == 'Finalizado') {
                                     $gradedEvaluation ++;
                                 } else {
                                     $notGradedEvaluation++;
                                 }
                             break;

                        default:
                            $notGradedEvaluation++;
                            break;

                     }
                }
                $total++;
            }
            return [
                'activity'   => $activity->activity_description,
                'graded'    => $gradedEvaluation,
                'notGraded' => $notGradedEvaluation,
                'formA'     => $totalFormA,
                'formB'     => $totalFormB,
                'total'     => $total
            ];
        });

        $collectionMapped = collect($mapped);

        $mappedArray =  $mapped->map(function ($item, $key) {
            if ($item['formA'] == 0 && $item['formB']== 0) {
                return  [
                    'gradedRatio' => round($item['graded'] / $item['total'] * 100, 1),
                    'notGradedRatio' => round($item['notGraded'] / $item['total'] * 100, 1),
                    'activity' => $item['activity']
                ];
            } else {
                if ($item['formA'] > 0) {
                    return  [
                    'gradedRatio' => round($item['graded'] / $item['formA'] * 100, 1),
                    'notGradedRatio' => round($item['notGraded'] / $item['formA'] * 100, 1),
                    'activity' => $item['activity']
                    ];
                }

                if ($item['formB'] > 0) {
                    return  [
                    'gradedRatio' => round($item['graded'] / $item['formB'] * 100, 1),
                    'notGradedRatio' => round($item['notGraded'] / $item['formB'] * 100, 1),
                    'activity' => $item['activity']
                    ];
                }
            }
        })->values();

        $graded = $mappedArray->map(function ($item, $key) {
            return $item['gradedRatio'];
        });

        $notGraded = $mappedArray->map(function ($item, $key) {
            return $item['notGradedRatio'];
        });

        $labels = $mappedArray->map(function ($item, $key) {
            // return substr($item['activity'], 0, 35)."...";

            return $item['activity'];
        });

        $chartData = [
                    'chartData' => [
                            'datasets' => [
                            [   'data' => $graded ,
                                'backgroundColor' => '#5cb85c',
                                'label' => 'Realizado'
                            ],
                            [   'data' => $notGraded ,
                                'backgroundColor' => '#d32f2f',
                                'label' => 'No realizado'
                            ],
                        ],
                        'labels' => $labels
                     ]
         ];
        return $this->response->success($chartData);
    }

    public function avanceProgressUserClassroomByActivity($course_id, $classroom, $section)
    {
        $classroom = Classroom::where('description', $classroom)->first();
        $section = Section::where('description', $section)->first();

        $courseRegisteredUsersGlobal = CourseRegisteredUser::where('course_id', $course_id)
        ->join('registered_users', 'course_registered_users.registered_user_id', 'registered_users.id')
        ->where('classroom_id', $classroom->id)
        ->where('is_sincronized', 1)
        ->select('course_registered_users.id', 'last_access_registered_moodle', 'rut')
        ->orderBy('course_registered_users.id')
        ->get();


        $resignActivity = Activity::join('sections', 'activities.section_id', 'sections.id')
        ->where('sections.description', 'Renuncia')
        ->where('activities.course_id', $course_id)
        ->select(
            'activities.id as activity_id',
            'activities.description as activity_description',
            'sections.description as section_description'
        )
        ->first();

        $courseRegisteredUsers = $courseRegisteredUsersGlobal->filter(function ($courseRegisteredUser, $key) use ($resignActivity) {
            $activityUser = ActivityCourseRegisteredUser::where('course_registered_user_id', $courseRegisteredUser->id)
            ->where('activity_id', $resignActivity->activity_id)
            ->first();

            return $activityUser->status_moodle != 'Finalizado';
        })->values();


        $activities = Activity::join('sections', 'activities.section_id', 'sections.id')
        ->where('sections.id', $section->id)
        ->select(
            'activities.id as activity_id',
            'activities.description as activity_description',
            'sections.description as section_description',
            'activities.course_id as course_id'
        )
        ->orderBy('sections.description')
        ->get()->filter(function ($item, $key) use ($course_id) {
            return $item->course_id == $course_id;
        })->values();


        $mapped = $activities->map(function ($activity, $key) use ($courseRegisteredUsers) {
            $gradedEvaluation = 0;
            $notGradedEvaluation = 0;
            $total =0;
            $totalFormB =0;
            $totalFormA =0;

            foreach ($courseRegisteredUsers as $key => $courseRegisteredUser) {
                $activityUser = ActivityCourseRegisteredUser::where('course_registered_user_id', $courseRegisteredUser->id)
                    ->where('activity_id', $activity->activity_id)
                    ->first();

                $statusMoodleArray = ['Sin entrega', '-', '', 'No'];

                $dv = explode('-', $courseRegisteredUser->rut);

                switch ($activity->section_description) {
                         case 'Post Test B':
                            if ($dv[1] != '0') {
                                if ($dv[1] == 'K') {
                                    if (!in_array(trim($activityUser->status_moodle), $statusMoodleArray)) {
                                        $gradedEvaluation ++;
                                    } else {
                                        $notGradedEvaluation++;
                                    }
                                    $totalFormB++;
                                } elseif ($dv[1] % 2 != 0) {
                                    if (!in_array(trim($activityUser->status_moodle), $statusMoodleArray)) {
                                        $gradedEvaluation ++;
                                    } else {
                                        $notGradedEvaluation++;
                                    }
                                    $totalFormB++;
                                }
                            }
                             break;
                        case 'Pre Test B':
                            if ($dv[1] != '0') {
                                if ($dv[1] == 'K') {
                                    if (!in_array(trim($activityUser->status_moodle), $statusMoodleArray)) {
                                        $gradedEvaluation ++;
                                    } else {
                                        $notGradedEvaluation++;
                                    }
                                    $totalFormB++;
                                } elseif ($dv[1] % 2 != 0) {
                                    if (!in_array(trim($activityUser->status_moodle), $statusMoodleArray)) {
                                        $gradedEvaluation ++;
                                    } else {
                                        $notGradedEvaluation++;
                                    }
                                    $totalFormB++;
                                }
                            }
                             break;
                        case 'Post Test A':
                             if ($dv[1] != 'K') {
                                 if ($dv[1] % 2 == 0) {
                                     if (!in_array(trim($activityUser->status_moodle), $statusMoodleArray)) {
                                         $gradedEvaluation ++;
                                     } else {
                                         $notGradedEvaluation++;
                                     }
                                     $totalFormA++;
                                 }
                             }
                             break;
                        case 'Pre Test A':
                             if ($dv[1] != 'K') {
                                 if ($dv[1] % 2 == 0) {
                                     if (!in_array(trim($activityUser->status_moodle), $statusMoodleArray)) {
                                         $gradedEvaluation ++;
                                     } else {
                                         $notGradedEvaluation++;
                                     }
                                     $totalFormA++;
                                 }
                             }
                             break;
                        case 'Encuesta':
                                 if (!in_array(trim($activityUser->status_moodle), $statusMoodleArray)) {
                                     $gradedEvaluation ++;
                                 } else {
                                     $notGradedEvaluation++;
                                 }
                             break;

                        default:
                        if (!in_array(trim($activityUser->status_moodle), $statusMoodleArray)) {
                            $gradedEvaluation++;
                        } else {
                            $notGradedEvaluation++;
                        }
                         
                            break;

                     }
                
                $total++;
            }
            return [
                'activity'   => $activity->activity_description,
                'graded'    => $gradedEvaluation,
                'notGraded' => $notGradedEvaluation,
                'formA'     => $totalFormA,
                'formB'     => $totalFormB,
                'total'     => $total
            ];
        });
        $collectionMapped = collect($mapped);

        $mappedArray =  $mapped->map(function ($item, $key) {
            if ($item['formA'] == 0 && $item['formB']== 0) {
                return  [
                    'gradedRatio' => round($item['graded'] / $item['total'] * 100, 1),
                    'notGradedRatio' => round($item['notGraded'] / $item['total'] * 100, 1),
                    'activity' => $item['activity']
                ];
            } else {
                if ($item['formA'] > 0) {
                    return  [
                    'gradedRatio' => round($item['graded'] / $item['formA'] * 100, 1),
                    'notGradedRatio' => round($item['notGraded'] / $item['formA'] * 100, 1),
                    'activity' => $item['activity']
                    ];
                }

                if ($item['formB'] > 0) {
                    return  [
                    'gradedRatio' => round($item['graded'] / $item['formB'] * 100, 1),
                    'notGradedRatio' => round($item['notGraded'] / $item['formB'] * 100, 1),
                    'activity' => $item['activity']
                    ];
                }
            }
        })->values();

        $graded = $mappedArray->map(function ($item, $key) {
            return $item['gradedRatio'];
        });

        $notGraded = $mappedArray->map(function ($item, $key) {
            return $item['notGradedRatio'];
        });

        $labels = $mappedArray->map(function ($item, $key) {
            // return substr($item['activity'], 0, 35)."...";

            return $item['activity'];
        });


        $chartData = [
                    'chartData' => [
                            'datasets' => [
                            [   'data' => $graded ,
                                'backgroundColor' => '#5cb85c',
                                'label' => 'Realizado'
                            ],
                            [   'data' => $notGraded ,
                                'backgroundColor' => '#d32f2f',
                                'label' => 'No realizado'
                            ],
                        ],
                        'labels' => $labels
                     ]
         ];
        return $this->response->success($chartData);
    }
}
