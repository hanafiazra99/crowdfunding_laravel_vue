<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function random($count){
        $blogs = Blog::select('*')
                    ->inRandomOrder()
                    ->limit($count)
                    ->get();
        $data['blogs'] = $blogs;

        return response()->json(['response_code'=>'00',
                                 'response_message'=>'Data Berhasil di load',
                                 'data'=>$data
                                ],200);
    }

    public function store(Request $request){
        $request->validate([
            'title'=>'required',
            'desciption'=>'required',
            'image'=>'required|mimes:jpg,jpeg,png'
        ]);

        $blog = Blog::create([
            'title'=>$request->title,
            'description'=>$request->description
        ]);

        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_extension = $image->getClientOriginalExtension();
            $image_name = $blog->id.'.'.$image_extension;
            $image_folder = '/photos/blog/';
            $image_location = $image_folder.$image_name;

            try{
                $image->move(public_path($image_folder),$image_name);
                $blog->update([
                    'image'=>$image_location
                ]);

            }catch(\Exception $e){
                return response()->json(['response_code'=>'01',
                                 'response_message'=>'Image gagal upload',
                                ],200);
            }
            $data['blog'] = $blog;
        }
        return response()->json(['response_code'=>'00',
                                 'response_message'=>'Data Berhasil di load',
                                 'data'=>$data
                                ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
