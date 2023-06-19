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

    function listLink($code)
    {
        $url = PageLink::where('page_id', $code)->get();
        return response()->json(['status' => 'success', 'data' => $url], 200);
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
                'harga_jual' => $request->harga_jual,
                'harga_discount' => $request->harga_discount,
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

    function updatePage(Request $request, $id)
    {
        $page = Page::where('page_id', $id)->first();
        $page->update([
            "title" => $request->title != '' ? $request->title : $page->title,
            "harga_jual" => $request->harga_jual != '' ? $request->harga_jual : $page->harga_jual,
            "harga_discount" => $request->harga_discount != '' ? $request->harga_discount : $page->harga_discount,
            "description" => $request->description != '' ? $request->description : $page->description,
            'status' => $request->status != '' ? $request->status : $page->status
        ]);
        return response()->json(['status' => 'success'], 200);
    }

    function removeLink($id)
    {
        $link = PageLink::find($id);
        $link->delete();
        return response()->json(['status' => 'success'], 200);
    }

    function addLink(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            foreach ($data['title_link'] as $key => $value) {
                $link = [
                    'page_id' => $id,
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

    function editLink(Request $request, $id)
    {
        $link = PageLink::find($id);
        $link->update([
            'link' => $request->link,
        ]);
        return response()->json(['status' => 'success'], 200);
    }

    function pageViewLinktree($id)
    {
        $page = Page::where('page_id', $id)->where('type', 1)->first();
        $pageLink = PageLink::where('page_id', $id)->get();
        return response()->json(['status' => 'success', 'data' => ['page' => $page, 'link' => $pageLink]], 200);
    }
}
