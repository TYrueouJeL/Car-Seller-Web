<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251020073710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE catalog (supplier_id INT NOT NULL, piece_id INT NOT NULL, INDEX IDX_1B2C32472ADD6D8C (supplier_id), INDEX IDX_1B2C3247C40FCFA8 (piece_id), PRIMARY KEY(supplier_id, piece_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feature (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feedback (id INT AUTO_INCREMENT NOT NULL, vehicle_id INT DEFAULT NULL, customer_id INT DEFAULT NULL, rating INT NOT NULL, comment VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D2294458545317D1 (vehicle_id), INDEX IDX_D22944589395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenance (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, technician_id INT DEFAULT NULL, maintenance_status_id INT DEFAULT NULL, maintenance_request_id INT DEFAULT NULL, type_id INT DEFAULT NULL, vehicle_id INT DEFAULT NULL, date DATETIME NOT NULL, is_done TINYINT(1) NOT NULL, INDEX IDX_2F84F8E99395C3F3 (customer_id), INDEX IDX_2F84F8E9E6C5D496 (technician_id), INDEX IDX_2F84F8E92E3624CC (maintenance_status_id), INDEX IDX_2F84F8E96539382B (maintenance_request_id), INDEX IDX_2F84F8E9C54C8C93 (type_id), INDEX IDX_2F84F8E9545317D1 (vehicle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenance_request (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, type_id INT DEFAULT NULL, vehicle_id INT DEFAULT NULL, technician_id INT DEFAULT NULL, request_date DATETIME NOT NULL, approved_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_4261CA0D9395C3F3 (customer_id), INDEX IDX_4261CA0DC54C8C93 (type_id), INDEX IDX_4261CA0D545317D1 (vehicle_id), INDEX IDX_4261CA0DE6C5D496 (technician_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenance_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE model (id INT AUTO_INCREMENT NOT NULL, brand_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_D79572D944F5D008 (brand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movement_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, vehicle_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', type VARCHAR(255) NOT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, INDEX IDX_F52993989395C3F3 (customer_id), INDEX IDX_F5299398545317D1 (vehicle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE piece (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE piece_model (model_id INT NOT NULL, piece_id INT NOT NULL, INDEX IDX_C526F3B27975B7E7 (model_id), INDEX IDX_C526F3B2C40FCFA8 (piece_id), PRIMARY KEY(model_id, piece_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_movement (id INT AUTO_INCREMENT NOT NULL, piece_id INT DEFAULT NULL, movement_type_id INT DEFAULT NULL, quantity INT NOT NULL, movement_date DATETIME NOT NULL, INDEX IDX_BB1BC1B5C40FCFA8 (piece_id), INDEX IDX_BB1BC1B5EA4ED04A (movement_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supplier (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supply_order (id INT AUTO_INCREMENT NOT NULL, supplier_id INT DEFAULT NULL, INDEX IDX_91F9D33C2ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supply_order_line (id INT AUTO_INCREMENT NOT NULL, piece_id INT DEFAULT NULL, stock_movement_id INT DEFAULT NULL, supply_order_id INT DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_E4E7419C40FCFA8 (piece_id), INDEX IDX_E4E7419FD50D693 (stock_movement_id), INDEX IDX_E4E741925440531 (supply_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, technician_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_97A0ADA39395C3F3 (customer_id), INDEX IDX_97A0ADA3E6C5D496 (technician_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_comment (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, ticket_id INT DEFAULT NULL, comment VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_98B80B3EF675F31B (author_id), INDEX IDX_98B80B3E700047D2 (ticket_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_piece (piece_id INT NOT NULL, type_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_4AC68CD4C40FCFA8 (piece_id), INDEX IDX_4AC68CD4C54C8C93 (type_id), PRIMARY KEY(piece_id, type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, phone_number VARCHAR(20) DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, model_id INT DEFAULT NULL, category_id INT DEFAULT NULL, customer_id INT DEFAULT NULL, year INT NOT NULL, registration VARCHAR(255) NOT NULL, mileage NUMERIC(10, 2) NOT NULL, type VARCHAR(255) NOT NULL, daily_price NUMERIC(10, 2) DEFAULT NULL, price NUMERIC(10, 2) DEFAULT NULL, INDEX IDX_1B80E4867975B7E7 (model_id), INDEX IDX_1B80E48612469DE2 (category_id), INDEX IDX_1B80E4869395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle_feature (vehicle_id INT NOT NULL, feature_id INT NOT NULL, INDEX IDX_A42809545317D1 (vehicle_id), INDEX IDX_A4280960E4B879 (feature_id), PRIMARY KEY(vehicle_id, feature_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE catalog ADD CONSTRAINT FK_1B2C32472ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE catalog ADD CONSTRAINT FK_1B2C3247C40FCFA8 FOREIGN KEY (piece_id) REFERENCES piece (id)');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D2294458545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D22944589395C3F3 FOREIGN KEY (customer_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT FK_2F84F8E99395C3F3 FOREIGN KEY (customer_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT FK_2F84F8E9E6C5D496 FOREIGN KEY (technician_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT FK_2F84F8E92E3624CC FOREIGN KEY (maintenance_status_id) REFERENCES maintenance_status (id)');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT FK_2F84F8E96539382B FOREIGN KEY (maintenance_request_id) REFERENCES maintenance_request (id)');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT FK_2F84F8E9C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT FK_2F84F8E9545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE maintenance_request ADD CONSTRAINT FK_4261CA0D9395C3F3 FOREIGN KEY (customer_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE maintenance_request ADD CONSTRAINT FK_4261CA0DC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE maintenance_request ADD CONSTRAINT FK_4261CA0D545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE maintenance_request ADD CONSTRAINT FK_4261CA0DE6C5D496 FOREIGN KEY (technician_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D944F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE piece_model ADD CONSTRAINT FK_C526F3B27975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('ALTER TABLE piece_model ADD CONSTRAINT FK_C526F3B2C40FCFA8 FOREIGN KEY (piece_id) REFERENCES piece (id)');
        $this->addSql('ALTER TABLE stock_movement ADD CONSTRAINT FK_BB1BC1B5C40FCFA8 FOREIGN KEY (piece_id) REFERENCES piece (id)');
        $this->addSql('ALTER TABLE stock_movement ADD CONSTRAINT FK_BB1BC1B5EA4ED04A FOREIGN KEY (movement_type_id) REFERENCES movement_type (id)');
        $this->addSql('ALTER TABLE supply_order ADD CONSTRAINT FK_91F9D33C2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE supply_order_line ADD CONSTRAINT FK_E4E7419C40FCFA8 FOREIGN KEY (piece_id) REFERENCES piece (id)');
        $this->addSql('ALTER TABLE supply_order_line ADD CONSTRAINT FK_E4E7419FD50D693 FOREIGN KEY (stock_movement_id) REFERENCES stock_movement (id)');
        $this->addSql('ALTER TABLE supply_order_line ADD CONSTRAINT FK_E4E741925440531 FOREIGN KEY (supply_order_id) REFERENCES supply_order (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA39395C3F3 FOREIGN KEY (customer_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3E6C5D496 FOREIGN KEY (technician_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE ticket_comment ADD CONSTRAINT FK_98B80B3EF675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE ticket_comment ADD CONSTRAINT FK_98B80B3E700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('ALTER TABLE type_piece ADD CONSTRAINT FK_4AC68CD4C40FCFA8 FOREIGN KEY (piece_id) REFERENCES piece (id)');
        $this->addSql('ALTER TABLE type_piece ADD CONSTRAINT FK_4AC68CD4C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E4867975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E48612469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E4869395C3F3 FOREIGN KEY (customer_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE vehicle_feature ADD CONSTRAINT FK_A42809545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE vehicle_feature ADD CONSTRAINT FK_A4280960E4B879 FOREIGN KEY (feature_id) REFERENCES feature (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalog DROP FOREIGN KEY FK_1B2C32472ADD6D8C');
        $this->addSql('ALTER TABLE catalog DROP FOREIGN KEY FK_1B2C3247C40FCFA8');
        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D2294458545317D1');
        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D22944589395C3F3');
        $this->addSql('ALTER TABLE maintenance DROP FOREIGN KEY FK_2F84F8E99395C3F3');
        $this->addSql('ALTER TABLE maintenance DROP FOREIGN KEY FK_2F84F8E9E6C5D496');
        $this->addSql('ALTER TABLE maintenance DROP FOREIGN KEY FK_2F84F8E92E3624CC');
        $this->addSql('ALTER TABLE maintenance DROP FOREIGN KEY FK_2F84F8E96539382B');
        $this->addSql('ALTER TABLE maintenance DROP FOREIGN KEY FK_2F84F8E9C54C8C93');
        $this->addSql('ALTER TABLE maintenance DROP FOREIGN KEY FK_2F84F8E9545317D1');
        $this->addSql('ALTER TABLE maintenance_request DROP FOREIGN KEY FK_4261CA0D9395C3F3');
        $this->addSql('ALTER TABLE maintenance_request DROP FOREIGN KEY FK_4261CA0DC54C8C93');
        $this->addSql('ALTER TABLE maintenance_request DROP FOREIGN KEY FK_4261CA0D545317D1');
        $this->addSql('ALTER TABLE maintenance_request DROP FOREIGN KEY FK_4261CA0DE6C5D496');
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D944F5D008');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993989395C3F3');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398545317D1');
        $this->addSql('ALTER TABLE piece_model DROP FOREIGN KEY FK_C526F3B27975B7E7');
        $this->addSql('ALTER TABLE piece_model DROP FOREIGN KEY FK_C526F3B2C40FCFA8');
        $this->addSql('ALTER TABLE stock_movement DROP FOREIGN KEY FK_BB1BC1B5C40FCFA8');
        $this->addSql('ALTER TABLE stock_movement DROP FOREIGN KEY FK_BB1BC1B5EA4ED04A');
        $this->addSql('ALTER TABLE supply_order DROP FOREIGN KEY FK_91F9D33C2ADD6D8C');
        $this->addSql('ALTER TABLE supply_order_line DROP FOREIGN KEY FK_E4E7419C40FCFA8');
        $this->addSql('ALTER TABLE supply_order_line DROP FOREIGN KEY FK_E4E7419FD50D693');
        $this->addSql('ALTER TABLE supply_order_line DROP FOREIGN KEY FK_E4E741925440531');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA39395C3F3');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3E6C5D496');
        $this->addSql('ALTER TABLE ticket_comment DROP FOREIGN KEY FK_98B80B3EF675F31B');
        $this->addSql('ALTER TABLE ticket_comment DROP FOREIGN KEY FK_98B80B3E700047D2');
        $this->addSql('ALTER TABLE type_piece DROP FOREIGN KEY FK_4AC68CD4C40FCFA8');
        $this->addSql('ALTER TABLE type_piece DROP FOREIGN KEY FK_4AC68CD4C54C8C93');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E4867975B7E7');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E48612469DE2');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E4869395C3F3');
        $this->addSql('ALTER TABLE vehicle_feature DROP FOREIGN KEY FK_A42809545317D1');
        $this->addSql('ALTER TABLE vehicle_feature DROP FOREIGN KEY FK_A4280960E4B879');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE catalog');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE feature');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('DROP TABLE maintenance');
        $this->addSql('DROP TABLE maintenance_request');
        $this->addSql('DROP TABLE maintenance_status');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE movement_type');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE piece');
        $this->addSql('DROP TABLE piece_model');
        $this->addSql('DROP TABLE stock_movement');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('DROP TABLE supply_order');
        $this->addSql('DROP TABLE supply_order_line');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE ticket_comment');
        $this->addSql('DROP TABLE ticket_status');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE type_piece');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE vehicle');
        $this->addSql('DROP TABLE vehicle_feature');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
