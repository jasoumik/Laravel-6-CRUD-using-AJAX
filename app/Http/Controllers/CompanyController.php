<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data=Company::latest()->get();
            return DataTables::of($data)->addIndexColumn()
            ->addColumn('action',function($data){
                $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('company');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'company_name'    =>  'required',
            'ownership_type'     =>  'required',
            'date_started'    =>  'required',
            'date_ended'    =>  'required',
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = array(
            'company_name'        =>  $request->company_name,
            'ownership_type'         =>  $request->ownership_type,
            'date_started'        =>  $request->date_started,
            'date_ended'        =>  $request->date_ended,

        );
        Company::create($form_data);
        return response()->json(['success' => 'Data Added successfully.']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Company::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $rules = array(
            'company_name'    =>  'required',
            'ownership_type'     =>  'required',
            //'date_started'    =>  'required',
           // 'date_ended'    =>  'required',
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = array(
            'company_name'        =>  $request->company_name,
            'ownership_type'         =>  $request->ownership_type,
            //'date_started'        =>  $request->date_started,
        );
        Company::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Data Updated successfully.']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Company::findOrFail($id);
        $data->delete();
    }
}
