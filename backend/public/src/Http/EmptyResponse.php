<?phpdeclare(strict_types=1);namespace App\Http;use Fig\Http\Message\StatusCodeInterface;use Psr\Http\Message\StreamInterface;use Slim\Psr7\Factory\StreamFactory;use Slim\Psr7\Headers;use Slim\Psr7\Response;use function header;class EmptyResponse extends Response{    public function __construct(int $status = 204)    {        parent::__construct(            $status,            new Headers([                'Content-Type' => 'application/json',                'Access-Control-Allow-Origin' => '*',                'Access-Control-Allow-Headers' => 'Origin, X-Requested-With, Content-Type, Accept',                'Access-Control-Allow-Methods' => 'GET, PUT, POST',            ]),            (new StreamFactory())->createStreamFromResource(fopen('php://temp', 'rb'))        );    }}