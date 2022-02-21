<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220221133039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, avatar LONGBLOB DEFAULT NULL, creation_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_880E0D76E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agent (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, admin_id INT DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, avatar LONGBLOB DEFAULT NULL, last_update DATETIME DEFAULT NULL, INDEX IDX_268B9C9DF92F3E70 (country_id), INDEX IDX_268B9C9D642B8210 (admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agent_skills (agent_id INT NOT NULL, skills_id INT NOT NULL, INDEX IDX_8BD641563414710B (agent_id), INDEX IDX_8BD641567FF61858 (skills_id), PRIMARY KEY(agent_id, skills_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agent_mission (agent_id INT NOT NULL, mission_id INT NOT NULL, INDEX IDX_423490963414710B (agent_id), INDEX IDX_42349096BE6CAE90 (mission_id), PRIMARY KEY(agent_id, mission_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, admin_id INT DEFAULT NULL, fisrtname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, code_name VARCHAR(255) NOT NULL, last_update DATETIME DEFAULT NULL, INDEX IDX_4C62E638F92F3E70 (country_id), INDEX IDX_4C62E638642B8210 (admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, flag LONGBLOB DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hiding_place (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, admin_id INT DEFAULT NULL, address VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, last_update DATETIME DEFAULT NULL, INDEX IDX_924939C1F92F3E70 (country_id), INDEX IDX_924939C1642B8210 (admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, admin_id INT DEFAULT NULL, skills_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, code_name VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, beginning_date DATE NOT NULL, ending_date DATE NOT NULL, last_update DATETIME DEFAULT NULL, INDEX IDX_9067F23CF92F3E70 (country_id), INDEX IDX_9067F23C642B8210 (admin_id), INDEX IDX_9067F23C7FF61858 (skills_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission_contact (mission_id INT NOT NULL, contact_id INT NOT NULL, INDEX IDX_DD5E7275BE6CAE90 (mission_id), INDEX IDX_DD5E7275E7A1254A (contact_id), PRIMARY KEY(mission_id, contact_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission_hidingplace (mission_id INT NOT NULL, hidingplace_id INT NOT NULL, INDEX IDX_79916478BE6CAE90 (mission_id), INDEX IDX_79916478783C627A (hidingplace_id), PRIMARY KEY(mission_id, hidingplace_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skills (id INT AUTO_INCREMENT NOT NULL, admin_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, last_update DATETIME DEFAULT NULL, INDEX IDX_D5311670642B8210 (admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE target (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, admin_id INT DEFAULT NULL, mission_id INT NOT NULL, fisrtname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, code_name VARCHAR(255) NOT NULL, last_update DATETIME DEFAULT NULL, INDEX IDX_466F2FFCF92F3E70 (country_id), INDEX IDX_466F2FFC642B8210 (admin_id), INDEX IDX_466F2FFCBE6CAE90 (mission_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE agent_skills ADD CONSTRAINT FK_8BD641563414710B FOREIGN KEY (agent_id) REFERENCES agent (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agent_skills ADD CONSTRAINT FK_8BD641567FF61858 FOREIGN KEY (skills_id) REFERENCES skills (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agent_mission ADD CONSTRAINT FK_423490963414710B FOREIGN KEY (agent_id) REFERENCES agent (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agent_mission ADD CONSTRAINT FK_42349096BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE hiding_place ADD CONSTRAINT FK_924939C1F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE hiding_place ADD CONSTRAINT FK_924939C1642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C7FF61858 FOREIGN KEY (skills_id) REFERENCES skills (id)');
        $this->addSql('ALTER TABLE mission_contact ADD CONSTRAINT FK_DD5E7275BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission_contact ADD CONSTRAINT FK_DD5E7275E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission_hidingplace ADD CONSTRAINT FK_79916478BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission_hidingplace ADD CONSTRAINT FK_79916478783C627A FOREIGN KEY (hidingplace_id) REFERENCES hiding_place (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skills ADD CONSTRAINT FK_D5311670642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFCF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFC642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFCBE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9D642B8210');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638642B8210');
        $this->addSql('ALTER TABLE hiding_place DROP FOREIGN KEY FK_924939C1642B8210');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C642B8210');
        $this->addSql('ALTER TABLE skills DROP FOREIGN KEY FK_D5311670642B8210');
        $this->addSql('ALTER TABLE target DROP FOREIGN KEY FK_466F2FFC642B8210');
        $this->addSql('ALTER TABLE agent_skills DROP FOREIGN KEY FK_8BD641563414710B');
        $this->addSql('ALTER TABLE agent_mission DROP FOREIGN KEY FK_423490963414710B');
        $this->addSql('ALTER TABLE mission_contact DROP FOREIGN KEY FK_DD5E7275E7A1254A');
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9DF92F3E70');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638F92F3E70');
        $this->addSql('ALTER TABLE hiding_place DROP FOREIGN KEY FK_924939C1F92F3E70');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CF92F3E70');
        $this->addSql('ALTER TABLE target DROP FOREIGN KEY FK_466F2FFCF92F3E70');
        $this->addSql('ALTER TABLE mission_hidingplace DROP FOREIGN KEY FK_79916478783C627A');
        $this->addSql('ALTER TABLE agent_mission DROP FOREIGN KEY FK_42349096BE6CAE90');
        $this->addSql('ALTER TABLE mission_contact DROP FOREIGN KEY FK_DD5E7275BE6CAE90');
        $this->addSql('ALTER TABLE mission_hidingplace DROP FOREIGN KEY FK_79916478BE6CAE90');
        $this->addSql('ALTER TABLE target DROP FOREIGN KEY FK_466F2FFCBE6CAE90');
        $this->addSql('ALTER TABLE agent_skills DROP FOREIGN KEY FK_8BD641567FF61858');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C7FF61858');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE agent');
        $this->addSql('DROP TABLE agent_skills');
        $this->addSql('DROP TABLE agent_mission');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE hiding_place');
        $this->addSql('DROP TABLE mission');
        $this->addSql('DROP TABLE mission_contact');
        $this->addSql('DROP TABLE mission_hidingplace');
        $this->addSql('DROP TABLE skills');
        $this->addSql('DROP TABLE target');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
