<?php

declare(strict_types=1);

namespace App\Data\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210212110707 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE auth_users (id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, email VARCHAR(255) NOT NULL, password_hash VARCHAR(255) NOT NULL, status VARCHAR(16) NOT NULL, new_email VARCHAR(255) DEFAULT NULL, role VARCHAR(16) NOT NULL, confirm_token_value VARCHAR(255) DEFAULT NULL, confirm_token_expires TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, password_reset_token_value VARCHAR(255) DEFAULT NULL, password_reset_token_expires TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, email_change_token_value VARCHAR(255) DEFAULT NULL, email_change_token_expires TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D8A1F49CE7927C74 ON auth_users (email)');
        $this->addSql('COMMENT ON COLUMN auth_users.id IS \'(DC2Type:auth_user_id)\'');
        $this->addSql('COMMENT ON COLUMN auth_users.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN auth_users.email IS \'(DC2Type:auth_user_email)\'');
        $this->addSql('COMMENT ON COLUMN auth_users.status IS \'(DC2Type:auth_user_status)\'');
        $this->addSql('COMMENT ON COLUMN auth_users.new_email IS \'(DC2Type:auth_user_email)\'');
        $this->addSql('COMMENT ON COLUMN auth_users.role IS \'(DC2Type:auth_user_role)\'');
        $this->addSql('COMMENT ON COLUMN auth_users.confirm_token_expires IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN auth_users.password_reset_token_expires IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN auth_users.email_change_token_expires IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE military_defect_notes (id UUID NOT NULL, defect_id UUID NOT NULL, note_notice VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_313D312A6C1DAB9B ON military_defect_notes (defect_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_313D312A50DF1216 ON military_defect_notes (note_notice)');
        $this->addSql('COMMENT ON COLUMN military_defect_notes.defect_id IS \'(DC2Type:military_defect_id)\'');
        $this->addSql('CREATE TABLE military_defects (id UUID NOT NULL, unit VARCHAR(255) NOT NULL, responsible VARCHAR(255) NOT NULL, district VARCHAR(255) NOT NULL, amount VARCHAR(255) NOT NULL, delivery_year VARCHAR(255) NOT NULL, commissioning_date VARCHAR(255) NOT NULL, warranty VARCHAR(255) NOT NULL, non_warranty VARCHAR(255) NOT NULL, fault_component VARCHAR(255) DEFAULT NULL, fault_mik VARCHAR(255) DEFAULT NULL, components_ak1 VARCHAR(255) DEFAULT NULL, components_pkk VARCHAR(255) DEFAULT NULL, components_kpe1 VARCHAR(255) DEFAULT NULL, components_kab004 VARCHAR(255) DEFAULT NULL, components_kab136 VARCHAR(255) DEFAULT NULL, components_kab137 VARCHAR(255) DEFAULT NULL, components_zu VARCHAR(255) DEFAULT NULL, components_zupkk VARCHAR(255) DEFAULT NULL, components_mfp VARCHAR(255) DEFAULT NULL, components_pou VARCHAR(255) DEFAULT NULL, components_mirs VARCHAR(255) DEFAULT NULL, components_msns VARCHAR(255) DEFAULT NULL, components_kab152 VARCHAR(255) DEFAULT NULL, components_kab153 VARCHAR(255) DEFAULT NULL, components_tmg36 VARCHAR(255) DEFAULT NULL, components_gvsh VARCHAR(255) DEFAULT NULL, components_pdu VARCHAR(255) DEFAULT NULL, components_r168 VARCHAR(255) DEFAULT NULL, components_r438 VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN military_defects.id IS \'(DC2Type:military_defect_id)\'');
        $this->addSql('COMMENT ON COLUMN military_defects.unit IS \'(DC2Type:military_defect_unit)\'');
        $this->addSql('COMMENT ON COLUMN military_defects.district IS \'(DC2Type:military_defect_district)\'');
        $this->addSql('CREATE TABLE military_unit_officials (id UUID NOT NULL, unit_id UUID NOT NULL, official_subunit VARCHAR(255) DEFAULT NULL, official_rank VARCHAR(255) DEFAULT NULL, official_fio VARCHAR(255) DEFAULT NULL, official_telephone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DA6AD53CF8BD700D ON military_unit_officials (unit_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DA6AD53C22EE6FA79FC812A2DC6DC6398718923B ON military_unit_officials (official_subunit, official_rank, official_fio, official_telephone)');
        $this->addSql('COMMENT ON COLUMN military_unit_officials.unit_id IS \'(DC2Type:military_unit_id)\'');
        $this->addSql('CREATE TABLE military_units (id UUID NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, amount VARCHAR(255) NOT NULL, procuration VARCHAR(255) DEFAULT NULL, commander_lastname VARCHAR(255) NOT NULL, commander_firstname VARCHAR(255) DEFAULT NULL, commander_surname VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN military_units.id IS \'(DC2Type:military_unit_id)\'');
        $this->addSql('COMMENT ON COLUMN military_units.name IS \'(DC2Type:military_unit_name)\'');
        $this->addSql('COMMENT ON COLUMN military_units.address IS \'(DC2Type:military_unit_address)\'');
        $this->addSql('ALTER TABLE military_defect_notes ADD CONSTRAINT FK_313D312A6C1DAB9B FOREIGN KEY (defect_id) REFERENCES military_defects (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE military_unit_officials ADD CONSTRAINT FK_DA6AD53CF8BD700D FOREIGN KEY (unit_id) REFERENCES military_units (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE military_defect_notes DROP CONSTRAINT FK_313D312A6C1DAB9B');
        $this->addSql('ALTER TABLE military_unit_officials DROP CONSTRAINT FK_DA6AD53CF8BD700D');
        $this->addSql('DROP TABLE auth_users');
        $this->addSql('DROP TABLE military_defect_notes');
        $this->addSql('DROP TABLE military_defects');
        $this->addSql('DROP TABLE military_unit_officials');
        $this->addSql('DROP TABLE military_units');
    }
}
