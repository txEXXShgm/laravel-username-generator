<?php

namespace Luilliarcec\LaravelUsernameGenerator\Tests\Units\Name;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Luilliarcec\LaravelUsernameGenerator\Facades\Username;
use Luilliarcec\LaravelUsernameGenerator\Support\UsernameGenerator;
use Luilliarcec\LaravelUsernameGenerator\Tests\Models\User;
use Luilliarcec\LaravelUsernameGenerator\Tests\TestCase;

class UsernameFullNameTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @var UsernameGenerator
     */
    protected $usernameGenerator;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->usernameGenerator = new UsernameGenerator();

    }

    /**
     * @test
     * @throws \Luilliarcec\LaravelUsernameGenerator\Exceptions\UsernameGeneratorException
     */
    public function make_lower_username()
    {
        $username = $this->usernameGenerator->make('Luis Andrés', 'Arce Cárdenas');
        $this->assertEquals('larcec', $username);

        $username = $this->usernameGenerator->make('Luis Andrés Arce Cárdenas');
        $this->assertEquals('larcec', $username);

        $username = Username::make('Luis Andrés', 'Arce Cárdenas');
        $this->assertEquals('larcec', $username);

        $username = Username::make('Luis Andrés Arce Cárdenas');
        $this->assertEquals('larcec', $username);
    }

    /**
     * @test
     * @throws \Luilliarcec\LaravelUsernameGenerator\Exceptions\UsernameGeneratorException
     */
    public function make_lower_username_with_similar_username_without_duplicate()
    {
        for ($i = 1; $i <= 2; $i++) {
            factory(User::class)->create([
                'username' => "larcec{$i}"
            ]);
        }

        factory(User::class)->create([
            'username' => "larceca"
        ]);

        $username = $this->usernameGenerator->make('Luis Andrés', 'Arce Cárdenas');
        $this->assertEquals('larcec', $username);

        $username = $this->usernameGenerator->make('Luis Andrés Arce Cárdenas');
        $this->assertEquals('larcec', $username);

        $username = Username::make('Luis Andrés', 'Arce Cárdenas');
        $this->assertEquals('larcec', $username);

        $username = Username::make('Luis Andrés Arce Cárdenas');
        $this->assertEquals('larcec', $username);
    }

    /**
     * @test
     * @throws \Luilliarcec\LaravelUsernameGenerator\Exceptions\UsernameGeneratorException
     */
    public function make_lower_username_with_similars_username_and_duplicate()
    {
        for ($i = 1; $i <= 3; $i++) {
            factory(User::class)->create([
                'username' => "larcec{$i}"
            ]);
        }

        factory(User::class)->create([
            'username' => "larcec"
        ]);

        $username = $this->usernameGenerator->make('Luis Andrés', 'Arce Cárdenas');
        $this->assertEquals('larcec4', $username);

        $username = $this->usernameGenerator->make('Luis Andrés Arce Cárdenas');
        $this->assertEquals('larcec4', $username);

        $username = Username::make('Luis Andrés', 'Arce Cárdenas');
        $this->assertEquals('larcec4', $username);

        $username = Username::make('Luis Andrés Arce Cárdenas');
        $this->assertEquals('larcec4', $username);
    }
}
