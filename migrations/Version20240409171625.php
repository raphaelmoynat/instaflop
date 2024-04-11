<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240409171625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reply_comment ADD post_id INT NOT NULL');
        $this->addSql('ALTER TABLE reply_comment ADD CONSTRAINT FK_89CA3BAE4B89032C FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_89CA3BAE4B89032C ON reply_comment (post_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE reply_comment DROP CONSTRAINT FK_89CA3BAE4B89032C');
        $this->addSql('DROP INDEX IDX_89CA3BAE4B89032C');
        $this->addSql('ALTER TABLE reply_comment DROP post_id');
    }
}
