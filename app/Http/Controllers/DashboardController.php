<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Helpers\MakeResponse;
use App\Models\CourseRegisteredUser;
use App\Models\ActivityCourseRegisteredUser;
use App\Models\Activity;

class DashboardController extends Controller
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

    public function sideCardFollowStudent($course_id)
    {
        $courseRegisteredUsers = CourseRegisteredUser::where('course_id', $course_id)
        ->where('is_sincronized', 1)
        ->select('id', 'last_access_registered_moodle')
        ->orderBy('id')
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

        $resignUsers = $courseRegisteredUsers->filter(function ($courseRegisteredUser, $key) use ($resignActivity) {
            $ActivityUser = ActivityCourseRegisteredUser::where('course_registered_user_id', $courseRegisteredUser->id)
            ->where('activity_id', $resignActivity->activity_id)
            ->first();

            return $ActivityUser->status_moodle == 'Finalizado';
        });

        $activeUsers    = $courseRegisteredUsers->filter(function ($courseRegisteredUser, $key) use ($resignActivity) {
            $ActivityUser = ActivityCourseRegisteredUser::where('course_registered_user_id', $courseRegisteredUser->id)
            ->where('activity_id', $resignActivity->activity_id)
            ->first();

            return $ActivityUser->status_moodle != 'Finalizado';
        })->values();


        $activeCount    = $activeUsers->filter(function ($courseRegisteredUser, $key) {
            return $courseRegisteredUser->last_access_registered_moodle != 'Nunca';
        });

        $inactiveCount  = $activeUsers->filter(function ($courseRegisteredUser, $key) {
            return $courseRegisteredUser->last_access_registered_moodle == 'Nunca';
        });

        return $this->response->success(
            [
            'resign'   => $resignUsers->count(),
            'active'   => $activeCount->count(),
            'inactive' => $inactiveCount->count(),
            'total'    => $courseRegisteredUsers->count()
            ]
        );
    }

    public function progressUserBySection($course_id)
    {
        $courseRegisteredUsersGlobal = CourseRegisteredUser::where('course_id', $course_id)
        ->join('registered_users', 'course_registered_users.registered_user_id', 'registered_users.id')
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

    public function avanceProgressUserBySection($course_id)
    {
        $courseRegisteredUsersGlobal = CourseRegisteredUser::where('course_id', $course_id)
        ->join('registered_users', 'course_registered_users.registered_user_id', 'registered_users.id')
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
}
