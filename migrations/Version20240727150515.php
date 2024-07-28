<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240727150515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE answer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE question_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE questionnaire_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE questionnaire_user_answer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE answer (id INT NOT NULL, question_id INT NOT NULL, value TEXT NOT NULL, is_right BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DADD4A251E27F6BF ON answer (question_id)');
        $this->addSql('CREATE TABLE question (id INT NOT NULL, title TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE questionnaire (id INT NOT NULL, name VARCHAR(500) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE questionnaire_question (questionnaire_id INT NOT NULL, question_id INT NOT NULL, PRIMARY KEY(questionnaire_id, question_id))');
        $this->addSql('CREATE INDEX IDX_28CC40C3CE07E8FF ON questionnaire_question (questionnaire_id)');
        $this->addSql('CREATE INDEX IDX_28CC40C31E27F6BF ON questionnaire_question (question_id)');
        $this->addSql('CREATE TABLE questionnaire_user_answer (id INT NOT NULL, questionnaire_id INT NOT NULL, answer_id INT NOT NULL, user_id_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_36AB8B38CE07E8FF ON questionnaire_user_answer (questionnaire_id)');
        $this->addSql('CREATE INDEX IDX_36AB8B38AA334807 ON questionnaire_user_answer (answer_id)');
        $this->addSql('CREATE INDEX IDX_36AB8B389D86650F ON questionnaire_user_answer (user_id_id)');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE questionnaire_question ADD CONSTRAINT FK_28CC40C3CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE questionnaire_question ADD CONSTRAINT FK_28CC40C31E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE questionnaire_user_answer ADD CONSTRAINT FK_36AB8B38CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE questionnaire_user_answer ADD CONSTRAINT FK_36AB8B38AA334807 FOREIGN KEY (answer_id) REFERENCES answer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE questionnaire_user_answer ADD CONSTRAINT FK_36AB8B389D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE answer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE question_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE questionnaire_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE questionnaire_user_answer_id_seq CASCADE');
        $this->addSql('ALTER TABLE answer DROP CONSTRAINT FK_DADD4A251E27F6BF');
        $this->addSql('ALTER TABLE questionnaire_question DROP CONSTRAINT FK_28CC40C3CE07E8FF');
        $this->addSql('ALTER TABLE questionnaire_question DROP CONSTRAINT FK_28CC40C31E27F6BF');
        $this->addSql('ALTER TABLE questionnaire_user_answer DROP CONSTRAINT FK_36AB8B38CE07E8FF');
        $this->addSql('ALTER TABLE questionnaire_user_answer DROP CONSTRAINT FK_36AB8B38AA334807');
        $this->addSql('ALTER TABLE questionnaire_user_answer DROP CONSTRAINT FK_36AB8B389D86650F');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE questionnaire');
        $this->addSql('DROP TABLE questionnaire_question');
        $this->addSql('DROP TABLE questionnaire_user_answer');
    }
}
