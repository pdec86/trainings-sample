<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240520175449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app_training_term ADD training_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE app_training_term ADD CONSTRAINT FK_4A64A3BDBEFD98D1 FOREIGN KEY (training_id) REFERENCES simpleDb.app_training (id)');
        $this->addSql('CREATE INDEX IDX_4A64A3BDBEFD98D1 ON app_training_term (training_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE simpleDb.app_training_term DROP FOREIGN KEY FK_4A64A3BDBEFD98D1');
        $this->addSql('DROP INDEX IDX_4A64A3BDBEFD98D1 ON simpleDb.app_training_term');
        $this->addSql('ALTER TABLE simpleDb.app_training_term DROP training_id');
    }
}
