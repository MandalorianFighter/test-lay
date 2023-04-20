<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\ActivityDataTable;
use Spatie\Activitylog\Models\Activity;
use App\Models\User;
use Yajra\DataTables\DataTables;

class ActivityController extends Controller
{
    public function index(ActivityDataTable $dataTable)
    {        
        return $dataTable->render('admin.activity');
    }

    public function dataActivity(Request $request)
    {
        $activities = Activity::with('causer')->latest()->get();

        return DataTables::of($activities)
        ->addColumn('created_at', function ($activity) {
            return $activity->created_at->diffForHumans();
         })
         ->addColumn('user', function ($activity) {
            return $activity->causer ? $activity->causer->name : "Deleted User";
        })
        ->toJson();
    }

    public function searchU(Request $request)
    {
        $search = $request->q;
        $data = User::select('id','name')->where('name', 'LIKE', "%$search%")->get();

        return response()->json($data);
    }
}


