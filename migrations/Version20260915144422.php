<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260915144422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event_picture (id INT AUTO_INCREMENT NOT NULL, is_published TINYINT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, live_event_id INT DEFAULT NULL, published_by_id INT DEFAULT NULL, INDEX IDX_938CE626B6A19D7F (live_event_id), INDEX IDX_938CE6265B075477 (published_by_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE event_picture ADD CONSTRAINT FK_938CE626B6A19D7F FOREIGN KEY (live_event_id) REFERENCES live_event (id)');
        $this->addSql('ALTER TABLE event_picture ADD CONSTRAINT FK_938CE6265B075477 FOREIGN KEY (published_by_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_picture DROP FOREIGN KEY FK_938CE626B6A19D7F');
        $this->addSql('ALTER TABLE event_picture DROP FOREIGN KEY FK_938CE6265B075477');
        $this->addSql('DROP TABLE event_picture');
    }
}
