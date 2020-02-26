<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200225134211 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE countries CHANGE country_code country_code VARCHAR(2) DEFAULT \'\' NOT NULL, CHANGE country_name country_name VARCHAR(100) DEFAULT \'\' NOT NULL');
        $this->addSql('ALTER TABLE favorites CHANGE IdUser IdUser INT DEFAULT NULL, CHANGE IdProperty IdProperty INT DEFAULT NULL');
        $this->addSql('ALTER TABLE messages CHANGE IdUser IdUser INT DEFAULT NULL, CHANGE IsRead IsRead TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE pictures DROP FOREIGN KEY FK_Pictures_Property');
        $this->addSql('ALTER TABLE properties CHANGE IdAddress IdAddress INT DEFAULT NULL, CHANGE IdPropertyType IdPropertyType INT DEFAULT NULL, CHANGE IdUser IdUser INT DEFAULT NULL, CHANGE IsVisible IsVisible TINYINT(1) DEFAULT NULL, CHANGE IsTop IsTop TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE users CHANGE IdAddress IdAddress INT DEFAULT NULL, CHANGE IsAdmin IsAdmin TINYINT(1) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E926535370 ON users (Email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE countries CHANGE country_code country_code VARCHAR(2) CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`, CHANGE country_name country_name VARCHAR(100) CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`');
        $this->addSql('ALTER TABLE favorites CHANGE IdProperty IdProperty INT NOT NULL, CHANGE IdUser IdUser INT NOT NULL');
        $this->addSql('ALTER TABLE messages CHANGE IsRead IsRead TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE IdUser IdUser INT NOT NULL');
        $this->addSql('ALTER TABLE pictures ADD CONSTRAINT FK_Pictures_Property FOREIGN KEY (IdProperty) REFERENCES properties (Id)');
        $this->addSql('ALTER TABLE properties CHANGE IsVisible IsVisible TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE IsTop IsTop TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE IdAddress IdAddress INT NOT NULL, CHANGE IdPropertyType IdPropertyType INT NOT NULL, CHANGE IdUser IdUser INT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_1483A5E926535370 ON users');
        $this->addSql('ALTER TABLE users CHANGE IsAdmin IsAdmin TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE IdAddress IdAddress INT NOT NULL');
    }
}