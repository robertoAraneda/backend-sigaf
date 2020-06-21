<?php

namespace App\Http\Controllers\FormController;

use App\Helpers\MakeResponse;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TicketFormController extends Controller
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

  public function postForm()
  {
    return [
      'meta' => [
        'type' => 'POST',
        'headers' => [
          [
            'name' => 'Content-Type',
            'value' => 'application/json'
          ],
          [
            'name' => 'Accept',
            'value' => 'application/json'
          ],
          [
            'name' => 'X-Requested-With',
            'value' => 'XTTPRequest'
          ]
        ],
        'href' => route('api.tickets.store'),
      ],
      'form' => [
        'created_at' => [
          'type' => 'date',
          'rules' => [['name' => 'required', 'value' => true]],
          'label' => 'Fecha de apertura',
          'DBname' => 'created_at',
          'defaultValue' => Carbon::now()->toDateTimeString()
        ]
      ]
    ];
  }
  public function putForm($id)
  {

    $ticket = Ticket::find($id);

    return [
      'meta' => [
        'method' => 'PUT',
        'headers' => [
          [
            'name' => 'Content-Type',
            'value' => 'application/json'
          ],
          [
            'name' => 'Accept',
            'value' => 'application/json'
          ],
          [
            'name' => 'X-Requested-With',
            'value' => 'XTTPRequest'
          ]
        ],
        'href' => route('api.tickets.store'),
      ],
      'form' => [
        'createdAt' => [
          'type' => 'date',
          'rules' => [['name' => 'required', 'value' => true]],
          'label' => 'Fecha de apertura',
          'DbName' => 'created_at',
          'defaultValue' => Carbon::now()->toDateTimeString()
        ],
        'userAssigned' => [
          'type' => 'select',
          'rules' => [['name' => 'required', 'value' => true]],
          'label' => 'Operador',
          'DbName' => 'user_assigned_id',
          'defaultValue' => $ticket->user_assigned_id,
          'value' => User::all()->map(function ($user) {
            return ['id' => $user->id, 'text' => $user->name];
          })
        ]
      ],

      // 'data' => $ticket->format()
    ];
  }
}
