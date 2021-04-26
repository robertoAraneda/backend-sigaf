<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Models\Ticket;
use App\Models\TicketDetail;
use App\Models\LogEditingTicket;
use App\Models\CourseRegisteredUser;
use App\Http\Resources\Json\Ticket as JsonTicket;
use App\Http\Resources\Json\TicketDetail as JsonTicketDetail;
use App\Http\Resources\TicketCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TicketController extends Controller
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
    /**
     * Validate the description field.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    protected function validateData($request)
    {
        return Validator::make($request, [
            'course_registered_user_id' => 'required',
            'type_ticket_id' => 'required|integer',
            'status_ticket_id' => 'required|integer',
            'source_ticket_id' => 'required|integer',
            'priority_ticket_id' => 'required|integer',
            'motive_ticket_id' => 'required|integer',
            'user_create_id' => 'required|integer',
            'user_assigned_id' => 'required|integer',
            'closing_date' => 'bool',
         ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }

            $tickets = new TicketCollection(Ticket::where('status_ticket_id', 1)->orderBy('created_at', 'asc')->get());

            return $this->response->success($tickets);
        } catch (\Exception $exception) {
            return $this->response->exception($exception->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }

            $validate = $this->validateData(request()->all());

            if ($validate->fails()) {
                return $this->response->exception($validate->errors());
            }

            $ticket = new Ticket();

            $code = $this->findCurrentCorrelative(request()->course_registered_user_id);

            $ticket->course_registered_user_id = request()->course_registered_user_id;
            $ticket->type_ticket_id = request()->type_ticket_id;
            $ticket->status_ticket_id = request()->status_ticket_id;
            $ticket->source_ticket_id = request()->source_ticket_id;
            $ticket->priority_ticket_id = request()->priority_ticket_id;
            $ticket->motive_ticket_id = request()->motive_ticket_id;
            $ticket->ticket_code = $this->createTicketCode($code, 1);
            $ticket->user_create_id = auth()->id();
            $ticket->user_assigned_id = request()->user_assigned_id;


            if (isset(request()->closing_date)) {
                $ticket->closing_date = Carbon::now()->format('Y-m-d H:i:s');
            }

            $ticket->save();

            return $this->response->success($ticket->fresh()->format());
        } catch (\Exception $exception) {
            return $this->response->exception($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($ticket)
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }

            if (!is_numeric($ticket)) {
                return $this->response->badRequest();
            }

            $ticketModel = Ticket::find($ticket);

            if (!isset($ticketModel)) {
                return $this->response->noContent();
            }

            return $this->response->success($ticketModel->format());
        } catch (\Exception $exception) {
            return $this->response->exception($exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($ticket)
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }

            if (!is_numeric($ticket)) {
                return $this->response->badRequest();
            }

            $ticketModel = Ticket::find($ticket);

            if (!isset($ticketModel)) {
                return $this->response->noContent();
            }

            $validate = $this->validateData(request()->all());

            if ($validate->fails()) {
                return $this->response->exception($validate->errors());
            }

            $ticketModel->course_registered_user_id = request()->course_registered_user_id;
            $ticketModel->type_ticket_id = request()->type_ticket_id;
            $ticketModel->status_ticket_id = request()->status_ticket_id;
            $ticketModel->source_ticket_id = request()->source_ticket_id;
            $ticketModel->priority_ticket_id = request()->priority_ticket_id;
            $ticketModel->motive_ticket_id = request()->motive_ticket_id;
            $ticketModel->user_create_id = request()->user_create_id;
            $ticketModel->user_assigned_id = request()->user_assigned_id;
            $ticketModel->version = $ticketModel->version + 1;

            if (isset(request()->closing_date)) {
                $ticketModel->closing_date = Carbon::now()->format('Y-m-d H:m:s');
            }

            $ticketModel->save();

            $logTicket = LogEditingTicket::where('ticket_id', $ticket)->first();
            if (isset($logTicket)) {
                $logTicket->delete();
            }

            $ticketModelEdited = Ticket::find($ticket);

            return $this->response->success($ticketModelEdited->format());
        } catch (\Exception $exception) {
            return $this->response->exception($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($ticket)
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }

            if (!is_numeric($ticket)) {
                return $this->response->badRequest();
            }

            $ticketModel = Ticket::find($ticket);

            if (!isset($ticketModel)) {
                return $this->response->noContent();
            }


            $ticketDetail = TicketDetail::where('ticket_id', $ticket)->get();

            if (count($ticketDetail) > 0) {
                foreach ($ticketDetail  as $key => $value) {
                    $detail = TicketDetail::find($value->id);
                    $detail->delete();
                }
            }


            $ticketModel->delete();

            return $this->response->success(null);
        } catch (\Exception $exception) {
            return $this->response->exception($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyMultiple($tickets)
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }

            $ticketsId = json_decode($tickets);

            foreach ($ticketsId as $value) {
                $ticketModel = Ticket::find($value);

                $ticketDetail = TicketDetail::where('ticket_id', $value)->get();
                if (count($ticketDetail) > 0) {
                    foreach ($ticketDetail  as $key => $value) {
                        $detail = TicketDetail::find($value->id);
                        $detail->delete();
                    }
                }
                $ticketModel->delete();
            }

            return $this->response->success(null);
        } catch (\Exception $exception) {
            return $this->response->exception($exception->getMessage());
        }
    }


    /**
     * Display a list of tickets resources related to type ticket resource.
     *
     * @param  int  $type_ticket
     * @return App\Helpers\MakeResponse
     *
     * @authenticated
     * @response {
     *  "typeTicket": "typeTicket",
     *  "relationships":{
     *    "links": {"href": "url", "rel": "/rels/tickets"},
     *    "collections": {"numberOfElements": "number", "data": "array"}
     *   }
     * }
     *
     * @urlParam type_ticket required The ID of the type ticket resource.
     */
    public function ticketsDetails($ticket)
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }

            if (!is_numeric($ticket)) {
                return $this->response->badRequest();
            }

            $ticketModel = Ticket::find($ticket);


            if (!isset($ticketModel)) {
                return $this->response->noContent();
            }

            $ticketFormated = new JsonTicket($ticketModel);

            $ticketFormated->ticketsDetails = [
        'ticket' => $ticketFormated,
        'relationships' => [
          'links' => [
            'href' => route(
                'api.tickets.ticketsDetails',
                ['ticket' => $ticketFormated->id],
                false
            ),
            'rel' => '/rels/ticketsDetails'
          ],
          'collection' => [
            'numberOfElements' => $ticketFormated->ticketsDetails->count(),
            'data' => $ticketFormated->ticketsDetails->map(function ($ticketDetail) {
                return new JsonTicketDetail($ticketDetail);
            })
          ]
        ]
      ];

            return $this->response->success($ticketFormated->ticketsDetails);
        } catch (\Exception $exception) {
            return $this->response->exception($exception->getMessage());
        }
    }

    public function ticketsByCourse($id)
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }

            $tickets = [];

            $collection = DB::table('tickets')
        ->leftJoin('course_registered_users', 'course_registered_users.id', '=', 'tickets.course_registered_user_id')
        ->select('tickets.id')
        ->where('course_registered_users.course_id', $id)
        ->where('tickets.status_ticket_id', 1)
        ->orderByDesc('tickets.created_at')
        ->get();

            foreach ($collection as $key) {
                $tickets[] = Ticket::find($key->id);
            }

            $response =  new TicketCollection($tickets);

            return $this->response->success($response);
        } catch (\Exception $exception) {
            return $this->response->exception($exception->getMessage());
        }
    }

    public function getTicketByCode($code)
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }
   
            $tickets = new TicketCollection(Ticket::where('ticket_code', $code)->orderBy('created_at', 'asc')->get());

            if (!isset($tickets)) {
                return $this->response->noContent();
            }

            return $this->response->success($tickets);
        } catch (\Exception $exception) {
            return $this->response->exception($exception->getMessage());
        }
    }

    public function getTicketByOperator($operator)
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }
   
            $tickets = new TicketCollection(Ticket::where('user_assigned_id', $operator)->orderBy('created_at', 'asc')->get());

            if (!isset($tickets)) {
                return $this->response->noContent();
            }

            return $this->response->success($tickets);
        } catch (\Exception $exception) {
            return $this->response->exception($exception->getMessage());
        }
    }

    public function getTicketByRangeOfDate($initialDate, $finalDate)
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }

            $initial = Carbon::createFromFormat('Y-m-d', $initialDate)->format('Y/m/d');
            $final = Carbon::createFromFormat('Y-m-d', $finalDate)->format('Y/m/d')." 23:59:59";
   
            $tickets = new TicketCollection(Ticket::whereBetween('created_at', [$initial, $final])->orderBy('created_at', 'asc')->get());

            if (!isset($tickets)) {
                return $this->response->noContent();
            }

            return $this->response->success($tickets);
        } catch (\Exception $exception) {
            return $this->response->exception($exception->getMessage());
        }
    }


    public function storeMultiple(Request $request)
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }

            $validate = $this->validateData(request()->all());

            if ($validate->fails()) {
                return $this->response->exception($validate->errors());
            }

            $ticketStored = [];

            $code = $this->findCurrentCorrelative(request()->course_registered_user_id[0]);
    
            $increment = 1;
            foreach (request()->course_registered_user_id as $key => $value) {
                $ticket = new Ticket();

                $ticket->course_registered_user_id = $value;
                $ticket->type_ticket_id = request()->type_ticket_id;
                $ticket->status_ticket_id = request()->status_ticket_id;
                $ticket->source_ticket_id = request()->source_ticket_id;
                $ticket->priority_ticket_id = request()->priority_ticket_id;
                $ticket->motive_ticket_id = request()->motive_ticket_id;
                $ticket->ticket_code = $this->createTicketCode($code, $increment);
                $ticket->user_create_id = auth()->id();
                $ticket->user_assigned_id = request()->user_assigned_id;

                if (isset(request()->closing_date)) {
                    $ticket->closing_date = Carbon::now()->format('Y-m-d H:i:s');
                }
                $ticket->save();
                $ticketStored[] = $ticket->fresh()->format();

                $increment++;
            }

            return $this->response->success($ticketStored);
        } catch (\Exception $exception) {
            return $this->response->exception($exception->getMessage());
        }
    }

    private function findCurrentCorrelative($idCourseRegisteredUser)
    {
        $user = CourseRegisteredUser::where('id', $idCourseRegisteredUser)
            ->with('course.category')->first();

        $category_code = $user->course->category->category_code;

        $cleanString = $this->cleanString($user->course->description);

        $course_code =  strtoupper(substr($cleanString, 0, 3));

        $ticketCode = Ticket::where('ticket_code', 'like', "$category_code-$course_code%")
                ->orderBy('id', 'desc')
                ->select('ticket_code')
                ->first();

        $currentSecuence = 0;

        if (isset($ticketCode)) {
            $currentSecuence = (int) explode('-', $ticketCode->ticket_code)[2];
        }
        
        return [
            'category_code' => $category_code,
            'course_code' => $course_code,
            'currentSecuence' => $currentSecuence,
        ];
    }

    private function createTicketCode($code, $increment)
    {
        $secuenceString = str_pad($code['currentSecuence'] + $increment, 4, "0", STR_PAD_LEFT);

        return  "{$code['category_code']}-{$code['course_code']}-{$secuenceString}";
    }

    public function cleanString($string)
    {
        if (!isset($string)) {
            return null;
        } else {
            $letters = ['Á', 'É', 'Í', 'Ó', 'Ú'];
            $replace = ['A', 'E', 'I', 'O', 'U'];

            $upperString = Str::upper($string);

            for ($i = 0; $i < count($replace); $i++) {
                $upperString = str_replace($letters[$i], $replace[$i], $upperString);
            }

            return $upperString;
        }
    }


    //charts
    //*Encontrar tickets para pie chart
    public function statusTicketsPieChart($id_course)
    {
        $tickets = Ticket::join('course_registered_users', 'tickets.course_registered_user_id', 'course_registered_users.id')
        ->join('status_tickets', 'tickets.status_ticket_id', 'status_tickets.id')
        ->where('course_registered_users.course_id', $id_course)
        ->select(DB::raw('count(tickets.id) as count, status_tickets.description as label'))
        ->groupBy('status_tickets.description')
        ->get();

        $data = $tickets->map(function ($item) {
            return $item->count;
        });
        $labels = $tickets->map(function ($item) {
            return $item->label;
        });
        $chartData  =   [
            'chartData' => [
                'datasets' => [
                 [   'data' => $data ,
                    'backgroundColor' => ['#5cb85c', '#d9534f']]
                ],
                'labels' => $labels
            ]
        ];
        return $this->response->success($chartData);
    }

    //charts
    //*Encontrar tickets para pie chart
    public function sourceTicketsPieChart($id_course)
    {
        $tickets = Ticket::join('course_registered_users', 'tickets.course_registered_user_id', 'course_registered_users.id')
        ->join('source_tickets', 'tickets.source_ticket_id', 'source_tickets.id')
        ->where('course_registered_users.course_id', $id_course)
        ->select(DB::raw('count(tickets.id) as count, source_tickets.description as label'))
        ->groupBy('source_tickets.description')
        ->get();
        $data = $tickets->map(function ($item) {
            return $item->count;
        });
        $labels = $tickets->map(function ($item) {
            return $item->label;
        });
        $chartData  =   [
            'chartData' => [
                'datasets' => [
                 [   'data' => $data ,
                    'backgroundColor' => ['#5cb85c', '#d9534f']]
                ],
                'labels' => $labels
            ]
        ];
        return $this->response->success($chartData);
    }

    //charts
    //*Encontrar tickets para pie chart
    public function ageTicketsPieChart($id_course)
    {
        $tickets = Ticket::join('course_registered_users', 'tickets.course_registered_user_id', 'course_registered_users.id')
        ->where('course_registered_users.course_id', $id_course)
        ->get();

        $ageTickets =  $tickets->map(function ($item, $key) {
            if ($item->closing_date == null) {
                $now = Carbon::now();
                $created = Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at);
                $difference = $now->diffInDays($created);
                return [
                    'age' => $difference
                ];
            } else {
                $created = Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at);
                $clossed = Carbon::createFromFormat('Y-m-d H:i:s', $item->closing_date);

                $difference = $created->diffInDays($clossed);
                return [
                    'age' => $difference
                ];
            }
        });

        $sorted = $ageTickets->sortBy('age')->values();

        $filter = $sorted->groupBy(function ($item) {
            switch ($item['age']) {
                case 0:
                    return '< 24h';
                case 1:
                    return '1 día';
                default:
                   return $item['age']." días";
                break;
            }
        })->map(function ($item, $key) {
            return [
                'label' => $key,
                'value' => count($item)
            ];
        });

        $data = $filter->map(function ($item) {
            return $item['value'];
        })->values();

        $labels = $filter->map(function ($item) {
            return $item['label'];
        })->values();

        $backgroundColor = $filter->map(function ($item) {
            return '#5cb85c';
        })->values();

        $chartData  =   [
            'chartData' => [
                'datasets' => [
                    [
                    'data' => $data ,
                    'backgroundColor' => $backgroundColor
                    ]
                ],
                 'labels' => $labels
            ]
        ];
        return $this->response->success($chartData);
    }

    //charts
    //*Encontrar tickets para pie chart
    public function typeTicketsPieChart($id_course)
    {
        $tickets = Ticket::join('course_registered_users', 'tickets.course_registered_user_id', 'course_registered_users.id')
        ->join('type_tickets', 'tickets.type_ticket_id', 'type_tickets.id')
        ->where('course_registered_users.course_id', $id_course)
        ->select(DB::raw('count(tickets.id) as count, type_tickets.description as label'))
        ->groupBy('type_tickets.description')
        ->get();
        $data = $tickets->map(function ($item) {
            return $item->count;
        });
        $labels = $tickets->map(function ($item) {
            return $item->label;
        });
        $chartData  =   [
            'chartData' => [
                'datasets' => [
                 [   'data' => $data ,
                    'backgroundColor' => ['#5cb85c', '#d9534f']]
                ],
                'labels' => $labels
            ]
        ];
        return $this->response->success($chartData);
    }
    //charts
    //*Encontrar tickets para pie chart
    public function priorityTicketsPieChart($id_course)
    {
        $tickets = Ticket::join('course_registered_users', 'tickets.course_registered_user_id', 'course_registered_users.id')
        ->join('priority_tickets', 'tickets.priority_ticket_id', 'priority_tickets.id')
        ->where('course_registered_users.course_id', $id_course)
        ->select(DB::raw('count(tickets.id) as count, priority_tickets.description as label'))
        ->groupBy('priority_tickets.description')
        ->get();

        $data = $tickets->map(function ($item) {
            return $item->count;
        });
        $labels = $tickets->map(function ($item) {
            return $item->label;
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

    //charts
    //*Encontrar tickets para pie chart
    public function timeLoggedUserChart($id_course)
    {
        $courseRegisteredUsers = CourseRegisteredUser::where('course_registered_users.course_id', $id_course)
        ->get();

        $groupped = $courseRegisteredUsers->groupBy(function ($item, $key) {
            $timeLogged = $item->last_access_registered_moodle;
            $split = explode(' ', $timeLogged);

            if (count($split) <= 1) {
                return 'Nunca';
            } else {
                switch ($split[1]) {
                    case 'día':
                      return 'Menos de una semana';
                    case 'días':
                        if ($split[0] < 6) {
                            return 'Menos de una semana';
                        } else {
                            return 'Más de una semana';
                        }
                        // no break
                    case 'horas':
                           return 'Menos de un día';
                    case 'minutos':
                           return 'Menos de un día';
                    default:
                        return 'Más de una semana';

                }
            }
        });

        $data = $groupped->map(function ($item) {
            return count($item);
        })->values();
        $labels = $groupped->map(function ($item, $key) {
            return $key;
        })->values();

        $chartData  =   [
            'chartData' => [
                'datasets' => [
                 [   'data' => $data ,
                     'backgroundColor' => ['#5cb85c', '#F9A825', '#D32F2F', '#F9A825']],
                ],
                'labels' => $labels
             ]
        ];
        return $this->response->success($chartData);
    }
    //charts
    //*Encontrar tickets para pie chart
    public function statusUsersChart($id_course)
    {
        $courseRegisteredUsers = CourseRegisteredUser::join('activity_course_users', 'course_registered_users.id', 'activity_course_users.course_registered_user_id')
        ->join('activities', 'activities.id', 'activity_course_users.activity_id')
        ->join('sections', 'sections.id', 'activities.section_id')
        ->where('course_registered_users.course_id', $id_course)
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

    //charts
    //*Encontrar tickets para pie chart
    public function motiveTicketsPieChart($id_course)
    {
        $tickets = Ticket::join('course_registered_users', 'tickets.course_registered_user_id', 'course_registered_users.id')
        ->join('motive_tickets', 'tickets.motive_ticket_id', 'motive_tickets.id')
        ->where('course_registered_users.course_id', $id_course)
        ->select(DB::raw('count(tickets.id) as count, motive_tickets.description as label'))
        ->groupBy('motive_tickets.description')
        ->get();

        $ticketsCount = Ticket::join('course_registered_users', 'tickets.course_registered_user_id', 'course_registered_users.id')
        ->join('motive_tickets', 'tickets.motive_ticket_id', 'motive_tickets.id')
        ->where('course_registered_users.course_id', $id_course)
        ->count();

        $data = $tickets->map(function ($item) use ($ticketsCount) {
            return round($item->count * 100 / $ticketsCount, 0);
        });

        $labels = $tickets->map(function ($item) {
            return $item->label;
        });
        $chartData  =   [
            'chartData' => [
                'datasets' => [
                 [   'data' => $data ,
                     'backgroundColor' => ['#5cb85c', '#F9A825', '#D32F2F', '#D32F2F']],
                ],
                'labels' => $labels
             ]
        ];
        return $this->response->success($chartData);
    }

    //charts
    //*Encontrar tickets para pie chart
    public function statusTicketsByOperatorChart($id_course)
    {
        $tickets = Ticket::join('course_registered_users', 'tickets.course_registered_user_id', 'course_registered_users.id')
        ->join('status_tickets', 'tickets.status_ticket_id', 'status_tickets.id')
        ->join('users', 'tickets.user_assigned_id', 'users.id')
        ->where('course_registered_users.course_id', $id_course)
        ->select(DB::raw('count(tickets.id) as tickets, status_tickets.description as label, users.name as user'))
        ->groupBy('status_tickets.description', 'users.name')
        ->get();

        $tickets = $tickets->groupBy(function ($item, $key) {
            $split = explode(' ', $item['user']);
            return ucwords(strtolower($split[0])). " ".  ucwords(strtolower($split[1]));
        });


        $labels = $tickets->map(function ($item, $key) {
            return $key;
        })->values();

        $dataOpen = $tickets->map(function ($item, $key) {
            if (count($item) == 2) {
                return $item;
            } elseif ($item[0]->label == 'Abierto') {
                return $item->push([
                    'tickets' => 0,
                    'label' => 'Cerrado',
                    'user' => $key
                ]);
            } else {
                return $item->push([
                    'tickets' => 0,
                    'label' => 'Abierto',
                    'user' => $key
                ]);
            }
        });

        $array = [];

        foreach ($dataOpen as $key => $value) {
            foreach ($value as $key => $val) {
                $array[] = $val;
            }
        }
        $collection = collect($array);

        $openTicket = $collection->filter(function ($item) {
            return $item['label'] == 'Abierto';
        })->map(function ($item) {
            return $item['tickets'];
        })->values();

        $closeTicket = $collection->filter(function ($item) {
            return $item['label'] == 'Cerrado';
        })->map(function ($item) {
            return $item['tickets'];
        })->values();

        $chartData  =   [
            'chartData' => [
                'datasets' => [
                [   'data' => $openTicket ,
                     'backgroundColor' => '#5cb85c',
                     'label' => 'Abierto'
                ],
                [   'data' => $closeTicket ,
                     'backgroundColor' => '#d32f2f',
                     'label' => 'Cerrado'
                ],
            ],
                'labels' => $labels
             ]
        ];
        return $this->response->success($chartData);
    }

    //charts
    //*Encontrar tickets para pie chart
    public function motiveTicketsByStatusChart($id_course)
    {
        $tickets = Ticket::join('course_registered_users', 'tickets.course_registered_user_id', 'course_registered_users.id')
        ->join('status_tickets', 'tickets.status_ticket_id', 'status_tickets.id')
        ->join('motive_tickets', 'tickets.motive_ticket_id', 'motive_tickets.id')
        ->where('course_registered_users.course_id', $id_course)
        ->select(DB::raw('count(tickets.id) as tickets, status_tickets.description as status, motive_tickets.description as motive'))
        ->groupBy('status_tickets.description', 'motive_tickets.description')
        ->get();

        $tickets = $tickets->groupBy('motive');

        $labels = $tickets->map(function ($item, $key) {
            return $key;
        })->values();

        $dataOpen = $tickets->map(function ($item, $key) {
            if (count($item) == 2) {
                return $item;
            } elseif ($item[0]->status == 'Abierto') {
                return $item->push([
                    'tickets' => 0,
                    'status' => 'Cerrado',
                    'user' => $key
                ]);
            } else {
                return $item->push([
                    'tickets' => 0,
                    'status' => 'Abierto',
                    'user' => $key
                ]);
            }
        });

        $array = [];

        foreach ($dataOpen as $key => $value) {
            foreach ($value as $key => $val) {
                $array[] = $val;
            }
        }
        $collection = collect($array);

        $openTicket = $collection->filter(function ($item) {
            return $item['status'] == 'Abierto';
        })->map(function ($item) {
            return $item['tickets'];
        })->values();

        $closeTicket = $collection->filter(function ($item) {
            return $item['status'] == 'Cerrado';
        })->map(function ($item) {
            return $item['tickets'];
        })->values();

        $chartData  =   [
            'chartData' => [
                'datasets' => [
                 [   'data' => $openTicket ,
                     'backgroundColor' => '#5cb85c',
                     'label' => 'Abierto'
                ],
                [   'data' => $closeTicket ,
                     'backgroundColor' => '#d32f2f',
                     'label' => 'Cerrado'
                ],
            ],
                'labels' => $labels
             ]
        ];
        return $this->response->success($chartData);
    }
    public function getTotalTicketCount($course_id)
    {
        $tickets = Ticket::join('course_registered_users', 'tickets.course_registered_user_id', 'course_registered_users.id')
                        ->where('course_registered_users.course_id', $course_id)
                        ->count();

                
        return response()->json($tickets);
    }

    public function getLastDayTicket($course_id)
    {
        $current_date = Carbon::now()->format('Y-m-d');
        $tickets = Ticket::join('course_registered_users', 'tickets.course_registered_user_id', 'course_registered_users.id')
                        ->where('course_registered_users.course_id', $course_id)
                        ->where('tickets.created_at', '>', $current_date)
                        ->count();

                
        return response()->json($tickets);
    }

    public function getOpenTicket($course_id)
    {
        $tickets = Ticket::join('course_registered_users', 'tickets.course_registered_user_id', 'course_registered_users.id')
                        ->where('course_registered_users.course_id', $course_id)
                        ->where('tickets.status_ticket_id', 1)
                        ->count();

                
        return response()->json($tickets);
    }

    public function getCloseTicket($course_id)
    {
        $tickets = Ticket::join('course_registered_users', 'tickets.course_registered_user_id', 'course_registered_users.id')
                        ->where('course_registered_users.course_id', $course_id)
                        ->where('tickets.status_ticket_id', 2)
                        ->count();

                
        return response()->json($tickets);
    }

    public function findTicketsByUser($user_id)
    {
        $tickets = Ticket::where('course_registered_user_id', $user_id)
        ->get();

        return $this->response->success(new TicketCollection($tickets));
    }
}
