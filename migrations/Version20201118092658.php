<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201118092658 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE technologies (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image_path VARCHAR(255) NOT NULL, uploaded_at DATETIME NOT NULL, is_public TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projects ADD uploaded_at DATETIME NOT NULL, ADD is_public TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE skills ADD uploaded_at DATETIME NOT NULL, ADD is_public TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE summary_numbers ADD uploaded_at DATETIME NOT NULL, ADD is_public TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE technologies');
        $this->addSql('ALTER TABLE projects DROP uploaded_at, DROP is_public');
        $this->addSql('ALTER TABLE skills DROP uploaded_at, DROP is_public');
        $this->addSql('ALTER TABLE summary_numbers DROP uploaded_at, DROP is_public');
    }
}
