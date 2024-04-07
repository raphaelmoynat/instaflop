<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240406162625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image ADD comment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD avatar_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F86383B10 FOREIGN KEY (avatar_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C53D045FF8697D13 ON image (comment_id)');
        $this->addSql('CREATE INDEX IDX_C53D045F86383B10 ON image (avatar_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE image DROP CONSTRAINT FK_C53D045FF8697D13');
        $this->addSql('ALTER TABLE image DROP CONSTRAINT FK_C53D045F86383B10');
        $this->addSql('DROP INDEX IDX_C53D045FF8697D13');
        $this->addSql('DROP INDEX IDX_C53D045F86383B10');
        $this->addSql('ALTER TABLE image DROP comment_id');
        $this->addSql('ALTER TABLE image DROP avatar_id');
    }
}
