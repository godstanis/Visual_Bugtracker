<?php 

namespace App\Http\Controllers\Bugtracker;

use App\Http\Requests\AddMemberRequest;
use App\Http\Requests\RemoveMemberRequest;
use App\Repositories\TeamRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\BugtrackerBaseController;

use App\User;
use App\Project;
use App\ProjectAccess;

class TeamController extends BugtrackerBaseController
{
    /**
     * Show all project members.
     *
     * @param Request $request
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function getAllTeamMembers(Request $request, Project $project)
    {
        $members = $project->members;

        if($request->ajax()) {
            return json_encode($members);
        }

        return view('bugtracker.project.team', compact('members', 'project'));
    }

    /**
     * Add existing user to the project, if not exists.
     *
     * @param AddMemberRequest $request
     * @param Project $project
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAddMember(AddMemberRequest $request, Project $project, User $user)
    {
        $newMember = $user->where('name', $request->user_name)->first();
        $alreadyMember = $project->members->contains($newMember);

        if(! $alreadyMember) {
            $project->members()->attach($newMember);
        }

        return redirect()->back();
    }

    /**
     * Remove user, assigned to the given project.
     *
     * @param RemoveMemberRequest $request
     * @param Project $project
     * @param User $user
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function getRemoveMember(RemoveMemberRequest $request, Project $project, User $user)
    {
        $project->members()->detach($user);

        if($request->ajax()) {
            return response("", 200);
        }

        return redirect()->back();
    }

    /**
     * Dirty method to search all users which match the given query.
     *
     * TODO: #6 Issue, team management improvements.
     *
     * @param Request $request
     * @param Project $project
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
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

        if($request->ajax()) {
            return response($jsonObj, 200)->header('Content-Type', 'application/json');
        }

        return response($jsonObj, 200);
    }

}
