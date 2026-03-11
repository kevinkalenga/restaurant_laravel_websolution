<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SectionTitle;
use App\Models\WhyChooseUs;
use Yajra\DataTables\DataTables;

class WhyChooseUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       if ($request->ajax()) {

        $data = WhyChooseUs::select(['id','icon','title','short_description','status']);

        return DataTables::of($data)
            ->addColumn('action', function ($row) {

                $edit = '<a href="'.route('admin.why-choose-us.edit',$row->id).'" class="btn btn-primary btn-sm">Edit</a>';

                $delete = '<a href="#" data-id="'.$row->id.'" class="btn btn-danger btn-sm delete-item">Delete</a>';

                return $edit.' '.$delete;
            })
            ->make(true);
       }

       $keys = ['why_choose_top_title', 'why_choose_main_title', 'why_choose_sub_title'];
       $titles = SectionTitle::whereIn('key', $keys)->pluck('value', 'key');

       return view('admin.why-choose-us.index', compact('titles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.why-choose-us.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
           'icon' => ['required','max:50'],
           'title' => ['required','max:255'],
           'short_description' => ['required','max:500'],
           'status' => ['required','boolean']
        ]);

        WhyChooseUs::create($data);

        return redirect()->route('admin.why-choose-us.index')->with('success', 'Item created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function updateTitle(Request $request)
    {
       $request->validate([
          'why_choose_top_title' => ['max:100'],
          'why_choose_main_title' => ['max:200'],
          'why_choose_sub_title' => ['max:500'],
       ]);

       SectionTitle::updateOrCreate(
        ['key' => 'why_choose_top_title'],
        ['value' => $request->why_choose_top_title],
       
      );
       SectionTitle::updateOrCreate(
        ['key' => 'why_choose_main_title'],
        ['value' => $request->why_choose_main_title],
       
      );
       SectionTitle::updateOrCreate(
        ['key' => 'why_choose_sub_title'],
        ['value' => $request->why_choose_sub_title],
       
      );

      return redirect()->back()->with('status', 'Updated Titles Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
