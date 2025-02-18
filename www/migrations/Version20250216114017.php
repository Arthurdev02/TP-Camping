<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250216114017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, accomodations_id INT DEFAULT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, nbre_adults INT NOT NULL, nbre_childrens INT NOT NULL, INDEX IDX_E00CEDDE67B3B43D (users_id), UNIQUE INDEX UNIQ_E00CEDDE1E35121A (accomodations_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE old_booking (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, accomodations_id INT DEFAULT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, nbre_adults INT NOT NULL, nbre_childrens INT NOT NULL, INDEX IDX_9399348E67B3B43D (users_id), UNIQUE INDEX UNIQ_9399348E1E35121A (accomodations_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE67B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE1E35121A FOREIGN KEY (accomodations_id) REFERENCES accomodation (id)');
        $this->addSql('ALTER TABLE old_booking ADD CONSTRAINT FK_9399348E67B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE old_booking ADD CONSTRAINT FK_9399348E1E35121A FOREIGN KEY (accomodations_id) REFERENCES accomodation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE67B3B43D');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE1E35121A');
        $this->addSql('ALTER TABLE old_booking DROP FOREIGN KEY FK_9399348E67B3B43D');
        $this->addSql('ALTER TABLE old_booking DROP FOREIGN KEY FK_9399348E1E35121A');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE old_booking');
    }
}
