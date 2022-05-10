<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220506211117 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reclamation (id_rec INT AUTO_INCREMENT NOT NULL, cin BIGINT DEFAULT NULL, type_rec VARCHAR(255) NOT NULL, description_rec TEXT NOT NULL, date_rec DATE NOT NULL, archived TINYINT(1) DEFAULT NULL, screenshot VARCHAR(500) NOT NULL, email VARCHAR(255) NOT NULL, INDEX FK_rec_cin (cin), PRIMARY KEY(id_rec)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id_reservation INT AUTO_INCREMENT NOT NULL, id INT DEFAULT NULL, cin BIGINT NOT NULL, date_reservation DATE NOT NULL, nbrPersonne INT NOT NULL, INDEX FK_rec_zoneC (id), PRIMARY KEY(id_reservation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404ABE530DA FOREIGN KEY (cin) REFERENCES client (cin)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955BF396750 FOREIGN KEY (id) REFERENCES zonecamping (id)');
        $this->addSql('ALTER TABLE zonecamping CHANGE latitude latitude DOUBLE PRECISION NOT NULL, CHANGE longitude longitude DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('ALTER TABLE zonecamping CHANGE latitude latitude DOUBLE PRECISION DEFAULT NULL, CHANGE longitude longitude DOUBLE PRECISION DEFAULT NULL');
    }
}
