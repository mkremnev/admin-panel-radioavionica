<?php

declare(strict_types=1);

namespace App\Data\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210126080951 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX uniq_da6ad53ccb0af6149fc812a2dc6dc6398718923b');
        $this->addSql('ALTER TABLE military_unit_officials RENAME COLUMN official_unit TO official_subunit');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DA6AD53C22EE6FA79FC812A2DC6DC6398718923B ON military_unit_officials (official_subunit, official_rank, official_fio, official_telephone)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_DA6AD53C22EE6FA79FC812A2DC6DC6398718923B');
        $this->addSql('ALTER TABLE military_unit_officials RENAME COLUMN official_subunit TO official_unit');
        $this->addSql('CREATE UNIQUE INDEX uniq_da6ad53ccb0af6149fc812a2dc6dc6398718923b ON military_unit_officials (official_unit, official_rank, official_fio, official_telephone)');
    }
}
