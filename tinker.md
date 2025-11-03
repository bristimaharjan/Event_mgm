## Eloquent ORM Basics

```
php artisan tinker
```

```
// import Models
> use App\Models\User;
> use App\Models\Post;
> use App\Models\Tag;
> use App\Models\Profile;
> use App\Models\post_tag;


// Creating records
$user = new User;
$user->name = 'John Doe';
$user->email = 'john@example.com';
$user->save();

// Mass assignment
$user = User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => bcrypt('password')
]);

// Updating records
$user = User::find(1);
$user->name = 'Jane Doe';
$user->save();

// Mass update
$user = User::find(1);
$user->update(['name' => 'Jane Doe']);

// Update multiple records
User::where('active', false)->update(['status' => 'inactive']);

// Deleting records
$user = User::find(1);
$user->delete();

// Delete by primary key
User::destroy(1);
User::destroy([1, 2, 3]);

// Delete with conditions
User::where('active', false)->delete();

// Soft deletes (if using SoftDeletes trait)
$user->delete(); // Soft delete
$user->forceDelete(); // Permanent delete
$user->restore(); // Restore soft deleted

// Get soft deleted records
$users = User::onlyTrashed()->get();
$users = User::withTrashed()->get();
```
