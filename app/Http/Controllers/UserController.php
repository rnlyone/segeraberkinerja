<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function flogin()
    {
        return view('welcome');
    }

    public function login(Request $request)
    {
        #logic untuk autentikasi
        $user = User::where('username', $request->username)->first();

        $attr = request()->validate([
            'username' => ['required'],
            'password' => ['required', 'min:8'],
        ]);

        if (Auth::attempt($attr)){
            Auth::login($user);
        return redirect()->route('dashboard')->with('sukses', "Login Sukses");
        } else {
            return back()->with('error', 'Username / Password Salah!');
        }
    }

    public function logout()
    {
            Auth::logout();
            return redirect()->intended('/login')->with('sukses', 'logout berhasil');
    }

    public function dashboard()
    {
        $customcss = '';
        // $jmlsetting = Setting::where('group', 'env')->get();
        $settings = ['customcss' => $customcss,
                     'title' => 'Dashboard',
                     'baractive' => 'dashboardbar',
                    ];
                    // foreach ($jmlsetting as $i => $set) {
                    //     $settings[$set->setname] = $set->value;
                    //  }


        return view('dashboard', [
            $settings['baractive'] => 'active',
            'stgs' => $settings,
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
