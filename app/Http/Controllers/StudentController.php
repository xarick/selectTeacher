<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\SelectToGroupM;
use App\Models\SelectToGroupO;
use App\Models\SelectToStudent;
use App\Models\SelectToStudentM;
use App\Models\User;
use App\Models\Year;
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

        $last = Year::where('active', true)->orderBy('id', 'DESC')->first();
        $scount = SelectToStudentM::where('year_id', $last->id)->where('student_id', auth()->user()->id)->count();

        return view('student.sciense-m', compact('scienses', 'scount'));
    }

    public function selectToStudentM($id)
    {
        $gcount = Group::findOrFail(auth()->user()->group_id);
        $last = Year::where('active', true)->orderBy('id', 'DESC')->first();

        $scount = SelectToStudentM::where('year_id', $last->id)->where('student_id', auth()->user()->id)->count();
        if ($gcount->com_science <= $scount) {
            return redirect()->back()->with("error", "Barcha o'qituvchilar tanlanib bo'lindi");
        }

        if (SelectToStudentM::where('year_id', $last->id)->where('student_id', auth()->user()->id)->where('select_to_group_m_id', $id)->exists()) {
            return redirect()->back()->with("error", "Bu o'qituvchi oldindan tanlangan");
        }

        $data = new SelectToStudentM;
        $data->year_id = $last->id;
        $data->student_id = auth()->user()->id;
        $data->select_to_group_m_id = $id;
        $data->active = true;
        $data->save();

        return redirect()->back()->with("success", "O'qituvchi tanlandi");
    }


    public function selectToStudentShowM(Request $request)
    {
        $last = Year::where('active', true)->orderBy('id', 'DESC')->first();

        $queryData = SelectToStudentM::query();
        $queryData->where('year_id', $last->id)->where('student_id', auth()->user()->id)->orderBy('id', 'DESC');

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

        return view('student.sciense-m-show', compact('scienses'));
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

        $last = Year::where('active', true)->orderBy('id', 'DESC')->first();
        $scount = SelectToStudent::where('year_id', $last->id)->where('student_id', auth()->user()->id)->count();

        return view('student.sciense-o', compact('scienses', 'scount'));
    }

    public function selectToStudentO($id)
    {
        $gcount = Group::findOrFail(auth()->user()->group_id);
        $last = Year::where('active', true)->orderBy('id', 'DESC')->first();

        $scount = SelectToStudent::where('year_id', $last->id)->where('student_id', auth()->user()->id)->count();
        if ($gcount->opt_science <= $scount) {
            return redirect()->back()->with("error", "Barcha fanlar tanlanib bo'lindi");
        }

        if (SelectToStudent::where('year_id', $last->id)->where('student_id', auth()->user()->id)->where('select_to_group_o_id', $id)->exists()) {
            return redirect()->back()->with("error", "Bu fan oldindan tanlangan");
        }

        $data = new SelectToStudent;
        $data->year_id = $last->id;
        $data->student_id = auth()->user()->id;
        $data->select_to_group_o_id = $id;
        $data->active = true;
        $data->save();

        return redirect()->back()->with("success", "Fan tanlandi");
    }


    public function selectToStudentShowO(Request $request)
    {
        $last = Year::where('active', true)->orderBy('id', 'DESC')->first();

        $queryData = SelectToStudent::query();
        $queryData->where('year_id', $last->id)->where('student_id', auth()->user()->id)->orderBy('id', 'DESC');

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

        return view('student.sciense-o-show', compact('scienses'));
    }
}
