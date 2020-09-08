<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200907233238 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, district_zip INT NOT NULL, age INT NOT NULL, people_count INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE policy (id INT AUTO_INCREMENT NOT NULL, price NUMERIC(8, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE policy_customer (policy_id INT NOT NULL, customer_id INT NOT NULL, INDEX IDX_A0EE56042D29E3C6 (policy_id), INDEX IDX_A0EE56049395C3F3 (customer_id), PRIMARY KEY(policy_id, customer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE policy_customer ADD CONSTRAINT FK_A0EE56042D29E3C6 FOREIGN KEY (policy_id) REFERENCES policy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE policy_customer ADD CONSTRAINT FK_A0EE56049395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE policy_customer DROP FOREIGN KEY FK_A0EE56049395C3F3');
        $this->addSql('ALTER TABLE policy_customer DROP FOREIGN KEY FK_A0EE56042D29E3C6');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE policy');
        $this->addSql('DROP TABLE policy_customer');
    }
}
