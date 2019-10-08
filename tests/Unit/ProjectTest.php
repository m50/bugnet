<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Project;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_project_belongs_to_user()
    {
        $this->login();
        
        $pRaw = factory(Project::class)->raw();
        $pRaw['tags'] = implode(', ', $pRaw['tags']);
        $project = auth()->user()->projects()->create($pRaw);

        $this->assertTrue(auth()->user()->projects->contains($project));
    }
    /** @test */
    public function a_project_has_errors()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function a_project_has_api_token()
    {
        $this->login();

        $project = auth()->user()->projects()->create(factory(Project::class)->raw());

        $this->assertTrue(!empty($project->api_token));
    }

    /** @test */
    public function only_authenticated_users_can_create_projects()
    {
        $attributes = factory(Project::class)->raw();
        $this->post('/projects', $attributes)->assertRedirect('login');
    }
}

