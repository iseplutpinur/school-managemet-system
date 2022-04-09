<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            return Datatables::of(Company::query())
                // ->addColumn('action', 'company-action')
                // ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('backend.company');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $companyId = $request->id;

        $company   =   Company::updateOrCreate(
            [
                'id' => $companyId
            ],
            [
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address
            ]
        );

        return Response()->json($company);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $company  = Company::where($where)->first();

        return Response()->json($company);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $company = Company::where('id', $request->id)->delete();

        return Response()->json($company);
    }
}
