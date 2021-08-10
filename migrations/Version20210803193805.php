<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210803193805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car_ad (id INT AUTO_INCREMENT NOT NULL, garage_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, year DATE NOT NULL, kilometers INT NOT NULL, brand VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, fuel VARCHAR(255) NOT NULL, INDEX IDX_B1F7C97C4FFF555 (garage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car_ad ADD CONSTRAINT FK_B1F7C97C4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE car_ad');
    }
}
