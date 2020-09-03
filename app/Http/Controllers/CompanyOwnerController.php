<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompanyOwner;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class CompanyOwnerController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
           // $company=Project::find($request->id)->company;
            $data=DB::table('companies_owners')
            ->join('companies','companies.id','=','companies_owners.company_id')
            ->join('users','users.id','=','companies_owners.user_id')
            ->select('companies_owners.*','users.user_name','companies.company_name')
            ->get();
           
            return DataTables::of($data)->addIndexColumn()
            ->addColumn('action',function($data){
                $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        $company = Company::get();
        $user=User::get();
        return view('company_owner',compact('company','user'));
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
            'owner_type'    =>  'required',
            'ownership_percentage'     =>  'required',
            'user_id'     =>  'required',
            'company_id'     =>  'required',
            
        );
       
       
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $form_data = array(
            'owner_type'        =>  $request->owner_type,
            'ownership_percentage'         =>  $request->ownership_percentage,
            'user_id'         =>  $request->user_id,
            'company_id'         =>  $request->company_id,
           
        );
        CompanyOwner::create($form_data);
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
            $data = CompanyOwner::findOrFail($id);
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
    public function update(Request $request)
    {
        $rules = array(
            // 'owner_type'    =>  'required',
            // 'ownership_percentage'     =>  'required',
            // 'user_id'     =>  'required',
            // 'company_id'     =>  'required',
            
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = array(
            'owner_type'        =>  $request->owner_type,
            'ownership_percentage'         =>  $request->ownership_percentage,
            'user_id'         =>  $request->user_id,
            'company_id'         =>  $request->company_id,
           
        );
        CompanyOwner::whereId($request->hidden_id)->update($form_data);
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
        $data = CompanyOwner::findOrFail($id);
        $data->delete();
    }
}
