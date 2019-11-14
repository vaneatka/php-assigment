<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191114081440 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, file_id INT NOT NULL, created_at DATETIME NOT NULL, map_id INT NOT NULL, document_type VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file_contents (id INT AUTO_INCREMENT NOT NULL, map_id INT NOT NULL, file_id INT NOT NULL, content JSON NOT NULL, fileId INT DEFAULT NULL, mapId INT DEFAULT NULL, INDEX IDX_5AA9EEAAFC548A5 (fileId), INDEX IDX_5AA9EEA1B8FEDDA (mapId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE map (id INT AUTO_INCREMENT NOT NULL, map_id INT NOT NULL, field JSON NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE file_contents ADD CONSTRAINT FK_5AA9EEAAFC548A5 FOREIGN KEY (fileId) REFERENCES file (id)');
        $this->addSql('ALTER TABLE file_contents ADD CONSTRAINT FK_5AA9EEA1B8FEDDA FOREIGN KEY (mapId) REFERENCES map (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file_contents DROP FOREIGN KEY FK_5AA9EEAAFC548A5');
        $this->addSql('ALTER TABLE file_contents DROP FOREIGN KEY FK_5AA9EEA1B8FEDDA');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE file_contents');
        $this->addSql('DROP TABLE map');
    }
}
