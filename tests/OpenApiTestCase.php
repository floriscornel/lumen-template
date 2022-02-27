<?php declare(strict_types=1);

namespace Tests;

use App\Models\PersonalAccessToken;
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Osteel\OpenApi\Testing\ValidatorBuilder;
use Osteel\OpenApi\Testing\ValidatorInterface;

class OpenApiTestCase extends TestCase
{
    use DatabaseMigrations;

    protected ValidatorInterface $validator;
    protected string $user_id;
    protected array $headers;

    public function setUp(): void
    {
        parent::setUp();

        //Setup our OpenAPI validator
        $this->validator = ValidatorBuilder::fromYaml('api-reference.yaml')->getValidator();

        //Create a new user
        $user = User::factory()->create();
        $this->user_id = $user->id;

        //Create an access token
        $token = new PersonalAccessToken([
            'token'   => md5($user->email),
            'user_id' => $user->id,
        ]);
        $token->save();

        //Set the Authorization and Accept headers
        $this->headers = [
            'Authorization' => 'Bearer ' . $token->id . '|' . $token->token,
            'Accept'        => 'application/json',
        ];
    }
}
