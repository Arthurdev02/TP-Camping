<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250212154044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accomodation (id INT AUTO_INCREMENT NOT NULL, tarifications_id INT DEFAULT NULL, types_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, nbre_bedrooms INT NOT NULL, is_avaliable TINYINT(1) NOT NULL, image_path VARCHAR(255) NOT NULL, size INT NOT NULL, INDEX IDX_520D81B3A6E37F0 (tarifications_id), INDEX IDX_520D81B38EB23357 (types_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE accomodation_equipement (accomodation_id INT NOT NULL, equipement_id INT NOT NULL, INDEX IDX_F21D5FDAFD70509C (accomodation_id), INDEX IDX_F21D5FDA806F0F5C (equipement_id), PRIMARY KEY(accomodation_id, equipement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, accomodations_id INT DEFAULT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, nbre_adults INT NOT NULL, nbre_childrens INT NOT NULL, INDEX IDX_E00CEDDE67B3B43D (users_id), UNIQUE INDEX UNIQ_E00CEDDE1E35121A (accomodations_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipement (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE season (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tarification (id INT AUTO_INCREMENT NOT NULL, season_id INT DEFAULT NULL, accomodation_id INT DEFAULT NULL, price NUMERIC(10, 2) NOT NULL, INDEX IDX_61328164EC001D1 (season_id), INDEX IDX_6132816FD70509C (accomodation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accomodation ADD CONSTRAINT FK_520D81B3A6E37F0 FOREIGN KEY (tarifications_id) REFERENCES tarification (id)');
        $this->addSql('ALTER TABLE accomodation ADD CONSTRAINT FK_520D81B38EB23357 FOREIGN KEY (types_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE accomodation_equipement ADD CONSTRAINT FK_F21D5FDAFD70509C FOREIGN KEY (accomodation_id) REFERENCES accomodation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE accomodation_equipement ADD CONSTRAINT FK_F21D5FDA806F0F5C FOREIGN KEY (equipement_id) REFERENCES equipement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE67B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE1E35121A FOREIGN KEY (accomodations_id) REFERENCES accomodation (id)');
        $this->addSql('ALTER TABLE tarification ADD CONSTRAINT FK_61328164EC001D1 FOREIGN KEY (season_id) REFERENCES season (id)');
        $this->addSql('ALTER TABLE tarification ADD CONSTRAINT FK_6132816FD70509C FOREIGN KEY (accomodation_id) REFERENCES accomodation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accomodation DROP FOREIGN KEY FK_520D81B3A6E37F0');
        $this->addSql('ALTER TABLE accomodation DROP FOREIGN KEY FK_520D81B38EB23357');
        $this->addSql('ALTER TABLE accomodation_equipement DROP FOREIGN KEY FK_F21D5FDAFD70509C');
        $this->addSql('ALTER TABLE accomodation_equipement DROP FOREIGN KEY FK_F21D5FDA806F0F5C');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE67B3B43D');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE1E35121A');
        $this->addSql('ALTER TABLE tarification DROP FOREIGN KEY FK_61328164EC001D1');
        $this->addSql('ALTER TABLE tarification DROP FOREIGN KEY FK_6132816FD70509C');
        $this->addSql('DROP TABLE accomodation');
        $this->addSql('DROP TABLE accomodation_equipement');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE equipement');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP TABLE tarification');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
