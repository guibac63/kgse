<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220306203641 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE admin_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE agent_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE contact_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE country_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE hiding_place_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE mission_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE skills_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE target_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE admin (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, creation_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D76E7927C74 ON admin (email)');
        $this->addSql('CREATE TABLE agent (id INT NOT NULL, country_id INT NOT NULL, admin_id INT DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, avatar VARCHAR(255) DEFAULT NULL, last_update TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_268B9C9DF92F3E70 ON agent (country_id)');
        $this->addSql('CREATE INDEX IDX_268B9C9D642B8210 ON agent (admin_id)');
        $this->addSql('CREATE TABLE agent_skills (agent_id INT NOT NULL, skills_id INT NOT NULL, PRIMARY KEY(agent_id, skills_id))');
        $this->addSql('CREATE INDEX IDX_8BD641563414710B ON agent_skills (agent_id)');
        $this->addSql('CREATE INDEX IDX_8BD641567FF61858 ON agent_skills (skills_id)');
        $this->addSql('CREATE TABLE contact (id INT NOT NULL, country_id INT NOT NULL, admin_id INT DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, code_name VARCHAR(255) NOT NULL, last_update TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4C62E638F92F3E70 ON contact (country_id)');
        $this->addSql('CREATE INDEX IDX_4C62E638642B8210 ON contact (admin_id)');
        $this->addSql('CREATE TABLE country (id INT NOT NULL, name VARCHAR(255) NOT NULL, flag VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE hiding_place (id INT NOT NULL, country_id INT NOT NULL, admin_id INT DEFAULT NULL, address VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, last_update TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_924939C1F92F3E70 ON hiding_place (country_id)');
        $this->addSql('CREATE INDEX IDX_924939C1642B8210 ON hiding_place (admin_id)');
        $this->addSql('CREATE TABLE mission (id INT NOT NULL, country_id INT NOT NULL, admin_id INT DEFAULT NULL, skills_id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, code_name VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, beginning_date DATE NOT NULL, ending_date DATE NOT NULL, last_update TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9067F23CF92F3E70 ON mission (country_id)');
        $this->addSql('CREATE INDEX IDX_9067F23C642B8210 ON mission (admin_id)');
        $this->addSql('CREATE INDEX IDX_9067F23C7FF61858 ON mission (skills_id)');
        $this->addSql('CREATE TABLE mission_contact (mission_id INT NOT NULL, contact_id INT NOT NULL, PRIMARY KEY(mission_id, contact_id))');
        $this->addSql('CREATE INDEX IDX_DD5E7275BE6CAE90 ON mission_contact (mission_id)');
        $this->addSql('CREATE INDEX IDX_DD5E7275E7A1254A ON mission_contact (contact_id)');
        $this->addSql('CREATE TABLE mission_hiding_place (mission_id INT NOT NULL, hiding_place_id INT NOT NULL, PRIMARY KEY(mission_id, hiding_place_id))');
        $this->addSql('CREATE INDEX IDX_45237465BE6CAE90 ON mission_hiding_place (mission_id)');
        $this->addSql('CREATE INDEX IDX_45237465F7A84D5B ON mission_hiding_place (hiding_place_id)');
        $this->addSql('CREATE TABLE mission_agent (mission_id INT NOT NULL, agent_id INT NOT NULL, PRIMARY KEY(mission_id, agent_id))');
        $this->addSql('CREATE INDEX IDX_B61DC3A0BE6CAE90 ON mission_agent (mission_id)');
        $this->addSql('CREATE INDEX IDX_B61DC3A03414710B ON mission_agent (agent_id)');
        $this->addSql('CREATE TABLE mission_target (mission_id INT NOT NULL, target_id INT NOT NULL, PRIMARY KEY(mission_id, target_id))');
        $this->addSql('CREATE INDEX IDX_1E97F5B2BE6CAE90 ON mission_target (mission_id)');
        $this->addSql('CREATE INDEX IDX_1E97F5B2158E0B66 ON mission_target (target_id)');
        $this->addSql('CREATE TABLE skills (id INT NOT NULL, admin_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, last_update TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D5311670642B8210 ON skills (admin_id)');
        $this->addSql('CREATE TABLE target (id INT NOT NULL, country_id INT NOT NULL, admin_id INT DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, code_name VARCHAR(255) NOT NULL, last_update TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_466F2FFCF92F3E70 ON target (country_id)');
        $this->addSql('CREATE INDEX IDX_466F2FFC642B8210 ON target (admin_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE agent_skills ADD CONSTRAINT FK_8BD641563414710B FOREIGN KEY (agent_id) REFERENCES agent (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE agent_skills ADD CONSTRAINT FK_8BD641567FF61858 FOREIGN KEY (skills_id) REFERENCES skills (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hiding_place ADD CONSTRAINT FK_924939C1F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hiding_place ADD CONSTRAINT FK_924939C1642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C7FF61858 FOREIGN KEY (skills_id) REFERENCES skills (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mission_contact ADD CONSTRAINT FK_DD5E7275BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mission_contact ADD CONSTRAINT FK_DD5E7275E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mission_hiding_place ADD CONSTRAINT FK_45237465BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mission_hiding_place ADD CONSTRAINT FK_45237465F7A84D5B FOREIGN KEY (hiding_place_id) REFERENCES hiding_place (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mission_agent ADD CONSTRAINT FK_B61DC3A0BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mission_agent ADD CONSTRAINT FK_B61DC3A03414710B FOREIGN KEY (agent_id) REFERENCES agent (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mission_target ADD CONSTRAINT FK_1E97F5B2BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mission_target ADD CONSTRAINT FK_1E97F5B2158E0B66 FOREIGN KEY (target_id) REFERENCES target (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skills ADD CONSTRAINT FK_D5311670642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFCF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFC642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE agent DROP CONSTRAINT FK_268B9C9D642B8210');
        $this->addSql('ALTER TABLE contact DROP CONSTRAINT FK_4C62E638642B8210');
        $this->addSql('ALTER TABLE hiding_place DROP CONSTRAINT FK_924939C1642B8210');
        $this->addSql('ALTER TABLE mission DROP CONSTRAINT FK_9067F23C642B8210');
        $this->addSql('ALTER TABLE skills DROP CONSTRAINT FK_D5311670642B8210');
        $this->addSql('ALTER TABLE target DROP CONSTRAINT FK_466F2FFC642B8210');
        $this->addSql('ALTER TABLE agent_skills DROP CONSTRAINT FK_8BD641563414710B');
        $this->addSql('ALTER TABLE mission_agent DROP CONSTRAINT FK_B61DC3A03414710B');
        $this->addSql('ALTER TABLE mission_contact DROP CONSTRAINT FK_DD5E7275E7A1254A');
        $this->addSql('ALTER TABLE agent DROP CONSTRAINT FK_268B9C9DF92F3E70');
        $this->addSql('ALTER TABLE contact DROP CONSTRAINT FK_4C62E638F92F3E70');
        $this->addSql('ALTER TABLE hiding_place DROP CONSTRAINT FK_924939C1F92F3E70');
        $this->addSql('ALTER TABLE mission DROP CONSTRAINT FK_9067F23CF92F3E70');
        $this->addSql('ALTER TABLE target DROP CONSTRAINT FK_466F2FFCF92F3E70');
        $this->addSql('ALTER TABLE mission_hiding_place DROP CONSTRAINT FK_45237465F7A84D5B');
        $this->addSql('ALTER TABLE mission_contact DROP CONSTRAINT FK_DD5E7275BE6CAE90');
        $this->addSql('ALTER TABLE mission_hiding_place DROP CONSTRAINT FK_45237465BE6CAE90');
        $this->addSql('ALTER TABLE mission_agent DROP CONSTRAINT FK_B61DC3A0BE6CAE90');
        $this->addSql('ALTER TABLE mission_target DROP CONSTRAINT FK_1E97F5B2BE6CAE90');
        $this->addSql('ALTER TABLE agent_skills DROP CONSTRAINT FK_8BD641567FF61858');
        $this->addSql('ALTER TABLE mission DROP CONSTRAINT FK_9067F23C7FF61858');
        $this->addSql('ALTER TABLE mission_target DROP CONSTRAINT FK_1E97F5B2158E0B66');
        $this->addSql('DROP SEQUENCE admin_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE agent_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE contact_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE country_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE hiding_place_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE mission_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE skills_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE target_id_seq CASCADE');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE agent');
        $this->addSql('DROP TABLE agent_skills');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE hiding_place');
        $this->addSql('DROP TABLE mission');
        $this->addSql('DROP TABLE mission_contact');
        $this->addSql('DROP TABLE mission_hiding_place');
        $this->addSql('DROP TABLE mission_agent');
        $this->addSql('DROP TABLE mission_target');
        $this->addSql('DROP TABLE skills');
        $this->addSql('DROP TABLE target');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
