<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220112213942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE address_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE people_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tavern_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE vote_by_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE address (id INT NOT NULL, street VARCHAR(255) NOT NULL, zip VARCHAR(5) NOT NULL, city VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE people (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nickname VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_28166A26E7927C74 ON people (email)');
        $this->addSql('CREATE TABLE tavern (id INT NOT NULL, address_id INT DEFAULT NULL, added_by_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_32681129F5B7AF75 ON tavern (address_id)');
        $this->addSql('CREATE INDEX IDX_3268112955B127A4 ON tavern (added_by_id)');
        $this->addSql('CREATE TABLE vote_by_user (id INT NOT NULL, tavern_id INT DEFAULT NULL, voter_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_304ED06C416D7217 ON vote_by_user (tavern_id)');
        $this->addSql('CREATE INDEX IDX_304ED06CEBB4B8AD ON vote_by_user (voter_id)');
        $this->addSql('CREATE UNIQUE INDEX one_vote_idx ON vote_by_user (tavern_id, voter_id)');
        $this->addSql('ALTER TABLE tavern ADD CONSTRAINT FK_32681129F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tavern ADD CONSTRAINT FK_3268112955B127A4 FOREIGN KEY (added_by_id) REFERENCES people (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vote_by_user ADD CONSTRAINT FK_304ED06C416D7217 FOREIGN KEY (tavern_id) REFERENCES tavern (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vote_by_user ADD CONSTRAINT FK_304ED06CEBB4B8AD FOREIGN KEY (voter_id) REFERENCES people (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE tavern DROP CONSTRAINT FK_32681129F5B7AF75');
        $this->addSql('ALTER TABLE tavern DROP CONSTRAINT FK_3268112955B127A4');
        $this->addSql('ALTER TABLE vote_by_user DROP CONSTRAINT FK_304ED06CEBB4B8AD');
        $this->addSql('ALTER TABLE vote_by_user DROP CONSTRAINT FK_304ED06C416D7217');
        $this->addSql('DROP SEQUENCE address_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE people_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tavern_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE vote_by_user_id_seq CASCADE');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE people');
        $this->addSql('DROP TABLE tavern');
        $this->addSql('DROP TABLE vote_by_user');
    }
}
