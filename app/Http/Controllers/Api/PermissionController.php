<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    //create
    public function store(Request $request)
    {
        $request->validate([
            'date_permission' => 'required',
            'reason' => 'required',
        ]);

        $permission = new Permission();
        $permission->user_id = $request->user()->id;
        $permission->date_permission = $request->date_permission;
        $permission->reason = $request->reason;
        $permission->is_approved = 2;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/permissions', $image->hashName());
            $permission->image = $image->hashName();
        }

        $permission->save();

        return response()->json(['message' => 'Permission created successfully'], 201);
    }

    public function show(Request $request)
    {
        $currentUser = $request->user();

        $permission = Permission::where('user_id', $currentUser->id)->get();
        return response(['permission' => $permission], 200);
    }

    public function index($user_id){
        $permission = Permission::where('user_id',$user_id)->get();
        return response(['permission' => $permission], 200);
    }

}
