<?phpdeclare(strict_types=1);namespace Test\Functional\V1\Auth\Join;use App\Auth\Entity\User\Email;use App\Auth\Entity\User\Id;use App\Auth\Entity\User\Token;use App\Auth\Entity\User\User;use DateTimeImmutable;use Doctrine\Persistence\ObjectManager;use Doctrine\Common\DataFixtures\AbstractFixture;class ConfirmFixtures extends AbstractFixture{    public const VALID = "00000000-0000-0000-0000-000000000001";    public const EXPIRED = "00000000-0000-0000-0000-000000000002";    public function load(ObjectManager $manager)    {        $user = User::requestJoinByEmail(            Id::generate(),            $date = new DateTimeImmutable(),            new Email('valid@app.test'),            'password-hash',            new Token($value = self::VALID, $date->modify('+1 hour'))        );        $manager->persist($user);        $user = User::requestJoinByEmail(            Id::generate(),            $date = new DateTimeImmutable(),            new Email('expired@app.test'),            'password-hash',            new Token($value = self::EXPIRED, $date->modify('-2 hours'))        );        $manager->persist($user);        $manager->flush();    }}