## Responses

### Success responses

To return success responses use `Firdavsi\Responses\Http\SuccessResponse`

```php
use App\Models\User;
use App\Http\Resources\UsersResource;
use Firdavsi\Responses\Http\SuccessResponse;

public function index(): SuccessResponse
{
    // ... your code
    return new SuccessResponse(
        response: UsersResource::collection(User::query()->get()),
        message: 'Users list',
        status: 200
    );
}
```

If you want to return empty responses use `Firdavsi\Responses\Http\SuccessEmptyResponse`

```php
use Firdavsi\Responses\Http\SuccessEmptyResponse;

public function index(): SuccessEmptyResponse
{
    // ... your code
    return new SuccessEmptyResponseResponse(
        message: 'Success',
        status: 200
    );
}
```

### Error responses

To return error responses use `Firdavsi\Responses\Http\ErrorResponse`

```php
use Firdavsi\Responses\Http\ErrorResponse;

public function index(): ErrorResponse
{
    // ... your code
    return new ErrorResponse(
        message: 'Something went wrong',
        status: 400
    );
}
```