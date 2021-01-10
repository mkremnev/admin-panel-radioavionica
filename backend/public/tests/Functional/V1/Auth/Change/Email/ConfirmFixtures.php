<?phpdeclare(strict_types=1);namespace Test\Functional\V1\Auth\Change\Email;use App\Auth\Entity\User\Email;use App\Auth\Entity\User\Id;use App\Auth\Entity\User\Token;use App\Auth\Entity\User\User;use App\Auth\Test\Builder\UserBuilder;use DateTimeImmutable;use Doctrine\Persistence\ObjectManager;use Doctrine\Common\DataFixtures\AbstractFixture;use Ramsey\Uuid\Uuid;class ConfirmFixtures extends AbstractFixture{    public const VALID = "00000000-0000-0000-0000-000000000001";    public const TOKEN = "00000000-0000-0000-0000-000000000002";    /**     * @inheritDoc     */    public function load(ObjectManager $manager)    {        $user = User::requestJoinByEmail(            new Id(self::VALID),            $date = new DateTimeImmutable('-10 day'),            new Email('valid@app.test'),            'password-hash',            new Token(self::TOKEN, $date->modify('+1 day'))        );        $user->confirmJoin(self::TOKEN, $date);        $manager->persist($user);        $manager->flush();    }}