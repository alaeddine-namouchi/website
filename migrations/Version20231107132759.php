<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231107132759 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('CREATE TABLE response (id INT AUTO_INCREMENT NOT NULL, contact_id INT DEFAULT NULL, user_id INT DEFAULT NULL, object VARCHAR(255) DEFAULT NULL, response LONGTEXT NOT NULL, submited TINYINT(1) NOT NULL, INDEX IDX_3E7B0BFBE7A1254A (contact_id), INDEX IDX_3E7B0BFBA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFBE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
        // $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFBA76ED395 FOREIGN KEY (user_id) REFERENCES admin (id)');
        // $this->addSql('ALTER TABLE action CHANGE alias alias VARCHAR(20) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_3E7B0BFBE7A1254A');
        // $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_3E7B0BFBA76ED395');
        // $this->addSql('DROP TABLE response');
        // $this->addSql('ALTER TABLE action CHANGE alias alias VARCHAR(50) NOT NULL');
    }
}
