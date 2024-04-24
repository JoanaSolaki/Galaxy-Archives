<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240424143703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE galaxy ADD image_name VARCHAR(255) DEFAULT NULL, CHANGE update_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE lifeform ADD image_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE planet ADD image_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD image_name VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE galaxy DROP image_name, CHANGE updated_at update_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE planet DROP image_name');
        $this->addSql('ALTER TABLE lifeform DROP image_name');
        $this->addSql('ALTER TABLE user DROP image_name, DROP updated_at');
    }
}
