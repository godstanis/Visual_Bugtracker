<?php 

namespace App\Http\Controllers\Bugtracker;

use Illuminate\Http\Request;
use App\Http\Controllers\BugtrackerBaseController;

use App\User;
use App\Project;
use App\ProjectAccess;

class TeamController extends BugtrackerBaseController
{

    protected $team_repository;

    public function __construct(\App\Repositories\TeamRepository $repository)
    {
        $this->team_repository = $repository;
    }

    /*
     * Show all project members
    */
    public function getAllTeamMembers(Project $project)
    {
        $project_access = $project->project_access()->get();

        return view('bugtracker.project.team', ['project_access' => $project_access, 'project'=>$project]);
    }

    /*
     * Add existing user to the project, if not exists
    */
    public function postAddMember(\App\Http\Requests\AddMemberRequest $request, Project $project, User $user)
    {

        $username = $request->user_name;
        $user = User::where('name', '=', $username)->first();

        $project_access_exists = ProjectAccess::where([
            ['user_id', '=', $user->id],
            ['project_id', '=', $project->id]
        ])->exists();

        if( $project_access_exists )
        {
            return redirect()->back();
        }

        $data = [
            'user_id' => $user->id,
            'project_id' => $project->id
        ];

        $this->team_repository->add($data);

        return redirect()->back();

    }

    /*
     * Remove user, assigned to the given project
    */
    public function postRemoveMember(\App\Http\Requests\RemoveMemberRequest $request, Project $project, User $user)
    {

        $this->team_repository->delete($user, $project);

        return redirect()->back();
    }

    /*
     * Search all users which match the given query
    */
    public function searchUser(Request $request, Project $project)
    {
        $this->validate($request, [
            'search_query' => 'required|string'
        ]);

        $search_query = $request->search_query;
        $users = User::where('name', 'REGEXP', $search_query)->take(10)->get();
        
        $foundNames = [];

        foreach ($users as $user) {
            $foundNames[] = ['name'=>$user->name, 'avatar'=>$user->profile_image];
        }

        $jsonObj = json_encode($foundNames);

        return response($jsonObj, 200)
            ->header('Content-Type', 'application/json');

    }

}
