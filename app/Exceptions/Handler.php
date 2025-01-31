use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;

public function render($request, Throwable $exception)
{
    // Si es un error 500
    if ($exception instanceof HttpException && $exception->getStatusCode() == 500) {
        return response()->view('errors.500', [], 500);
    }

    return parent::render($request, $exception);
}
