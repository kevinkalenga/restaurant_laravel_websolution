<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use App\Models\Counter;

class CounterController extends Controller
{
    use FileUploadTrait;
    
    public function index()
    {
        $counter = Counter::first();

      return view('admin.counter.index', compact('counter'));
    }
    
    
    public function update(Request $request)
    {
        $counter = Counter::first();

        $request->validate([
            'background' => 'nullable|image|max:2048',

            'counter_icon_one' => 'required|string|max:255',
            'counter_count_one' => 'required|string|max:255',
            'counter_name_one' => 'required|string|max:255',

            'counter_icon_two' => 'required|string|max:255',
            'counter_count_two' => 'required|string|max:255',
            'counter_name_two' => 'required|string|max:255',

            'counter_icon_three' => 'required|string|max:255',
            'counter_count_three' => 'required|string|max:255',
            'counter_name_three' => 'required|string|max:255',

            'counter_icon_four' => 'required|string|max:255',
            'counter_count_four' => 'required|string|max:255',
            'counter_name_four' => 'required|string|max:255',
        ]);

        $data = [
            'counter_icon_one' => $request->counter_icon_one,
            'counter_count_one' => $request->counter_count_one,
            'counter_name_one' => $request->counter_name_one,

            'counter_icon_two' => $request->counter_icon_two,
            'counter_count_two' => $request->counter_count_two,
            'counter_name_two' => $request->counter_name_two,

            'counter_icon_three' => $request->counter_icon_three,
            'counter_count_three' => $request->counter_count_three,
            'counter_name_three' => $request->counter_name_three,

            'counter_icon_four' => $request->counter_icon_four,
            'counter_count_four' => $request->counter_count_four,
            'counter_name_four' => $request->counter_name_four,
        ];

        /*
        |--------------------------------------------------------------------------
        | Background
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('background')) {

            if (
                $counter &&
                $counter->background &&
                file_exists(public_path($counter->background))
            ) {
                unlink(public_path($counter->background));
            }

            $data['background'] = $this->uploadImage(
                $request,
                'background',
                'uploads'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Create / Update
        |--------------------------------------------------------------------------
        */
        if ($counter) {

            $counter->update($data);

        } else {

            Counter::create($data);
        }

        return redirect()
            ->route('admin.counter.index')
            ->with('success', 'Counter updated successfully!');
    }
}
