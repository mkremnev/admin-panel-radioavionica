<?phpdeclare(strict_types=1);namespace App\Http;use Slim\Psr7\Factory\StreamFactory;use Slim\Psr7\Headers;use Slim\Psr7\Response;class JsonResponse extends Response{    /**     * @param mixed $data     * @param int $status     */    public function __construct($data, int $status = 200)    {        parent::__construct(            $status,            new Headers([                'Content-Type' => 'application/json',                'Access-Control-Allow-Origin' => '*',                'Access-Control-Allow-Headers' => '*',                'Access-Control-Allow-Methods' => '*',            ]),            (new StreamFactory())->createStream(json_encode($data, JSON_THROW_ON_ERROR))        );    }}