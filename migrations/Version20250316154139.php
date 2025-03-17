<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250316154139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE workspace_membership (id INT AUTO_INCREMENT NOT NULL, workspace_id INT DEFAULT NULL, member_id INT DEFAULT NULL, INDEX IDX_6F485B8A82D40A1F (workspace_id), INDEX IDX_6F485B8A7597D3FE (member_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE workspace_membership ADD CONSTRAINT FK_6F485B8A82D40A1F FOREIGN KEY (workspace_id) REFERENCES workspace (id)');
        $this->addSql('ALTER TABLE workspace_membership ADD CONSTRAINT FK_6F485B8A7597D3FE FOREIGN KEY (member_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE user ADD member_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497597D3FE FOREIGN KEY (member_id) REFERENCES member (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6497597D3FE ON user (member_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE workspace_membership DROP FOREIGN KEY FK_6F485B8A82D40A1F');
        $this->addSql('ALTER TABLE workspace_membership DROP FOREIGN KEY FK_6F485B8A7597D3FE');
        $this->addSql('DROP TABLE workspace_membership');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497597D3FE');
        $this->addSql('DROP INDEX IDX_8D93D6497597D3FE ON user');
        $this->addSql('ALTER TABLE user DROP member_id');
    }
}
