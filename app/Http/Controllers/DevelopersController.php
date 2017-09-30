<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

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

    public function approve($developer_id)
    {
        $user = User::find($developer_id);
        $user->approveAsDeveloper();

        return redirect('/desarrolladores/solicitudes')->with(['status', "El desarrollador {$user->name} ha sido aprobado"]);
    }

    public function applies()
    {
        $applicants = User::applicant()->get();

        return view('developers.applicants', compact('applicants'));
    }
}
