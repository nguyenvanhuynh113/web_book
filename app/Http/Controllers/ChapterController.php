<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChapterRequest;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/chater/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $books=DB::table('books')->orderByDesc('created_at')->get();
        return view('admin/chapter/create',compact('books'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChapterRequest $request)
    {
        Chapter::create([
            'name'=>$request->name,
            'title'=>$request->title,
            'content'=>$request->input('content'),
            'slug'=>$request->slug,
            'id_book'=>$request->id_book,
            'status'=>$request->status
        ]);
        return redirect()->back()->with('status','Add chater sucess');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $books=DB::table('books')->orderByDesc('created_at')->get();
        $chapter=DB::table('chapters')->where('id',$id)->first();
        return view('admin/chapter/edit',compact('chapter','books'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ChapterRequest $request, $id)
    {
        $check=DB::table('chapters')->where('name',$request->name)->where('id','!=',$id)->first();
        if (is_null($check))
        {
            DB::table('chapters')->where('id',$id)->update([
                'name'=>$request->name,
                'title'=>$request->title,
                'content'=>$request->input('content'),
                'slug'=>$request->slug,
                'id_book'=>$request->id_book,
                'status'=>$request->status
            ]);
            return redirect()->back()->with('status','Updated chapter');
        }
        else{
            return redirect()->back()->with('error','Name chapter is already exits');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Chapter::destroy($id);
        return redirect()->back()->with('status','Deleted chapter');
    }
}
