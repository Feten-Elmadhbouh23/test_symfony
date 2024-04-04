<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240328151441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avie (id INT AUTO_INCREMENT NOT NULL, description TEXT NOT NULL, etoile DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cities (id INT AUTO_INCREMENT NOT NULL, city VARCHAR(80) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE donations (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, total DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande_client DROP FOREIGN KEY fk_comd');
        $this->addSql('ALTER TABLE commande_client DROP FOREIGN KEY fk_platt');
        $this->addSql('DROP TABLE commande_client');
        $this->addSql('ALTER TABLE commande_resto CHANGE id_client id_client INT DEFAULT NULL');
        $this->addSql('ALTER TABLE features CHANGE id_abonnement id_abonnement INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livreur CHANGE id_vehicule id_vehicule INT DEFAULT NULL, CHANGE id_zone_livraison id_zone_livraison INT DEFAULT NULL, CHANGE num_tel num_tel VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE offre_resto CHANGE id_resto id_resto INT DEFAULT NULL, CHANGE id_plat id_plat INT DEFAULT NULL');
        $this->addSql('ALTER TABLE plat DROP FOREIGN KEY fk_categorieP');
        $this->addSql('ALTER TABLE plat DROP FOREIGN KEY fk_gerantiid');
        $this->addSql('ALTER TABLE plat CHANGE id_category id_category INT DEFAULT NULL, CHANGE id_restaurant id_restaurant INT DEFAULT NULL');
        $this->addSql('ALTER TABLE plat ADD CONSTRAINT FK_2038A2075697F554 FOREIGN KEY (id_category) REFERENCES category (id)');
        $this->addSql('ALTER TABLE plat ADD CONSTRAINT FK_2038A2074E1F92E8 FOREIGN KEY (id_restaurant) REFERENCES gerant (id)');
        $this->addSql('ALTER TABLE reponsee CHANGE id_reclamation id_reclamation INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY fk_clientidd');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY fk_gerantiddd');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY fk_table');
        $this->addSql('ALTER TABLE reservation CHANGE id_client id_client INT DEFAULT NULL, CHANGE id_restaurant id_restaurant INT DEFAULT NULL, CHANGE id_table id_table INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955E173B1B8 FOREIGN KEY (id_client) REFERENCES client (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849554E1F92E8 FOREIGN KEY (id_restaurant) REFERENCES gerant (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495518ACCE76 FOREIGN KEY (id_table) REFERENCES `table` (id)');
        $this->addSql('ALTER TABLE `table` DROP FOREIGN KEY fk_gert');
        $this->addSql('ALTER TABLE `table` CHANGE id_resto id_resto INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `table` ADD CONSTRAINT FK_F6298F4667A41481 FOREIGN KEY (id_resto) REFERENCES gerant (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande_client (id INT AUTO_INCREMENT NOT NULL, id_plat INT NOT NULL, id_commande INT NOT NULL, prix DOUBLE PRECISION NOT NULL, quantite INT NOT NULL, status VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date DATETIME NOT NULL, INDEX fk_platt (id_plat), INDEX fk_comd (id_commande), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commande_client ADD CONSTRAINT fk_comd FOREIGN KEY (id_commande) REFERENCES commande_resto (id)');
        $this->addSql('ALTER TABLE commande_client ADD CONSTRAINT fk_platt FOREIGN KEY (id_plat) REFERENCES plat (id_plat) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE avie');
        $this->addSql('DROP TABLE cities');
        $this->addSql('DROP TABLE donations');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE commande_resto CHANGE id_client id_client INT NOT NULL');
        $this->addSql('ALTER TABLE features CHANGE id_abonnement id_abonnement INT NOT NULL');
        $this->addSql('ALTER TABLE livreur CHANGE id_zone_livraison id_zone_livraison INT NOT NULL, CHANGE id_vehicule id_vehicule INT NOT NULL, CHANGE num_tel num_tel INT NOT NULL');
        $this->addSql('ALTER TABLE offre_resto CHANGE id_resto id_resto INT NOT NULL, CHANGE id_plat id_plat INT NOT NULL');
        $this->addSql('ALTER TABLE plat DROP FOREIGN KEY FK_2038A2075697F554');
        $this->addSql('ALTER TABLE plat DROP FOREIGN KEY FK_2038A2074E1F92E8');
        $this->addSql('ALTER TABLE plat CHANGE id_category id_category INT NOT NULL, CHANGE id_restaurant id_restaurant INT NOT NULL');
        $this->addSql('ALTER TABLE plat ADD CONSTRAINT fk_categorieP FOREIGN KEY (id_category) REFERENCES category (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plat ADD CONSTRAINT fk_gerantiid FOREIGN KEY (id_restaurant) REFERENCES gerant (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponsee CHANGE id_reclamation id_reclamation INT NOT NULL');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955E173B1B8');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849554E1F92E8');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495518ACCE76');
        $this->addSql('ALTER TABLE reservation CHANGE id_client id_client INT NOT NULL, CHANGE id_restaurant id_restaurant INT NOT NULL, CHANGE id_table id_table INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT fk_clientidd FOREIGN KEY (id_client) REFERENCES client (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT fk_gerantiddd FOREIGN KEY (id_restaurant) REFERENCES gerant (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT fk_table FOREIGN KEY (id_table) REFERENCES `table` (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `table` DROP FOREIGN KEY FK_F6298F4667A41481');
        $this->addSql('ALTER TABLE `table` CHANGE id_resto id_resto INT NOT NULL');
        $this->addSql('ALTER TABLE `table` ADD CONSTRAINT fk_gert FOREIGN KEY (id_resto) REFERENCES gerant (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
