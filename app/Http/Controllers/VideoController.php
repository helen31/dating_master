<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Videos;
use Illuminate\Http\Request;

use App\Http\Requests;

class VideoController extends Controller
{
    private $video;

    public function __construct(Videos $videos)
    {
        $this->video = $videos;
    }

    /*
     * Show choosen video
     */
    public function show($id, $vid)
    {
        $video = Videos::find($vid);

        return view('client.profile.video_show')->with([
            'video' => $video,
        ]);
    }
    /*
     * Add video to database
     */
    public function addVideo(Request $request)
    {

        $this->validate($request, [
            'name'        => 'required',
            'description' => 'required',
            'cover'       => 'required',
            'video'       => 'required',
        ]);

        $id =\Auth::user()->id;

        $video = new Videos();
        $video->name = $request->input('name');
        $video->description = $request->input('description');
        if($request->hasFile('cover')){
            $video->cover = $this->upload($request->file('cover'), 'videos/covers/');
        }
        $video->video = $this->upload($request->file('video'), 'videos/videos-mp4/');
        $video->uid = $id;
        $video->save();

        return redirect(\App::getLocale().'/profile/'.$id.'/video');
    }
    /*
     * Delete video
     */
    public function deleteVideo($videoID)
    {
        $video = Videos::find($videoID);
        $this->removeFile('/uploads/videos/covers/'.$video->cover);
        $this->removeFile('/uploads/videos/videos/videos-mp4/'.$video->video);
        Videos::destroy($videoID);
        return response('success', 200);
    }
}
