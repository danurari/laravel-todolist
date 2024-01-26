<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
   public function testLoginPage()
   {
       $this->get('/login')
           ->assertSeeText("Login");
   }

   public function testLoginPageForMember()
   {
       $this->withSession([
           "user" => "danur",
           "password" => "rahasia"
       ])->get('/login')
           ->assertRedirect("/");
   }

    public function testLoginSuccess()
   {
       $this->post('/login', [
           "user" => "danur",
           "password" => "rahasia"
       ])->assertRedirect("/")
           ->assertSessionHas("user", "danur");
   }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            "user" => "danur"
        ])->post('/login', [
            "user" => "danur",
            "password" => "rahasia"
        ])->assertRedirect("/");
    }

    public  function testLoginValidationError()
    {
        $this->post('/login', [])
            ->assertSeeText("User or password is required");
    }

    public function testLoginFailed()
    {
        $this->post('/login', [
            "user" => "wrong",
            "password" => "wrong"
        ])->assertSeeText("User or password is wrong");
    }

    public function testLogout()
    {
        $this->withSession([
            "user" => "danur"
        ])->post('/logout')
            ->assertRedirect("/")
            ->assertSessionMissing("user");
    }



}


