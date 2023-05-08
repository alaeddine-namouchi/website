<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426101809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE action (id INT AUTO_INCREMENT NOT NULL, section_id INT DEFAULT NULL, action_type_id INT DEFAULT NULL, action_id INT DEFAULT NULL, label VARCHAR(255) NOT NULL, alias VARCHAR(20) NOT NULL, route VARCHAR(255) NOT NULL, business_name VARCHAR(255) DEFAULT NULL, INDEX IDX_47CC8C92D823E37A (section_id), INDEX IDX_47CC8C921FEE0472 (action_type_id), INDEX IDX_47CC8C929D32F035 (action_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE action_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, alias VARCHAR(20) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, profile_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', update_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', work_unit VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(100) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_880E0D76E7927C74 (email), INDEX IDX_880E0D76CCFA12B8 (profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL, num INT NOT NULL, INDEX IDX_23A0E6612469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_image (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, image_id INT DEFAULT NULL, INDEX IDX_B28A764E7294869C (article_id), INDEX IDX_B28A764E3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, alias VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, alias VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, object LONGTEXT NOT NULL, email_adress VARCHAR(120) NOT NULL, mobile_number VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content (id INT AUTO_INCREMENT NOT NULL, author_id_id INT DEFAULT NULL, language_id INT DEFAULT NULL, article_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, intro LONGTEXT DEFAULT NULL, body LONGTEXT NOT NULL, slug LONGTEXT DEFAULT NULL, tags LONGTEXT DEFAULT NULL, published_date DATE DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, published TINYINT(1) DEFAULT NULL, INDEX IDX_FEC530A969CCBE9A (author_id_id), INDEX IDX_FEC530A982F1BAF4 (language_id), INDEX IDX_FEC530A97294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, alt VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `language` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, alias VARCHAR(5) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, content_id INT DEFAULT NULL, language_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, label VARCHAR(255) NOT NULL, link LONGTEXT DEFAULT NULL, emplacement VARCHAR(255) NOT NULL, type_menu VARCHAR(255) NOT NULL, INDEX IDX_7D053A9384A0A3ED (content_id), INDEX IDX_7D053A9382F1BAF4 (language_id), INDEX IDX_7D053A93727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil_action (id INT AUTO_INCREMENT NOT NULL, profile_id INT NOT NULL, action_id INT NOT NULL, INDEX IDX_363305C0CCFA12B8 (profile_id), INDEX IDX_363305C09D32F035 (action_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, alias VARCHAR(20) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile_category (profile_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_FF267870CCFA12B8 (profile_id), INDEX IDX_FF26787012469DE2 (category_id), PRIMARY KEY(profile_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, alias VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, business_name VARCHAR(255) DEFAULT NULL, all_action TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE time_line (id INT AUTO_INCREMENT NOT NULL, language_id INT DEFAULT NULL, category_id INT DEFAULT NULL, time_line_topic_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, step_date DATE NOT NULL, description LONGTEXT NOT NULL, icon LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', published TINYINT(1) DEFAULT NULL, article VARCHAR(255) DEFAULT NULL, INDEX IDX_7CA9BDDB82F1BAF4 (language_id), INDEX IDX_7CA9BDDB12469DE2 (category_id), INDEX IDX_7CA9BDDB44E722C8 (time_line_topic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE time_line_topic (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) DEFAULT NULL, label_slug VARCHAR(255) DEFAULT NULL, path VARCHAR(255) DEFAULT NULL, intro LONGTEXT DEFAULT NULL, status TINYINT(1) DEFAULT NULL, position INT DEFAULT NULL, created_by INT DEFAULT NULL, update_by INT DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', update_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, matricule VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', phone_number VARCHAR(100) DEFAULT NULL, unit_work VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C92D823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C921FEE0472 FOREIGN KEY (action_type_id) REFERENCES action_type (id)');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C929D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6612469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE article_image ADD CONSTRAINT FK_B28A764E7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE article_image ADD CONSTRAINT FK_B28A764E3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE content ADD CONSTRAINT FK_FEC530A969CCBE9A FOREIGN KEY (author_id_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE content ADD CONSTRAINT FK_FEC530A982F1BAF4 FOREIGN KEY (language_id) REFERENCES `language` (id)');
        $this->addSql('ALTER TABLE content ADD CONSTRAINT FK_FEC530A97294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A9384A0A3ED FOREIGN KEY (content_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A9382F1BAF4 FOREIGN KEY (language_id) REFERENCES `language` (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93727ACA70 FOREIGN KEY (parent_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE profil_action ADD CONSTRAINT FK_363305C0CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE profil_action ADD CONSTRAINT FK_363305C09D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
        $this->addSql('ALTER TABLE profile_category ADD CONSTRAINT FK_FF267870CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profile_category ADD CONSTRAINT FK_FF26787012469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE time_line ADD CONSTRAINT FK_7CA9BDDB82F1BAF4 FOREIGN KEY (language_id) REFERENCES `language` (id)');
        $this->addSql('ALTER TABLE time_line ADD CONSTRAINT FK_7CA9BDDB12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE time_line ADD CONSTRAINT FK_7CA9BDDB44E722C8 FOREIGN KEY (time_line_topic_id) REFERENCES time_line_topic (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C929D32F035');
        $this->addSql('ALTER TABLE profil_action DROP FOREIGN KEY FK_363305C09D32F035');
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C921FEE0472');
        $this->addSql('ALTER TABLE content DROP FOREIGN KEY FK_FEC530A969CCBE9A');
        $this->addSql('ALTER TABLE article_image DROP FOREIGN KEY FK_B28A764E7294869C');
        $this->addSql('ALTER TABLE content DROP FOREIGN KEY FK_FEC530A97294869C');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6612469DE2');
        $this->addSql('ALTER TABLE profile_category DROP FOREIGN KEY FK_FF26787012469DE2');
        $this->addSql('ALTER TABLE time_line DROP FOREIGN KEY FK_7CA9BDDB12469DE2');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A9384A0A3ED');
        $this->addSql('ALTER TABLE article_image DROP FOREIGN KEY FK_B28A764E3DA5256D');
        $this->addSql('ALTER TABLE content DROP FOREIGN KEY FK_FEC530A982F1BAF4');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A9382F1BAF4');
        $this->addSql('ALTER TABLE time_line DROP FOREIGN KEY FK_7CA9BDDB82F1BAF4');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93727ACA70');
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D76CCFA12B8');
        $this->addSql('ALTER TABLE profil_action DROP FOREIGN KEY FK_363305C0CCFA12B8');
        $this->addSql('ALTER TABLE profile_category DROP FOREIGN KEY FK_FF267870CCFA12B8');
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C92D823E37A');
        $this->addSql('ALTER TABLE time_line DROP FOREIGN KEY FK_7CA9BDDB44E722C8');
        $this->addSql('DROP TABLE action');
        $this->addSql('DROP TABLE action_type');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_image');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE content');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE profil_action');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE profile_category');
        $this->addSql('DROP TABLE section');
        $this->addSql('DROP TABLE time_line');
        $this->addSql('DROP TABLE time_line_topic');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
