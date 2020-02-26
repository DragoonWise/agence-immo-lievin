<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200226082844 extends AbstractMigration
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
        $this->addSql('DROP INDEX FK_Pictures_Property ON pictures');
        $this->addSql('ALTER TABLE pictures ADD FileName VARCHAR(255) DEFAULT \'empty.jpg\' NOT NULL, DROP Label, DROP Updated_at, DROP Deleted_at, DROP Deleted, CHANGE idproperty idproperty_id INT NOT NULL');
        $this->addSql('ALTER TABLE pictures ADD CONSTRAINT FK_8F7C2FC092536343 FOREIGN KEY (idproperty_id) REFERENCES properties (id)');
        $this->addSql('CREATE INDEX IDX_8F7C2FC092536343 ON pictures (idproperty_id)');
        $this->addSql('ALTER TABLE properties CHANGE IdAddress IdAddress INT DEFAULT NULL, CHANGE IdPropertyType IdPropertyType INT DEFAULT NULL, CHANGE IdUser IdUser INT DEFAULT NULL, CHANGE IsVisible IsVisible TINYINT(1) DEFAULT NULL, CHANGE IsTop IsTop TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE users CHANGE IdAddress IdAddress INT DEFAULT NULL, CHANGE IsAdmin IsAdmin TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE countries CHANGE country_code country_code VARCHAR(2) CHARACTER SET utf8 DEFAULT \'\'\'\'\'\' NOT NULL COLLATE `utf8_bin`, CHANGE country_name country_name VARCHAR(100) CHARACTER SET utf8 DEFAULT \'\'\'\'\'\' NOT NULL COLLATE `utf8_bin`');
        $this->addSql('ALTER TABLE favorites CHANGE IdProperty IdProperty INT DEFAULT NULL, CHANGE IdUser IdUser INT DEFAULT NULL');
        $this->addSql('ALTER TABLE messages CHANGE IsRead IsRead TINYINT(1) DEFAULT \'NULL\', CHANGE IdUser IdUser INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pictures DROP FOREIGN KEY FK_8F7C2FC092536343');
        $this->addSql('DROP INDEX IDX_8F7C2FC092536343 ON pictures');
        $this->addSql('ALTER TABLE pictures ADD Label VARCHAR(50) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_bin`, ADD Updated_at DATETIME DEFAULT \'current_timestamp()\' NOT NULL, ADD Deleted_at DATETIME DEFAULT \'NULL\', ADD Deleted TINYINT(1) DEFAULT \'0\' NOT NULL, DROP FileName, CHANGE idproperty_id IdProperty INT NOT NULL');
        $this->addSql('CREATE INDEX FK_Pictures_Property ON pictures (IdProperty)');
        $this->addSql('ALTER TABLE properties CHANGE IsVisible IsVisible TINYINT(1) DEFAULT \'NULL\', CHANGE IsTop IsTop TINYINT(1) DEFAULT \'NULL\', CHANGE IdAddress IdAddress INT DEFAULT NULL, CHANGE IdPropertyType IdPropertyType INT DEFAULT NULL, CHANGE IdUser IdUser INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users CHANGE IsAdmin IsAdmin TINYINT(1) DEFAULT \'NULL\', CHANGE IdAddress IdAddress INT DEFAULT NULL');
    }
}
