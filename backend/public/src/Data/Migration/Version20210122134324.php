<?php

declare(strict_types=1);

namespace App\Data\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210122134324 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE military_units (id UUID NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, amount INT NOT NULL, commander_lastname VARCHAR(255) NOT NULL, commander_firstname VARCHAR(255) DEFAULT NULL, commander_surname VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN military_units.id IS \'(DC2Type:military_units_id)\'');
        $this->addSql('COMMENT ON COLUMN military_units.name IS \'(DC2Type:military_units_name)\'');
        $this->addSql('COMMENT ON COLUMN military_units.address IS \'(DC2Type:military_units_address)\'');
        $this->addSql('CREATE TABLE military_units_officilas (id UUID NOT NULL, units_id UUID NOT NULL, officials_unit VARCHAR(255) DEFAULT NULL, officials_rank VARCHAR(255) DEFAULT NULL, officials_fio VARCHAR(255) DEFAULT NULL, officials_telephone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DC4EE33899387CE8 ON military_units_officilas (units_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DC4EE338195FDCCC4D9D387A84C2E31F286BA23F ON military_units_officilas (officials_unit, officials_rank, officials_fio, officials_telephone)');
        $this->addSql('COMMENT ON COLUMN military_units_officilas.units_id IS \'(DC2Type:military_units_id)\'');
        $this->addSql('ALTER TABLE military_units_officilas ADD CONSTRAINT FK_DC4EE33899387CE8 FOREIGN KEY (units_id) REFERENCES military_units (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE military_units_officilas DROP CONSTRAINT FK_DC4EE33899387CE8');
        $this->addSql('DROP TABLE military_units');
        $this->addSql('DROP TABLE military_units_officilas');
    }
}
