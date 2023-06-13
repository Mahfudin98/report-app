<?php

namespace App\Http\Controllers\Api\Member;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    function index($username)
    {
        $page = DB::table('pages')
            ->join('members', 'pages.member_id', '=', 'members.id')
            ->where('members.username', $username)
            ->get();
        return response()->json(['status' => 'success', 'data' => $page], 200);
    }

    function store(Request $request)
    {
        $this->validate($request, [
            'member_id'   => 'required',
            'product_id'  => 'nullable',
            'title'       => 'required',
            'description' => 'nullable',
            'type'        => 'required',
            'title_link'  => 'required',
            'link'        => 'required',
        ]);

        $charactersLength = strlen(strtoupper($request->title));
        $randomString = '';
        for ($i = 0; $i < 9; $i++) {
            $randomString .= strtoupper($request->title)[rand(0, $charactersLength - 1)];
        }
        $code = $randomString . mt_rand(1000, 9999);

        DB::beginTransaction();

        try {
            $page = Page::create([
                'page_id' => preg_replace('/\s+/', '', $code),
                'member_id' => $request->member_id,
                'product_code' => $request->product_id,
                'title' => $request->title,
                'description' => $request->description,
                'type' => $request->type,
            ]);
            $data = $request->all();
            foreach ($data['title_link'] as $key => $value) {
                $link = [
                    'page_id' => $page->page_id,
                    'title' => $data['title_link'][$key],
                    'link' => $data['link'][$key],
                ];
                PageLink::create($link);
            }
            DB::commit();
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    function edit($id)
    {
    }

    function update(Request $request, $id)
    {
    }

    function pageView()
    {
    }
}