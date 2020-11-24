<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201119065241 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projects ADD page_path VARCHAR(255) NOT NULL, ADD modificated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE skills ADD modificated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE summary_numbers ADD modificated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE technologies ADD modificated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projects DROP page_path, DROP modificated_at');
        $this->addSql('ALTER TABLE skills DROP modificated_at');
        $this->addSql('ALTER TABLE summary_numbers DROP modificated_at');
        $this->addSql('ALTER TABLE technologies DROP modificated_at');
    }
}
