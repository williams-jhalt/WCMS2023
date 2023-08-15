<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230809202002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, customer_number VARCHAR(255) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, company VARCHAR(255) NOT NULL, address1 VARCHAR(255) NOT NULL, address2 VARCHAR(255) DEFAULT NULL, address3 VARCHAR(255) DEFAULT NULL, city VARCHAR(255) NOT NULL, state VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(255) DEFAULT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, manufacturer_id INT DEFAULT NULL, item_number VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, release_date DATE DEFAULT NULL, description LONGTEXT DEFAULT NULL, keywords LONGTEXT DEFAULT NULL, price NUMERIC(10, 2) DEFAULT NULL, active TINYINT(1) NOT NULL, barcode VARCHAR(255) DEFAULT NULL, stock_quantity INT NOT NULL, reorder_quantity INT NOT NULL, video TINYINT(1) NOT NULL, on_sale TINYINT(1) NOT NULL, height DOUBLE PRECISION DEFAULT NULL, length DOUBLE PRECISION DEFAULT NULL, width DOUBLE PRECISION DEFAULT NULL, diameter DOUBLE PRECISION DEFAULT NULL, weight DOUBLE PRECISION DEFAULT NULL, color VARCHAR(255) DEFAULT NULL, material VARCHAR(255) DEFAULT NULL, discountable TINYINT(1) NOT NULL, max_discount_rate DOUBLE PRECISION NOT NULL, saleable TINYINT(1) NOT NULL, product_length DOUBLE PRECISION DEFAULT NULL, insertable_length DOUBLE PRECISION DEFAULT NULL, realistic TINYINT(1) NOT NULL, balls TINYINT(1) NOT NULL, suction_cup TINYINT(1) NOT NULL, harness TINYINT(1) NOT NULL, vibrating TINYINT(1) NOT NULL, thick TINYINT(1) NOT NULL, double_ended TINYINT(1) NOT NULL, circumference DOUBLE PRECISION DEFAULT NULL, brand VARCHAR(255) DEFAULT NULL, map_price NUMERIC(10, 2) DEFAULT NULL, amazon_restricted TINYINT(1) NOT NULL, approval_required TINYINT(1) NOT NULL, INDEX IDX_D34A04ADC54C8C93 (type_id), INDEX IDX_D34A04ADA23B42D (manufacturer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_product_category (product_id INT NOT NULL, product_category_id INT NOT NULL, INDEX IDX_437017AA4584665A (product_id), INDEX IDX_437017AABE6903FD (product_category_id), PRIMARY KEY(product_id, product_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_category (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_image (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', image_name VARCHAR(255) DEFAULT NULL, image_original_name VARCHAR(255) DEFAULT NULL, image_mime_type VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, image_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', INDEX IDX_64617F034584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_manufacturer (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_type (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weborder (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, order_number VARCHAR(255) NOT NULL, reference1 VARCHAR(255) DEFAULT NULL, reference2 VARCHAR(255) DEFAULT NULL, reference3 VARCHAR(255) DEFAULT NULL, ship_to_name VARCHAR(255) NOT NULL, ship_to_address VARCHAR(255) NOT NULL, ship_to_address2 VARCHAR(255) DEFAULT NULL, ship_to_address3 VARCHAR(255) DEFAULT NULL, ship_to_city VARCHAR(255) NOT NULL, ship_to_state VARCHAR(255) DEFAULT NULL, ship_to_zip VARCHAR(255) DEFAULT NULL, ship_to_country VARCHAR(255) NOT NULL, order_date DATETIME NOT NULL, INDEX IDX_6C0EEE769395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weborder_item (id INT AUTO_INCREMENT NOT NULL, weborder_id INT NOT NULL, item_number VARCHAR(255) NOT NULL, quantity INT NOT NULL, INDEX IDX_C1DA7FC0117822DB (weborder_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADC54C8C93 FOREIGN KEY (type_id) REFERENCES product_type (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADA23B42D FOREIGN KEY (manufacturer_id) REFERENCES product_manufacturer (id)');
        $this->addSql('ALTER TABLE product_product_category ADD CONSTRAINT FK_437017AA4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_product_category ADD CONSTRAINT FK_437017AABE6903FD FOREIGN KEY (product_category_id) REFERENCES product_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_image ADD CONSTRAINT FK_64617F034584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE weborder ADD CONSTRAINT FK_6C0EEE769395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE weborder_item ADD CONSTRAINT FK_C1DA7FC0117822DB FOREIGN KEY (weborder_id) REFERENCES weborder (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADC54C8C93');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADA23B42D');
        $this->addSql('ALTER TABLE product_product_category DROP FOREIGN KEY FK_437017AA4584665A');
        $this->addSql('ALTER TABLE product_product_category DROP FOREIGN KEY FK_437017AABE6903FD');
        $this->addSql('ALTER TABLE product_image DROP FOREIGN KEY FK_64617F034584665A');
        $this->addSql('ALTER TABLE weborder DROP FOREIGN KEY FK_6C0EEE769395C3F3');
        $this->addSql('ALTER TABLE weborder_item DROP FOREIGN KEY FK_C1DA7FC0117822DB');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_product_category');
        $this->addSql('DROP TABLE product_category');
        $this->addSql('DROP TABLE product_image');
        $this->addSql('DROP TABLE product_manufacturer');
        $this->addSql('DROP TABLE product_type');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE weborder');
        $this->addSql('DROP TABLE weborder_item');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
