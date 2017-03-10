<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        Auth::user()->hasRole(['Owner', 'Moder', 'Partner']);

        view()->share('new_ticket_messages', parent::getUnreadMessages());
        view()->share('unread_ticket_count', parent::getUnreadMessagesCount());
    }

    public function login()
    {
        return view('admin.auth.login');
    }

    public function dashboard() /* Готово */
    {

        $heading = 'Управление';

        if(Auth::user()->hasRole('Owner') || Auth::user()->hasRole('Moder')) {
            $girls = User::where('role_id', '=', '5')->get();

            $active = User::where('role_id', '=', '5')
                ->where('status_id', '=', 1)
                ->get();
            $deactive = User::where('role_id', '=', '5')
                ->where('status_id', '=', 2)
                ->get();

            $dismiss = User::where('role_id', '=', '5')
                ->where('status_id', '=', 3)
                ->get();

            $deleted = User::withTrashed()
                ->where('role_id', '=', '5')
                ->where('status_id', '=', 4)
                ->get();

            $moderation = User::where('role_id', '=', '5')
                ->where('status_id', '=', 5)
                ->get();

            $noprofile = User::where('role_id', '=', '5')
                ->where('status_id', '=', 6)
                ->get();

            $men = User::where('role_id', '=', '4')->get();

            $m_active = User::where('role_id', '=', '4')
                ->where('status_id', '=', 1)
                ->get();
            $m_deactive = User::where('role_id', '=', '4')
                ->where('status_id', '=', 2)
                ->get();

            $m_dismiss = User::where('role_id', '=', '4')
                ->where('status_id', '=', 3)
                ->get();

            $m_deleted = User::withTrashed()
                ->where('role_id', '=', '4')
                ->where('status_id', '=', 4)
                ->get();

            $m_moderation = User::where('role_id', '=', '4')
                ->where('status_id', '=', 5)
                ->get();

            $m_noprofile = User::where('role_id', '=', '4')
                ->where('status_id', '=', 6)
                ->get();

            $partner = User::where('role_id', '=', '3')->get();
            $moderator = User::where('role_id', '=', '2')->get();


            return view('admin.dashboard')->with([
                'heading' => $heading,

                'girls' => $girls,
                'active' => $active,
                'deactive' => $deactive,
                'dismiss' => $dismiss,
                'deleted' => $deleted,
                'moderation' => $moderation,
                'noprofile' => $noprofile,

                'men' => $men,
                'm_active' => $m_active,
                'm_deactive' => $m_deactive,
                'm_dismiss' => $m_dismiss,
                'm_deleted' => $m_deleted,
                'm_moderation' => $m_moderation,
                'm_noprofile' => $m_noprofile,

                'partner' => $partner,
                'moderator' => $moderator,

            ]);
        }
        if(Auth::user()->hasRole('Partner')){
            $girls = User::where('role_id', '=', '5')
                ->where('partner_id', '=', Auth::user()->id)
                ->get();

            $active = User::where('role_id', '=', '5')
                ->where('partner_id', '=', Auth::user()->id)
                ->where('status_id', '=', 1)
                ->get();
            $deactive = User::where('role_id', '=', '5')
                ->where('partner_id', '=', Auth::user()->id)
                ->where('status_id', '=', 2)
                ->get();

            $dismiss = User::where('role_id', '=', '5')
                ->where('partner_id', '=', Auth::user()->id)
                ->where('status_id', '=', 3)
                ->get();

            $deleted = User::withTrashed()
                ->where('role_id', '=', '5')
                ->where('partner_id', '=', Auth::user()->id)
                ->where('status_id', '=', 4)
                ->get();

            $moderation = User::where('role_id', '=', '5')
                ->where('partner_id', '=', Auth::user()->id)
                ->where('status_id', '=', 5)
                ->get();

            return view('admin.dashboard')->with([
                'heading' => $heading,
                'girls' => $girls,
                'active' => $active,
                'deactive' => $deactive,
                'dismiss' => $dismiss,
                'deleted' => $deleted,
                'moderation' => $moderation,
            ]);
        }
    }

    public function all_users()
    {
        $header = 'Все пользователи';
        $u = new User();
        $users = $u->where('users.role_id', '=', 1)
                    ->orWhere('users.role_id', 2)
                    ->orWhere('users.role_id', 3)
                    ->rightJoin('roles', 'users.role_id', '=', 'roles.id')
                    ->select(['users.id', 'email', 'first_name', 'last_name', 'name'])
                    ->paginate(15);

        return view('admin.profile.index')->with([
            'users'   => $users,
            'heading' => $header,

        ]);

        /*$users = DB::table('users')
            ->rightJoin('roles', 'users.role_id', '=', 'roles.id')
            ->get(['users.id', 'email', 'first_name', 'last_name', 'name']);*/
    }

    public function profile()
    {
        $id = Auth::id();

        $user = User::find($id);

        return view('admin.profile.partners.edit')->with([
            'user'    => $user,
            'heading' => 'Профиль пользователя',

        ]);
    }

    public function profile_update(Request $request)
    {
        $user = User::find($request->input('id'));

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');

        $user->address = $request->input('address');
        $user->company_name = $request->input('company');
        $user->info = $request->input('info');
        $user->contacts = $request->input('contacts');

        // Check email changes
        if ($request->input('email') != $user->email) {
            $user->email = $request->input('email');
        }

        // Check password changes
        if (!empty($request->input('confirm'))) {
            if ($request->input('confirm') == $request->input('password')) {
                $user->password = brypt($request->input('password'));
            }
        }

        /* Check new file*/
        if (!empty($request->file())) {
            if (File::exists('/uploads/admins/'.$user->avatar)) {
                File::delete('/uploads/admins/'.$user->avatar);
            } // delete old file

            $file = $request->file('avatar');

            $fileName = time().'-'.$file->getClientOriginalName();
            $destination = public_path().'/uploads/admins';
            $file->move($destination, $fileName);

            $user->avatar = $fileName;
        }

        $user->save();

        return redirect('/admin/profile');
    }
}
