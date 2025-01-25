<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Filter;

class FilterController extends Controller
{
    //

    public function destroy($filter)
    {
        $filter = Filter::find($filter);
        $filter->delete();

        return redirect()->route('manage-filters.index');
    }

    public function index()
    {

        $filter = Filter::where('user_id', auth()->id())->get();
        return view(
            'filter.index',
            [
                'filters' => $filter
            ]
        );
    }
}
