<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220103120755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE about (id INT AUTO_INCREMENT NOT NULL, rotate VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, birth DATETIME NOT NULL, address VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, projects INT NOT NULL, name VARCHAR(255) NOT NULL, phone INT NOT NULL, file_name_photo VARCHAR(255) NOT NULL, file_name_cv VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projects (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, page_path VARCHAR(255) NOT NULL, photo_path VARCHAR(255) NOT NULL, is_public TINYINT(1) NOT NULL, modificated_at DATETIME NOT NULL, uploaded_at DATETIME NOT NULL, git_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skills (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, percent INT NOT NULL, is_public TINYINT(1) NOT NULL, uploaded_at DATETIME NOT NULL, modificated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE summary_numbers (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, numbers INT NOT NULL, is_public TINYINT(1) NOT NULL, uploaded_at DATETIME NOT NULL, modificated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technologies (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image_path VARCHAR(255) NOT NULL, is_public TINYINT(1) NOT NULL, uploaded_at DATETIME NOT NULL, modificated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE about');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE skills');
        $this->addSql('DROP TABLE summary_numbers');
        $this->addSql('DROP TABLE technologies');
        $this->addSql('DROP TABLE user');
    }
}
