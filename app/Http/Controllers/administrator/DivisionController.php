<?php

namespace App\Http\Controllers\administrator;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DivisionController extends Controller
{
    public function index()
    {
        $division = Division::all();
        return view('division.divisionIndex', compact('division'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'division_name' => 'required|string|max:100'
        ]);

        $charactersLength = strlen(strtoupper($request->division_name));
        $randomString = '';
        for ($i = 0; $i < 3; $i++) {
            $randomString .= strtoupper($request->division_name)[rand(0, $charactersLength - 1)];
        }
        $code = $randomString. mt_rand(1000, 9999);
        Division::create([
            'division_code' => $code,
            'division_name' => $request->division_name,
        ]);

        return back()->with(['success' => 'Divisi Ditambahkan']);
    }

    public function edit($division_code)
    {
        $division = Division::where('division_code', $division_code)->first();

        return view('division.divisionEdit', compact('division'));
    }

    public function update(Request $request, $division_code)
    {
        $division = Division::where('division_code', $division_code)->first();

        $this->validate($request, [
            'division_code' => ['required', Rule::unique('divisions')->ignore($division)],
            'division_name' => 'required|string|max:100'
        ]);

        $division->update([
            'division_code' => $request->division_code,
            'division_name' => $request->division_name,
        ]);

        return redirect(route('division-index'))->with(['success' => 'Division berhasil diupdate']);
    }

    public function destroy($id)
    {
        $division = Division::find($id);

    }
}
