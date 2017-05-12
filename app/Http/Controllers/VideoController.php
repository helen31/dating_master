<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\User;
use App\Models\Videos;

use App\Services\ClientFinanceService;
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
     * Открывает выбранное видео
     * Просмотр видео девушек для мужчин платный
     */
    public function show($id, $vid)
    {
        $type = Constants::EXP_GIRL_VIDEO;
        $is_access = ClientFinanceService::spendLoveCoins($id, $type);
        if($is_access == true){
            $video = Videos::find($vid);
            return view('client.profile.video_show')->with([
                'video' => $video,
            ]);
        }else{
            \Session::flash('alert-danger', trans('finance.no_money_no_honey'));
            return redirect('profile/'.$id.'/finance');
        }
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
