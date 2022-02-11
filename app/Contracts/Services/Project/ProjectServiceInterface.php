<?php

namespace App\Contracts\Services\Project;

use Illuminate\Http\Request;
use App\Models\Project;

/**
 * Interface for Payroll service
 */
interface ProjectServiceInterface
{
    /**
     * To get all projects
     * 
     * @return $array of projects
     */
    public function getProjects();

    /**
     * To get all employees
     * 
     * @return $array of employee
     */
    public function getEmployee();

    /**
     * To store project
     * 
     * @param Illuminate\Http\Request $request
     * @return bool
     */
    public function storeProject(Request $request);

    /**
     * To get all members and non members
     * 
     * @param App\Models\Project $project
     * @return $array of employee
     */
    public function getMembers(Project $project);

    /**
     * To get all members and non members
     * 
     * @param App\Models\Project $project
     * @param int $id
     * @return $array of employee
     */
    public function memberToogle(Project $project, $id);

    /**
     * To update project
     * 
     * @param App\Models\Project $project
     * @param Illuminate\Http\Request $request
     * @return bool
     */
    public function updateProject(Request $request, Project $project);

    /**
     * To delete project
     * 
     * @param App\Models\Project $project
     * @return bool
     */
    public function deleteProject(Project $project);

    /**
     * To get schedules
     * 
     * @return collection of schedules
     */
    public function getSchedules();
}
