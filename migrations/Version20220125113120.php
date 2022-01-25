<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220125113120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lexicon (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_4313ACFA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE word (id INT AUTO_INCREMENT NOT NULL, lexicon_id INT NOT NULL, name VARCHAR(255) NOT NULL, definition LONGTEXT DEFAULT NULL, img VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_C3F1751188C5CA0A (lexicon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lexicon ADD CONSTRAINT FK_4313ACFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE word ADD CONSTRAINT FK_C3F1751188C5CA0A FOREIGN KEY (lexicon_id) REFERENCES lexicon (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE word DROP FOREIGN KEY FK_C3F1751188C5CA0A');
        $this->addSql('ALTER TABLE lexicon DROP FOREIGN KEY FK_4313ACFA76ED395');
        $this->addSql('DROP TABLE lexicon');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE word');
    }
}
