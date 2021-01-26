<?php

declare(strict_types=1);

namespace App\Data\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210126083353 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE military_unit_officials (id UUID NOT NULL, unit_id UUID NOT NULL, official_subunit VARCHAR(255) DEFAULT NULL, official_rank VARCHAR(255) DEFAULT NULL, official_fio VARCHAR(255) DEFAULT NULL, official_telephone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DA6AD53CF8BD700D ON military_unit_officials (unit_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DA6AD53C22EE6FA79FC812A2DC6DC6398718923B ON military_unit_officials (official_subunit, official_rank, official_fio, official_telephone)');
        $this->addSql('COMMENT ON COLUMN military_unit_officials.unit_id IS \'(DC2Type:military_unit_id)\'');
        $this->addSql('CREATE TABLE military_units (id UUID NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, amount VARCHAR(255) NOT NULL, commander_lastname VARCHAR(255) NOT NULL, commander_firstname VARCHAR(255) DEFAULT NULL, commander_surname VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN military_units.id IS \'(DC2Type:military_unit_id)\'');
        $this->addSql('COMMENT ON COLUMN military_units.name IS \'(DC2Type:military_unit_name)\'');
        $this->addSql('COMMENT ON COLUMN military_units.address IS \'(DC2Type:military_unit_address)\'');
        $this->addSql('ALTER TABLE military_unit_officials ADD CONSTRAINT FK_DA6AD53CF8BD700D FOREIGN KEY (unit_id) REFERENCES military_units (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE military_unit_officials DROP CONSTRAINT FK_DA6AD53CF8BD700D');
        $this->addSql('DROP TABLE military_unit_officials');
        $this->addSql('DROP TABLE military_units');
    }
}
