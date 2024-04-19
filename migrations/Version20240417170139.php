<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240417170139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE "like_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "like" (id INT NOT NULL, author_id INT NOT NULL, post_id INT NOT NULL, comment_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AC6340B3F675F31B ON "like" (author_id)');
        $this->addSql('CREATE INDEX IDX_AC6340B34B89032C ON "like" (post_id)');
        $this->addSql('CREATE INDEX IDX_AC6340B3F8697D13 ON "like" (comment_id)');
        $this->addSql('ALTER TABLE "like" ADD CONSTRAINT FK_AC6340B3F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "like" ADD CONSTRAINT FK_AC6340B34B89032C FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "like" ADD CONSTRAINT FK_AC6340B3F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE "like_id_seq" CASCADE');
        $this->addSql('ALTER TABLE "like" DROP CONSTRAINT FK_AC6340B3F675F31B');
        $this->addSql('ALTER TABLE "like" DROP CONSTRAINT FK_AC6340B34B89032C');
        $this->addSql('ALTER TABLE "like" DROP CONSTRAINT FK_AC6340B3F8697D13');
        $this->addSql('DROP TABLE "like"');
    }
}
