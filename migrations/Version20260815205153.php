<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260815205153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event_location (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_active TINYINT NOT NULL, street VARCHAR(255) DEFAULT NULL, zip_code INT DEFAULT NULL, city LONGTEXT DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, website_url VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, latitude VARCHAR(255) DEFAULT NULL, longitude VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE live_event (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, short_description VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, starts_at DATETIME NOT NULL, doors_open_at DATETIME NOT NULL, ends_at DATETIME DEFAULT NULL, has_tickets TINYINT NOT NULL, is_free_entry TINYINT NOT NULL, price_presale INT DEFAULT NULL, price_door INT DEFAULT NULL, is_sold_out TINYINT NOT NULL, is_canceled TINYINT NOT NULL, age_limit INT NOT NULL, is_age_restricted TINYINT NOT NULL, location_id INT DEFAULT NULL, INDEX IDX_6B7407BA64D218E (location_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE live_event_support_act (live_event_id INT NOT NULL, support_act_id INT NOT NULL, INDEX IDX_7C9A508FB6A19D7F (live_event_id), INDEX IDX_7C9A508F595FBBD8 (support_act_id), PRIMARY KEY (live_event_id, support_act_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE support_act (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, website_url VARCHAR(255) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, youtube VARCHAR(255) DEFAULT NULL, bandcamp VARCHAR(255) DEFAULT NULL, spotify VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE live_event ADD CONSTRAINT FK_6B7407BA64D218E FOREIGN KEY (location_id) REFERENCES event_location (id)');
        $this->addSql('ALTER TABLE live_event_support_act ADD CONSTRAINT FK_7C9A508FB6A19D7F FOREIGN KEY (live_event_id) REFERENCES live_event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE live_event_support_act ADD CONSTRAINT FK_7C9A508F595FBBD8 FOREIGN KEY (support_act_id) REFERENCES support_act (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE live_event DROP FOREIGN KEY FK_6B7407BA64D218E');
        $this->addSql('ALTER TABLE live_event_support_act DROP FOREIGN KEY FK_7C9A508FB6A19D7F');
        $this->addSql('ALTER TABLE live_event_support_act DROP FOREIGN KEY FK_7C9A508F595FBBD8');
        $this->addSql('DROP TABLE event_location');
        $this->addSql('DROP TABLE live_event');
        $this->addSql('DROP TABLE live_event_support_act');
        $this->addSql('DROP TABLE support_act');
    }
}
