<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240415172233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8D72A1C5CA');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D72A1C5CA FOREIGN KEY (retweet_id) REFERENCES post (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT fk_5a8a6c8d72a1c5ca');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT fk_5a8a6c8d72a1c5ca FOREIGN KEY (retweet_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
