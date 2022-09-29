<?php 

namespace App\Transformers\Tasks;

use App\Services\ResponseService;
use Illuminate\Http\Resources\Json\JsonResource;

class TasksResource extends JsonResource
{
    protected $config;

    public function __construct($resource, $config = array())
    {
        //Ensure you call the parent constructor
        parent::__construct($resource);

        $this->config = $config;
    }

    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'user_id'   => $this->user_id,
            'list_id'   => $this->list_id,
            'title'     => $this->title,
            'status'    => $this->status == 1 ? 'Feito' : 'À fazer',
        ];
    }

    public function with($request)
    {
        return ResponseService::defaultResponses($this->config, $this->id);
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode(200);
    }
    
}
