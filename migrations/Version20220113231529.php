<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220113231529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comics (id INT AUTO_INCREMENT NOT NULL, licence_id INT DEFAULT NULL, editor_id INT DEFAULT NULL, writer_id INT DEFAULT NULL, designer_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, year DATE NOT NULL, INDEX IDX_2D56FB5826EF07C9 (licence_id), INDEX IDX_2D56FB586995AC4C (editor_id), INDEX IDX_2D56FB581BC7E6B6 (writer_id), INDEX IDX_2D56FB58CFC54FAB (designer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE designer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE editor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, comics_id INT DEFAULT NULL, src VARCHAR(255) NOT NULL, alt VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_C53D045F71AE76A2 (comics_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE licence (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, media VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE writer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comics ADD CONSTRAINT FK_2D56FB5826EF07C9 FOREIGN KEY (licence_id) REFERENCES licence (id)');
        $this->addSql('ALTER TABLE comics ADD CONSTRAINT FK_2D56FB586995AC4C FOREIGN KEY (editor_id) REFERENCES editor (id)');
        $this->addSql('ALTER TABLE comics ADD CONSTRAINT FK_2D56FB581BC7E6B6 FOREIGN KEY (writer_id) REFERENCES writer (id)');
        $this->addSql('ALTER TABLE comics ADD CONSTRAINT FK_2D56FB58CFC54FAB FOREIGN KEY (designer_id) REFERENCES designer (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F71AE76A2 FOREIGN KEY (comics_id) REFERENCES comics (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F71AE76A2');
        $this->addSql('ALTER TABLE comics DROP FOREIGN KEY FK_2D56FB58CFC54FAB');
        $this->addSql('ALTER TABLE comics DROP FOREIGN KEY FK_2D56FB586995AC4C');
        $this->addSql('ALTER TABLE comics DROP FOREIGN KEY FK_2D56FB5826EF07C9');
        $this->addSql('ALTER TABLE comics DROP FOREIGN KEY FK_2D56FB581BC7E6B6');
        $this->addSql('DROP TABLE comics');
        $this->addSql('DROP TABLE designer');
        $this->addSql('DROP TABLE editor');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE licence');
        $this->addSql('DROP TABLE writer');
    }
}
