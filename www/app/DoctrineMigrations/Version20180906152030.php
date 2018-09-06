<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180906152030 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE oc_skill (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE oc_advert_skill (id INT NOT NULL, advert_id INT NOT NULL, skill_id INT NOT NULL, level VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_32EFF25BD07ECCB6 ON oc_advert_skill (advert_id)');
        $this->addSql('CREATE INDEX IDX_32EFF25B5585C142 ON oc_advert_skill (skill_id)');
        $this->addSql('CREATE TABLE oc_category (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE oc_advert (id INT NOT NULL, image_id INT DEFAULT NULL, user_id INT DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, author VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, content TEXT NOT NULL, nb_applications INT DEFAULT 0 NOT NULL, published BOOLEAN NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B1931752B36786B ON oc_advert (title)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B193175989D9B62 ON oc_advert (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B1931753DA5256D ON oc_advert (image_id)');
        $this->addSql('CREATE INDEX IDX_B193175A76ED395 ON oc_advert (user_id)');
        $this->addSql('CREATE TABLE oc_advert_category (advert_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(advert_id, category_id))');
        $this->addSql('CREATE INDEX IDX_435EA006D07ECCB6 ON oc_advert_category (advert_id)');
        $this->addSql('CREATE INDEX IDX_435EA00612469DE2 ON oc_advert_category (category_id)');
        $this->addSql('CREATE TABLE oc_image (id INT NOT NULL, url VARCHAR(255) NOT NULL, alt VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE oc_application (id INT NOT NULL, advert_id INT NOT NULL, author VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, content TEXT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, ip VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_39F85DD8D07ECCB6 ON oc_application (advert_id)');
        $this->addSql('CREATE TABLE oc_user (id INT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled BOOLEAN NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, roles TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7866CFC992FC23A8 ON oc_user (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7866CFC9A0D96FBF ON oc_user (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7866CFC9C05FB297 ON oc_user (confirmation_token)');
        $this->addSql('COMMENT ON COLUMN oc_user.roles IS \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE oc_advert_skill ADD CONSTRAINT FK_32EFF25BD07ECCB6 FOREIGN KEY (advert_id) REFERENCES oc_advert (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE oc_advert_skill ADD CONSTRAINT FK_32EFF25B5585C142 FOREIGN KEY (skill_id) REFERENCES oc_skill (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE oc_advert ADD CONSTRAINT FK_B1931753DA5256D FOREIGN KEY (image_id) REFERENCES oc_image (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE oc_advert ADD CONSTRAINT FK_B193175A76ED395 FOREIGN KEY (user_id) REFERENCES oc_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE oc_advert_category ADD CONSTRAINT FK_435EA006D07ECCB6 FOREIGN KEY (advert_id) REFERENCES oc_advert (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE oc_advert_category ADD CONSTRAINT FK_435EA00612469DE2 FOREIGN KEY (category_id) REFERENCES oc_category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE oc_application ADD CONSTRAINT FK_39F85DD8D07ECCB6 FOREIGN KEY (advert_id) REFERENCES oc_advert (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE oc_advert_skill DROP CONSTRAINT FK_32EFF25B5585C142');
        $this->addSql('ALTER TABLE oc_advert_category DROP CONSTRAINT FK_435EA00612469DE2');
        $this->addSql('ALTER TABLE oc_advert_skill DROP CONSTRAINT FK_32EFF25BD07ECCB6');
        $this->addSql('ALTER TABLE oc_advert_category DROP CONSTRAINT FK_435EA006D07ECCB6');
        $this->addSql('ALTER TABLE oc_application DROP CONSTRAINT FK_39F85DD8D07ECCB6');
        $this->addSql('ALTER TABLE oc_advert DROP CONSTRAINT FK_B1931753DA5256D');
        $this->addSql('ALTER TABLE oc_advert DROP CONSTRAINT FK_B193175A76ED395');
        $this->addSql('DROP TABLE oc_skill');
        $this->addSql('DROP TABLE oc_advert_skill');
        $this->addSql('DROP TABLE oc_category');
        $this->addSql('DROP TABLE oc_advert');
        $this->addSql('DROP TABLE oc_advert_category');
        $this->addSql('DROP TABLE oc_image');
        $this->addSql('DROP TABLE oc_application');
        $this->addSql('DROP TABLE oc_user');
    }
}
