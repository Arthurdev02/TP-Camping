<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250207154451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hebergement (id INT AUTO_INCREMENT NOT NULL, equipements_id INT DEFAULT NULL, types_id INT DEFAULT NULL, capacite INT NOT NULL, superficie NUMERIC(10, 2) NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_4852DD9C852CCFF5 (equipements_id), INDEX IDX_4852DD9C8EB23357 (types_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hebergement ADD CONSTRAINT FK_4852DD9C852CCFF5 FOREIGN KEY (equipements_id) REFERENCES equipement (id)');
        $this->addSql('ALTER TABLE hebergement ADD CONSTRAINT FK_4852DD9C8EB23357 FOREIGN KEY (types_id) REFERENCES type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hebergement DROP FOREIGN KEY FK_4852DD9C852CCFF5');
        $this->addSql('ALTER TABLE hebergement DROP FOREIGN KEY FK_4852DD9C8EB23357');
        $this->addSql('DROP TABLE equipement');
        $this->addSql('DROP TABLE hebergement');
    }
}
