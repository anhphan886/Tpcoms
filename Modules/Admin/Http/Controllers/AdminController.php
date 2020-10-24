<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return redirect()->route(LOGIN_HOME_PAGE);
    }

    public function changeLocale(Request $request, $locale)
    {
        $request->session()->put('locale', $locale);

        return back();
    }
}
