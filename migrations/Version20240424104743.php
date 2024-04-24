<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240424104743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE galaxy (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, INDEX IDX_F6BB1376F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lifeform (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, INDEX IDX_FB5582F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lifeform_planet (lifeform_id INT NOT NULL, planet_id INT NOT NULL, INDEX IDX_ED0E8EF56953885B (lifeform_id), INDEX IDX_ED0E8EF5A25E9820 (planet_id), PRIMARY KEY(lifeform_id, planet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planet (id INT AUTO_INCREMENT NOT NULL, galaxy_id INT DEFAULT NULL, author_id INT DEFAULT NULL, INDEX IDX_68136AA5B61FAB2 (galaxy_id), INDEX IDX_68136AA5F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE report_lifeform (id INT AUTO_INCREMENT NOT NULL, lifeform_id INT DEFAULT NULL, author_id INT DEFAULT NULL, INDEX IDX_9BCCFF6953885B (lifeform_id), INDEX IDX_9BCCFFF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE report_planet (id INT AUTO_INCREMENT NOT NULL, planet_id INT DEFAULT NULL, author_id INT DEFAULT NULL, INDEX IDX_41E0BF3AA25E9820 (planet_id), INDEX IDX_41E0BF3AF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE galaxy ADD CONSTRAINT FK_F6BB1376F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE lifeform ADD CONSTRAINT FK_FB5582F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE lifeform_planet ADD CONSTRAINT FK_ED0E8EF56953885B FOREIGN KEY (lifeform_id) REFERENCES lifeform (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lifeform_planet ADD CONSTRAINT FK_ED0E8EF5A25E9820 FOREIGN KEY (planet_id) REFERENCES planet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE planet ADD CONSTRAINT FK_68136AA5B61FAB2 FOREIGN KEY (galaxy_id) REFERENCES galaxy (id)');
        $this->addSql('ALTER TABLE planet ADD CONSTRAINT FK_68136AA5F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE report_lifeform ADD CONSTRAINT FK_9BCCFF6953885B FOREIGN KEY (lifeform_id) REFERENCES lifeform (id)');
        $this->addSql('ALTER TABLE report_lifeform ADD CONSTRAINT FK_9BCCFFF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE report_planet ADD CONSTRAINT FK_41E0BF3AA25E9820 FOREIGN KEY (planet_id) REFERENCES planet (id)');
        $this->addSql('ALTER TABLE report_planet ADD CONSTRAINT FK_41E0BF3AF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE galaxy DROP FOREIGN KEY FK_F6BB1376F675F31B');
        $this->addSql('ALTER TABLE lifeform DROP FOREIGN KEY FK_FB5582F675F31B');
        $this->addSql('ALTER TABLE lifeform_planet DROP FOREIGN KEY FK_ED0E8EF56953885B');
        $this->addSql('ALTER TABLE lifeform_planet DROP FOREIGN KEY FK_ED0E8EF5A25E9820');
        $this->addSql('ALTER TABLE planet DROP FOREIGN KEY FK_68136AA5B61FAB2');
        $this->addSql('ALTER TABLE planet DROP FOREIGN KEY FK_68136AA5F675F31B');
        $this->addSql('ALTER TABLE report_lifeform DROP FOREIGN KEY FK_9BCCFF6953885B');
        $this->addSql('ALTER TABLE report_lifeform DROP FOREIGN KEY FK_9BCCFFF675F31B');
        $this->addSql('ALTER TABLE report_planet DROP FOREIGN KEY FK_41E0BF3AA25E9820');
        $this->addSql('ALTER TABLE report_planet DROP FOREIGN KEY FK_41E0BF3AF675F31B');
        $this->addSql('DROP TABLE galaxy');
        $this->addSql('DROP TABLE lifeform');
        $this->addSql('DROP TABLE lifeform_planet');
        $this->addSql('DROP TABLE planet');
        $this->addSql('DROP TABLE report_lifeform');
        $this->addSql('DROP TABLE report_planet');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
