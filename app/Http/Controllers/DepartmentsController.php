<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    public function show()
    {
        $depts = Department::get();
        return response()->json($depts);
    }
}
