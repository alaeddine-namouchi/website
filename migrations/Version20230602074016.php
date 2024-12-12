<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230602074016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact_theme (id INT AUTO_INCREMENT NOT NULL, contact_id INT NOT NULL, theme_id INT DEFAULT NULL, INDEX IDX_BA5FF707E7A1254A (contact_id), INDEX IDX_BA5FF70759027487 (theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact_theme ADD CONSTRAINT FK_BA5FF707E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
        $this->addSql('ALTER TABLE contact_theme ADD CONSTRAINT FK_BA5FF70759027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact_theme DROP FOREIGN KEY FK_BA5FF707E7A1254A');
        $this->addSql('ALTER TABLE contact_theme DROP FOREIGN KEY FK_BA5FF70759027487');
        $this->addSql('DROP TABLE contact_theme');
    }
}
