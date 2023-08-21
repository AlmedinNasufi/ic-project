<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    // List all roles
    public function index()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    // Create a new role
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $role = new Role;
        $role->name = $request->name;
        $role->save();

        return response()->json($role, 201);
    }

    // Show a specific role
    public function show($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        return response()->json($role);
    }

    // Update a specific role
    public function update(Request $request, $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $id . '|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $role->name = $request->name;
        $role->save();

        return response()->json($role);
    }

    // Delete a specific role
    public function destroy($id)
    {
            $role = Role::find($id);

            if (!$role) {
                return response()->json(['message' => 'Role not found'], 404);
            }

            $role->delete();
            return response()->json(['message' => 'Role deleted successfully']);

    }
}
