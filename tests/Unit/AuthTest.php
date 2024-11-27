<?php

use App\Http\Controllers\UserAuthController;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\ChangeUserRoleRequest;
use App\Http\Resources\UserAuthResource;
use App\Models\User;
use App\Http\Services\UserAuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Tests\TestCase;

class AuthTest extends TestCase
{

    public function test_login_user_service()
    {
        // Check database is working for debug purposes
        $user = User::factory()->create();

        $request = new LoginUserRequest([
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertNotNull($request);

        $service = new UserAuthService();
        $result = $service->login($request->toArray());

        $this->assertTrue($result);

        // Mock user token into the session
        session(['user' => $user]);

        $this->assertInstanceOf(User::class, current_user());

        // Check if name, email and password are the same as the user
        $this->assertEquals($user->name, current_user()->name);
        $this->assertEquals($user->email, current_user()->email);
        $this->assertTrue(Hash::check('password', current_user()->password));
    }

    public function test_login_wrong_credentials()
    {
        $request = new LoginUserRequest([
            'email' => 'wrong@email.com',
            'password' => 'wrong_password',
        ]);

        $service = new UserAuthService();
        $result = $service->login($request->toArray());

        $this->assertFalse($result);
    }

    public function test_register_user_service()
    {
        // Create a new RegisterUserRequest with valid data
        $request = new RegisterUserRequest([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password',
            'confirm_password' => 'password',
        ]);

        $this->assertNotNull($request);

        // Use the UserAuthService to register the user
        $service = new UserAuthService();
        $user = $service->register($request->toArray());

        // Assert that the user was created and returned
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('testuser@example.com', $user->email);
        $this->assertTrue(Hash::check('password', $user->password));
    }

    public function test_register_user_with_existing_email()
    {
        // Create a user to simulate an existing email
        $existingUser = User::factory()->create([
            'email' => 'existing@example.com',
        ]);

        // Create a new RegisterUserRequest with the same email
        $request = new RegisterUserRequest([
            'name' => 'Another User',
            'email' => 'existing@example.com',
            'password' => 'password',
            'confirm_password' => 'password',
        ]);

        $this->assertNotNull($request);

        // Use the UserAuthService to attempt registration
        $service = new UserAuthService();
        $this->expectException(\Illuminate\Database\QueryException::class);
        $service->register($request->toArray());
    }

}
