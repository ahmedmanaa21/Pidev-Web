<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220415124817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client CHANGE cin cin BIGINT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY ref_equipement');
        $this->addSql('ALTER TABLE offre CHANGE ref_equipement ref_equipement INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FBE7129ED FOREIGN KEY (ref_equipement) REFERENCES equipement (ref_equipement)');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY eq');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY eu');
        $this->addSql('ALTER TABLE panier CHANGE ref_equipement ref_equipement INT DEFAULT NULL, CHANGE Cin Cin BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF293A8763A FOREIGN KEY (Cin) REFERENCES client (cin)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2BE7129ED FOREIGN KEY (ref_equipement) REFERENCES equipement (ref_equipement)');
        $this->addSql('ALTER TABLE reclamation CHANGE archived archived TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_rec_zoneC');
        $this->addSql('ALTER TABLE reservation CHANGE id_zoneCamping id_zoneCamping INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495590263F7E FOREIGN KEY (id_zoneCamping) REFERENCES zonecamping (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client CHANGE cin cin BIGINT NOT NULL');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FBE7129ED');
        $this->addSql('ALTER TABLE offre CHANGE ref_equipement ref_equipement INT NOT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT ref_equipement FOREIGN KEY (ref_equipement) REFERENCES equipement (ref_equipement) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF293A8763A');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2BE7129ED');
        $this->addSql('ALTER TABLE panier CHANGE ref_equipement ref_equipement INT NOT NULL, CHANGE Cin Cin BIGINT NOT NULL');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT eq FOREIGN KEY (ref_equipement) REFERENCES equipement (ref_equipement) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT eu FOREIGN KEY (Cin) REFERENCES client (cin) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reclamation CHANGE archived archived TINYINT(1) DEFAULT 0');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495590263F7E');
        $this->addSql('ALTER TABLE reservation CHANGE id_zoneCamping id_zoneCamping INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_rec_zoneC FOREIGN KEY (id_zoneCamping) REFERENCES zonecamping (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
