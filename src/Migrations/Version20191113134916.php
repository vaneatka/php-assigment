<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191113134916 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client DROP FOREIGN KEY client_ibfk_1');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY employee_ibfk_1');
        $this->addSql('ALTER TABLE branch DROP FOREIGN KEY branch_ibfk_1');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY employee_ibfk_2');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, uuid VARBINARY(255) NOT NULL, created_at DATETIME NOT NULL, map_id INT DEFAULT NULL, document_type VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file_map (file_id INT NOT NULL, map_id INT NOT NULL, INDEX IDX_BCEE242293CB796C (file_id), INDEX IDX_BCEE242253C55F64 (map_id), PRIMARY KEY(file_id, map_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file_contents (id INT AUTO_INCREMENT NOT NULL, file_id INT NOT NULL, map_id INT NOT NULL, content JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE map (id INT AUTO_INCREMENT NOT NULL, map_id INT NOT NULL, field JSON NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE file_map ADD CONSTRAINT FK_BCEE242293CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE file_map ADD CONSTRAINT FK_BCEE242253C55F64 FOREIGN KEY (map_id) REFERENCES map (id)');
        $this->addSql('DROP TABLE branch');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE employee');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file_map DROP FOREIGN KEY FK_BCEE242293CB796C');
        $this->addSql('ALTER TABLE file_map DROP FOREIGN KEY FK_BCEE242253C55F64');
        $this->addSql('CREATE TABLE branch (branch_id INT NOT NULL, mgr_id INT DEFAULT NULL, branch_name VARCHAR(40) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_general_ci`, mgr_start_date DATE DEFAULT \'NULL\', INDEX mgr_id (mgr_id), PRIMARY KEY(branch_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE client (client_id INT NOT NULL, branch_id INT DEFAULT NULL, client_name VARCHAR(40) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_general_ci`, INDEX branch_id (branch_id), PRIMARY KEY(client_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE employee (emp_id INT NOT NULL, super_id INT DEFAULT NULL, branch_id INT DEFAULT NULL, first_name VARCHAR(40) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_general_ci`, last_name VARCHAR(40) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_general_ci`, birth_day DATE DEFAULT \'NULL\', sex VARCHAR(1) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_general_ci`, salary INT DEFAULT NULL, INDEX super_id (super_id), INDEX branch_id (branch_id), PRIMARY KEY(emp_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE branch ADD CONSTRAINT branch_ibfk_1 FOREIGN KEY (mgr_id) REFERENCES employee (emp_id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT client_ibfk_1 FOREIGN KEY (branch_id) REFERENCES branch (branch_id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT employee_ibfk_1 FOREIGN KEY (branch_id) REFERENCES branch (branch_id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT employee_ibfk_2 FOREIGN KEY (super_id) REFERENCES employee (emp_id) ON DELETE SET NULL');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE file_map');
        $this->addSql('DROP TABLE file_contents');
        $this->addSql('DROP TABLE map');
    }
}
