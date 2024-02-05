<?php

namespace App\Http\Controllers\Auth;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
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
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $route = route('register');
        return view('auth.register', compact('route'));
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(
        array $data,
        RolesEnum|string $roleName = RolesEnum::USER
    )
    {
        $role = Role::where('name', $roleName)->first();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ])->assignRole($role);

        // Sync permissions for the role
        if ($roleName == RolesEnum::USER) {
            $role->syncPermissions(PermissionsEnum::VIEW_TASKS);
            $user->syncPermissions(PermissionsEnum::VIEW_TASKS);
        } else {
            $role->syncPermissions(PermissionsEnum::VIEW_TASKS,
                PermissionsEnum::EDIT_TASKS);
            $user->syncPermissions(PermissionsEnum::VIEW_TASKS,
                PermissionsEnum::EDIT_TASKS);
        }

        return $user;
    }

    public function showRegistrationFormManager()
    {
        $route = route('register.manager');
        return view('auth.register', compact('route'));
    }

    /**
     * @throws ValidationException
     */
    public function registerAsManager(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered(
            $user = $this->create($request->all(), RolesEnum::MANAGER)));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }
}
