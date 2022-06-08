<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SelectToGroupM;
use App\Models\SelectToGroupO;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function scienseM(Request $request)
    {
        $queryData = SelectToGroupM::query();
        $queryData->where('group_id', auth()->user()->group_id)->orderBy('id', 'DESC');

        $name = $request->name;
        // if ($name != '') {
        //     $queryData->where(function ($q) use ($name) {
        //         return $q->where('name', 'ilike', '%' . $name . '%');
        //     });
        // }

        $scienses = $queryData->paginate(15);
        $scienses->appends([
            'name' => $name,
        ]);

        return view('student.sciense-m', compact('scienses'));
    }

    public function scienseO(Request $request)
    {
        $queryData = SelectToGroupO::query();
        $queryData->where('group_id', auth()->user()->group_id)->orderBy('id', 'DESC');

        $name = $request->name;
        // if ($name != '') {
        //     $queryData->where(function ($q) use ($name) {
        //         return $q->where('name', 'ilike', '%' . $name . '%');
        //     });
        // }

        $scienses = $queryData->paginate(15);
        $scienses->appends([
            'name' => $name,
        ]);

        return view('student.sciense-o', compact('scienses'));
    }
}
