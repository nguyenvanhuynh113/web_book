<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeRequest;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $types=DB::table('types')->orderByDesc('created_at')->get();
        return view('admin/type/index',compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin/type/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TypeRequest $request)
    {
        Type::create([
            'type_name'=>$request->type_name,
            'title'=>$request->title,
            'slug'=>$request->slug,
            'status'=>$request->status
        ]);
        return redirect()->back()->with('status','Add type sucess');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type=DB::table('types')->where('id',$id)->first();
        return view('admin/type/edit',compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $check=DB::table('types')->where('type_name',$request->type_name)
            ->where('id','!=',$id)->first();
        if(is_null($check))
        {
            DB::table('types')->where('id',$id)->update([
                'type_name'=>$request->category_name,
                'title'=>$request->title,
                'slug'=>$request->slug,
                'status'=>$request->status
            ]);
            return redirect()->back()->with('status','Updated type sucess');
        }
        else
        {
            return redirect()->back()->with('error','Category name is already exist');
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
        Type::destroy($id);
        return redirect()->back()->with('status','Deleted type sucess');
    }
}
