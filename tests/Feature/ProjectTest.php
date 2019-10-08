<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->login();
        $attributes = factory(Project::class)->raw(['url' => 'https://google.com/']);
        $words = $attributes['tags'];
        $attributes['tags'] = implode(', ', $words);

        $this->post('/projects', $attributes)->assertRedirect('/projects');
        $attributes['tags'] = $this->arrayAsString($words);
        $this->assertDatabaseHas('projects', $attributes);
        $this->get('/projects')->assertSee($attributes['name']);
    }

    /** @test */
    public function a_user_can_update_a_project()
    {
        $this->withoutExceptionHandling();
        $this->login();
        $attributes = factory(Project::class)->raw(['url' => 'https://google.com/']);
        $project = auth()->user()->projects()->create($attributes);
        unset($attributes['name']);
        $attributes['url'] = 'https://facebook.com/';
        $path = '/projects/' . $project->slug;
        $this->patch($path, ['url' => $attributes['url']])->assertRedirect('/projects');
        $attributes['tags'] = $this->arrayAsString($attributes['tags']);
        $this->assertDatabaseHas('projects', $attributes);
        $this->get($path)->assertSee($attributes['url']);
    }

    /** @test */
    public function only_owner_can_update_project()
    {
        $this->login();
        $project = auth()->user()->projects()->create(factory(Project::class)->raw());
        $user = factory(\App\User::class)->create();
        $this->login($user);
        $path = '/projects/' . $project->slug;
        $this->patch($path, ['description' => 'test test'])->assertStatus(403);
    }

    /** @test */
    public function only_owner_can_view_project()
    {
        $this->login();
        $project = auth()->user()->projects()->create(factory(Project::class)->raw());
        $user = factory(\App\User::class)->create();
        $this->login($user);
        $path = '/projects/' . $project->slug;
        $this->get($path)->assertStatus(403);
    }

    /** @test */
    public function admin_can_view_project()
    {
        $this->login();
        $project = auth()->user()->projects()->create(factory(Project::class)->raw());
        $user = factory(\App\User::class)->create();
        $this->loginAdmin($user);
        $path = '/projects/' . $project->slug;
        $this->get($path)->assertStatus(200);
    }
}
