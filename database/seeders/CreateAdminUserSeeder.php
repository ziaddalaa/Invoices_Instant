<?php
namespace Database\Seeders;
use App\Models\User as ModelsUser;
use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class CreateAdminUserSeeder extends Seeder
{
/**
* Run the database seeds.
*
* @return void
*/
public function run()
{
$user = ModelsUser::create([
'name' => 'Ziad Alaa',
'email' => 'ziad@yahoo.com',
'password' => bcrypt('12345678'),
'role_name' => ["owner"],
'status' => "مفعل",
]);
$role = Role::create(['name' => 'owner']);
$permissions = Permission::pluck('id','id')->all();
$role->syncPermissions($permissions);
$user->assignRole([$role->id]);
}
}
