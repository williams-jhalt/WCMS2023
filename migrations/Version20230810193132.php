<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230810193132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E092755C305 ON customer (customer_number)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD10696A9B ON product (item_number)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CDFC735677153098 ON product_category (code)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B0AEC4B777153098 ON product_manufacturer (code)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_136758877153098 ON product_type (code)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6C0EEE76551F0F81 ON weborder (order_number)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_81398E092755C305 ON customer');
        $this->addSql('DROP INDEX UNIQ_D34A04AD10696A9B ON product');
        $this->addSql('DROP INDEX UNIQ_CDFC735677153098 ON product_category');
        $this->addSql('DROP INDEX UNIQ_B0AEC4B777153098 ON product_manufacturer');
        $this->addSql('DROP INDEX UNIQ_136758877153098 ON product_type');
        $this->addSql('DROP INDEX UNIQ_6C0EEE76551F0F81 ON weborder');
    }
}
