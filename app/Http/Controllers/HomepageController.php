<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;

use DB;


class HomepageController extends Controller
{
    
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $allProjects = Project::all();
            $allUsers = User::all();
            $favoriteProjects = $user->projects()->wherePivot('is_favorite', true)->get();
            $otherProjects = $user->projects()->wherePivot('is_favorite', false)->get();



            if (!($user->is_admin)) {
                return view('pages.homepage', ['user' => $user], [
                    'allProjects' => $allProjects,
                    'favoriteProjects' => $favoriteProjects,
                    'otherProjects' => $otherProjects,
                    'allUsers' => $allUsers,
                ]);
            }
            if ($user->is_admin) {
                return view('pages.homepage', ['user' => $user], [
                    'allUsers' => $allUsers,
                    'allProjects' => $allProjects,
                ]);
            }

        }

    }

    public function remove($id) {
        if(Auth::user()){
            $projects = Project::find($id);
            $projects->delete();
            return redirect('/homepage')->with('status','Project Deleted with successfully!');
        }
    }

    public function add() {
        return view('pages.add');
    }

    public function insertProject(Request $request) {
        $projects = new Project();
        $projects-> name = $request->input('name');
        $projects-> details = $request->input('details');
        $projects-> delivery = $request->input('delivery');
        if($projects->delivery->isPast()){
            return redirect('/add')->with('message','Date is not valid');
        }
        $user = Auth::user();
        
        $projects->save();
        $projects->users()->attach($user);
        $projects->coordinators()->attach($user);
        
        return redirect('/homepage')->with('status','Inserted Sucessfully!');
    }


    function action(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('project')
                    ->where('name', 'like', '%' . $query . '%')
                    ->get();

            } else {
                $data = DB::table('project')
                    ->orderBy('id', 'desc')
                    ->get();
            }

            $total_row = $data->count();
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $output .= '
                    <tr>
                    <td>' . $row->name . '</td>
                    </tr>
                    ';
                }
            } else {
                $output = '
                <tr>
                    <td align="center" colspan="5">No Data Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row
            );
            echo json_encode($data);
        }
    }

}