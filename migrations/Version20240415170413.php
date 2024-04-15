<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240415170413 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE retweet_id_seq CASCADE');
        $this->addSql('ALTER TABLE retweet DROP CONSTRAINT fk_45e67db34b89032c');
        $this->addSql('DROP TABLE retweet');
        $this->addSql('ALTER TABLE post DROP retweet_content');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE retweet_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE retweet (id INT NOT NULL, post_id INT NOT NULL, content TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_45e67db34b89032c ON retweet (post_id)');
        $this->addSql('ALTER TABLE retweet ADD CONSTRAINT fk_45e67db34b89032c FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post ADD retweet_content TEXT DEFAULT NULL');
    }
}
