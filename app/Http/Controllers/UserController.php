<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * A description of the entire PHP function.
     *
     * @return Inertia
     */
    public function index()
    {
        $paginate = User::whereNot('id', auth()->user()->id)->paginate(12);
        return Inertia::render('User/Index', [
            'paginate' => $paginate
        ]);
    }

    /**
     * A description of the entire PHP function.
     *
     * @param Request $request description
     * @throws Exception description of exception
     * @return mixed
     */
    public function bulkDestroy(Request $request)
    {
        User::destroy($request->ids);
        return back();/*  */
    }


    /**
     * A description of the entire PHP function.
     *
     * @param User $user description
     * @throws Some_Exception_Class description of exception
     * @return mixed
     */
    public function destroy(User $user)
    {
        $user->delete();
        return back();
    }

    public function search(Request $request)
    {
        $users = User::where('status', 1)
            ->whereNot('id', auth()->user()->id)
            ->whereHas('roles', fn ($q) => $q->where('name', 'administrador'))->limit(5);
        return response()->json($users->get());
    }
}
