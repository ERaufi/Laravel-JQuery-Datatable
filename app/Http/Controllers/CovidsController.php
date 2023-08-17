<?php

namespace App\Http\Controllers;

use App\Models\Covids;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class CovidsController extends Controller
{
    public function getCovidData(Request $request)
    {
        // return response()->json($request->all(), 500);

        $orderColumnIndex = $request->input('order_column', 0); // Default column index for ordering
        $orderDirection = $request->input('order_dir', 'asc');   // Default ordering direction

        $orderableColumns = ['country_id', 'date', 'Confirmed', 'Deaths', 'Recovered', 'Active'];
        $orderByColumn = $orderableColumns[$orderColumnIndex];


        $query = Covids::query()
            ->when($request->country_id, function ($query) use ($request) {
                return $query->where('country_id', $request->country_id);
            })
            ->when($request->date, function ($query) use ($request) {
                return $query->where('date', $request->date);
            })
            ->when($request->confirmed, function ($query) use ($request) {
                return $query->where('confirmed', $request->confirmed);
            })
            ->when($request->deaths, function ($query) use ($request) {
                return $query->where('deaths', $request->deaths);
            })
            ->when($request->recovered, function ($query) use ($request) {
                return $query->where('recovered', $request->recovered);
            })
            ->when($request->active, function ($query) use ($request) {
                return $query->where('active', $request->active);
            })
            ->with('countries')
            ->orderBy($orderByColumn, $orderDirection);

        // Apply filters
        // if ($request->has('country_id')) {
        //     $query->where('country_id', $request->country_id);
        // }

        $totalRecords = $query->count();

        // Get pagination parameters
        $start = $request->input('start');
        $length = $request->input('length');

        // Apply pagination
        $covids = $query->skip($start)->take($length)->get();

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $covids,
        ]);
    }
}
