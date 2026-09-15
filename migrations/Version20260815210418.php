<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260815210418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_location ADD slug VARCHAR(255) NOT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1872601B989D9B62 ON event_location (slug)');
        $this->addSql('ALTER TABLE live_event ADD slug VARCHAR(255) NOT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6B7407BA989D9B62 ON live_event (slug)');
        $this->addSql('ALTER TABLE support_act ADD slug VARCHAR(255) NOT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B4517CEC989D9B62 ON support_act (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_1872601B989D9B62 ON event_location');
        $this->addSql('ALTER TABLE event_location DROP slug, DROP created_at, DROP updated_at');
        $this->addSql('DROP INDEX UNIQ_6B7407BA989D9B62 ON live_event');
        $this->addSql('ALTER TABLE live_event DROP slug, DROP created_at, DROP updated_at');
        $this->addSql('DROP INDEX UNIQ_B4517CEC989D9B62 ON support_act');
        $this->addSql('ALTER TABLE support_act DROP slug, DROP created_at, DROP updated_at');
    }
}
