<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240424113553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE galaxy ADD name VARCHAR(100) NOT NULL, ADD particularities VARCHAR(1500) NOT NULL, ADD description VARCHAR(1500) NOT NULL, ADD created_at DATETIME NOT NULL, ADD update_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE lifeform ADD name VARCHAR(100) NOT NULL, ADD species VARCHAR(100) DEFAULT NULL, ADD behavior VARCHAR(100) NOT NULL, ADD description VARCHAR(1500) NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE planet ADD name VARCHAR(100) NOT NULL, ADD type VARCHAR(100) NOT NULL, ADD life_condition VARCHAR(100) NOT NULL, ADD description VARCHAR(1500) NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE report_lifeform ADD body VARCHAR(1500) NOT NULL, ADD created_at DATETIME NOT NULL, ADD update_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE report_planet ADD body VARCHAR(1500) NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD username VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE galaxy DROP name, DROP particularities, DROP description, DROP created_at, DROP update_at');
        $this->addSql('ALTER TABLE lifeform DROP name, DROP species, DROP behavior, DROP description, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE planet DROP name, DROP type, DROP life_condition, DROP description, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE report_lifeform DROP body, DROP created_at, DROP update_at');
        $this->addSql('ALTER TABLE report_planet DROP body, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE user DROP username');
    }
}
