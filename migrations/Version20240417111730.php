<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240417111730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE interest_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE interest_group_contact (interest_group_id INT NOT NULL, contact_id INT NOT NULL, INDEX IDX_A5ACF6EA82874C87 (interest_group_id), INDEX IDX_A5ACF6EAE7A1254A (contact_id), PRIMARY KEY(interest_group_id, contact_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE interest_group_contact ADD CONSTRAINT FK_A5ACF6EA82874C87 FOREIGN KEY (interest_group_id) REFERENCES interest_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interest_group_contact ADD CONSTRAINT FK_A5ACF6EAE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE interest_group_contact DROP FOREIGN KEY FK_A5ACF6EA82874C87');
        $this->addSql('ALTER TABLE interest_group_contact DROP FOREIGN KEY FK_A5ACF6EAE7A1254A');
        $this->addSql('DROP TABLE interest_group');
        $this->addSql('DROP TABLE interest_group_contact');
    }
}
