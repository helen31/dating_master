<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Album;
use App\Models\Images;
use App\Services\ExpenseService;
use Carbon\Carbon;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AlbumController extends Controller
{
    private $album;
    private $expensesService;

    /**
     * AlbumController constructor.
     * @param ExpenseService $expenseService
     */
    public function __construct(Album $album, ExpenseService $expenseService)
    {
        $this->album = $album;
        $this->expensesService = $expenseService;
    }

    /*
     * Выводит альбомы в профиле
     */
    public function profileAlbum($id)
    {
        return view('client.albums.index')->with([
            'id' => $id,
            'albums' => (new Album)->getAlbums($id)
        ]);
    }
    /*
     * Выводит фото альбома для тех кто просматривает его
     */
    public function showAlbum($id, $aid)
    {
        $photos = Images::where('album_id', '=', $aid)->get();
        $album_Data = Album::where('id', '=' ,$aid)->get()[0];
        return view('client.albums.showAlbum')->with([
            'photos' => $photos,
            'id'     => $id,
            'album' => $album_Data,
        ]);
    }
    /*
     * Выводит форму редактирования альбома
     */
    public function editAlbum($id, $aid)
    {
        $photos = Images::where('album_id', '=', $aid)->get();
        $album_Data = Album::where('id', '=' ,$aid)->get()[0];
        return view('client.albums.editAlbum')->with([
            'photos' => $photos,
            'id'     => $id,
            'album' => $album_Data,
        ]);
    }
    /**
     * Create new album
     *
     * @param int $id
     * @return mixed
     */
    public function createAlbum($id)
    {
        return view('client.albums.createAlbum')->with([
            'user_id' => $id,
        ]);
    }

    /**
     * Create and store new album with photos
     *
     * @param Request $request
     * @param $id
     * @return Redirect
     */
    public function addAlbum(Request $request,$id)
    {
        //$id=\Auth::user()->id;
        /**
         * Make new Album
         */
        $album = new Album();
        $album->name          = $request->input('name');
        $album->cover_image   = $this->upload($request->file('cover_image'), 'albums/');
        $album->user_id       = $id;
        $album->save();
        /**
         * Load photos
         */
        foreach ($request->allFiles()['files'] as $file) {
            $image = new Images();
            $image->album_id = $album->id;
            $image->image = $this->upload($file, 'albums/');
            $image->save();
        }
        return redirect('profile/'.$id.'/albums');
    }

    public function saveAlbum(Request $request, $id, $aid){
        $album = $this->album->find($aid);
        $album->name=$request->input('name');
        $files=$request->allFiles();
        if(isset($files['cover_image'])){
            $album->cover_image=$this->upload($files['cover_image'], 'albums/');
        }
        $album->save();

        foreach ($request->allFiles()['files'] as $file) {
            if(!is_null($file)){
                $image = new Images();
                $image->album_id = $aid;
                $image->image = $this->upload($file, 'albums/');
                $image->save();
            }
        }
        return redirect('/profile/'.$id.'/albums');
    }
    /**
     * Drop photo
     *
     * @param Request $request
     * @return
     */
    public function dropImageAlbum($aid)
    {
        $image = Images::find($aid);
        $this->removeFile('/uploads/albums/'.$image->image);
        Images::destroy($aid);
        return response('success', 200);
    }

    /**
     * Drop album & files
     *
     * @param Request $request
     * @return mixed
     */
    public function deleteAlbum($albumId)
    {
        $images = Images::where('album_id', '=', $albumId);
        foreach ($images as $i){
            $this->removeFile('/uploads/albums/'.$i->image);
        }

        Album::destroy($albumId);
        return response('success', 200);
    }
}

