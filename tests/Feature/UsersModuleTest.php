<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class UsersModuleTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    function it_shows_the_users_list()
    {
        factory(User::class)->create([
            'name'=> 'Karina',

        ]);
        
        factory(User::class)->create([
            'name'=> 'Angel'
        ]);
        $this->get('/usuarios')
        ->assertStatus(200)
        ->assertSee('Listado de Usuarios')
        ->assertSee('Angel')
        ->assertSee('Karina');
    }

    /** @test */
    function it_shows_a_default_message_if_there_list_is_empty()
    {
//        DB::table('users')->truncate();
        $this->get('/usuarios')
        ->assertStatus(200)
        ->assertSee('No hay usuarios registrados.');
    }

    /** @test */    
    function it_display_the_users_details()
    {
        $user  = factory(User::class)->create([
            'name'=>'Duilio Palacios'
            ]);

        $this->get('/usuarios/'.$user->id)
            ->assertStatus(200)
            ->assertSee('Duilio Palacios');
    }

    /** @test */
    function it_loads_the_new_users_page()
    {
        $this->get('/usuarios/nuevo')
            ->assertStatus(200)
            ->assertSee('Crear Usuario');
    }

    /** @test */
    public function it_display_a_404_error_if_user_is_not_found()
    {
        $this->get('/usuarios/999')
            ->assertStatus(404)
            ->assertSee('Página no encontrada');
    }
    /** @test */
    function it_loads_the_edit_users_page()
    {
        $this->withoutExceptionHandling();
        factory(User::class)->create();
        $user= User::first();
        //dd($user);
        $this->get("/usuarios/{$user->id}/edit")
            ->assertStatus(200)
            ->assertSee("Editar Usuario");
    }
    /** @test */
    public function it_create_a_new_user()
    {
        $this->withoutExceptionHandling();

        $this->post('/usuarios/',[
            'name'=>'Angel',
            'email'=>'angeltorres-1@hotmail.com',
            'password'=>'123456',
        ])->assertRedirect('usuarios');//route('users.index');
        
        $this->assertCredentials([
            'name'=>'Angel',
            'email'=>'angeltorres-1@hotmail.com',
            'password'=>'123456',
        ]);
    }
   /** @test */
   public function the_name_is_required()
   {
       $this->from('usuarios/nuevo')
       ->post('/usuarios/',[
           'name'=>'',
           'email'=>'angeltorres-1@hotmail.com',
           'password'=>'123456',
       ])->assertRedirect('usuarios/nuevo')
       ->assertSessionHasErrors(['name']);

       $this->assertEquals(0,User::count());
   }  
   /** @test */
   public function the_email_is_required()
   {
       $this->from('usuarios/nuevo')
       ->post('/usuarios/',[
           'name'=>'Angel Torres',
           'email'=>'',
           'password'=>'123456',
       ])->assertRedirect('usuarios/nuevo')
       ->assertSessionHasErrors(['email']);

       $this->assertEquals(0,User::count());
   }

    /** @test */
    public function the_password_is_required()
    {
        $this->from('usuarios/nuevo')
        ->post('/usuarios/',[
            'name'=>'Angel  Torres',
            'email'=>'angeltorres-1@hotmail.com',
            'password'=>'',
        ])->assertRedirect('usuarios/nuevo')
        ->assertSessionHasErrors(['password']);

        $this->assertEquals(0,User::count());
    }
    /** @test */
    public function the_email_must_be_valid()
    {
        $this->from('usuarios/nuevo')
        ->post('/usuarios/',[
            'name'=>'Angel Torres',
            'email'=>'correo-no-valido',
            'password'=>'123456',
        ])->assertRedirect('usuarios/nuevo')
        ->assertSessionHasErrors(['email']);
 
        $this->assertEquals(0,User::count());
    }
    /** @test */
    public function the_email_must_be_unique()
    {
        //$this->withoutExceptionHandling();
        factory(User::class)->create([
            'email'=>'angeltorres-1@hotmail.com'
        ]);
        
        $this->from('usuarios/nuevo')
        ->post('/usuarios/',[
            'name'=>'Angel',
            'email'=>'angeltorres-1@hotmail.com',
            'password'=>'123456'
        ])
        ->assertRedirect('usuarios/nuevo')
        ->assertSessionHasErrors(['email']);
 
        $this->assertEquals(1,User::count());
    }
    /** @test */
    function it_loads_the_edit_user_page()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $this->get("/usuarios/{$user->id}/edit")
            ->assertStatus(200)
            ->assertViewIs('users.edit')
           ->assertSee("Editar Usuario")
           ->assertViewHas('user',function ($viewUser) use  ($user)
           {
               return $viewUser->id == $user->id;
           });
    }

    /** @test */
    public function it_updates_a_user()
    {
        $this->withoutExceptionHandling();
        $user=factory(User::class)->create();

        $this->put("/usuarios/{$user->id}",[
            'name'=>'Angel',
            'email'=>'angeltorres-1@hotmail.com',
            'password'=>'123456',
        ])->assertRedirect("/usuarios/{$user->id}");//route('users.index');
        
        $this->assertCredentials([
            'name'=>'Angel',
            'email'=>'angeltorres-1@hotmail.com',
            'password'=>'123456',
        ]);
    }
   /** @test */
   public function the_name_is_required_when_updating_the_user()
   {
       //$this->withoutExceptionHandling();
       $user=factory(User::class)->create();
       $this->from("/usuarios/{$user->id}/edit")
       ->put("/usuarios/{$user->id}",[
           'name'=>'',
           'email'=>'angeltorres-1@hotmail.com',
           'password'=>'123456',
       ])->assertRedirect("usuarios/{$user->id}/edit")
       ->assertSessionHasErrors(['name']);

       $this->assertDatabaseMissing('users',['email'=>'angeltorres-1@hotmail.com']);
   }
    /** @test */
    public function the_email_must_be_valid_when_updating_the_user()
    {
        $user=factory(User::class)->create();
        $this->from("/usuarios/{$user->id}/edit")
        ->put("/usuarios/{$user->id}",[
            'name'=>'Angel',
            'email'=>'correo-no-valido',
            'password'=>'123456',
        ])->assertRedirect("usuarios/{$user->id}/edit")
        ->assertSessionHasErrors(['email']);

        $this->assertDatabaseMissing('users',['name'=>'Angel']);
    }
    /** @test */
    public function the_email_must_be_unique_when_updating_the_user()
    {
        //$this->withoutExceptionHandling();
        factory(User::class)->create([
            'email'=>'existing-email@example.com',
        ]);
        $user = factory(User::class)->create([
            'email'=>'angeltorres-1@hotmail.com',
        ]);
        $this->from("usuarios/{$user->id}/edit")
        ->put("usuarios/{$user->id}",[
            'name'=>'Angel Torres',
            'email'=>'existing-email@example.com',
            'password'=>'123456'
        ])->assertRedirect("usuarios/{$user->id}/edit")
        ->assertSessionHasErrors(['email']);
 
        //$this->assertEquals(0,User::count());
    }
   /** @test */
   public function the_email_is_required_when_updating_a_user()
   {
        $user=factory(User::class)->create();
        $this->from("/usuarios/{$user->id}/edit")
        ->put("/usuarios/{$user->id}",[
            'name'=>'Angel',
            'email'=>'correo-no-valido',
            'password'=>'123456',
        ])->assertRedirect("usuarios/{$user->id}/edit")
        ->assertSessionHasErrors(['email']);

        $this->assertDatabaseMissing('users',['name'=>'Angel']);
   }

    /** @test */
    public function the_password_is_optional_when_updating_a_user()
    {
        $oldPassword = 'CLAVE_ANTERIOR';
        $user = factory(User::class)->create([
            'password'=> bcrypt($oldPassword)  
        ]);
        
        $this->from("usuarios/{$user->id}/edit")
        ->put("usuarios/{$user->id}",[
            'name'=>'Angel',
            'email'=>'angeltorres-1@hotmail.com',
            'password'=>''
        ])
        ->assertRedirect("usuarios/{$user->id}");

 
        $this->assertCredentials([
            'name'=>'Angel',
            'email'=>'angeltorres-1@hotmail.com',
            'password'=>$oldPassword 
            ]);
    }
    /** @test */
    public function the_users_email_can_stay_same_when_updating_a_user()
    {
        $user = factory(User::class)->create([
            'email'=>'angeltorres-1@hotmail.com',
        ]);
        
        $this->from("usuarios/{$user->id}/edit")
        ->put("usuarios/{$user->id}",[
            'name'=>'Angel',
            'email'=>'angeltorres-1@hotmail.com',
            'password'=>'123456'
        ])
        ->assertRedirect("usuarios/{$user->id}");

 
        $this->assertDatabaseHas('users',[
            'name'=>'Angel',
            'email'=>'angeltorres-1@hotmail.com',
            ]);
    }
    /** @test */
    public function it_delete_a_user()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        
        $this->delete("usuarios/{$user->id}/")
        ->assertRedirect('usuarios');
        
        $this->assertDatabaseMissing('users',['id'=>$user->id]);
        //$this->assertSame(0,User::count());
    }

}
