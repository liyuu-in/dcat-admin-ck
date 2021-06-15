<?php

namespace Liyuu\DcatAdminCk\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Liyuu\DcatAdminCk\Http\Middleware\CKFinderMiddleware;

class DcatAdminCkController extends Controller
{
    public function __construct()
    {
        $authenticationMiddleware = config('ckfinder.authentication');

        if ($authenticationMiddleware) {
            $this->middleware($authenticationMiddleware);
        } else {

            $this->middleware(CKFinderMiddleware::class);
        }
    }

    public function requestAction(Request $request)
    {
        //dd($request);
        return app('CKConnector')->handle($request);
    }

    public function browserAction(Request $request)
    {
        return view('dcat-ck::browser');
    }
}
