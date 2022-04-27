<?php

namespace App\Http\Controllers\Dashboard\Role;

use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleStore;
use App\Http\Requests\Role\RoleUpdate;
use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\Role\RoleCollection;
use App\Services\Role\RoleServiceInterface;

class RoleController extends Controller
{
    public function __construct(
        protected RoleServiceInterface $roleService
    ){}

    /**
     * get all roles
     * @return RoleCollection
     */
    public function index()
    {
        return new RoleCollection(
            $this->roleService->all()
        );
    }

    /**
     * Store a newly created resource in storage
     * @param RoleStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RoleStore $request)
    {
        return $this->success([
            "msg"  => trans("dashboard.success.role.create"),
            "data" => new RoleResource(
                $this->roleService->create(
                    $request->all()
                )
            )
        ]);
    }

    /**
     * Display the specified resource
     * @param Role $role
     * @return RoleResource
     */
    public function show(Role $role)
    {
        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage
     * @param Role $role
     * @param RoleUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Role $role  ,RoleUpdate $request)
    {
        $role = $this->roleService->update(
            $role,
            $request->all()
        ) ;

        return
            $this->success([
                "msg"  => trans("dashboard.success.role.update"),
                "data" => new RoleResource($role)
            ]);
    }

    /**
     * Remove the specified resource from storage
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return $this->success([
            "msg" => trans("dashboard.success.role.delete")
        ]);
    }
}
