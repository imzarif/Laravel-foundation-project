<?php

namespace App\Http\Controllers\Platform\SuperAdmin;

use App\Constant\AppConstant;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ConceptRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Traits\ColorPickerTrait;

class DashboardController extends Controller
{
    /**
     * Display list of concept.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
            return view('platform.super-admin.dashboard.super-admin-dashboard');
    }

    public function create(Request $request)
    {
            return view('platform.super-admin.dashboard.super-admin-dashboard');
    }
}
