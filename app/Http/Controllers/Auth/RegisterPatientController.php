<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Patient;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Auth;
class RegisterPatientController extends Controller
{
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

    use RegistersUsers;

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
     public function showRegistrationForm()
     {
       return view('auth.register-patient');
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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'birthday' =>'required|date',
            'd_type'=>'required|numeric|in:1,2,3'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
      $patient= Patient::create([
        'birthday' =>$data['birthday'],
        'd_type'=>$data['d_type'],
        'doctor_id'=>Auth::user()->id,
      ]);
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'owner_id'=>$patient->id,
            'owner_type'=>"patient"
        ]);
    }
}
