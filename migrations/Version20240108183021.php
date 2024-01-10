<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240108183021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'ulanish';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ADD cetegory_id INT NOT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3311BAD3D98 FOREIGN KEY (cetegory_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A3311BAD3D98 ON book (cetegory_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3311BAD3D98');
        $this->addSql('DROP INDEX IDX_CBE5A3311BAD3D98 ON book');
        $this->addSql('ALTER TABLE book DROP cetegory_id');
    }
}
