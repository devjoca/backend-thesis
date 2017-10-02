<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Password;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use Laravel\Passport\ClientRepository;

class DevelopersController extends Controller
{
    public function index()
    {
        return view('developers.index');
    }

    public function apply()
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
        ], [
            'email.unique' => 'Este email ya ha sido escogido',
        ]);

        User::createDeveloper(request('name'), request('email'));

        return redirect()->back()->with(['status' => 'Su solicitud será aprobada por los administradores']);
    }

    public function approve($developer_id, ClientRepository $clients)
    {
        $user = User::find($developer_id);
        $user->approveAsDeveloper();

        Password::broker()->sendResetLink(['email' => $user->email]);

        $clients->createPersonalAccessClient(
            $user->id, $user->name, 'http://localhost'
        );

        return redirect('/desarrolladores/solicitudes')->with(['status', "El desarrollador {$user->name} ha sido aprobado"]);
    }

    public function listKeys()
    {

        return view('developers.keys');
    }

    public function applies()
    {
        $applicants = User::applicant()->get();

        return view('developers.applicants', compact('applicants'));
    }

    public function storePersonalAccessToken(ClientRepository $clients)
    {
       request()->validate([
            'name' => 'required|max:255',
            'scopes' => 'array|in:'.implode(',', Passport::scopeIds()),
        ]);

        Passport::personalAccessClient(Client::where('user_id', Auth::id())->first()->id);

        return request()->user()->createToken(
            request('name'), request('scopes') ?: []
        );
    }
}
