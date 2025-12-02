<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Journal;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $journals = Journal::get();
        return view('masters.journal_index',compact('journals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::get();
        return view('masters.journal_create',compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'journal_name' => 'required',
            'journal_group' => 'required',
            'opening_balane' => 'nullable|numeric'
        ]);

        $data = $request->all();
        $data['balance'] = $request->opening_balance;
        $status = Journal::create($data);
        if($status)
        {
            Toastr::success('Journal added successfully', 'success', ["positionClass" => "toast-bottom-right"]);
        }
        else
        {
            Toastr::error('try again!', 'error', ["positionClass" => "toast-bottom-right"]);
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $journal = Journal::findOrFail($id);
        $group = Group::findOrFail($journal->journal_group);
        return view('masters.journal_show',compact('journal','group'));
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
        //
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
}
