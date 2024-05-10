<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240509062304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE proyects (proyect_id INT AUTO_INCREMENT NOT NULL, proyect_name VARCHAR(255) NOT NULL, PRIMARY KEY(proyect_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tasks (task_id INT AUTO_INCREMENT NOT NULL, proyect_id INT NOT NULL, priority VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, date_init DATETIME NOT NULL, estimated_hours TIME DEFAULT NULL, dedicated_hours TIME DEFAULT NULL, clasification VARCHAR(255) NOT NULL, INDEX IDX_50586597405B99CF (proyect_id), PRIMARY KEY(task_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_50586597405B99CF FOREIGN KEY (proyect_id) REFERENCES proyects (proyect_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_50586597405B99CF');
        $this->addSql('DROP TABLE proyects');
        $this->addSql('DROP TABLE tasks');
    }
}
