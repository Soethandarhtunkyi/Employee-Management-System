<?php

namespace App\Http\Controllers\Project;

use App\Contracts\Services\Project\ProjectServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    /**
     * project service interface
     */
    private $projectInterface;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProjectServiceInterface $projectServiceInterface)
    {
        $this->projectInterface = $projectServiceInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = $this->projectInterface->getProjects();

        return view('projects.index')
            ->with(['projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showCreateView()
    {
        // Check user has manager access or not.
        if (Gate::denies('isManager')) {
            abort(401);
        }

        $employees = $this->projectInterface->getEmployee();

        return view('projects.create')
            ->with(['employees' => $employees]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postCreate(StoreProjectRequest $request)
    {
        // Check user has manager access or not.
        if (Gate::denies('isManager')) {
            abort(401);
        }

        $project = $this->projectInterface->storeProject($request);

        Session::flash('success', 'Project Created Successfully.');

        return response()->json([
            'result' => $project ? 1 : 0
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function showDetail(Project $project)
    {
        $project->load('manager');

        $schedules = $this->projectInterface->getSchedules();

        return view('projects.show')
            ->with([
                'project' => $project,
                'schedules' => $schedules
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function showEditView(Project $project)
    {
        // Check user own the project.
        if (Gate::denies('own', $project->manager_id)) {
            abort(401);
        }

        return view('projects.edit')
            ->with(['project' => $project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function updateProject(UpdateProjectRequest $request, Project $project)
    {
        // Check user own the project.
        if (Gate::denies('own', $project->manager_id)) {
            abort(401);
        }

        if ($project->employees->count() < 1) {
            return back()
                ->withInput()
                ->withErrors('Your project should have at least one employee.');
        }

        $project = $this->projectInterface->updateProject($request, $project);
        if ($project) {
            return redirect()
                ->route('projects-index')
                ->with('success', 'Project Updated Successfully.');
        }
        
        return back()
            ->withErrors('Unknown error occured.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function deleteProject(Project $project)
    {
        // Check user own the project.
        if (Gate::denies('own', $project->manager_id)) {
            abort(401);
        }

        $result = $this->projectInterface->deleteProject($project);

        return response()->json([
            'result' => $result ? 1 : 0
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function getMembers(Project $project)
    {
        $data = $this->projectInterface->getMembers($project);

        return response()->json([
            'result' => $data ? 1 : 0,
            'data' => $data ? $data : null
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function memberToogle(Project $project, $id)
    {
        // Check user own the project.
        if (Gate::denies('own', $project->manager_id)) {
            abort(401);
        }

        $result = $this->projectInterface->memberToogle($project, $id);

        return response()->json([
            'result' => $result ? 1 : 0
        ]);
    }
}
