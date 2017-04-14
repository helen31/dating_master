<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Profile;
use App\Models\ProfileMedia;
use App\Models\State;
use App\Models\Status;
use App\Models\User;
use App\Models\profileImages;
use App\Models\Videos;

use App\Services\ZodiacSignService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class ManController extends Controller
{
    private $user;
    private $profile;
    private $profileImages;

    public function __construct(User $user, Profile $profile,profileImages $profileImages)
    {
        $this->middleware('auth');

        $this->user = $user;
        $this->profile = $profile;
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
            $men = User::where('role_id', '=', '4')
                ->leftJoin('status', 'status.id', '=', 'users.status_id')
                ->select(['users.*', 'status.name as stat_name'])
                ->paginate(15);

            return view('admin.profile.men.index')->with([
                'heading' => 'Все мужчины',
                'men'   => $men,
            ]);
        }else{
            abort(404);
        }
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
            'eyes'      => $this->profile->getEnum('eyes'),
            'hair'      => $this->profile->getEnum('hair'),
            'education' => $this->profile->getEnum('education'),
            'kids'      => $this->profile->getEnum('kids'),
            'kids_live' => $this->profile->getEnum('kids_live'),
            'want_kids' => $this->profile->getEnum('want_kids'),
            'family'    => $this->profile->getEnum('family'),
            'religion'  => $this->profile->getEnum('religion'),
            'smoke'     => $this->profile->getEnum('smoke'),
            'drink'     => $this->profile->getEnum('drink'),
            'finance_income' => $this->profile->getEnum('finance_income'),
            'english_level'  => $this->profile->getEnum('english_level'),
        ];
        $countries = Country::orderBy('name')->get();
        $states = State::all();
        $statuses = Status::all();
        $videos = Videos::where('uid', '=', $id)->get();

        return view('admin.profile.men.edit')->with([
            'heading'   => 'Редактировать профиль',
            'user'      => $user,
            'selects'   => $selects,
            'countries' => $countries,
            'states'    => $states,
            'statuses'  => $statuses,
            'videos'     => $videos,
            'zodiac_list' => ZodiacSignService::getAll(),
            'profile_images' => $profile_images,
        ]);
    }

    /**
     * Обновление профиля мужчины
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

        /* Проверка возраста мужчины - не больше 18 лет */

        if($this->age($request->input('birthday')) < 18 ){
            \Session::flash('flash_error', 'Мужчина моложе 18 лет');
            return redirect()->back();
        };

        /* Обновление данных пользователя (мужчины) - таблица users */

        $user->first_name = $request->input('first_name');
        $user->last_name  = $request->input('second_name');
        $user->vip = $request->input('vip') ? 1 : 0;

        if ($request->hasFile('avatar')) {
            $user_avatar = $this->upload($request->file('avatar'), 'users/avatars/');
            $user->avatar = $user_avatar;
        }
        if($request->input('password') !=null){
            $user->password   = bcrypt($request->input('password'));
        }

        $user->country_id = $request->input('country');
        $user->state_id   = $request->input('state');
        $user->city_id    = $request->input('city');
        $user->status_id = 1; // Статус профиля - активный

        //Статус анкеты и сообщение модератора для приостановленных и отклоненных анкет
        if($request->input('status')){
            $user->status_id = $request->input('status');
        }else{
            $user->status_id = 1; // Статус профиля - активный
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
        $profile->finance_income = $request->input('finance_income');
        $profile->about = $request->input('about');
        $profile->know_lang = $request->input('know_lang');
        $profile->english_level = $request->input('english_level');
        $profile->looking = $request->input('looking');
        $profile->l_age_start=$request->input('l_age_start');
        $profile->l_age_stop=$request->input('l_age_stop');
        $profile->l_height_start=$request->input('l_height_start');
        $profile->l_height_stop=$request->input('l_height_stop');
        $profile->l_weight_start=$request->input('l_weight_start');
        $profile->l_weight_stop=$request->input('l_weight_stop');
        $profile->l_horoscope_id=$request->input('l_horoscope_id');

        $profile->save();

        /* Обновляем фото профиля мужчины */

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
     * Приостановление профиля мужчины из админки
     */
    public function deactivate($id)
    {
        $user = $this->user->find($id);
        $user->status_id = 2; //Статус профиля - приостановлен
        $user->save();

        \Session::flash('flash_success', trans('flash.profile_update_success'));

        return redirect('admin/man/deactive');
    }
    /**
     * Активация профиля мужчины из админки
     */
    public function activate($id)
    {
        $user = $this->user->find($id);
        $user->status_id = 1; //Статус профиля - активный
        $user->save();

        \Session::flash('flash_success', trans('flash.profile_update_success'));

        return redirect('admin/man/active');
    }
    /**
     * Удаление профиля мужчины
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

        return redirect('/admin/men');
    }
    /**
     * Восстановление удаленного профиля мужчины
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
        $user->status_id = 1; //Статус профиля - активный
        $user->deleted_at = NULL; //Снимаем дату удаления, иначе невозможно будет получить данные профиля
        $user->save();

        return redirect('/admin/men');
    }

    /**
     * Получение списка мужчин по статусу анкет
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

        $men = []; //without -> role moder -> error -> undefined variable on line 335

        if (Auth::user()->hasRole('Owner') || Auth::user()->hasRole('Moder')) {
            $men = User::withTrashed()->where('role_id', '=', '4')
                ->where('status_id', '=', $s->id)
                ->paginate(15);
        }

        return view('admin.profile.men.status')->with([
            'heading' => 'Мужчины по статусу анкеты: '.trans('admin/control.'.$status),
            'men'   => $men,
        ]);
    }

    /* Определение возраста
        Принимает: дату рождения в формате 'Y-m-d'
        Возвращает: возраст (int)
     */
    private function age($birthday)
    {
        $age = Carbon::now()->diffInYears(Carbon::createFromFormat('Y-m-d', $birthday));
        return $age;
    }

    public function dropProfileFoto($fid){
        $image = profileImages::find($fid);
        $this->removeFile('/uploads/users/profile_photos/'.$image->image);
        profileImages::destroy($fid);
        return response('success', 200);
    }

    /*
    * Add mans video to database
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
     * Delete mans
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