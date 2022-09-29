<?php
namespace App\Transformers\User;

use App\Services\ResponseService;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'password' => '********'
        ];
    }

    /**
     * Seleciona dados adicionais para serem retornados juntos com o array do resource.
     *
     * @param \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return ResponseService::defaultResponses($this->config, $this->id);
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