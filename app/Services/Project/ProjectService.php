<?php

namespace App\Services\Project;

use App\Contracts\Dao\Project\ProjectDaoInterface;
use App\Contracts\Services\Project\ProjectServiceInterface;
use Illuminate\Http\Request;
use App\Models\Project;

/**
 * Service class for Project
 */
class ProjectService implements ProjectServiceInterface
{
    /**
     * Project dao
     */
    private $projectDao;
    /**
     * Class Constructor
     * @param payrollDaoInterface
     * @return
     */
    public function __construct(ProjectDaoInterface $projectDao)
    {
        $this->projectDao = $projectDao;
    }

    /**
     * To get all projects
     * 
     * @return $array of projects
     */
    public function getProjects()
    {
        return $this->projectDao->getProjects();
    }

    /**
     * To get all employees
     * 
     * @return $array of employee
     */
    public function getEmployee()
    {
        return $this->projectDao->getEmployee();
    }

    /**
     * To store project
     * 
     * @param Illuminate\Http\Request $request
     * @return bool
     */
    public function storeProject(Request $request)
    {
        return $this->projectDao->storeProject($request);
    }

    /**
     * To get all members and non members
     * 
     * @param App\Models\Project $project
     * @return $array of employee
     */
    public function getMembers(Project $project)
    {
        return $this->projectDao->getMembers($project);
    }

    /**
     * To get all members and non members
     * 
     * @param App\Models\Project $project
     * @param int $id
     * @return $array of employee
     */
    public function memberToogle(Project $project, $id)
    {
        return $this->projectDao->memberToogle($project, $id);
    }

    /**
     * To update project
     * 
     * @param App\Models\Project $project
     * @param Illuminate\Http\Request $request
     * @return bool
     */
    public function updateProject(Request $request, Project $project)
    {
        return $this->projectDao->updateProject($request, $project);
    }

    /**
     * To delete project
     * 
     * @param App\Models\Project $project
     * @return bool
     */
    public function deleteProject(Project $project)
    {
        return $this->projectDao->deleteProject($project);
    }

    /**
     * To get schedules
     * 
     * @return collection of schedules
     */
    public function getSchedules()
    {
        return $this->projectDao->getSchedules();
    }
}
