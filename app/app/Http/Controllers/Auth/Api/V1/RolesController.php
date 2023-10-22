<?php
namespace App\Http\Controllers\Api\V1;

use App\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\Role as RoleResource;
use App\Http\Requests\Admin\StoreRolesRequest;
use App\Http\Requests\Admin\UpdateRolesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class RolesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
         
        return Role::all();

    }

    public function show($id)
    {
        $role = new Role();
        $role->findOrFail($id);

        return new RoleResource($role);
    }

    public function store(StoreRolesRequest $request)
    {
        //
    }

    public function update(UpdateRolesRequest $request, $id)
    {
        //
    }

    public function destroy($id)
    {
       //
    }
}
