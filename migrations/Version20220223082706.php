<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220223082706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mission_hiding_place (mission_id INT NOT NULL, hiding_place_id INT NOT NULL, INDEX IDX_45237465BE6CAE90 (mission_id), INDEX IDX_45237465F7A84D5B (hiding_place_id), PRIMARY KEY(mission_id, hiding_place_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mission_hiding_place ADD CONSTRAINT FK_45237465BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission_hiding_place ADD CONSTRAINT FK_45237465F7A84D5B FOREIGN KEY (hiding_place_id) REFERENCES hiding_place (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE mission_hidingplace');
        $this->addSql('ALTER TABLE contact CHANGE fisrtname firstname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE target CHANGE fisrtname firstname VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mission_hidingplace (mission_id INT NOT NULL, hidingplace_id INT NOT NULL, INDEX IDX_79916478783C627A (hidingplace_id), INDEX IDX_79916478BE6CAE90 (mission_id), PRIMARY KEY(mission_id, hidingplace_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE mission_hidingplace ADD CONSTRAINT FK_79916478BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission_hidingplace ADD CONSTRAINT FK_79916478783C627A FOREIGN KEY (hidingplace_id) REFERENCES hiding_place (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE mission_hiding_place');
        $this->addSql('ALTER TABLE contact CHANGE firstname fisrtname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE target CHANGE firstname fisrtname VARCHAR(255) NOT NULL');
    }
}
