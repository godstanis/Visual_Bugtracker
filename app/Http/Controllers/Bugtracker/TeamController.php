<?php 

namespace App\Http\Controllers\Bugtracker;

use App\Http\Requests\AddMemberRequest;
use App\Http\Requests\RemoveMemberRequest;
use App\Http\Resources\User\UserCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\BugtrackerBaseController;

use App\User;
use App\Project;

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
            return response('', 200);
        }

        return redirect()->back();
    }

    /**
     * Search all users matching query.
     *
     * @param Request $request
     * @param Project $project
     * @param User $user
     * @return UserCollection
     * @throws \Illuminate\Validation\ValidationException
     */
    public function searchUser(Request $request, Project $project, User $user)
    {
        $this->validate($request, [
            'name' => 'required|string'
        ]);

        $users = $user->where('name', 'LIKE', '%'.$request->name.'%')->take(5)->get();

        return new UserCollection($users);
    }

}
