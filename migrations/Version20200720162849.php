<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200720162849 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE focus_lieu (id INT AUTO_INCREMENT NOT NULL, focus_ville_id INT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_657B8FD02E169D19 (focus_ville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE focus_pays (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, introduction LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, image_cover VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE focus_ville (id INT AUTO_INCREMENT NOT NULL, focus_pays_id INT NOT NULL, title VARCHAR(255) NOT NULL, introduction VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, image_cover VARCHAR(255) NOT NULL, INDEX IDX_D7EDCEB55C528DDD (focus_pays_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marker_lieu (id INT AUTO_INCREMENT NOT NULL, focus_lieu_id INT NOT NULL, title VARCHAR(255) NOT NULL, longitude VARCHAR(255) NOT NULL, latitude VARCHAR(255) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B60267F49004DC55 (focus_lieu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marker_pays (id INT AUTO_INCREMENT NOT NULL, focus_pays_id INT NOT NULL, title VARCHAR(255) NOT NULL, longitude VARCHAR(255) NOT NULL, latitude VARCHAR(255) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_ADCA26035C528DDD (focus_pays_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marker_ville (id INT AUTO_INCREMENT NOT NULL, focus_ville_id INT NOT NULL, title VARCHAR(255) NOT NULL, longitude VARCHAR(255) NOT NULL, latitude VARCHAR(255) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_EB3D538C2E169D19 (focus_ville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE focus_lieu ADD CONSTRAINT FK_657B8FD02E169D19 FOREIGN KEY (focus_ville_id) REFERENCES focus_ville (id)');
        $this->addSql('ALTER TABLE focus_ville ADD CONSTRAINT FK_D7EDCEB55C528DDD FOREIGN KEY (focus_pays_id) REFERENCES focus_pays (id)');
        $this->addSql('ALTER TABLE marker_lieu ADD CONSTRAINT FK_B60267F49004DC55 FOREIGN KEY (focus_lieu_id) REFERENCES focus_lieu (id)');
        $this->addSql('ALTER TABLE marker_pays ADD CONSTRAINT FK_ADCA26035C528DDD FOREIGN KEY (focus_pays_id) REFERENCES focus_pays (id)');
        $this->addSql('ALTER TABLE marker_ville ADD CONSTRAINT FK_EB3D538C2E169D19 FOREIGN KEY (focus_ville_id) REFERENCES focus_ville (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE marker_lieu DROP FOREIGN KEY FK_B60267F49004DC55');
        $this->addSql('ALTER TABLE focus_ville DROP FOREIGN KEY FK_D7EDCEB55C528DDD');
        $this->addSql('ALTER TABLE marker_pays DROP FOREIGN KEY FK_ADCA26035C528DDD');
        $this->addSql('ALTER TABLE focus_lieu DROP FOREIGN KEY FK_657B8FD02E169D19');
        $this->addSql('ALTER TABLE marker_ville DROP FOREIGN KEY FK_EB3D538C2E169D19');
        $this->addSql('DROP TABLE focus_lieu');
        $this->addSql('DROP TABLE focus_pays');
        $this->addSql('DROP TABLE focus_ville');
        $this->addSql('DROP TABLE marker_lieu');
        $this->addSql('DROP TABLE marker_pays');
        $this->addSql('DROP TABLE marker_ville');
    }
}
