<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240601105829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE app_lecturer (id BIGINT AUTO_INCREMENT NOT NULL, firstName VARCHAR(256) NOT NULL, lastName VARCHAR(256) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_training (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(512) NOT NULL, lecturerId BIGINT NOT NULL, UNIQUE INDEX UNIQ_DD92EA225E237E06 (name), INDEX IDX_DD92EA2290F2DEDC (lecturerId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_training_term (id BIGINT AUTO_INCREMENT NOT NULL, training_id BIGINT NOT NULL, dateAndTime DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', price NUMERIC(12, 2) NOT NULL, INDEX IDX_30E89D62BEFD98D1 (training_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app_training ADD CONSTRAINT FK_DD92EA2290F2DEDC FOREIGN KEY (lecturerId) REFERENCES app_lecturer (id)');
        $this->addSql('ALTER TABLE app_training_term ADD CONSTRAINT FK_30E89D62BEFD98D1 FOREIGN KEY (training_id) REFERENCES app_training (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app_training DROP FOREIGN KEY FK_DD92EA2290F2DEDC');
        $this->addSql('ALTER TABLE app_training_term DROP FOREIGN KEY FK_30E89D62BEFD98D1');
        $this->addSql('DROP TABLE app_lecturer');
        $this->addSql('DROP TABLE app_training');
        $this->addSql('DROP TABLE app_training_term');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
