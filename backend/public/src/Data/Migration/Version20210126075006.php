<?php

declare(strict_types=1);

namespace App\Data\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210126075006 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE military_unit_officials (id UUID NOT NULL, unit_id UUID NOT NULL, official_unit VARCHAR(255) DEFAULT NULL, official_rank VARCHAR(255) DEFAULT NULL, official_fio VARCHAR(255) DEFAULT NULL, official_telephone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DA6AD53CF8BD700D ON military_unit_officials (unit_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DA6AD53CCB0AF6149FC812A2DC6DC6398718923B ON military_unit_officials (official_unit, official_rank, official_fio, official_telephone)');
        $this->addSql('COMMENT ON COLUMN military_unit_officials.unit_id IS \'(DC2Type:military_units_id)\'');
        $this->addSql('ALTER TABLE military_unit_officials ADD CONSTRAINT FK_DA6AD53CF8BD700D FOREIGN KEY (unit_id) REFERENCES military_units (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE military_units_officials');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE military_units_officials (id UUID NOT NULL, units_id UUID NOT NULL, official_unit VARCHAR(255) DEFAULT NULL, official_rank VARCHAR(255) DEFAULT NULL, official_fio VARCHAR(255) DEFAULT NULL, official_telephone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_61380e26cb0af6149fc812a2dc6dc6398718923b ON military_units_officials (official_unit, official_rank, official_fio, official_telephone)');
        $this->addSql('CREATE INDEX idx_61380e2699387ce8 ON military_units_officials (units_id)');
        $this->addSql('COMMENT ON COLUMN military_units_officials.units_id IS \'(DC2Type:military_units_id)\'');
        $this->addSql('ALTER TABLE military_units_officials ADD CONSTRAINT fk_61380e2699387ce8 FOREIGN KEY (units_id) REFERENCES military_units (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE military_unit_officials');
    }
}
