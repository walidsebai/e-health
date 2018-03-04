<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Doctor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
class RegisterDoctorController extends Controller
{
    use RegistersUsers;
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    public function showRegistrationForm()
    {
      return view('auth.register-doctor');
    }

    public function register(Request $request)
  {
      //dd($request);
      $this->validator($request->all())->validate();

      $user = $this->create($request->all());

      //$this->guard()->login($user);

      return $this->registered($request, $user)
                      ?: redirect($this->redirectPath());
  }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'birthday' =>'required|date',
            'public'=>'required|boolean',
            'addresse'=>'required|string'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function create(array $data)
    {
      //dd($data);
      $doctor= Doctor::create([
        'birthday'=>$data['birthday'],
        'public'=>$data['public'],
        'addresse'=>$data['addresse']
      ]);
      $user=User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
        'owner_id'=>$doctor->id,
        'owner_type'=>"doctor"
    ]);

        return $user;
    }
    protected function registered(Request $request, $user)
    {
        //
    }
}
