<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240726105439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `admin` (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attribution_prestation_category (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attribution_prestation_category_prestation (attribution_prestation_category_id INT NOT NULL, prestation_id INT NOT NULL, INDEX IDX_67A48F7016AF9A60 (attribution_prestation_category_id), INDEX IDX_67A48F709E45C554 (prestation_id), PRIMARY KEY(attribution_prestation_category_id, prestation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attribution_prestation_category_category (attribution_prestation_category_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_FC10521716AF9A60 (attribution_prestation_category_id), INDEX IDX_FC10521712469DE2 (category_id), PRIMARY KEY(attribution_prestation_category_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, parent_cat_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, coef_price DOUBLE PRECISION NOT NULL, INDEX IDX_64C19C1A9BE6A85 (parent_cat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, zip_code VARCHAR(5) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE civility (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, abreviation VARCHAR(5) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT NOT NULL, city_id INT NOT NULL, address VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL, INDEX IDX_81398E098BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT NOT NULL, employee_status_id INT NOT NULL, creation_date DATE NOT NULL, INDEX IDX_5D9F75A16E6768FF (employee_status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, payment_mode_id INT NOT NULL, customer_id INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_F52993986EAC8BA0 (payment_mode_id), INDEX IDX_F52993989395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_line (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, prestation_id INT NOT NULL, main_order_id INT NOT NULL, order_line_status_id INT NOT NULL, employee_id INT DEFAULT NULL, qty SMALLINT NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_9CE58EE14584665A (product_id), INDEX IDX_9CE58EE19E45C554 (prestation_id), INDEX IDX_9CE58EE154BD7C4D (main_order_id), INDEX IDX_9CE58EE1B3842B7F (order_line_status_id), INDEX IDX_9CE58EE18C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_line_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_mode (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, base_price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, coef_price DOUBLE PRECISION NOT NULL, INDEX IDX_D34A04AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `admin` ADD CONSTRAINT FK_880E0D76BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attribution_prestation_category_prestation ADD CONSTRAINT FK_67A48F7016AF9A60 FOREIGN KEY (attribution_prestation_category_id) REFERENCES attribution_prestation_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attribution_prestation_category_prestation ADD CONSTRAINT FK_67A48F709E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attribution_prestation_category_category ADD CONSTRAINT FK_FC10521716AF9A60 FOREIGN KEY (attribution_prestation_category_id) REFERENCES attribution_prestation_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attribution_prestation_category_category ADD CONSTRAINT FK_FC10521712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1A9BE6A85 FOREIGN KEY (parent_cat_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E098BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A16E6768FF FOREIGN KEY (employee_status_id) REFERENCES employee_status (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993986EAC8BA0 FOREIGN KEY (payment_mode_id) REFERENCES payment_mode (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE14584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE19E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE154BD7C4D FOREIGN KEY (main_order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE1B3842B7F FOREIGN KEY (order_line_status_id) REFERENCES order_line_status (id)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE18C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE user ADD civility_id INT NOT NULL, ADD lastname VARCHAR(255) NOT NULL, ADD firstname VARCHAR(255) NOT NULL, ADD phone VARCHAR(10) NOT NULL, ADD discr VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64923D6A298 FOREIGN KEY (civility_id) REFERENCES civility (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64923D6A298 ON user (civility_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64923D6A298');
        $this->addSql('ALTER TABLE `admin` DROP FOREIGN KEY FK_880E0D76BF396750');
        $this->addSql('ALTER TABLE attribution_prestation_category_prestation DROP FOREIGN KEY FK_67A48F7016AF9A60');
        $this->addSql('ALTER TABLE attribution_prestation_category_prestation DROP FOREIGN KEY FK_67A48F709E45C554');
        $this->addSql('ALTER TABLE attribution_prestation_category_category DROP FOREIGN KEY FK_FC10521716AF9A60');
        $this->addSql('ALTER TABLE attribution_prestation_category_category DROP FOREIGN KEY FK_FC10521712469DE2');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1A9BE6A85');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E098BAC62AF');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09BF396750');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A16E6768FF');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1BF396750');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993986EAC8BA0');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993989395C3F3');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE14584665A');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE19E45C554');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE154BD7C4D');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE1B3842B7F');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE18C03F15C');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('DROP TABLE `admin`');
        $this->addSql('DROP TABLE attribution_prestation_category');
        $this->addSql('DROP TABLE attribution_prestation_category_prestation');
        $this->addSql('DROP TABLE attribution_prestation_category_category');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE civility');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE employee_status');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_line');
        $this->addSql('DROP TABLE order_line_status');
        $this->addSql('DROP TABLE payment_mode');
        $this->addSql('DROP TABLE prestation');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP INDEX IDX_8D93D64923D6A298 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP civility_id, DROP lastname, DROP firstname, DROP phone, DROP discr');
    }
}
