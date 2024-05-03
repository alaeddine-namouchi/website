<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230525083523 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profile_scope (id INT AUTO_INCREMENT NOT NULL, profile_id INT DEFAULT NULL, scope_id INT DEFAULT NULL, INDEX IDX_F77BCA01CCFA12B8 (profile_id), INDEX IDX_F77BCA01682B5931 (scope_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE profile_scope ADD CONSTRAINT FK_F77BCA01CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE profile_scope ADD CONSTRAINT FK_F77BCA01682B5931 FOREIGN KEY (scope_id) REFERENCES scope (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile_scope DROP FOREIGN KEY FK_F77BCA01CCFA12B8');
        $this->addSql('ALTER TABLE profile_scope DROP FOREIGN KEY FK_F77BCA01682B5931');
        $this->addSql('DROP TABLE profile_scope');
    }
}
