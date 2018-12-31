<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181231092315 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE reviews (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, author_id INT DEFAULT NULL, content VARCHAR(255) NOT NULL, dateAdded DATETIME NOT NULL, rating INT NOT NULL, INDEX IDX_6970EB0F4584665A (product_id), INDEX IDX_6970EB0FF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FF675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADA196F9FD');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADA196F9FD FOREIGN KEY (authorId) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users CHANGE image image VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE reviews');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADA196F9FD');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADA196F9FD FOREIGN KEY (authorId) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users CHANGE image image VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
