<?phpdeclare(strict_types=1);namespace App\Http\Action\v1\Military\AddDefect;use Psr\Http\Message\ResponseInterface;use Psr\Http\Message\ServerRequestInterface;use Psr\Http\Server\RequestHandlerInterface;class AddDefectAction implements RequestHandlerInterface{    /**     * @inheritDoc     */    public function handle(ServerRequestInterface $request): ResponseInterface    {        // TODO: Implement handle() method.    }}