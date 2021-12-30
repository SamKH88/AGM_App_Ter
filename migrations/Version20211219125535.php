<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211219125535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE produit (ref_pro VARCHAR(20) NOT NULL PRIMARY KEY, des_pro VARCHAR(255) NOT NULL, cond_pro VARCHAR(50) DEFAULT NULL, qte_st INT NOT NULL, seuil INT NOT NULL, date_per DATE DEFAULT NULL, type_pro VARCHAR(2) NOT NULL, fourn_pro VARCHAR(255) DEFAULT NULL, date_fin DATE DEFAULT NULL, PRIMARY KEY(ref_pro)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (user_id VARCHAR(30) NOT NULL PRIMARY KEY, user_nm VARCHAR(255) NOT NULL, user_pre VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, user_type INT NOT NULL, user_loc_imb VARCHAR(10) NOT NULL, userloc_etage INT NOT NULL, userloc_porte VARCHAR(10) NOT NULL, team VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE utilisateur');
    }
}
