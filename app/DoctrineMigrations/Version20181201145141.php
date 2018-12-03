<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181201145141 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cars (id INT AUTO_INCREMENT NOT NULL, make VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, TravelledDistance BIGINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parts_cars (car_id INT NOT NULL, part_id INT NOT NULL, INDEX IDX_2BFFFFA1C3C6F69F (car_id), INDEX IDX_2BFFFFA14CE34BEC (part_id), PRIMARY KEY(car_id, part_id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customers (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, BirthDate DATE NOT NULL, isYoungDriver TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parts (id INT AUTO_INCREMENT NOT NULL, supplier_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, quantity INT NOT NULL, INDEX IDX_6940A7FE2ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sales (id INT AUTO_INCREMENT NOT NULL, car_id INT DEFAULT NULL, customer_id INT DEFAULT NULL, Discount DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_6B817044C3C6F69F (car_id), INDEX IDX_6B8170449395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suppliers (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, isImporter TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parts_cars ADD CONSTRAINT FK_2BFFFFA1C3C6F69F FOREIGN KEY (car_id) REFERENCES cars (id)');
        $this->addSql('ALTER TABLE parts_cars ADD CONSTRAINT FK_2BFFFFA14CE34BEC FOREIGN KEY (part_id) REFERENCES parts (id)');
        $this->addSql('ALTER TABLE parts ADD CONSTRAINT FK_6940A7FE2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES suppliers (id)');
        $this->addSql('ALTER TABLE sales ADD CONSTRAINT FK_6B817044C3C6F69F FOREIGN KEY (car_id) REFERENCES cars (id)');
        $this->addSql('ALTER TABLE sales ADD CONSTRAINT FK_6B8170449395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE parts_cars DROP FOREIGN KEY FK_2BFFFFA1C3C6F69F');
        $this->addSql('ALTER TABLE sales DROP FOREIGN KEY FK_6B817044C3C6F69F');
        $this->addSql('ALTER TABLE sales DROP FOREIGN KEY FK_6B8170449395C3F3');
        $this->addSql('ALTER TABLE parts_cars DROP FOREIGN KEY FK_2BFFFFA14CE34BEC');
        $this->addSql('ALTER TABLE parts DROP FOREIGN KEY FK_6940A7FE2ADD6D8C');
        $this->addSql('DROP TABLE cars');
        $this->addSql('DROP TABLE parts_cars');
        $this->addSql('DROP TABLE customers');
        $this->addSql('DROP TABLE parts');
        $this->addSql('DROP TABLE sales');
        $this->addSql('DROP TABLE suppliers');
    }
}
