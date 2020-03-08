<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200307224850 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_tache');
        $this->addSql('ALTER TABLE user ADD tache_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D2235D39 FOREIGN KEY (tache_id) REFERENCES tache (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D2235D39 ON user (tache_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_tache (user_id INT NOT NULL, tache_id INT NOT NULL, INDEX IDX_7145DB2DA76ED395 (user_id), INDEX IDX_7145DB2DD2235D39 (tache_id), PRIMARY KEY(user_id, tache_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_tache ADD CONSTRAINT FK_7145DB2DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_tache ADD CONSTRAINT FK_7145DB2DD2235D39 FOREIGN KEY (tache_id) REFERENCES tache (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D2235D39');
        $this->addSql('DROP INDEX IDX_8D93D649D2235D39 ON user');
        $this->addSql('ALTER TABLE user DROP tache_id');
    }
}
