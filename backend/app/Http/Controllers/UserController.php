<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use App\Transformers\User\UserResource;
use App\Transformers\User\UserResourceCollection;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        try{
            $user = $this->user->create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => $request->get('password'),
            ]);
        }catch(\Throwable|\Exception $e){
            return ResponseService::exception('users.store',null,$e);
        }
        
        return new UserResource($user,array('type' => 'store','route' => 'users.store'));
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email','password');

        try{
            $validate = $this->validation($credentials);

            if($validate->fails()){
                return ResponseService::exception('users.login',null,$validate->errors());
            }

            $token = $this->user->login($credentials);
        }catch(\Throwable| \Exception $e){
            return ResponseService::exception('users.login',null,$e);
        }

        return response()->json(compact('token'));
    }

    public function logout(Request $request)
    {
        try{
            auth()->user()->tokens()->delete();
        }catch(\Throwable | \Exception $e){
            return response()->json(compact('request'));
        }

        return response([
            'status' => true,'message' => 'Deslogado com sucesso'
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function validation(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required'
        ],[],[
            'email' => $data['email'],
            'password' => $data['password']
        ]);
    }
}
