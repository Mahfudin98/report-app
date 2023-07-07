<?php

namespace App\Http\Controllers\Api\Administrator;

use App\Http\Controllers\Controller;
use App\Models\HeadlineImage;
use App\Models\ImageRoationSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
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

    function indexData()
    {
        $headlineImage = DB::table('headline_images')
            ->join('image_roation_schedules', 'headline_images.id', '=', 'image_roation_schedules.headline_image_id')
            ->select('headline_images.*', 'image_roation_schedules.start_date', 'image_roation_schedules.end_date')
            ->latest()
            ->get();
        $data = [];
        foreach ($headlineImage as $value) {
            $path = Storage::disk('public')->url('headline/' . $value->image);
            $data[] = [
                'id' => $value->id,
                'image' => $value->type == 1 ? $path : $value->image,
                'alt' => $value->alt_text,
                'type' => $value->type,
                "start_date" => $value->start_date,
                "end_date" => $value->end_date,
                "created_at" => $value->created_at
            ];
        }
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required',
            'alt_text' => 'required',
            'type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

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

    function destroy($id)
    {
        $rotation = ImageRoationSchedule::where('headline_image_id', $id)->first();
        $image = HeadlineImage::find($id);
        if ($image->type == 1) {
            File::delete(storage_path('app/public/headline/' . $image->image));
        }
        $rotation->delete();
        $image->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
