<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251017090349 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE feature (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle_feature (vehicle_id INT NOT NULL, feature_id INT NOT NULL, INDEX IDX_A42809545317D1 (vehicle_id), INDEX IDX_A4280960E4B879 (feature_id), PRIMARY KEY(vehicle_id, feature_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vehicle_feature ADD CONSTRAINT FK_A42809545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE vehicle_feature ADD CONSTRAINT FK_A4280960E4B879 FOREIGN KEY (feature_id) REFERENCES feature (id)');
        $this->addSql('ALTER TABLE vehicle ADD year INT NOT NULL, ADD registration VARCHAR(255) NOT NULL, ADD mileage NUMERIC(10, 2) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicle_feature DROP FOREIGN KEY FK_A42809545317D1');
        $this->addSql('ALTER TABLE vehicle_feature DROP FOREIGN KEY FK_A4280960E4B879');
        $this->addSql('DROP TABLE feature');
        $this->addSql('DROP TABLE vehicle_feature');
        $this->addSql('ALTER TABLE vehicle DROP year, DROP registration, DROP mileage');
    }
}
