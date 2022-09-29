<?php
namespace App\Transformers\TaskList;

use App\Services\ResponseService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskListResourceCollection extends ResourceCollection
{
    protected $config;
    /**
     * Cria uma nova instância do resource
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resource, $config = array())
    {
        parent::__construct($resource);

        $this->config = $config;
    }

    /**
     * Transforma o resource em um array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return ['data' => $this->collection];
    }

    /**
     * Seleciona dados adicionais para serem retornados juntos com o array do resource.
     *
     * @param \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'status' => true,
            'msg'    => 'Listando dados',
            'url'    => route('task-list.index')
        ];
    }

    /**
     * Customização da saída da respostas do resource.
     *
     * @param  \Illuminate\Http\Request
     * @param  \Illuminate\Http\Response
     * @return void
     */
    public function withResponse($request, $response)
    {
        $response->setStatusCode(200);
    }
}