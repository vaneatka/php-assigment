<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191114080454 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE file_contents (id INT AUTO_INCREMENT NOT NULL, map_id INT NOT NULL, file_id INT NOT NULL, content JSON NOT NULL, fileId INT DEFAULT NULL, INDEX IDX_5AA9EEAAFC548A5 (fileId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE file_contents ADD CONSTRAINT FK_5AA9EEAAFC548A5 FOREIGN KEY (fileId) REFERENCES file (id)');
        $this->addSql('DROP TABLE map');
        $this->addSql('ALTER TABLE file ADD file_id INT NOT NULL, DROP uuid, CHANGE map_id map_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE map (id INT AUTO_INCREMENT NOT NULL, map_id INT NOT NULL, field LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE file_contents');
        $this->addSql('ALTER TABLE file ADD uuid VARBINARY(255) NOT NULL, DROP file_id, CHANGE map_id map_id INT DEFAULT NULL');
    }
}
