<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\UserLogDataTable;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\DataTables;

class UserLogController extends Controller
{
    public function index(UserLogDataTable $dataTable)
    {        
        return $dataTable->render('users.activity');
    }

    public function dataUserLog(Request $request)
    {
        $activities = Activity::where('causer_id', auth()->user()->id)->latest()->get();

        return DataTables::of($activities)
        ->addColumn('created_at', function ($activity) {
            return $activity->created_at->diffForHumans();
         })
        ->toJson();
    }
}
