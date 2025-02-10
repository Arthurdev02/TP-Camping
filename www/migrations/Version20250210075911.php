<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250210075911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tarification (id INT AUTO_INCREMENT NOT NULL, hebergements_id INT DEFAULT NULL, tarif NUMERIC(10, 2) NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, INDEX IDX_61328164383C247 (hebergements_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tarification_saison (tarification_id INT NOT NULL, saison_id INT NOT NULL, INDEX IDX_D439AE24A709F580 (tarification_id), INDEX IDX_D439AE24F965414C (saison_id), PRIMARY KEY(tarification_id, saison_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tarification ADD CONSTRAINT FK_61328164383C247 FOREIGN KEY (hebergements_id) REFERENCES hebergement (id)');
        $this->addSql('ALTER TABLE tarification_saison ADD CONSTRAINT FK_D439AE24A709F580 FOREIGN KEY (tarification_id) REFERENCES tarification (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tarification_saison ADD CONSTRAINT FK_D439AE24F965414C FOREIGN KEY (saison_id) REFERENCES saison (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tarification DROP FOREIGN KEY FK_61328164383C247');
        $this->addSql('ALTER TABLE tarification_saison DROP FOREIGN KEY FK_D439AE24A709F580');
        $this->addSql('ALTER TABLE tarification_saison DROP FOREIGN KEY FK_D439AE24F965414C');
        $this->addSql('DROP TABLE tarification');
        $this->addSql('DROP TABLE tarification_saison');
    }
}
