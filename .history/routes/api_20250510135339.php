use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

Route::get('/users', [UserController::class, 'index']);
Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store']);
