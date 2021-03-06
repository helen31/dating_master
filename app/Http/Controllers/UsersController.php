<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Album;
use App\Models\Country;
use App\Models\Messages;
use App\Models\Profile;
use App\Models\Passport;
use App\Models\profileImages;
use App\Models\Session;
use App\Models\Smiles;
use App\Models\Videos;
use App\Models\State;
use App\Models\User;
use App\Models\ServicesPrice;
use App\Services\ZodiacSignService;
use App\Services\ClientFinanceService;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UsersController extends Controller
{
    /**
     * @var User - Git Test
     */
    private $user;

    /**
     * @var Profile
     */
    private $profile;
    /**
     * @var Passport
     */
    private $passport;
    /**
     * @var ZodiacSignService
     */
    private $zodiacSignService;

    public function __construct(User $user, Profile $profile, Passport $passport, ZodiacSignService $zodiacSignService)
    {
        $this->user = $user;
        $this->profile = $profile;
        $this->passport = $passport;
        $this->zodiacSignService = $zodiacSignService;
        parent::__construct();
    }

    public function show($id)
    {
        $client_id = Auth::user()->id;
        $user = User::select([
            'users.id as uid',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.avatar',
                'users.webcam',
                'users.city_id',
                'users.country_id',
                'users.role_id',
                'profile.*',
                'countries.name as country',
                'countries.name_en as country_en',
                'cities.name as city',
                'cities.name_en as city_en',
            ])
            ->join('profile', 'profile.user_id', '=', 'users.id')
            ->leftjoin('countries', 'countries.id', '=', 'users.country_id')
            ->leftJoin('cities', 'cities.id', '=', 'users.city_id')
            ->where('users.id', '=', $id)
            ->first();

        $profile_images = profileImages::where('user_id', '=', $id)->get();
        $albums = Album::where('user_id', '=', $id)->get();
        $videos = Videos::where('uid', '=', $id)->get();
        $can_open_albums = ClientFinanceService::isServiceActive($client_id, $id, Constants::EXP_ALBUM);
        $album_expire_date = ClientFinanceService::checkDateTimeExpired($client_id, $id, Constants::EXP_ALBUM);
        $album_price = ServicesPrice::where('name', '=', Constants::EXP_ALBUM)->first()->price;
        $can_open_video = ClientFinanceService::isServiceActive($client_id, $id, Constants::EXP_GIRL_VIDEO);
        $video_expire_date = ClientFinanceService::checkDateTimeExpired($client_id, $id, Constants::EXP_GIRL_VIDEO);
        $video_price = ServicesPrice::where('name', '=', Constants::EXP_GIRL_VIDEO)->first()->price;

        return view('client.profile.show')->with([
            'u' => $user,
            'id' => $id,
            'profile_images' => $profile_images,
            'albums' => $albums,
            'videos' => $videos,
            'can_open_albums' => $can_open_albums,
            'album_expire_date' => $album_expire_date,
            'album_price' => $album_price,
            'can_open_video' => $can_open_video,
            'video_expire_date' => $video_expire_date,
            'video_price' => $video_price,
            'sign'  => $this->zodiacSignService->getSignByBirthday($user->birthday),
        ]); 
    }

    /**
     * Show the form for editing the profile.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        if(\Auth::user()->id == $id){
            $selects = [
                'eyes'       => $this->profile->getEnum('eyes'),
                'hair'      => $this->profile->getEnum('hair'),
                'education' => $this->profile->getEnum('education'),
                'kids'      => $this->profile->getEnum('kids'),
                'kids_live' => $this->profile->getEnum('kids_live'),
                'want_kids' => $this->profile->getEnum('want_kids'),
                'family'    => $this->profile->getEnum('family'),
                'religion'  => $this->profile->getEnum('religion'),
                'smoke'     => $this->profile->getEnum('smoke'),
                'drink'     => $this->profile->getEnum('drink'),
                'finance_income'     => $this->profile->getEnum('finance_income'),
                'english_level'     => $this->profile->getEnum('english_level'),
            ];

            $user = $this->user->find($id);
            $passport = $this->passport->where('user_id', '=', $id)->first();
            $countries = Country::all_order();

            return view('client.profile.edit')->with([
                'selects'   => $selects,
                'user'      => $user,
                'passport'  => $passport,
                'countries' => $countries,
                'id'        => $id,
            ]);
        } else
            return redirect('/'.\App::getLocale().'/profile/show/'.$id);

    }

    public function online()
    {
        if (\Auth::user()->hasRole('male')) {
            $users = User::where('role_id', '=', 5)->paginate(20);
        } else {
            $users = User::where('role_id', '=', 4)->paginate(20);
        }

        return view('client.profile.users')->with([
           'users' => $users,
        ]);
    }

    /**
     * Show the users photo albums and editing actions.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function profilePhoto(int $id)
    {
        $profile_images = profileImages::where('user_id', '=', $id)->get();
        $albums = Album::where('user_id', '=', $id)->get();

        return view('client.profile.photos')->with([
            'profile_images' => $profile_images,
            'albums' => $albums,
            'id' => $id,
        ]);
    }
    public function  profilePhotoAdd(Request $request, $id){

        if($request->hasFile('profile_photo')){
            $profile_photos = $request->file('profile_photo');
            foreach($profile_photos as $photo){
                $profile_image = new profileImages();
                $profile_image->url = $this->upload($photo, 'users/profile_photos/');
                $profile_image->user_id = $id;
                $profile_image->save();
            }
        }
        return redirect(\App::getLocale().'/profile/'.$id.'/photo');

    }
    public function profilePhotoDelete($photo_id){
        $image = profileImages::find($photo_id);
        $this->removeFile('/uploads/users/profile_photos/'.$image->image);
        profileImages::destroy($photo_id);
        return response('success', 200);
    }

    /**
     * Show the users videos and editing actions.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function profileVideo(int $id)
    {
        $id = Auth::user()->id;
        $videos = Videos::where('uid', '=', $id)->get();

        return view('client.profile.video')->with([
            'id' => $id,
            'videos' => $videos,
        ]);
    }

    /**
     * Show users income smiles.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function profileSmiles(int $id)
    {
        $smiles = Smiles::where('smiles.to', '=', $id)
            ->leftJoin('users', 'users.id', '=', 'smiles.from')
            ->select('users.first_name', 'users.avatar', 'smiles.from', 'smiles.to', 'smiles.updated_at')
            ->orderBy('updated_at', 'DESC')
            ->paginate(15);

        return view('client.profile.smiles')->with([
            'smiles' => $smiles
        ]);
    }

    /**
     * Show users finance statistic.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function profileFinance($id)
    {
        return view('client.profile.finance')->with([

        ]);
    }

    /**
     * Update the user profile in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(\Auth::user()->hasRole('Female')){
            $this->validate($request, [
                'first_name' => 'required',
                'second_name'  => 'required',
                'email'      => 'required',
                'birthday'   => 'required',
                'phone'     => 'required',
                'passno'    => 'required',
                'pass_date' => 'required',
            ]);
        }else{
            $this->validate($request, [
                'first_name' => 'required',
                'second_name'  => 'required',
                'email'      => 'required',
                'birthday'   => 'required',
                'phone'     => 'required',
            ]);
        }

        /* Обновление данных пользователя - таблица users */

        $user = User::find($id);

        if ($request->file('avatar')) {
            $file = $request->file('avatar');
            $user_avatar = time() . '-' . $file->getClientOriginalName();
            $destination = public_path() . '/uploads/users/avatars/';
            $file->move($destination, $user_avatar);
            $user->avatar = $user_avatar;
        }

        $user->first_name = $request->input('first_name');
        $user->last_name  = $request->input('second_name');
        $user->email      = $request->input('email');

        if(!empty($request->input('password')))
            $user->password   = bcrypt( $request->input('password'));

        $user->phone      = $request->input('phone');
        $user->country_id = $request->input('country');
        $user->state_id   = $request->input('state');
        $user->city_id    = $request->input('city');
        $user->status_message = NULL;
        if(Auth::user()->hasRole('Male')){
            $user->status_id = 1; //Статус профиля - активный
        }else{
            $user->status_id = 5; //Статус профиля - на модерации
        }

        $user->save();

        /* Сохранение паспортных данных девушки - таблица passport */

        if(\Auth::user()->hasRole('female')) {
            if( empty((Passport::where('user_id', '=', $id)->first())) ){
                $passport = new Passport();
                $passport->user_id = $id;
            }else{
                $passport = Passport::where('user_id', '=', $id)->first();
            }
            $passport->passno = str_replace(' ', '', $request->input('passno'));
            $passport->date = $request->input('pass_date');

            if ($request->hasFile('pass_photo')) {
                $user_passport = $this->upload($request->file('pass_photo'), 'users/passports/');
                $passport->cover = $user_passport;
            }
            $passport->save();
        }

        /* Сохранение профиля пользователя, таблица profiles */

        if( empty((Profile::where('user_id', '=', $id)->first())) ){

            $profile = new Profile();

            if($user->role_id == 5){
                $profile->gender   = "female";
            }elseif($user->role_id == 4){
                $profile->gender   = "male";
            }else{
                $profile->gender   = "---";
            }
            $profile->user_id   = $id;
            $profile->birthday   = $request->input('birthday');
            $profile->height    = $request->input('height');
            $profile->weight   = $request->input('weight');
            $profile->eyes       = $request->input('eyes');
            $profile->hair      = $request->input('hair');
            $profile->education = $request->input('education');
            $profile->kids      = $request->input('kids');
            $profile->kids_live      = $request->input('kids_live');
            $profile->want_kids = $request->input('want_kids');
            $profile->family    = $request->input('family');
            $profile->religion  = $request->input('religion');
            $profile->smoke     = $request->input('smoke');
            $profile->drink     = $request->input('drink');
            $profile->occupation= $request->input('occupation');
            $profile->about     = $request->input('about');
            $profile->looking   = $request->input('looking');
            $profile->l_age_start   = $request->input('l_age_start');
            $profile->l_age_stop    = $request->input('l_age_stop');
            $profile->l_height_start   = $request->input('l_height_start');
            $profile->l_height_stop    = $request->input('l_height_stop');
            $profile->l_weight_start   = $request->input('l_weight_start');
            $profile->l_weight_stop    = $request->input('l_weight_stop');
            $profile->finance_income   = $request->input('finance_income');
            $profile->english_level    = $request->input('english_level');
            $profile->know_lang  = $request->input('know_lang');
            $profile->zodiac = $this->zodiacSignService->getSignByBirthday($request->input('birthday'));
            $profile->save();
            return redirect('/profile/show/'.$id);
        } else {
            $profile = Profile::where('user_id', '=', $id)->first();
            $profile->user_id   = $id;
            $profile->birthday  = $request->input('birthday');
            $profile->height    = $request->input('height');
            $profile->weight    = $request->input('weight');
            $profile->eyes       = $request->input('eyes');
            $profile->hair      = $request->input('hair');
            $profile->education = $request->input('education');
            $profile->kids      = $request->input('kids');
            $profile->kids_live = $request->input('kids_live');
            $profile->want_kids = $request->input('want_kids');
            $profile->family    = $request->input('family');
            $profile->religion  = $request->input('religion');
            $profile->smoke     = $request->input('smoke');
            $profile->drink     = $request->input('drink');
            $profile->occupation =$request->input('occupation');
            $profile->about     = $request->input('about');
            $profile->looking   = $request->input('looking');
            $profile->l_age_start = $request->input('l_age_start');
            $profile->l_age_stop = $request->input('l_age_stop');
            $profile->l_height_start   = $request->input('l_height_start');
            $profile->l_height_stop    = $request->input('l_height_stop');
            $profile->l_weight_start   = $request->input('l_weight_start');
            $profile->l_weight_stop    = $request->input('l_weight_stop');
            $profile->finance_income   = $request->input('finance_income');
            $profile->english_level    = $request->input('english_level');
            $profile->know_lang  = $request->input('know_lang');
            $profile->zodiac = $this->zodiacSignService->getSignByBirthday($request->input('birthday'));
            $profile->save();
            return redirect('/profile/show/'.$id);
        }
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
    /**
     * Приостановление профиля (пользователем)
     */
    public function deactivate($id)
    {
        $user = $this->user->find($id);
        $user->status_id = 2; //Статус профиля - приостановлен
        $user->save();

        return redirect()->back();
    }
    /**
     * Активация профиля (пользователем)
     */
    public function activate($id)
    {
        $user = $this->user->find($id);
        if(Auth::user()->hasRole('Male')){
            $user->status_id = 1; //Статус профиля - активный
        }else{
            $user->status_id = 5; //Статус профиля - на модерации
        }
        $user->save();

        return redirect()->back();
    }
    public function delete($id)
    {
        $user = $this->user->find($id);
        $user->status_id = 4; //Статус профиля - удален
        $user->save();
        $user->delete();

        return redirect('/');
    }
}
