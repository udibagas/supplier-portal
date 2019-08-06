<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return User::selectRaw('users.*, departments.name AS department, vendors.name AS vendor')
            ->join('departments', 'departments.id', '=', 'users.department_id', 'LEFT')
            ->join('vendors', 'vendors.id', '=', 'users.vendor_id', 'LEFT')
            ->when($request->keyword, function($q) use ($request) {
                return $q->where('users.email', 'LIKE', '%'.$request->keyword.'%')
                    ->orWhere('users.name', 'LIKE', '%'.$request->keyword.'%')
                    ->orWhere('users.phone', 'LIKE', '%'.$request->keyword.'%');
            })
            ->orderBy($request->sort, $request->order == 'ascending' ? 'asc' : 'desc')
            ->paginate($request->pageSize);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $input = $request->all();
        $input['api_token'] = str_random(60);

        if ($request->password) {
            $input['password'] = bcrypt($request->password);
        }

        if ($request->role == User::ROLE_USER) {
            $input['vendor_id'] = null;
        }

        if ($request->role == User::ROLE_VENDOR) {
            $input['department_id'] = null;
        }

        return User::create($input);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $input = $request->all();

        if ($request->password) {
            $input['password'] = bcrypt($request->password);
        }

        if ($request->role == User::ROLE_USER) {
            $input['vendor_id'] = null;
        }

        if ($request->role == User::ROLE_VENDOR) {
            $input['department_id'] = null;
        }

        $user->update($input);
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->id == auth()->user()->id) {
            return response(['message' => 'You can not delete your own account'], 500);
        }

        $user->delete();
        return ['message' => 'Data has been deleted'];
    }

    public function getRoleList()
    {
        return [
            User::ROLE_ADMIN => 'Admin',
            User::ROLE_USER => 'User',
            User::ROLE_VENDOR => 'Vendor',
        ];
    }
}
