<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220113080424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610CA85D888');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610CA85D888 FOREIGN KEY (security_user_id) REFERENCES security_user (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610CA85D888');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610CA85D888 FOREIGN KEY (security_user_id) REFERENCES security_user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
