<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260313120542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE model ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D79572D912469DE2 ON model (category_id)');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E48612469DE2');
        $this->addSql('DROP INDEX IDX_1B80E48612469DE2 ON vehicle');
        $this->addSql('ALTER TABLE vehicle DROP category_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D912469DE2');
        $this->addSql('DROP INDEX IDX_D79572D912469DE2 ON model');
        $this->addSql('ALTER TABLE model DROP category_id');
        $this->addSql('ALTER TABLE vehicle ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E48612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_1B80E48612469DE2 ON vehicle (category_id)');
    }
}
