<?php

namespace App\Http\Controllers;

use App\Project;
use App\ProjectWorker;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ProjectWorkerController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
           // $company=Project::find($request->id)->company;
           $data=DB::table('projects_workers')
           ->join('projects','projects.id','=','projects_workers.project_id')
           ->join('users','users.id','=','projects_workers.user_id')
           ->select('projects_workers.*','projects.project_name','users.user_name')
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
        $project = Project::get();
        $user=User::get();
        return view('project_worker',compact('project','user'));
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
            'project_id'    =>  'required',
            'user_id'     =>  'required',
            
        );
       
       
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $form_data = array(
            'project_id'        =>  $request->project_id,
            'user_id'         =>  $request->user_id,
           
        );
        ProjectWorker::create($form_data);
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
            $data = ProjectWorker::findOrFail($id);
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
            'project_id'    =>  'required',
            //'location'     =>  'required',
            //'area_in_bigha'     =>  'required',
            //'company_id'     =>  'required',
            
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = array(
            'project_id'        =>  $request->project_id,
            'user_id'         =>  $request->user_id,
           
        );
        ProjectWorker::whereId($request->hidden_id)->update($form_data);
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
        $data = ProjectWorker::findOrFail($id);
        $data->delete();
    }
}
