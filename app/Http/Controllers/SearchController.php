<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    private $users;
    private $profile;

    public function __construct(User $user, Profile $profile)
    {
        $this->users = $user->paginate(20);
        $this->profile = new Profile();
        parent::__construct();
    }

    public function index()
    {
        $required_gender = 'female';
        if(\Auth::user() && \Auth::user()->hasRole('Female')){
            $required_gender = 'male';
        }
        return view('client.search')->with([
            'required_gender' => $required_gender,
            'selects'   => $this->getSelects(),
            'users'     => $this->getUsers($this->getRole()),
            'countries' => Country::all(),
        ]);
    }

    public function search(Request $request)
    {

        $users = $this->searchGetProfiles($request);
        $required_gender = 'female';
        if(\Auth::user() && \Auth::user()->hasRole('Female')){
            $required_gender = 'male';
        }

        return view('client.search')->with([
            'users' => $users['find_users'],
            'required_gender' => $required_gender,
            'selects' => $this->getSelects(),
            'search_attrs' => $request,
            'countries' => Country::all(),
        ]);
    }

    public function searchGetProfiles($request){

        $profile_attrs=$request->input();
        if(isset($profile_attrs['is_avatar']) && $profile_attrs['is_avatar']==1){
            $avatar='';
        }else{
            $avatar='iss_set';
        }
        $find_users=User::select(['users.*','profile.birthday'])
            ->whereHas('profile', function ($query) use ($profile_attrs){
                $arr_between_age = '(`birthday` BETWEEN  STR_TO_DATE(YEAR(CURDATE())-'.$profile_attrs["age_stop"].', "%Y") AND STR_TO_DATE(YEAR(CURDATE())-'.($profile_attrs["age_start"]-1).', "%Y"))';
                $arr_between_weight = '(`weight` BETWEEN  '.$profile_attrs["weight_start"].' AND '.$profile_attrs["weight_stop"].')';
                $arr_between_height = '(`height` BETWEEN  '.$profile_attrs["height_start"].' AND '.$profile_attrs["height_stop"].')';
                if(isset($profile_attrs['age_start']) && $profile_attrs['age_start']!='---'){      $query->whereRaw($arr_between_age );}
                if(isset($profile_attrs['weight_start']) && $profile_attrs['weight_start']!='---'){      $query->whereRaw($arr_between_weight );}
                if(isset($profile_attrs['height_start']) && $profile_attrs['height_start']!='---'){      $query->whereRaw($arr_between_height );}
                if(isset($profile_attrs['zodiac']) && $profile_attrs['zodiac'][0]!='---'){ $query->whereIn('zodiac', $profile_attrs['zodiac']);}
                if(isset($profile_attrs['hair']) && $profile_attrs['hair'][0]!='---'){ $query->whereIn('hair', $profile_attrs['hair']);}
                if(isset($profile_attrs['eyes']) && $profile_attrs['eyes'][0]!='---'){ $query->whereIn('eyes', $profile_attrs['eyes']);}
                if(isset($profile_attrs['education']) && $profile_attrs['education'][0]!='---'){ $query->whereIn('education', $profile_attrs['education']);}
                if(isset($profile_attrs['kids']) && $profile_attrs['kids']!='---'){      $query->where('kids', '=', $profile_attrs['kids']);}
                if(isset($profile_attrs['want_kids']) && $profile_attrs['want_kids']!='---'){ $query->where('want_kids', '=', $profile_attrs['want_kids']);}
                if(isset($profile_attrs['family']) && $profile_attrs['family'][0]!='---'){ $query->whereIn('family', $profile_attrs['family']);}
                if(isset($profile_attrs['religion']) && $profile_attrs['religion'][0]!='---'){  $query->whereIn('religion', $profile_attrs['religion']);}
                if(isset($profile_attrs['smoke']) && $profile_attrs['smoke']!='---'){     $query->where('smoke', '=', $profile_attrs['smoke']);}
                if(isset($profile_attrs['drink']) && $profile_attrs['drink']!='---'){     $query->where('drink', '=', $profile_attrs['drink']);}
            })

            ->where('role_id', '=', $profile_attrs['looking'])
            ->where('status_id', '=', '1')
            ->where('avatar','!=', $avatar)

            ->where(function ($query) use ($profile_attrs){
                if (isset($profile_attrs['country']) && $profile_attrs['country']!='false'){
                    $query->where('country_id', '=', $profile_attrs['country']);
                }
            })
            ->join('profile', 'users.id', '=', 'profile.user_id')
            ->paginate(20);
        return [
            'find_users' => $find_users,
        ];
    }

    private function getSelects()
    {
        return [
            'zodiac'    => array('---'=>'---')+$this->profile->getEnum('zodiac'),
            'hair'      => array('---'=>'---')+$this->profile->getEnum('hair'),
            'eyes'      => array('---'=>'---')+$this->profile->getEnum('eyes'),
            'education' => array('---'=>'---')+$this->profile->getEnum('education'),
            'kids'      => array('---'=>'---')+$this->profile->getEnum('kids'),
            'want_kids' => array('---'=>'---')+$this->profile->getEnum('want_kids'),
            'family'    => array('---'=>'---')+$this->profile->getEnum('family'),
            'religion'  => array('---'=>'---')+$this->profile->getEnum('religion'),
            'smoke'     => array('---'=>'---')+$this->profile->getEnum('smoke'),
            'drink'     => array('---'=>'---')+$this->profile->getEnum('drink'),
        ];
    }
}
