<?php

namespace App\Http\Controllers\Api\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;

class ApiDivisionsController extends Controller
{
    public function index()
    {
        $division = Division::all();
        return response()->json(['status' => 'success', 'data' => $division, 'message' => 'Data load successfully.'], 200);
    }
}
