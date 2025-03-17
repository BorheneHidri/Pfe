<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250305150113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA7882D40A1F');
        $this->addSql('DROP INDEX IDX_70E4FA7882D40A1F ON member');
        $this->addSql('ALTER TABLE member ADD name VARCHAR(255) NOT NULL, DROP workspace_id, CHANGE avatar avatar VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE member ADD workspace_id INT NOT NULL, DROP name, CHANGE avatar avatar VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA7882D40A1F FOREIGN KEY (workspace_id) REFERENCES workspace (id)');
        $this->addSql('CREATE INDEX IDX_70E4FA7882D40A1F ON member (workspace_id)');
    }
}
