<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250220130747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE1E35121A');
        $this->addSql('DROP INDEX UNIQ_E00CEDDE1E35121A ON booking');
        $this->addSql('ALTER TABLE booking ADD accomodation_id INT NOT NULL, DROP accomodations_id');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEFD70509C FOREIGN KEY (accomodation_id) REFERENCES accomodation (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDEFD70509C ON booking (accomodation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEFD70509C');
        $this->addSql('DROP INDEX IDX_E00CEDDEFD70509C ON booking');
        $this->addSql('ALTER TABLE booking ADD accomodations_id INT DEFAULT NULL, DROP accomodation_id');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE1E35121A FOREIGN KEY (accomodations_id) REFERENCES accomodation (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E00CEDDE1E35121A ON booking (accomodations_id)');
    }
}
