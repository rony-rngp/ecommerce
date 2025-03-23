<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::latest()->paginate(pagination_limit());
        return view('backend.video.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.video.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'post_by' => 'required',
           'title' => 'required',
           'youtube_url' => 'required|url',
           'image' => 'required|mimes:jpeg,jpg,png,gif,PNG|max:2048'
        ]);

        $video = new Video();
        $video->post_by = $request->post_by;
        $video->title = $request->title;
        $video->youtube_url = $request->youtube_url;
        if($request->has('image')){
            $video->image = upload_image('video/', $request->file('image'));
        }
        $video->save();
        return redirect()->route('admin.videos.index')->with('success', 'Video added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $video = Video::find($id);
        return view('backend.video.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'post_by' => 'required',
            'title' => 'required',
            'youtube_url' => 'required|url',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif,PNG|max:2048'
        ]);

        $video = Video::find($id);
        $video->post_by = $request->post_by;
        $video->title = $request->title;
        $video->youtube_url = $request->youtube_url;
        if($request->has('image')){
            $video->image = update_image('video/', $video->image, $request->file('image'));
        }
        $video->save();
        return redirect()->route('admin.videos.index')->with('success', 'Video updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $video = Video::find($id);
        delete_image($video->image);
        $video->delete();
        return redirect()->route('admin.videos.index')->with('success', 'Video deleted successfully');
    }
}
