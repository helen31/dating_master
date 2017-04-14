<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Passport;
use App\Models\Profile;
use App\Models\ProfileMedia;
use App\Models\State;
use App\Models\Status;
use App\Models\User;
use App\Models\profileImages;

use App\Models\Album;
use App\Models\Images;
use App\Models\Videos;

use App\Services\ZodiacSignService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class GirlsController extends Controller
{
    private $user;
    private $profile;
    private $profileImages;
    private $album;
    private $passport;
    private $passport_photos = [];

    public function __construct(User $user, Profile $profile, Passport $passport,Album $album,profileImages $profileImages)
    {
        $this->middleware('auth');

        $this->user = $user;
        $this->album = $album;
        $this->profile = $profile;
        $this->passport = $passport;
        $this->profileImages=$profileImages;
        view()->share('new_ticket_messages', parent::getUnreadMessages());
        view()->share('unread_ticket_count', parent::getUnreadMessagesCount());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasRole('Owner') || Auth::user()->hasRole('Moder')) {
            $partners = User::where('role_id', '=', '3')->get();

            $girls = User::where('role_id', '=', '5')
                ->leftJoin('status', 'status.id', '=', 'users.status_id')
                ->select(['users.*', 'status.name as stat_name'])
                ->paginate(15);

            return view('admin.profile.girls.index')->with([
                'heading' => 'Все девушки',
                'girls'   => $girls,
                'partners'=> $partners,
            ]);
        }elseif (Auth::user()->hasRole('Partner')) {

            $girls = User::where('role_id', '=', '5')
                                ->where('partner_id', '=', Auth::user()->id)
                                ->leftJoin('status', 'status.id', '=', 'users.status_id')
                                ->select(['users.*', 'status.name as stat_name'])
                                ->paginate(15);

            return view('admin.profile.girls.index')->with([
                'heading' => 'Все девушки',
                'girls'   => $girls
            ]);
        }else{
            abort(404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $selects = [
            'gender'    => $this->profile->getEnum('gender'),
            'eyes'       => $this->profile->getEnum('eyes'),
            'hair'      => $this->profile->getEnum('hair'),
            'education' => $this->profile->getEnum('education'),
            'kids'      => $this->profile->getEnum('kids'),
            'kids_live' => $this->profile->getEnum('kids_live'),
            'want_kids'    => $this->profile->getEnum('want_kids'),
            'family'    => $this->profile->getEnum('family'),
            'religion'  => $this->profile->getEnum('religion'),
            'smoke'     => $this->profile->getEnum('smoke'),
            'drink'     => $this->profile->getEnum('drink'),
            'finance_income' => $this->profile->getEnum('finance_income'),
            'english_level' => $this->profile->getEnum('english_level'),
        ];
        $countries = Country::orderBy('name')->get();

        return view('admin.profile.girls.create')->with([
            'heading'   => 'Добавить девушку',
            'selects'   => $selects,
            'countries' => $countries,
            'zodiac_list'=>ZodiacSignService::getAll(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        /* Стандартная валидация полей */

        $this->validate($request, [
            'first_name'    => 'required|max:255',
            'second_name'   => 'required|max:255',
            'birthday'      => 'required',
            'email'         => 'required|max:128|unique:users',
            'phone'         => 'required|max:30',
            'password'      => 'required',
            'country'       => 'required',
            'state'         => 'required',
            'city'          => 'required',
            'passno'        => 'required',
            'pass_date'     => 'required',
            'pass_photo'    => 'required',
            'height'        => 'numeric',
            'weight'        => 'numeric',
            'l_age_start'   => 'numeric',
            'l_age_stop'    => 'numeric',
            'l_height_start' => 'numeric',
            'l_height_stop'  => 'numeric',
            'l_weight_start' => 'numeric',
            'l_weight_stop'  => 'numeric',
        ]);

        /* Проверка возраста девушки - больше 18 лет */

        if($this->age($request->input('birthday')) < 18 ){
            \Session::flash('flash_error', 'Девушка моложе 18 лет');
            return redirect()->back();
        };

        /* Проверка количества фото профиля - не больше 10 штук */

        if($request->hasFile("profile_photo")){
            if(count($request->file("profile_photo")) > 10){
                \Session::flash('flash_error', 'Количество загруженных фото должно быть не больше 10');
                return redirect()->back();
            }
        }

        /* Создание нового пользователя (девушки) - таблица users */

        $user_avatar = 'empty_girl.png';
        if ($request->hasFile('avatar')) {
            $user_avatar = $this->upload($request->file('avatar'), 'users/avatars/');
        }
        $this->user->avatar = $user_avatar;

        $this->user->webcam = $request->input('webcam') ? 1 : 0;
        $this->user->hot = $request->input('hot') ? 1 : 0;
        $this->user->first_name = $request->input('first_name');
        $this->user->last_name = $request->input('second_name');
        $this->user->email = $request->input('email');
        $this->user->phone = $request->input('phone');
        $this->user->password = bcrypt($request->input('password'));

        $this->user->country_id = $request->input('country');
        $this->user->state_id = $request->input('state');
        $this->user->city_id = $request->input('city');

        if(Auth::user()->hasRole('Owner') || Auth::user()->hasRole('Moder') ){
            $this->user->partner_id = 1; //Если профиль создал админ или модератор, то партнер - админ
        }else{
            $this->user->partner_id = Auth::user()->id; //Или партнером является создавший аккаунт партнер
        }
        $this->user->role_id = 5; // Роль - женщина
        $this->user->status_id = 5; // Статус - на модерации

        $this->user->save();

        /* Создание профиля девушки  - таблица profile */


        $this->profile->user_id = $this->user->id;
        $this->profile->gender    = 'female';
        $this->profile->birthday = $request->input('birthday');
        $this->profile->height    = $request->input('height');
        $this->profile->weight    = $request->input('weight');
        $this->profile->eyes       = $request->input('eyes');
        $this->profile->hair      = $request->input('hair');
        $this->profile->education = $request->input('education');
        $this->profile->kids      = $request->input('kids');
        $this->profile->kids_live = $request->input('kids_live');
        $this->profile->want_kids = $request->input('want_kids');
        $this->profile->family    = $request->input('family');
        $this->profile->religion  = $request->input('religion');
        $this->profile->smoke     = $request->input('smoke');
        $this->profile->drink     = $request->input('drink');
        $this->profile->occupation = $request->input('occupation');
        $this->profile->finance_income = $request->input('finance_income');
        $this->profile->about     = $request->input('about');
        $this->profile->know_lang = $request->input('know_lang');
        $this->profile->english_level  = $request->input('english_level');
        $this->profile->looking = $request->input('looking');
        $this->profile->l_age_start = $request->input('l_age_start');
        $this->profile->l_age_stop = $request->input('l_age_stop');
        $this->profile->l_height_start = $request->input('l_height_start');
        $this->profile->l_height_stop = $request->input('l_height_stop');
        $this->profile->l_weight_start = $request->input('l_weight_start');
        $this->profile->l_weight_stop = $request->input('l_weight_stop');
        $this->profile->l_horoscope_id = $request->input('l_horoscope_id');

        $this->profile->save();

        /* Сохранение паспортных данных девушки - таблица passport */

        $this->passport->user_id = $this->user->id;
        $this->passport->passno = str_replace(' ', '', $request->input('passno'));
        $this->passport->date = $request->input('pass_date');

        if($request->hasFile('pass_photo')){
            $user_passport = $this->upload($request->file('pass_photo'), 'users/passports/');
            $this->passport->cover=$user_passport;
        }
        $this->passport->save();

        /* Сохранение фотографий профиля девушки - максимум 10 - таблица profile_images */

        if($request->hasFile('profile_photo')){
            $profile_photos = $request->file('profile_photo');
            foreach($profile_photos as $photo){
                $profile_image = new profileImages();
                $profile_image->url = $this->upload($photo, 'users/profile_photos/');
                $profile_image->user_id = $this->user->id;
                $profile_image->save();
            }
        }

        \Session::flash('flash_success', trans('flash.profile_add_success'));

        return redirect('admin/girls/');

    }

    public function changePartner(Request $request){
        $request->input('girl_id');
        $user = User::find($request->input('girl_id'));
        $user->partner_id=$request->input('partner_list');
        $user->save();
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user = $this->user->find($id);
        $profile_images = $this->profileImages->where('user_id', $id)->get();
        $selects = [
            'gender'    => $this->profile->getEnum('gender'),
            'eyes'       => $this->profile->getEnum('eyes'),
            'hair'      => $this->profile->getEnum('hair'),
            'education' => $this->profile->getEnum('education'),
            'kids'      => $this->profile->getEnum('kids'),
            'kids_live' => $this->profile->getEnum('kids_live'),
            'want_kids'    => $this->profile->getEnum('want_kids'),
            'family'    => $this->profile->getEnum('family'),
            'religion'  => $this->profile->getEnum('religion'),
            'smoke'     => $this->profile->getEnum('smoke'),
            'drink'     => $this->profile->getEnum('drink'),
            'finance_income' => $this->profile->getEnum('finance_income'),
            'english_level' => $this->profile->getEnum('english_level'),
        ];
        $countries = Country::orderBy('name')->get();
        $states = State::all();
        $passport = Passport::where('user_id', '=', $id)->first();
        $statuses = Status::all();
        $videos = Videos::where('uid', '=', $id)->get();

        return view('admin.profile.girls.edit')->with([
            'heading'   => 'Редактировать профиль',
            'user'      => $user,
            'selects'   => $selects,
            'countries' => $countries,
            'states'    => $states,
            'passport'  => $passport,
            'statuses'  => $statuses,
            'albums'    => (new Album)->getAlbums($id),
            'videos'    => $videos,
            'zodiac_list'=>ZodiacSignService::getAll(),
            'profile_images' => $profile_images,
        ]);
    }

    /**
     * Обновление профиля девушки
     *
     */
    public function update(Request $request, $id)
    {

        /* Стандартная валидация полей */

        $this->validate($request, [
            'first_name'    => 'required|max:255',
            'second_name'   => 'required|max:255',
            'birthday'      => 'required',
            'country'       => 'required',
            'state'         => 'required',
            'city'          => 'required',
            'height'        => 'numeric',
            'weight'        => 'numeric',
            'l_age_start'   => 'numeric',
            'l_age_stop'    => 'numeric',
            'l_height_start' => 'numeric',
            'l_height_stop'  => 'numeric',
            'l_weight_start' => 'numeric',
            'l_weight_stop'  => 'numeric',
        ]);

        /* Создание необходимых для работы объектов */

        $user = User::find($id);
        $profile = Profile::where('user_id', '=', $id)->first();

        /* Проверка возраста девушки - больше 18 лет */

        if($this->age($request->input('birthday')) < 18 ){
            \Session::flash('flash_error', 'Девушка моложе 18 лет');
            return redirect()->back();
        };

        /* Обновление данных пользователя (девушки) - таблица users */

        $user->webcam = $request->input('webcam') ? 1 : 0;
        $user->hot = $request->input('hot') ? 1 : 0;
        $user->first_name = $request->input('first_name');
        $user->last_name  = $request->input('second_name');

        if ($request->hasFile('avatar')) {
            $user_avatar = $this->upload($request->file('avatar'),'users/avatars/');
            $user->avatar = $user_avatar;
        }

        if($request->input('password') !=null){
            $user->password   = bcrypt($request->input('password'));
        }

        $user->country_id = $request->input('country');
        $user->state_id   = $request->input('state');
        $user->city_id    = $request->input('city');

        //Статус анкеты и сообщение модератора для приостановленных и отклоненных анкет
        //Партнеры не могут изменить статут девушки, поэтому у них нет $request->input('status')
        if($request->input('status')){
            $user->status_id = $request->input('status');
        }else{
            $user->status_id = 5; // Статус профиля - на модерации
        }
        $user->status_message = NULL;
        if($user->status_id == 2 || $user->status_id == 3){
            if($request->input('status_message')){
                $user->status_message = $request->input('status_message');
            }
        }

        $user->save();

        /* Обновляем данные профиля девушки - таблица profiles */

        $profile->birthday = $request->input('birthday');
        $profile->height    = $request->input('height');
        $profile->weight    = $request->input('weight');
        $profile->eyes       = $request->input('eyes');
        $profile->hair      = $request->input('hair');
        $profile->education = $request->input('education');
        $profile->kids      = $request->input('kids');
        $profile->want_kids = $request->input('want_kids');
        $profile->family    = $request->input('family');
        $profile->religion  = $request->input('religion');
        $profile->smoke     = $request->input('smoke');
        $profile->drink     = $request->input('drink');
        $profile->occupation= $request->input('occupation');
        $profile->kids_live = $request->input('kids_live');
        $profile->finance_income =$request->input('finance_income');
        $profile->about = $request->input('about');
        $profile->know_lang=$request->input('know_lang');
        $profile->english_level=$request->input('english_level');
        $profile->looking = $request->input('looking');
        $profile->l_age_start=$request->input('l_age_start');
        $profile->l_age_stop=$request->input('l_age_stop');
        $profile->l_height_start=$request->input('l_height_start');
        $profile->l_height_stop=$request->input('l_height_stop');
        $profile->l_weight_start=$request->input('l_weight_start');
        $profile->l_weight_stop=$request->input('l_weight_stop');
        $profile->l_horoscope_id=$request->input('l_horoscope_id');

        $profile->save();

        /* Обновляем фото профиля девушки */

        if($request->hasFile('profile_photo')){
            $profile_photos = $request->file('profile_photo');
            foreach($profile_photos as $photo){
                $profile_image = new profileImages();
                $profile_image->url = $this->upload($photo, 'users/profile_photos/');
                $profile_image->user_id = $id;
                $profile_image->save();
            }
        }

        \Session::flash('flash_success', trans('flash.profile_update_success'));
        return redirect()->back();
    }
    /**
     * Приостановление профиля девушки из админки
     */
    public function deactivate($id)
    {
        $user = $this->user->find($id);
        $user->status_id = 2; //Статус профиля - приостановлен
        $user->save();

        \Session::flash('flash_success', trans('flash.profile_update_success'));

        return redirect('admin/girls/deactive');
    }
    /**
     * Активация профиля девушки из админки
     */
    public function activate($id)
    {
        $user = $this->user->find($id);
        $user->status_id = 5; //Статус профиля - на модерации
        $user->save();

        \Session::flash('flash_success', trans('flash.profile_update_success'));

        return redirect('admin/girls/onmoderation');
    }
    /**
     * Удаление профиля девушки
     *
     * Так как в модели Users используется SoftDeletes, то запись не удаляется из базы,
     * а к ней добавляется дата удаления deleted_at
     * получить такую запись можно только с помощью метода withTrashed()
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::withTrashed()->find($id);
        $user->status_id = 4; //Статус профиля - удален
        $user->save();
        $user->delete();

        return redirect('/admin/girls');
    }
    /**
     * Восстановление удаленного профиля девушки
     *
     * Так как в модели Users используется SoftDeletes, то запись не удаляется из базы,
     * а к ней добавляется дата удаления deleted_at
     * получить такую запись можно только с помощью метода withTrashed()
     *
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $user = User::withTrashed()->find($id);
        $user->status_id = 5; //Статус профиля - на модерации
        $user->deleted_at = NULL; //Снимаем дату удаления, иначе невозможно будет получить данные профиля
        $user->save();

        return redirect('/admin/girls');
    }

    /**
     * Получение списка девушек по статусу анкет
     *
     * Так как в модели Users используется SoftDeletes, то запись не удаляется из базы,
     * а к ней добавляется дата удаления deleted_at
     * получить такую запись можно только с помощью метода withTrashed()
     *
     * @return \Illuminate\Http\Response
     */
    public function getByStatus($status)
    {
        $s = Status::where('name', '=', $status)->first();

        $girls = []; //without -> role moder -> error -> undefined variable girls on line 335

            if (Auth::user()->hasRole('Owner') || Auth::user()->hasRole('Moder')) {
                $girls = User::withTrashed()->where('role_id', '=', '5')
                    ->where('status_id', '=', $s->id)
                    ->paginate(15);
            } elseif (Auth::user()->hasRole('Partner')) {
                $girls = User::withTrashed()->where('role_id', '=', '5')
                    ->where('partner_id', '=', Auth::user()->id)
                    ->where('status_id', '=', $s->id)
                    ->paginate(15);
            }

        return view('admin.profile.girls.status')->with([
            'heading' => 'Девушки по статусу анкеты: '.trans('admin/control.'.$status),
            'girls'   => $girls,
        ]);
    }

    /**
     * Check existence of passport in database.
     *
     * firstly for ajax request
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function check(Request $request)
    {
        $passp = $this->passport->where('passno', 'like', str_replace(' ', '', $request->input('passno')))->first();

        if ($passp) {
            return response('<span class="bg-danger">Такой номер пасспорта существует в базе</span>', 200);
        } else {
            return response('<span class="bg-success">Номер паспорта в базе не обнаружен</span>', 200);
        }
    }

    /* Определение возраста девушки
        Принимает: дату рождения в формате 'Y-m-d'
        Возвращает: возраст (int)
     */
    private function age($birthday)
    {
        $age = Carbon::now()->diffInYears(Carbon::createFromFormat('Y-m-d', $birthday));
        return $age;
    }
    /*
     * Принимает ID партнера
    * Возвращает имя и фамилию партнера в одну строку
    */
    public static function getPartnerNameByID($partner_id){
        $partner = DB::table('users')->select('first_name', 'last_name')
         ->where('id', '=', $partner_id)->first();

        $partner_name = $partner->first_name.' '.$partner->last_name;
        return $partner_name;
    }

    public function editAlbum($id, $aid)
    {
        $photos = Images::where('album_id', '=', $aid)->get();
        $album_Data = Album::where('id', '=' ,$aid)->get()[0];
        return view('admin.profile.girls.editAlbum')->with([
            'heading' => 'Edit Album',
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
        return view('admin.profile.girls.createAlbum')->with([
            'heading' => 'Albums',
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
    public function addAlbum(Request $request, $id)
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
        return redirect('/'.\App::getLocale().'/admin/girl/edit/'.$id);
    }

    public function saveAlbum(Request $request,$id,$aid){
        $album = $this->album->find($aid);
        $album->name=$request->input('name');
        $files=$request->allFiles();
        if(isset($files['cover_image'])){
            $album->cover_image=$this->upload($files['cover_image'],'albums/');
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
        return redirect('/'.\App::getLocale().'/admin/girl/edit/'.$id."/edit_album/".$aid);
    }

    public function dropProfileFoto($fid){
        $image = profileImages::find($fid);
        $this->removeFile('/uploads/users/profile_photos/'.$image->image);
        profileImages::destroy($fid);
        return response('success', 200);
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
    /*
     * Add girl video to database
     */
    public function addVideo(Request $request, $id)
    {

        $this->validate($request, [
            'name'        => 'required',
            'description' => 'required',
            'cover'       => 'required',
            'video'       => 'required',
        ]);

        $video = new Videos();
        $video->name = $request->input('name');
        $video->description = $request->input('description');
        if($request->hasFile('cover')){
            $video->cover = $this->upload($request->file('cover'), 'videos/covers/');
        }
        $video->video = $this->upload($request->file('video'), 'videos/videos-mp4/');
        $video->uid = $id;
        $video->save();

        \Session::flash('flash_success', 'Ваше видео успешно добавлено');

        return redirect(\App::getLocale().'/admin/girl/edit/'.$id);
    }
    /*
     * Delete girl
     * video
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
