<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\staffs;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->company_group == 'Qatar') {
            $projects = Project::where('status', 'active')->where('given_by', 'Qatar')->get();
        } else {
            $projects = Project::where('status', 'active')->get();
        }
        $page_headline = 'Pending Projects';
        $project_count = DB::table('projects')->where('status', 'active')->count();
        return view('projects.index', compact('projects', 'page_headline', 'project_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $staffs = User::join('staffs', 'users.id', 'staffs.user_id')->Where('staffs.status', 'active')->get();
        $staffs = staffs::where('status', 'active')->get();
        return view('projects.create', compact('staffs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'project_name' => 'required',
            'customer' => 'required',
            'team_leader' => 'required',
            'end_date' => 'nullable',
            'budget' => 'nullable',
        ]);
        $data = $request->all();
        // return $data;
        $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d');

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        // return $request->team_members;
        if ($request->team_members) {
            $data['team_members'] = implode(', ', $request->team_members);
        }
        if ($request->attachment1) {
            $attachment = $request->file('attachment1');
            $attachmentName = time() . '.' . $request->file('attachment1')->getClientOriginalName();
            $attachment->storeAs('public/projects/', $attachmentName);
            $data['attachment1'] = $attachmentName;
        }
        if ($request->attachment2) {
            $attachment = $request->file('attachment2');
            $attachmentName = time() . '.' . $request->file('attachment2')->getClientOriginalName();
            $attachment->storeAs('public/projects', $attachmentName);
            $data['attachment2'] = $attachmentName;
        }
        if ($request->attachment3) {
            $attachment = $request->file('attachment3');
            $attachmentName = time() . '.' . $request->file('attachment3')->getClientOriginalName();
            $attachment->storeAs('public/projects', $attachmentName);
            $data['attachment3'] = $attachmentName;
        }
        if ($request->attachment4) {
            $attachment = $request->file('attachment4');
            $attachmentName = time() . '.' . $request->file('attachment4')->getClientOriginalName();
            $attachment->storeAs('public/projects', $attachmentName);
            $data['attachment4'] = $attachmentName;
        }
        // image upload end

        $status = Project::create($data);
        if ($status) {
            Toastr::success('Project Added', 'success', ['positionClass' => 'toast-bottom-right']);
            return redirect()->route('project.index');
        } else {
            Toastr::error('try again!', 'error', ['positionClass' => 'toast-bottom-right']);
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::findOrFail($id);
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $this->validate($request, [
            'project_name' => 'required',
            'project_description' => 'nullable',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
            'budget' => 'nullable',
            'attachment1' => 'required',
        ]);
        $data = $request->all();
        $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d');

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        // return $request->team_members;
        if ($request->team_members) {
            $data['team_members'] = implode(', ', $request->team_members);
        }
        if ($request->attachment1) {
            $attachment = $request->file('attachment1');
            $attachmentName = time() . '.' . $request->file('attachment1')->getClientOriginalName();
            $attachment->storeAs('public/projects/', $attachmentName);
            $data['attachment1'] = $attachmentName;
        }
        if ($request->attachment2) {
            $attachment = $request->file('attachment2');
            $attachmentName = time() . '.' . $request->file('attachment2')->getClientOriginalName();
            $attachment->storeAs('public/projects', $attachmentName);
            $data['attachment2'] = $attachmentName;
        }
        if ($request->attachment3) {
            $attachment = $request->file('attachment3');
            $attachmentName = time() . '.' . $request->file('attachment3')->getClientOriginalName();
            $attachment->storeAs('public/projects', $attachmentName);
            $data['attachment3'] = $attachmentName;
        }
        if ($request->attachment4) {
            $attachment = $request->file('attachment4');
            $attachmentName = time() . '.' . $request->file('attachment4')->getClientOriginalName();
            $attachment->storeAs('public/projects', $attachmentName);
            $data['attachment4'] = $attachmentName;
        }
        // image upload end

        $status = $project->fill($data)->save();

        if ($status) {
            Toastr::success('Project Edited', 'success', ['positionClass' => 'toast-bottom-right']);
            return redirect()->back();
        } else {
            Toastr::error('try again!', 'error', ['positionClass' => 'toast-bottom-right']);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function view_delivered()
    {
        if (Auth::user()->company_group == 'Qatar') {
            $projects = Project::where('status', 'delivered')->where('given_by', 'Qatar')->get();
        } else {
            $projects = Project::where('status', 'delivered')->get();
        }
        $page_headline = 'Delivered Projects';
        $project_count = DB::table('projects')->where('status', 'delivered')->count();
        return view('projects.index', compact('projects', 'page_headline', 'project_count'));
    }

    public function view_rejected()
    {
        if (Auth::user()->company_group == 'Qatar') {
            $projects = Project::where('status', 'rejected')->where('given_by', 'Qatar')->get();
        } else {
            $projects = Project::where('status', 'rejected')->get();
        }
        $page_headline = 'Rejected Projects';
        $project_count = DB::table('projects')->where('status', 'rejected')->count();
        return view('projects.index', compact('projects', 'page_headline', 'project_count'));
    }

    public function deliver(Request $request, $id)
    {
        $data['status'] = 'delivered';
        $data['payment_status'] = $request->payment_status;
        $project_details = DB::table('projects')->where('id', $id)->first();
        $customer_details = DB::table('customers')->where('id', $project_details->customer)->first();
        $status = DB::table('projects')->where('id', $id)->update($data);
        if ($status) {
            if ($request->payment_status == 'paid') {
                $payment_method = $request->payment_method;
                $daybook_data['date'] = carbon::now()->format('Y-m-d');
                $daybook_data['income_id'] = 'From_Project';
                $daybook_data['project'] = $id;
                $daybook_data['amount'] = $project_details->budget;
                $daybook_data['type'] = 'Income';
                $daybook_data['accounts'] = $request->payment_method;

                $daybook_status = DB::table('daybooks')->insert($daybook_data);
            } elseif ($request->payment_status == 'not paid') {
                $customer_data['balance'] = $customer_details->balance + $project_details->budget;
                $customer_status = DB::table('customers')->where('id', $project_details->customer)->update($customer_data);
            }
            Toastr::success('Project delivered', 'success', ['positionClass' => 'toast-bottom-right']);
            return redirect()->route('project.delivered');
        } else {
            Toastr::error('try again!', 'error', ['positionClass' => 'toast-bottom-right']);
            return redirect()->back();
        }
    }

    public function reject($id)
    {
        $data['status'] = 'rejected';
        $status = DB::table('projects')->where('id', $id)->update($data);
        if ($status) {
            Toastr::success('Project Rejected', 'success', ['positionClass' => 'toast-bottom-right']);
            return redirect()->route('project.rejected');
        } else {
            Toastr::error('try again!', 'error', ['positionClass' => 'toast-bottom-right']);
            return redirect()->back();
        }
    }

    public function view_works($id)
    {
        $works = DB::table('works')->where('project', $id)->get();
        return view('works.index', compact('works'));
    }
}
