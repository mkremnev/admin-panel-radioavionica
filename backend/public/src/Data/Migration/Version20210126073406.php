<?php

declare(strict_types=1);

namespace App\Data\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210126073406 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE military_units_officials (id UUID NOT NULL, units_id UUID NOT NULL, official_unit VARCHAR(255) DEFAULT NULL, official_rank VARCHAR(255) DEFAULT NULL, official_fio VARCHAR(255) DEFAULT NULL, official_telephone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_61380E2699387CE8 ON military_units_officials (units_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_61380E26CB0AF6149FC812A2DC6DC6398718923B ON military_units_officials (official_unit, official_rank, official_fio, official_telephone)');
        $this->addSql('COMMENT ON COLUMN military_units_officials.units_id IS \'(DC2Type:military_units_id)\'');
        $this->addSql('ALTER TABLE military_units_officials ADD CONSTRAINT FK_61380E2699387CE8 FOREIGN KEY (units_id) REFERENCES military_units (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE military_units_officilas');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE military_units_officilas (id UUID NOT NULL, units_id UUID NOT NULL, officials_unit VARCHAR(255) DEFAULT NULL, officials_rank VARCHAR(255) DEFAULT NULL, officials_fio VARCHAR(255) DEFAULT NULL, officials_telephone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_dc4ee33899387ce8 ON military_units_officilas (units_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_dc4ee338195fdccc4d9d387a84c2e31f286ba23f ON military_units_officilas (officials_unit, officials_rank, officials_fio, officials_telephone)');
        $this->addSql('COMMENT ON COLUMN military_units_officilas.units_id IS \'(DC2Type:military_units_id)\'');
        $this->addSql('ALTER TABLE military_units_officilas ADD CONSTRAINT fk_dc4ee33899387ce8 FOREIGN KEY (units_id) REFERENCES military_units (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE military_units_officials');
    }
}
