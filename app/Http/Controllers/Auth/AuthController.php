<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Social;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Validator;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $auth;
    private $social_user;
    protected $redirectAfterLogout = '/';
    // @todo check user status

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'resendEmail', 'activateAccount'],
                                ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name'  => 'required|max:255',
            'email'      => 'required|email|max:255|unique:users',
            'password'   => 'required|confirmed|min:6',
            'checkTerms' => 'required',
        ]);
    }
    /**
     * Create a new user instance after a valid registration.
     * Создает нового пользователя после успешной регистрации (в таблице users)
     * Создает профиль пользователя (в таблице profiles) и инициализирует его начальными данными
     *
     * @param array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        $status_id = 6; //Статус - профиль не заполнен
        $user = new User([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'password'   => bcrypt($data['password']),
            'role_id'    => $data['gender'],
            'partner_id' => 1,
            'status_id'  => $status_id,
        ]);
        $user->save();

        $profile = new Profile();

        $profile->user_id = $user->id;
        if($user->role_id == 4){
            $profile->gender = 'male';
        }elseif($user->role_id == 5){
            $profile->gender = 'female';
        }else{
            $profile->gender = '---';
        }
        $profile->birthday = '1900-01-01';
        $profile->l_age_start = 18;
        $profile->l_age_stop = 99;

        $profile->save();

        return $user;
    }

    /** @todo Sender  */
    public function sendEmail(User $user)
    {
        $data = [
            'name' => $user->first_name.' '.$user->last_name,
            'code' => $user->activation_code,
        ];

        \Mail::queue('emails.activateAccount', $data, function ($message) use ($user) {
            $message->subject(\Lang::get('auth.pleaseActivate'));
            $message->to($user->email);
        });
    }

    public function resendEmail()
    {
        $user = \Auth::user();
        if ($user->resent >= 3) {
            return view('auth.tooManyEmails')->with('email', $user->email);
        } else {
            $user->resent = $user->resent + 1;
            $user->save();
            $this->sendEmail($user);

            return view('auth.activateAccount')->with('email', $user->email);
        }
    }

    //@todo Activation
    public function activateAccount($code, User $user)
    {
        if ($user->accountIsActive($code)) {
            \Session::flash('message', \Lang::get('auth.successActivated'));

            return redirect('/');
        }
    }

    public function getSocialRedirect($provider)
    {
        $providerKey = \Config::get('services.'.$provider);

        if (empty($providerKey)) {
            return view('pages.status')->with('error', 'No such provider');
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * @param $provider
     */
    public function getSocialHandle($provider)
    {
        $user = Socialite::driver($provider)->user();

        $user_check = Social::where('provider', '=', $provider)->where('social_id', '=', $user->getId())->first();
        $user_check_email = User::where('email', '=', $user->getEmail())->first();

        if ($user_check || $user_check_email) {
            \Auth::loginUsingId($user_check->user_id);

            return redirect('/');
        } else {
            $name = explode(' ', $user->getName());
            $password = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 15);
            $email = $user->getEmail();

            if ($provider == 'twitter') {
                $role_id = 6;
                $email = $user->getName().'@twitter.com';
            } else {
                if ($user->user['gender'] == 'male') {
                    $role_id = 4;
                } elseif ($user->user['gender'] == 'female') {
                    $role_id = 5;
                }
            }

            $usr = new User();
            $usr->first_name = $name[0];
            $usr->last_name = $name[1];
            $usr->email = $email;
            $usr->password = bcrypt($password);
            $usr->role_id = $role_id;
            $usr->save();

            $social = new Social();
            $social->provider = $provider;
            $social->social_id = $user->getId();

            $profile = new Profile();
            $profile->user_id = $usr->id;
            if($usr->role_id == 4){
                $profile->gender = 'male';
            }elseif($usr->role_id == 5){
                $profile->gender = 'female';
            }else{
                $profile->gender = '---';
            }
            $profile->birthday = '1900-01-01';
            $profile->l_age_start = 18;
            $profile->l_age_stop = 99;

            $profile->save();


            $usr->social()->save($social);

            \Auth::loginUsingId($usr->id);

            return redirect('/');
        }
    }
}
