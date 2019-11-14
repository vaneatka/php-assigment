<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191113141057 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE FileContents (file_id INT NOT NULL, map_id INT NOT NULL, INDEX IDX_7A93F09F93CB796C (file_id), INDEX IDX_7A93F09F53C55F64 (map_id), PRIMARY KEY(file_id, map_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file_contents (id INT AUTO_INCREMENT NOT NULL, file_id INT NOT NULL, map_id INT NOT NULL, content JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE FileContents ADD CONSTRAINT FK_7A93F09F93CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE FileContents ADD CONSTRAINT FK_7A93F09F53C55F64 FOREIGN KEY (map_id) REFERENCES map (id)');
        $this->addSql('ALTER TABLE file CHANGE map_id map_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE map CHANGE field field JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE FileContents');
        $this->addSql('DROP TABLE file_contents');
        $this->addSql('ALTER TABLE file CHANGE map_id map_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE map CHANGE field field LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
