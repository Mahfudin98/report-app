<?php

namespace App\Http\Controllers\Api\Administrator;

use App\Http\Controllers\Controller;
use App\Models\HeadlineImage;
use App\Models\ImageRoationSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageHeadlineController extends Controller
{
    function index()
    {
        $curerntDate = Carbon::now()->format('Y-m-d');
        $headlineImage = ImageRoationSchedule::where('start_date', '<=', $curerntDate)
            ->where('end_date', '>=', $curerntDate)
            ->latest()
            ->take(4)
            ->get()
            ->pluck('headlineImage');
        $data = [];
        foreach ($headlineImage as $value) {
            $path = Storage::disk('public')->url('headline/' . $value->image);
            $data[] = [
                'image' => $value->type == 1 ? $path : $value->image,
                'alt' => $value->alt_text,
            ];
        }
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    function store(Request $request)
    {
        // $this->validate($request, [
        //     'image' => 'required|string',
        //     'alt_text' => 'required|string',
        //     'type' => 'required',
        //     'start_date' => 'required',
        //     'end_date' => 'required'
        // ]);

        $filename = $request->image;

        if ($request->type == 1) {
            $file = $request->file('image');
            $filename = time() . Str::slug($request->alt_text) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/headline', $filename);
        }
        try {
            $headlineImage = HeadlineImage::create([
                'image' => $filename,
                'alt_text' => $request->alt_text,
                'type' => $request->type
            ]);
            ImageRoationSchedule::create([
                'headline_image_id' => $headlineImage->id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ]);
            DB::commit();
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage());
        }
    }
}
