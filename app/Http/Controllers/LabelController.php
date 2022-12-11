<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLabelRequest;
use App\Http\Requests\UpdateLabelRequest;
use App\Models\Label;

class LabelController extends Controller
{
    public function index()
    {
        $labels = Label::paginate(10);
        return view('labels.index', compact('labels'));
    }

    public function create()
    {
        $label = new Label();
        return view('labels.create', compact('label'));
    }

    public function store(StoreLabelRequest $request)
    {
        $data = $request->validated();

        $label = new Label();
        $label->fill($data);
        $label->save();

        flash('ssss')->success();
        return redirect()->route('labels.index');
    }

    public function edit(Label $label)
    {
        $label = new Label();
        return view('labels.edit', compact('label'));
    }

    public function update(UpdateLabelRequest $request, Label $label)
    {
        $data = $request->validated();

        $label->fill($data);
        $label->save();

        flash('ssss')->success();
        return redirect()->route('labels.index');
    }

    public function destroy(Label $label)
    {
        if ($label->tasks()->exists()) {
            flash('err')->error();
            return back();
        }

        $label->delete();
        flash('Label has been deleted successfully')->success();
        return redirect()->route('labels.index');
    }
}
