<?php

namespace App\Http\Controllers\Api\V1;

use App\User;
use App\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class UsersController extends Controller
{
    public function index()
    {
        return User::with('role')->get();
    }

    public function show($id)
    {
        
        return User::with(['role'])->where('id', '=', $id)->get();

    }

    public function store(StoreUsersRequest $request)
    {


        $newUser = User::create($request->all());      
        

        if ($newUser->save()) {
            
            $newUser->role()->attach($request['role']);

            return response()
                ->json($newUser);

        }
    }

    public function update(UpdateUsersRequest $request, $id)
    {
       

        $user = User::findOrFail($id);
        $user->update($request->all());
        $user->role()->sync($request->input('role', []));
        
        if ($user->save()) {
            
            $user->role()->attach($user['role']);

            return response()
                ->json($user);

        }
    }

    public function destroy($id)
    {
       
        $user = User::findOrFail($id);
        $user->delete();

        return response()
        ->json($user);
    }
}
