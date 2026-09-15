<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260829161525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE live_event_comment (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, user_id INT DEFAULT NULL, live_event_id INT DEFAULT NULL, INDEX IDX_1CFC4E7BA76ED395 (user_id), INDEX IDX_1CFC4E7BB6A19D7F (live_event_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE live_event_comment ADD CONSTRAINT FK_1CFC4E7BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE live_event_comment ADD CONSTRAINT FK_1CFC4E7BB6A19D7F FOREIGN KEY (live_event_id) REFERENCES live_event (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE live_event_comment DROP FOREIGN KEY FK_1CFC4E7BA76ED395');
        $this->addSql('ALTER TABLE live_event_comment DROP FOREIGN KEY FK_1CFC4E7BB6A19D7F');
        $this->addSql('DROP TABLE live_event_comment');
    }
}
