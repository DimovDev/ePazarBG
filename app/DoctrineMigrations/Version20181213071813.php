<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181213071813 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP INDEX UNIQ_D34A04ADA196F9FD, ADD INDEX IDX_D34A04ADA196F9FD (authorId)');
        $this->addSql('DROP INDEX IDX_D34A04ADF675F31B ON product');
        $this->addSql('ALTER TABLE product DROP author_id, CHANGE dateAdded dateAdded DATETIME NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADA196F9FD FOREIGN KEY (authorId) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_role ADD CONSTRAINT FK_2DE8C6A3A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP INDEX IDX_D34A04ADA196F9FD, ADD UNIQUE INDEX UNIQ_D34A04ADA196F9FD (authorId)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADA196F9FD');
        $this->addSql('ALTER TABLE product ADD author_id INT NOT NULL, CHANGE dateAdded dateAdded DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('CREATE INDEX IDX_D34A04ADF675F31B ON product (author_id)');
        $this->addSql('ALTER TABLE user_role DROP FOREIGN KEY FK_2DE8C6A3A76ED395');
    }
}
