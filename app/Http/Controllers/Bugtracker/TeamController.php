<?php 

namespace App\Http\Controllers\Bugtracker;

use App\Http\Requests\AddMemberRequest;
use App\Http\Requests\RemoveMemberRequest;
use App\Http\Resources\User\MemberCollection;
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
    public function index(Request $request, Project $project)
    {
        $members = $project->members;

        if($request->ajax()) {
            return new MemberCollection($members, $project);
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
    public function add(AddMemberRequest $request, Project $project, User $user)
    {
        $newMember = $user->where('name', $request->name)->first();
        $alreadyMember = $project->members->contains($newMember);

        if(! $alreadyMember) {
            $project->members()->attach($newMember);
            $response = response('User has been attached to the project', 200);
        } else {
            $response = response('User has not been attached', 422); // 422 - Unprocessable Entity status code
        }

        if($request->ajax()) {
            return $response;
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
    public function remove(RemoveMemberRequest $request, Project $project, User $user)
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
     * @return MemberCollection
     * @throws \Illuminate\Validation\ValidationException
     */
    public function search(Request $request, Project $project, User $user)
    {
        $this->validate($request, [
            'name' => 'required|string'
        ]);

        $users = $user->where('name', 'LIKE', '%'.$request->name.'%')->take(5)->get();

        return new MemberCollection($users, $project);
    }

    /**
     * Adds an ability to the user.
     *
     * @param Request $request
     * @param Project $project
     * @param User $user
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function addAbility(Request $request, Project $project, User $user)
    {
        $user = $user->where('name', $request->user)->first();
        $ability = $request->ability_name;
        if (\in_array($ability, config('abilities.default'), true)) {
            $user->allow($ability, $project);
            return response('Success', 200);
        }
        return response('The input, provided with the request is not valid', 422);
    }

    /**
     * Removes an ability from the user.
     *
     * @param Request $request
     * @param Project $project
     * @param User $user
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function removeAbility(Request $request, Project $project, User $user)
    {
        $user = $user->where('name', $request->user)->first();
        $ability = $request->ability_name;
        if (\in_array($ability, config('abilities.default'), true)) {
            $user->disallow($ability, $project);
            return response('Success', 200);
        }
        return response('The input, provided with the request is not valid', 422);
    }

}
