<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function addOrEditCategoryPreferences(Request $request) {
        $validator = Validator::make($request->all(), [
            'categories' => 'sometimes|array',
            'categories.*' => 'exists:categories,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = auth()->user();
        $user->preferredCategories()->sync($request->input('categories'));
        $user->load('preferredCategories');

        return response()->json($user);
    }
}
