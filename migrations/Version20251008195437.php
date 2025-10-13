<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251008195437 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires ADD details_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4BB1A0722 FOREIGN KEY (details_id) REFERENCES detail (id)');
        $this->addSql('CREATE INDEX IDX_D9BEC0C4BB1A0722 ON commentaires (details_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4BB1A0722');
        $this->addSql('DROP INDEX IDX_D9BEC0C4BB1A0722 ON commentaires');
        $this->addSql('ALTER TABLE commentaires DROP details_id');
    }
}
